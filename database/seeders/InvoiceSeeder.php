<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        Invoice::truncate();

        $statuses = [
            'Paid',
            'Pending',
            'Overdue',
        ];

        for ($i = 1; $i <= 15; $i++) {

            $dueDate = Carbon::now()->addDays(rand(-15,30));

            Invoice::create([
                'invoice_no' => 'INV-'.str_pad($i,5,'0',STR_PAD_LEFT),
                'client' => 'Client '.$i,
                'amount' => rand(5000,80000),
                'due_date' => $dueDate,
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}