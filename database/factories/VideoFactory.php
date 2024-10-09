<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> json_encode(['en'=>$this->faker->words(2,true), 'ar'=>$this->faker->words(2,true)],JSON_UNESCAPED_UNICODE),
            'path'=>'1727606057610873597VALORANT 04-27-2021 7-56-59-207.mp4',
            'type'=>'paid',
            'course_id'=>$this->faker->numberBetween(1,20),
            ];
    }
}
