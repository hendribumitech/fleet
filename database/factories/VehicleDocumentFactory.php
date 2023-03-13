<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\VehicleDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'number' => $this->faker->text($this->faker->numberBetween(5, 50)),
        'document_id' => $this->faker->word,
        'vehicle_id' => $this->faker->word,
        'path_file' => $this->faker->boolean,
        'issued_at' => $this->faker->date('Y-m-d'),
        'expired_at' => $this->faker->date('Y-m-d')
        ];
    }
}
