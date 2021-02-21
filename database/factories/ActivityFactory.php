<?php

namespace Database\Factories;

use App\Models\{Activity,Counter,Schedule};
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedule_id' =>Schedule::factory(),
            'counter_id' =>Counter::factory(),
            'in' =>$this->faker->time($format = 'H:i:s', $max = 'now'),
            'break' =>$this->faker->time($format = 'H:i:s', $max = 'now'),
            'back' =>$this->faker->time($format = 'H:i:s', $max = 'now'),
            'out' => $this->faker->time($format = 'H:i:s', $max = 'now')
        ];
    }
}
