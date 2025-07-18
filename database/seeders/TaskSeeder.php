<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::pluck('id')->toArray();
        $tags = Tag::all();

        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                $task = Task::create([
                    'title' => "Task {$i} for {$user->name}",
                    'description' => "Description for task {$i}",
                    'category_id' => $categories[array_rand($categories)],
                    'user_id' => $user->id,
                    'due_date' => now()->addDays(rand(1, 10)),
                    'is_completed' => rand(0, 1),
                ]);

                // Attach random tags
                $task->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            }
        }
    }
}
