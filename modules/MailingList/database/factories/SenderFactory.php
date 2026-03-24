<?php

declare(strict_types=1);

namespace Database\Factories;

use AcMarche\MailingList\Models\Sender;
use AcMarche\MailingList\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sender>
 */
final class SenderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
        ];
    }
}
