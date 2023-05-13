<?php

namespace Database\Factories\Fleet;

use App\Models\Fleet\VehicleChecklist;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleChecklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleChecklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => $this->faker->word,
        'checklist_date' => $this->faker->date('Y-m-d')
        ];
    }
}
