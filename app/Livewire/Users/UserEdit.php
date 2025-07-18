<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public ?User $user;

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
                'unique:users,name,' . ($this->user->id ?? 'null'),
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

    public function mount(User $user)
    {
        Gate::authorize('Kemaskini Pengguna');

        $this->user = $user;

        $this->name = $user->name;

        $this->email = $user->email;

        $this->is_active = $user->is_active;

        $this->role_ids = $user->roles->pluck('name')->toArray();
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $this->user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => $this->is_active,
        ])->save();

        // $this->user->roles()->sync($this->role_ids);
        $this->user->syncRoles($this->role_ids);

        $this->dispatch('userUpdated', [
            'id' => $this->user->id,
        ]);
    }

    public function render()
    {

        return view('livewire.users.user-edit', [
            'roles' => Role::all(),
        ]);
    }
}
