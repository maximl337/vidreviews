<?php

use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(App\User::class)->create([
            'email' => 'angad_dubey@hotmail.com',
            'password' => bcrypt('test123')
        ]);

        $reviewers = factory(App\User::class, 6)->create();

        foreach($reviewers as $reviewer) {
            factory(App\Review::class)->create([
                'user_id' => $user->id,
                'reviewer_id' => $reviewer->id
            ]);
        }
    }
}
