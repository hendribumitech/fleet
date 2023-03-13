<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'registration_number' => $this->faker->text($this->faker->numberBetween(5, 20)),
        'name' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'merk' => $this->faker->text($this->faker->numberBetween(5, 30)),
        'engine_number' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'identity_number' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'owner_name' => $this->faker->text($this->faker->numberBetween(5, 255)),
        'registration_year' => $this->faker->lexify('?????'),
        'purchase_date' => $this->faker->date('Y-m-d'),
        'vehicle_ownership_number' => $this->faker->text($this->faker->numberBetween(5, 50))
        ];
    }
}
