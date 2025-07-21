<?php

namespace App\Livewire\Roles;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermission extends Component
{
    public ?Role $role;

    public $permission_ids = [];

    public function mount(Role $role)
    {
        Gate::authorize('Kemaskini Permission');

        $this->role = $role;

        $this->permission_ids = $role->permissions->pluck('id')->toArray();
    }

    public function clearModalValidation()
    {
        $this->permission_ids = $this->role->permissions->pluck('id')->toArray();
        $this->resetValidation();
    }

    function update()
    {
        $this->role->syncPermissions($this->permission_ids);

        $this->dispatch('syncPermissionUpdated', [
            'id' => $this->role->id,
        ]);
    }

    public function render()
    {
        $permissions = Permission::all();

        return view('livewire.roles.role-permission', [
            'permissions' => $permissions
        ]);
    }
}
