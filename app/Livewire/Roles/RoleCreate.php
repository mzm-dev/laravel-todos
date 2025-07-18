<?php

namespace App\Livewire\Roles;


use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleCreate extends Component
{
    #[Validate]
    public string $name;


    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'unique:roles,name',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Medan ini diperlukan',
            'name.string' => 'Medan ini mestilah string',
            'name.min' => 'Panjang medan ini mestilah minimal :min karakter',
            'name.max' => 'Panjang medan ini mestilah maksimal :max karakter',
            'name.unique' => 'Maklumat ini sudah wujud',
        ];
    }

    public function mount()
    {
        Gate::authorize('Daftar Peranan');
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Role::create([
            'name' => $this->name
        ]);

        $this->dispatch('roleCreated');
    }

    public function render()
    {
        return view('livewire.roles.role-create');
    }
}
