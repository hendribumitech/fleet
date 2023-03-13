<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\Sparepart;
use Illuminate\Database\Eloquent\Factories\Factory;

class SparepartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sparepart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 100)),
        'description' => $this->faker->boolean
        ];
    }
}
