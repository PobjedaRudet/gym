<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MakeAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set admin@begsfit.ba as admin
        $admin = Member::where('email', 'admin@begsfit.ba')->first();

        if ($admin) {
            $admin->update(['is_admin' => true]);
            $this->command->info('Member admin@begsfit.ba is now admin!');
        } else {
            $this->command->warn('Member with email admin@begsfit.ba not found.');
        }
    }
}
