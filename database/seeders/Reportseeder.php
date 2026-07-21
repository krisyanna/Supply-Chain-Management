<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::truncate();

        $reports = [
            [
                'type' => 'Inventory Report',
                'submitted_by' => 'Inventory Manager',
                'status' => 'Completed',
            ],
            [
                'type' => 'Sales Report',
                'submitted_by' => 'Sales Manager',
                'status' => 'Completed',
            ],
            [
                'type' => 'Forecast Report',
                'submitted_by' => 'Forecast Analyst',
                'status' => 'Pending',
            ],
            [
                'type' => 'Transfer Report',
                'submitted_by' => 'Warehouse Supervisor',
                'status' => 'Completed',
            ],
            [
                'type' => 'Shipment Report',
                'submitted_by' => 'Logistics Manager',
                'status' => 'In Progress',
            ],
            [
                'type' => 'Procurement Report',
                'submitted_by' => 'Procurement Officer',
                'status' => 'Completed',
            ],
            [
                'type' => 'Monthly Inventory Summary',
                'submitted_by' => 'Admin',
                'status' => 'Pending',
            ],
            [
                'type' => 'Warehouse Performance Report',
                'submitted_by' => 'Warehouse Manager',
                'status' => 'Completed',
            ],
            [
                'type' => 'Supplier Performance Report',
                'submitted_by' => 'Procurement Manager',
                'status' => 'Completed',
            ],
            [
                'type' => 'Annual Forecast Report',
                'submitted_by' => 'Forecast Manager',
                'status' => 'In Progress',
            ],
        ];

        foreach ($reports as $report) {
            Report::create($report);
        }
    }
}