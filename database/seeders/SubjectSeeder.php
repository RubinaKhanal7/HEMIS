<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'school_id' => '1',
                'subject_code' => 'BC',
                'subject' => 'Business Communication',
                'credit_hour' => '101',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'FA',
                'subject' => 'Financial Accounting',
                'credit_hour' => '102',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'OB',
                'subject' => 'Organizational Behavior',
                'credit_hour' => '103',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'BA',
                'subject' => 'Business Analytics',
                'credit_hour' => '104',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'POM',
                'subject' => 'Principles of Management',
                'credit_hour' => '105',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'CMA',
                'subject' => 'Cost & Management Accounting',
                'credit_hour' => '106',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'CMA',
                'subject' => 'Business Economics',
                'credit_hour' => '107',
            ],
            [
                'school_id' => '1',
                'subject_code' => 'BI',
                'subject' => 'Banking & Insurance',
                'credit_hour' => '108',
            ]
        ];

        $subjects = array_map(function ($incomehead) {
            return array_merge($incomehead, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }, $data);

        DB::table('subjects')->insert($subjects);
    }
}
