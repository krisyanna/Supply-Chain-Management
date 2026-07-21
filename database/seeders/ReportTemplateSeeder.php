<?php

namespace Database\Seeders;

use App\Models\ReportTemplate;
use Illuminate\Database\Seeder;

class ReportTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportTemplate::truncate();

        $templates = [
            [
                'name' => 'Inventory Summary Report',
                'created_by' => 'System Administrator',
                'status' => 'Active',
            ],
            [
                'name' => 'Monthly Sales Report',
                'created_by' => 'Sales Manager',
                'status' => 'Active',
            ],
            [
                'name' => 'Forecast Analysis Report',
                'created_by' => 'Forecast Manager',
                'status' => 'Active',
            ],
            [
                'name' => 'Warehouse Performance Report',
                'created_by' => 'Warehouse Supervisor',
                'status' => 'Active',
            ],
            [
                'name' => 'Transfer Activity Report',
                'created_by' => 'Logistics Officer',
                'status' => 'Active',
            ],
            [
                'name' => 'Supplier Purchase Report',
                'created_by' => 'Procurement Officer',
                'status' => 'Active',
            ],
            [
                'name' => 'Financial Summary Report',
                'created_by' => 'Finance Department',
                'status' => 'Draft',
            ],
            [
                'name' => 'Quarterly Executive Report',
                'created_by' => 'Operations Manager',
                'status' => 'Archived',
            ],
        ];

        foreach ($templates as $template) {
            ReportTemplate::create($template);
        }
    }
}