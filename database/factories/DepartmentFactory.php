<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\DepartmentService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'queue_code' => Str::random(2),
            'services_per_day' => 20
        ];
    }

     /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withServices()
    {
        return $this->state([]);
    }
}
