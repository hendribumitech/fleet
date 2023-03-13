<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'code' => $this->faker->text($this->faker->numberBetween(5, 20))
        ];
    }
}
