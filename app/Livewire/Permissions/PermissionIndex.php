<?php

namespace App\Livewire\Permissions;

use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    public $output = null;
    public $outputClear = false;

    public function render()
    {
        $permissions = Permission::paginate();
        return view('livewire.permissions.permission-index', [
            'permissions' => $permissions
        ])->layout('layouts.app');
    }


    public function syncPermissions()
    {
        Artisan::call('permission:sync-gates');

        // Ambil output dan tunjuk pada UI
        $this->output = Artisan::output();

        $this->dispatch('syncPermissionDone');
    }

    public function syncOk()
    {
        $this->output = null;
        $this->outputClear = true;
    }
}
