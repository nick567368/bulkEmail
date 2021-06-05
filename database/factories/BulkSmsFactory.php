<?php

namespace Database\Factories;

use App\Models\BulkSms;
use Illuminate\Database\Eloquent\Factories\Factory;

class BulkSmsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BulkSms::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tilte' => $this->faker->word,
        'email' => $this->faker->word,
        'screem' => $this->faker->word,
        'screen' => $this->faker->word,
        'message' => $this->faker->word,
        'image_path' => $this->faker->word,
        'image_name' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
