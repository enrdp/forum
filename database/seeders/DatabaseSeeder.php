<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\{User,Thread, Reply};
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()
            ->count(50)
            ->create()
            ->each(function ($user) {
                Thread::factory()
                    ->count(2)
                    ->create(['user_id' => $user->id])
                    ->each(function ($thread) use ($user) {
                        Reply::factory()
                            ->count(5)
                            ->create([
                                'user_id' => $user->id,
                                'thread_id' => $thread->id,
                            ]);
                    });
            });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
