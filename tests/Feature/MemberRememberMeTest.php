<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MemberRememberMeTest extends TestCase
{
    public function test_member_login_with_remember_me_sets_recaller_cookie_and_restores_user_without_session(): void
    {
        $member = Member::create([
            'name' => 'Test',
            'surname' => 'Member',
            'code' => 'A',
            'email' => 'member@example.com',
            'mobile' => '061111111',
            'jmbg' => 1234567890123,
            'register_date' => now()->toDateString(),
            'image_path' => 'test.jpg',
            'street' => 'Test Street',
            'post_no' => '71000',
            'city' => 'Sarajevo',
            'status' => 'active',
            'password' => Hash::make('secret123'),
        ]);

        DB::table('fees')->insert([
            'date' => now()->toDateString(),
            'start' => now()->subDay()->toDateString(),
            'end' => now()->addMonth()->toDateString(),
            'amount' => 100,
            'comment' => 'Test fee',
            'member_id' => $member->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('member.login.submit'), [
            'email' => $member->email,
            'password' => 'secret123',
            'remember' => '1',
        ]);

        $response->assertRedirect(route('member.profile'));
        $this->assertAuthenticatedAs($member, 'member');

        $member->refresh();

        $recallerCookieName = Auth::guard('member')->getRecallerName();
        $recallerCookie = $response->getCookie($recallerCookieName);

        $this->assertNotNull($member->remember_token);
        $this->assertNotNull($recallerCookie);
        $response->assertCookie($recallerCookieName);

        Auth::forgetGuards();

        $this->withCookie($recallerCookieName, $recallerCookie->getValue())
            ->get(route('member.profile'))
            ->assertOk()
            ->assertSee($member->email);
    }
}
