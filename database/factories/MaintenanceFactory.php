<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Maintenance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => $this->faker->word,
        'start' => $this->faker->date('Y-m-d H:i:s'),
        'end' => $this->faker->date('Y-m-d H:i:s'),
        'description' => $this->faker->boolean
        ];
    }
}
