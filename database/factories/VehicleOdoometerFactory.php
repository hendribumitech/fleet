<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\VehicleOdoometer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleOdoometerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleOdoometer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => $this->faker->word,
        'odoometer' => $this->faker->numberBetween(0, 999)
        ];
    }
}
