<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        Gate::authorize('Urus Pengguna');
    }

    #[On('deleteUserAction')]
    public function deleteUser(User $user)
    {
        Gate::authorize('Hapus Pengguna');

        $user->delete();

        $this->dispatch('userDeleted');
    }

    #[On('userCreated')]
    #[On('userUpdated')]
    public function render()
    {
        $users = User::paginate();

        return view('livewire.users.user-index', [
            'users' => $users
        ])->layout('layouts.app');
    }
}
