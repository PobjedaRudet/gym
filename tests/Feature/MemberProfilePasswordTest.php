<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Postavljanje lozinke za portal sa profila clana (memberProfile/{id}).
 *
 * Tabele u testnoj bazi su MyISAM pa se transakcije ne vracaju;
 * test zato sam brise redove koje je kreirao.
 */
class MemberProfilePasswordTest extends TestCase
{
    private array $created = [];

    protected function tearDown(): void
    {
        foreach ($this->created as $model) {
            $model->delete();
        }

        parent::tearDown();
    }

    private function member(array $attrs = []): Member
    {
        return $this->created[] = Member::create(array_merge([
            'name' => 'Test',
            'surname' => 'Lozinka',
            'code' => 'RFIDLOZ',
            'email' => 'portal-lozinka@example.com',
            'mobile' => '061000000',
            'jmbg' => 1234567890123,
            'register_date' => now()->toDateString(),
            'image_path' => 'test.jpg',
            'street' => 'Ulica 1',
            'post_no' => '71000',
            'city' => 'Sarajevo',
            'status' => 'on',
        ], $attrs));
    }

    private function admin(): User
    {
        return $this->created[] = User::create([
            'name' => 'Recepcija',
            'email' => 'recepcija-lozinka@example.com',
            'password' => Hash::make('x'),
        ]);
    }

    public function test_admin_sets_portal_password(): void
    {
        $member = $this->member(['remember_token' => 'staritoken']);

        $this->actingAs($this->admin())
            ->post(route('memberProfile.password.set', ['id' => $member->id]), [
                'password' => 'novaLozinka1',
                'password_confirmation' => 'novaLozinka1',
            ])
            ->assertRedirect(route('memberProfile', ['id' => $member->id]))
            ->assertSessionHas('success');

        $member->refresh();
        $this->assertTrue(Hash::check('novaLozinka1', $member->password));
        $this->assertNull($member->remember_token);
    }

    public function test_password_must_be_confirmed_and_long_enough(): void
    {
        $member = $this->member(['password' => Hash::make('stara123')]);
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('memberProfile.password.set', ['id' => $member->id]), [
                'password' => 'novaLozinka1',
                'password_confirmation' => 'drugacija',
            ])
            ->assertSessionHasErrors('password');

        $this->actingAs($admin)
            ->post(route('memberProfile.password.set', ['id' => $member->id]), [
                'password' => '12345',
                'password_confirmation' => '12345',
            ])
            ->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('stara123', $member->fresh()->password));
    }

    public function test_member_without_email_cannot_get_password(): void
    {
        $member = $this->member(['email' => null]);

        $this->actingAs($this->admin())
            ->post(route('memberProfile.password.set', ['id' => $member->id]), [
                'password' => 'novaLozinka1',
                'password_confirmation' => 'novaLozinka1',
            ])
            ->assertRedirect(route('memberProfile', ['id' => $member->id]))
            ->assertSessionHasErrors('password');

        $this->assertNull($member->fresh()->password);
    }

    public function test_guest_cannot_set_password(): void
    {
        $member = $this->member();

        $this->post(route('memberProfile.password.set', ['id' => $member->id]), [
            'password' => 'novaLozinka1',
            'password_confirmation' => 'novaLozinka1',
        ])->assertRedirect(route('login'));

        $this->assertNull($member->fresh()->password);
    }

    public function test_profile_shows_portal_access_card(): void
    {
        $member = $this->member();

        $this->actingAs($this->admin())
            ->get(route('memberProfile', ['id' => $member->id]))
            ->assertOk()
            ->assertSee('Pristup portalu')
            ->assertSee('Lozinka nije postavljena')
            ->assertSee(route('memberProfile.password.set', ['id' => $member->id]), false);
    }
}
