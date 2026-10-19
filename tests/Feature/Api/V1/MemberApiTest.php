<?php

namespace Tests\Feature\Api\V1;

use App\Models\Attendance;
use App\Models\Member;
use App\Models\Moderator;
use App\Models\Obavijest;
use App\Models\PrijavaTreninga;
use App\Models\TerminTreninga;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Pokrece se SAMO nad testnom bazom (phpunit.xml -> DB_DATABASE=begs_gym_testing).
 */
class MemberApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Kolona attendances.gym postoji u zivoj bazi, ali je ne kreira nijedna
     * migracija. Dodaje se samo u testnu bazu, odmah nakon migracija i prije
     * test transakcije (ALTER TABLE u MySQL-u bi zatvorio transakciju).
     */
    protected function refreshTestDatabase()
    {
        if (!RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->migrateFreshUsing());

            if (!Schema::hasColumn('attendances', 'gym')) {
                Schema::table('attendances', function (Blueprint $table) {
                    $table->unsignedTinyInteger('gym')->nullable();
                });
            }

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }

    private function member(array $attrs = [], ?string $feeEnd = '+1 month'): Member
    {
        static $n = 0;
        $n++;

        $member = Member::create(array_merge([
            'name' => 'Test',
            'surname' => 'Clan' . $n,
            'code' => 'RFID' . $n,
            'email' => "clan{$n}@example.com",
            'mobile' => '061000000',
            'jmbg' => 1234567890123,
            'register_date' => now()->toDateString(),
            'image_path' => 'test.jpg',
            'street' => 'Ulica 1',
            'post_no' => '71000',
            'city' => 'Sarajevo',
            'status' => 'on',
            'password' => Hash::make('tajna123'),
        ], $attrs));

        if ($feeEnd !== null) {
            DB::table('fees')->insert([
                'date' => now()->toDateString(),
                'start' => now()->subMonth()->toDateString(),
                'end' => now()->modify($feeEnd)->toDateString(),
                'amount' => 50,
                'comment' => 'test',
                'member_id' => $member->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $member;
    }

    private function tokenFor(Member $member): string
    {
        return $member->createToken('test')->plainTextToken;
    }

    /**
     * Zaboravi kesirane guardove izmedju zahtjeva, inace test aplikacija
     * zadrzi korisnika iz prethodnog zahtjeva umjesto da cita novi token.
     */
    private function asToken(string $token): self
    {
        $this->app['auth']->forgetGuards();

        return $this->withToken($token);
    }

    private function moderator(): Moderator
    {
        return Moderator::create(['name' => 'Trener', 'email' => 'trener@example.com', 'password' => Hash::make('x')]);
    }

    public function test_login_returns_token_and_hides_sensitive_fields(): void
    {
        $member = $this->member();

        $response = $this->postJson('/api/v1/member/login', [
            'email' => $member->email,
            'password' => 'tajna123',
            'device_name' => 'pixel',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['token', 'member' => ['id', 'name', 'surname', 'email', 'photo_url', 'membership' => ['active', 'expires_at', 'days_left'], 'goals']])
            ->assertJsonPath('member.membership.active', true);

        $json = json_encode($response->json());
        $this->assertStringNotContainsString('jmbg', $json);
        $this->assertStringNotContainsString('"code"', $json);
        $this->assertStringNotContainsString('is_admin', $json);
        $this->assertStringNotContainsString('password', $json);
    }

    public function test_login_rejects_wrong_password_and_inactive_account(): void
    {
        $member = $this->member();
        $neaktiviran = $this->member(['password' => null]);

        $this->postJson('/api/v1/member/login', ['email' => $member->email, 'password' => 'pogresno', 'device_name' => 'x'])
            ->assertStatus(401)->assertJsonPath('code', 'invalid_credentials');

        $this->postJson('/api/v1/member/login', ['email' => $neaktiviran->email, 'password' => 'tajna123', 'device_name' => 'x'])
            ->assertStatus(401);

        $this->postJson('/api/v1/member/login', [])->assertStatus(422);
    }

    public function test_login_rejects_expired_membership(): void
    {
        $member = $this->member([], '-1 day');

        $this->postJson('/api/v1/member/login', ['email' => $member->email, 'password' => 'tajna123', 'device_name' => 'x'])
            ->assertStatus(403)->assertJsonPath('code', 'membership_expired');
    }

    public function test_protected_routes_require_token_and_active_membership(): void
    {
        $this->getJson('/api/v1/member/me')->assertStatus(401);
        // Bez Accept zaglavlja API i dalje vraca JSON 401, ne redirect na web login.
        $this->get('/api/v1/member/me')->assertStatus(401);

        $member = $this->member();
        $token = $this->tokenFor($member);
        $this->asToken($token)->getJson('/api/v1/member/me')->assertOk()->assertJsonPath('data.id', $member->id);

        DB::table('fees')->where('member_id', $member->id)->update(['end' => now()->subDay()->toDateString()]);
        $this->asToken($token)->getJson('/api/v1/member/me')->assertStatus(403)->assertJsonPath('code', 'membership_expired');
    }

    public function test_staff_user_token_cannot_use_member_api(): void
    {
        $user = User::create(['name' => 'Recepcija', 'email' => 'staff@example.com', 'password' => Hash::make('x')]);
        $token = $user->createToken('staff')->plainTextToken;

        $this->asToken($token)->getJson('/api/v1/member/me')->assertStatus(401);
    }

    public function test_logout_revokes_current_token(): void
    {
        $member = $this->member();
        $token = $this->tokenFor($member);

        $this->asToken($token)->postJson('/api/v1/member/logout')->assertOk();
        $this->assertSame(0, $member->tokens()->count());
    }

    public function test_dashboard_and_statistics_match_attendance_data(): void
    {
        $member = $this->member();
        Attendance::create(['in' => now()->subHours(2), 'out' => now()->subHour(), 'date' => now()->toDateString(), 'status' => 0, 'member_id' => $member->id]);
        Attendance::create(['in' => now()->subMinutes(30), 'out' => null, 'date' => now()->toDateString(), 'status' => 1, 'member_id' => $member->id]);
        $token = $this->tokenFor($member);

        $this->asToken($token)->getJson('/api/v1/member/dashboard')
            ->assertOk()
            ->assertJsonPath('data.total_visits', 2)
            ->assertJsonPath('data.visits_this_month', 2)
            ->assertJsonPath('data.time_total.total_minutes', 60)
            ->assertJsonCount(7, 'data.week')
            ->assertJsonCount(6, 'data.last_six_months');

        $this->asToken($token)->getJson('/api/v1/member/statistics')
            ->assertOk()
            ->assertJsonCount(6, 'data.monthly')
            ->assertJsonCount(4, 'data.weekly')
            ->assertJsonCount(7, 'data.weekdays')
            ->assertJsonCount(12, 'data.yearly.current.visits');
    }

    public function test_statistics_lists_all_years_by_month(): void
    {
        $member = $this->member();
        $godina = now()->year - 2;
        foreach ([[3, 10, 90], [3, 12, 30], [11, 5, 60]] as [$mjesec, $dan, $minuta]) {
            $in = \Carbon\Carbon::create($godina, $mjesec, $dan, 10, 0, 0);
            Attendance::create(['in' => $in, 'out' => $in->copy()->addMinutes($minuta), 'date' => $in->toDateString(), 'status' => 0, 'member_id' => $member->id]);
        }
        Attendance::create(['in' => now()->subHours(2), 'out' => now()->subHour(), 'date' => now()->toDateString(), 'status' => 0, 'member_id' => $member->id]);

        $this->asToken($this->tokenFor($member))->getJson('/api/v1/member/statistics')
            ->assertOk()
            ->assertJsonCount(2, 'data.years')
            ->assertJsonPath('data.years.0.year', now()->year)
            ->assertJsonPath('data.years.1.year', $godina)
            ->assertJsonCount(12, 'data.years.1.visits')
            ->assertJsonPath('data.years.1.visits.2', 2)
            ->assertJsonPath('data.years.1.visits.10', 1)
            ->assertJsonPath('data.years.1.total_visits', 3)
            ->assertJsonPath('data.years.1.total_hours', 3)
            // Postojeci godisnji pregled ostaje isti.
            ->assertJsonPath('data.yearly.previous.year', now()->year - 1)
            ->assertJsonPath('data.yearly.previous.visits', array_fill(0, 12, 0));
    }

    public function test_settings_read_update_and_validate(): void
    {
        $member = $this->member();
        $token = $this->tokenFor($member);

        $this->asToken($token)->getJson('/api/v1/member/settings')
            ->assertOk()->assertJsonPath('data.monthly_goal_visits', 20)->assertJsonPath('data.monthly_goal_hours', 30);

        $this->asToken($token)->putJson('/api/v1/member/settings', ['monthly_goal_visits' => 12, 'monthly_goal_hours' => 15])->assertOk();
        $this->assertSame(900, (int) $member->fresh()->monthly_goal_minutes);

        $this->asToken($token)->putJson('/api/v1/member/settings', ['monthly_goal_visits' => 0, 'monthly_goal_hours' => 500])
            ->assertStatus(422)->assertJsonValidationErrors(['monthly_goal_visits', 'monthly_goal_hours']);
    }

    public function test_change_password(): void
    {
        $member = $this->member();
        $token = $this->tokenFor($member);

        $this->asToken($token)->putJson('/api/v1/member/password', [
            'current_password' => 'pogresno', 'password' => 'nova1234', 'password_confirmation' => 'nova1234',
        ])->assertStatus(422);

        $this->asToken($token)->putJson('/api/v1/member/password', [
            'current_password' => 'tajna123', 'password' => 'nova1234', 'password_confirmation' => 'nova1234',
        ])->assertOk();

        $this->assertTrue(Hash::check('nova1234', $member->fresh()->password));
    }

    public function test_announcements_list_marks_seen_and_badges_count(): void
    {
        $member = $this->member(['last_seen_obavijesti' => now()->subDay()]);
        $mod = $this->moderator();
        Obavijest::create(['moderator_id' => $mod->id, 'naslov' => 'Novo', 'sadrzaj' => 'Tekst', 'tip' => 'info']);
        $token = $this->tokenFor($member);

        $this->asToken($token)->getJson('/api/v1/member/badges')->assertOk()->assertJsonPath('data.unread_announcements', 1);

        $this->asToken($token)->getJson('/api/v1/member/announcements')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Novo')
            ->assertJsonStructure(['data', 'links', 'meta' => ['current_page', 'last_page', 'total']]);

        $this->assertNotNull($member->fresh()->last_seen_obavijesti);
        $this->asToken($token)->getJson('/api/v1/member/badges')->assertJsonPath('data.unread_announcements', 0);
    }

    public function test_training_signup_rules(): void
    {
        $mod = $this->moderator();
        $termin = TerminTreninga::create([
            'moderator_id' => $mod->id, 'naziv' => 'Box', 'opis' => null, 'datum_od' => now()->subDay()->toDateString(),
            'dani' => [1, 3], 'vrijeme_od' => '18:00', 'vrijeme_do' => '19:00', 'max_mjesta' => 1,
        ]);
        $buduci = TerminTreninga::create([
            'moderator_id' => $mod->id, 'naziv' => 'Yoga', 'opis' => null, 'datum_od' => now()->addWeek()->toDateString(),
            'dani' => [2], 'vrijeme_od' => '10:00', 'vrijeme_do' => '11:00', 'max_mjesta' => 5,
        ]);

        $prvi = $this->member();
        $drugi = $this->member();
        $t1 = $this->tokenFor($prvi);
        $t2 = $this->tokenFor($drugi);

        $this->asToken($t1)->postJson("/api/v1/member/trainings/{$termin->id}/signup")
            ->assertStatus(201)->assertJsonPath('data.is_signed_up', true)->assertJsonPath('data.free_places', 0);
        $this->asToken($t1)->postJson("/api/v1/member/trainings/{$termin->id}/signup")
            ->assertStatus(409)->assertJsonPath('code', 'already_signed_up');
        $this->asToken($t2)->postJson("/api/v1/member/trainings/{$termin->id}/signup")
            ->assertStatus(409)->assertJsonPath('code', 'full');
        $this->asToken($t2)->postJson("/api/v1/member/trainings/{$buduci->id}/signup")
            ->assertStatus(409)->assertJsonPath('code', 'not_active');

        $this->asToken($t1)->getJson('/api/v1/member/trainings')
            ->assertOk()->assertJsonCount(2, 'data');

        $this->asToken($t1)->deleteJson("/api/v1/member/trainings/{$termin->id}/signup")
            ->assertOk()->assertJsonPath('data.is_signed_up', false);
        $this->assertSame(0, PrijavaTreninga::count());
    }

    public function test_live_lists_members_inside_by_gym(): void
    {
        $member = $this->member();
        $drugi = $this->member();
        $a = new Attendance(['in' => now(), 'date' => now()->toDateString(), 'status' => 1, 'member_id' => $drugi->id]);
        $a->gym = 2;
        $a->save();

        $this->asToken($this->tokenFor($member))->getJson('/api/v1/member/live')
            ->assertOk()
            ->assertJsonCount(0, 'data.gym')
            ->assertJsonCount(1, 'data.ladies_gym')
            ->assertJsonMissing(['jmbg' => 1234567890123]);
    }

    public function test_activate_sends_password_once(): void
    {
        Mail::fake();
        $member = $this->member(['password' => null]);

        $this->postJson('/api/v1/member/activate', ['email' => $member->email])->assertOk();
        $this->assertNotNull($member->fresh()->password);
        $this->postJson('/api/v1/member/activate', ['email' => $member->email])->assertStatus(422)->assertJsonPath('code', 'already_activated');
    }

    public function test_web_portal_login_still_works(): void
    {
        $member = $this->member();

        $this->post(route('member.login.submit'), ['email' => $member->email, 'password' => 'tajna123'])
            ->assertRedirect(route('member.profile'));
        $this->assertAuthenticatedAs($member, 'member');
    }
}
