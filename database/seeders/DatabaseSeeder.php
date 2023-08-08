<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\CategoryDescription;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        CategoryDescription::create([
            'name' => 'Masalah Email UNS',
        ]);
        CategoryDescription::create([
            'name' => 'Architecture',
        ]);
        CategoryDescription::create([
            'name' => 'Cyber Attack',
        ]);
        CategoryDescription::create([
            'name' => 'Information',
        ]);
        CategoryDescription::create([
            'name' => 'Infrastruktur',
        ]);
        CategoryDescription::create([
            'name' => 'IT Expertise and Skill',
        ]);
        CategoryDescription::create([
            'name' => 'IT Invesment and Decision Making',
        ]);
        CategoryDescription::create([
            'name' => 'Policy, Regulation Guideline, SOP',
        ]);
        CategoryDescription::create([
            'name' => 'Software',
        ]);
        CategoryDescription::create([
            'name' => 'Staff Operation (Human Error and Malicious Intent)',
        ]);
    }
}
