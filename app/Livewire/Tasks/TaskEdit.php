<?php

namespace App\Livewire\Tasks;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskEdit extends Component
{
    public ?Task $task;

    public $taskId;

    public $title;

    public $description;

    public $category_id;

    public $due_date;

    public $tag_ids = [];

    public function mount(Task $task)
    {
        Gate::authorize('Kemaskini Tugasan');

        $this->task = $task;

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->category_id = $task->category_id;
        $this->due_date = optional($task->due_date)->format('Y-m-d');
        $this->tag_ids = $task->tags->pluck('id')->toArray();
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'required',
            'due_date' => 'required|date',
        ]);
        $this->task->fill([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'user_id' => Auth::id(),
            'due_date' => $this->due_date,
        ])->save();

        $this->task->tags()->sync($this->tag_ids);

         $this->dispatch('taskUpdated', [
            'id' => $this->task->id,
        ]);
    }


    public function render()
    {
        return view('livewire.tasks.task-edit', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ])->layout('layouts.app');
    }
}
