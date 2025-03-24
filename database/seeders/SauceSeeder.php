<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sauces;
use App\Models\User;

class SauceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer des sauces avec des utilisateurs existants
        $sauce = Sauces::create([
            'userId' => 1, // L'ID de l'utilisateur doit déjà exister
            'name' => 'Sauce Super Hot',
            'manufacturer' => 'HotSauce Inc.',
            'description' => 'Une sauce incroyablement piquante!',
            'mainPepper' => 'Carolina Reaper',
            'imageUrl' => 'super-hot-sauce.jpg',
            'heat' => 10,
            'likes' => 100,
            'dislikes' => 10,
        ]);

        // Lier les utilisateurs qui aiment la sauce
        $usersWhoLiked = User::inRandomOrder()->take(5)->pluck('userId');
        $sauce->usersLiked()->attach($usersWhoLiked);

        // Lier les utilisateurs qui n'aiment pas la sauce
        $usersWhoDisliked = User::inRandomOrder()->take(3)->pluck('userId');
        $sauce->usersDisliked()->attach($usersWhoDisliked);

        // Créer plusieurs autres sauces fictives via factory
        \App\Models\Sauces::factory(5)->create();
    }
}
