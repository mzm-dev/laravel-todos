<?php

namespace App\Livewire\Roles;


use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{
    public ?Role $role;

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
                'unique:roles,name,' . ($this->role->id ?? 'null'),
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

    public function mount(Role $role)
    {
        Gate::authorize('Kemaskini Peranan');

        $this->role = $role;

        $this->name = $role->name;
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function update()
    {

        $this->validate();

        $this->role->fill([
            'name' => $this->name
        ])->save();

        $this->dispatch('roleUpdated', [
            'id' => $this->role->id,
        ]);
    }

    public function render()
    {
        return view('livewire.roles.role-edit');
    }
}
