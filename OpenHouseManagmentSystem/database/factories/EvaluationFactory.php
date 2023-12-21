<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evaluator_id' => \App\Models\Evaluator::factory(),
            'project_id' => \App\Models\Project::factory(),
            'rating' => $this->faker->numberBetween(1, 10),
            'preferences' => $this->faker->text,
        ];
    }
}
