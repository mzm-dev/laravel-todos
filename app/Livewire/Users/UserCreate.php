<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{

    #[Validate]
    public string $name;

    #[Validate]
    public string $email;

    public $is_active;

    public $role_ids = [];

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:users,name',
            ],
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Medan ini diperlukan',
            'name.string' => 'Medan ini mestilah string',
            'name.min' => 'Panjang medan ini mestilah minimal :min karakter',
            'name.max' => 'Panjang medan ini mestilah maksimal :max karakter',
            'name.unique' => 'Maklumat ini sudah wujud',
        ];
    }

    public function mount()
    {
        Gate::authorize('Daftar Pengguna');
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ]);

        $user->syncRoles($this->role_ids);

        $this->dispatch('userCreated');
    }
    public function render()
    {
        return view('livewire.users.user-create', [
            'roles' => Role::all()
        ]);
    }
}
