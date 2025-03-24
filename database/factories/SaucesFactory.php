<?php

namespace Database\Factories;

use App\Models\Sauces;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaucesFactory extends Factory
{
    /**
     * Le modèle associé à cette factory.
     *
     * @var string
     */
    protected $model = Sauces::class;

    /**
     * Définir l'état par défaut de la sauce.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userId' => User::inRandomOrder()->first()->id, 
            'name' => $this->faker->word() . ' Sauce',
            'manufacturer' => $this->faker->company(),
            'description' => $this->faker->sentence(), 
            'mainPepper' => $this->faker->word(), 
            'imageUrl' => $this->faker->imageUrl(), 
            'heat' => $this->faker->numberBetween(1, 10), 
            'likes' => $this->faker->numberBetween(0, 1000), 
            'dislikes' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
