<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class TaskIndex extends Component
{

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        Gate::authorize('Urus Tugasan');
    }

    #[On('toggleCompleteAction')]
    public function toggleComplete($id)
    {
        $task = Task::findOrFail($id);
        $task->is_completed = !$task->is_completed;
        $task->save();

        $this->dispatch('taskUpdated');
    }


    #[On('deleteTaskAction')]
    public function deleteTask(Task $task)
    {
        Gate::authorize('Hapus Tugasan');

        $task->delete();

        $this->dispatch('taskDeleted');
    }

    public function render()
    {
        $tasks = Task::with(['category', 'tags'])
            ->where('user_id', Auth::user()->id)
            ->paginate(3);

        return view('livewire.tasks.task-index', [
            'tasks' => $tasks
        ])->layout('layouts.app');
    }
}
