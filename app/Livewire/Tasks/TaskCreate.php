<?php

namespace App\Livewire\Tasks;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskCreate extends Component
{
    public $title, $description, $category_id, $tag_ids = [], $due_date;

    public function mount()
    {
        Gate::authorize('Daftar Tugasan');
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category_id' => 'nullable',
            'due_date' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'user_id' => Auth::id(),
            'due_date' => $this->due_date,
        ]);

        $task->tags()->sync($this->tag_ids);

        $this->dispatch('taskCreated');
    }

    #[On('taskCreated')]
    public function modalClose()
    {
        $this->dispatch('close');
    }

    public function render()
    {
        return view('livewire.tasks.task-create', [
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ])->layout('layouts.app');
    }
}
