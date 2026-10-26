<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clients = Client::factory()->count(5)->create();
        $services = Service::factory()->count(5)->create();

        $invoices = Invoice::factory()
            ->count(10)
            ->recycle($clients)
            ->recycle($services)
            ->create();

        foreach ($invoices as $invoice) {
            if ($invoice->status === 'unpaid') {
                continue;
            }

            $amount = $invoice->status === 'paid'
                ? $invoice->amount
                : round($invoice->amount / 2, 2);

            Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amount,
                'payment_date' => $invoice->issue_date->copy()->addDays(rand(1, 30)),
                'method' => fake()->randomElement(['Bank Transfer', 'Cheque', 'Cash', 'Online']),
                'reference' => fake()->bothify('TXN-#####'),
            ]);
        }
    }
}
