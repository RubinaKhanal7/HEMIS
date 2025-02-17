<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            'Faculty of Management',
            'Faculty of Humanities & Social Sciences',
            'Faculty of Education',
            'Faculty of Law'
        ];


        foreach ($sections as $section) {
            Section::create([
                'section_name' => $section,
            ]);
        }
    }
}
