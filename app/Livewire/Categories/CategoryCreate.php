<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CategoryCreate extends Component
{
    #[Validate]
    public string $name;

    public $is_active;

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
        Gate::authorize('Daftar Kategori Tugasan');
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'is_active' => $this->is_active ? 1 : 0
        ]);

        $this->dispatch('categoryCreated');
    }

    public function render()
    {
        return view('livewire.categories.category-create');
    }
}
