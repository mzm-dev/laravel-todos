<?php

namespace App\Livewire\Roles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        Gate::authorize('Urus Peranan');
    }

    public function render()
    {
        $roles = Role::paginate();

        return view('livewire.roles.role-index', [
            'roles' => $roles
        ])->layout('layouts.app');
    }
}
