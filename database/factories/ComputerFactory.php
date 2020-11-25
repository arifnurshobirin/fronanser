<?php

namespace Database\Factories;

use App\Models\Counter;
use App\Models\Computer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComputerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Computer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'counter_id' => Counter::factory(),
            'nocomputer' => $this->faker->unique()->numberBetween(1,99),
            'type' => $this->faker->randomElement($array = array ('Zonerich', 'IBM','HP','Wincore M2','Wincore M3')),
            'printer' =>$this->faker->randomElement($array = array ('ND 77', 'Star','Zonerich','Wincore Nixdrof','Epson','HP')),
            'drawer' =>$this->faker->randomElement($array = array ('Wincore','IBM','HP')),
            'scanner' =>$this->faker->randomElement($array = array ('Magellan 8100', 'Magellan 2000','Datalogic','Zonerich','HP')),
            'monitor' =>$this->faker->randomElement($array = array ('TFT', 'HP','Wincore')),
            'status' => $this->faker->randomElement($array = array ('Active', 'Inactive','Broken'))
        ];
    }
}
