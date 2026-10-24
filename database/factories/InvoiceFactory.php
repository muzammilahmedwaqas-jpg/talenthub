<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $issueDate = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'client_id' => Client::factory(),
            'service_id' => Service::factory(),
            'invoice_number' => 'INV-' . fake()->unique()->numerify('####'),
            'issue_date' => $issueDate,
            'due_date' => (clone $issueDate)->modify('+30 days'),
            'amount' => fake()->randomFloat(2, 500, 5000),
            'status' => fake()->randomElement(['unpaid', 'partial', 'paid']),
        ];
    }
}
