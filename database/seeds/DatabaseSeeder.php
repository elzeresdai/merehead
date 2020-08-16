<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $authors = factory(\App\Authors::class, 15)->create()->pluck('id');

      factory(\App\User::class, 5)->create()->each(function($user) use ($authors){
          $user->books()->saveMany(
              factory(\App\Book::class, 5)->make()->each(function ($book) use ($authors){
                 $book->author_id = rand(1,count($authors));
              })
          );
      });
    }

}
