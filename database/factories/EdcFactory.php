<?php

namespace Database\Factories;

use App\Models\Counter;
use App\Models\Edc;
use Illuminate\Database\Eloquent\Factories\Factory;

class EdcFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Edc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'counter_id' =>Counter::factory(),
            'tidedc' => $this->faker->unique()->numberBetween(1,100),
            'midedc' => $this->faker->numberBetween(100000000000000,999999999999999),
            'ipaddress' => $this->faker->numberBetween(1000000000,9999999999),
            'connection' =>$this->faker->randomElement($array = array ('GPRS', 'LAN')),
            'simcard' => $this->faker->randomElement($array = array ('Indosat', 'Telkomsel','XL')),
            'type' => $this->faker->randomElement($array = array ('WireCard', 'BCA','Spots')),
            'status' => $this->faker->randomElement($array = array ('Active', 'Inactive','Broken'))
        ];
    }
}
