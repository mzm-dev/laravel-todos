<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CategoryEdit extends Component
{
    public ?Category $category;

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
            '*.required' => 'Medan ini diperlukan',
            'name.string' => 'Medan ini mestilah string',
            'name.min' => 'Panjang medan ini mestilah minimal :min karakter',
            'name.max' => 'Panjang medan ini mestilah maksimal :max karakter',
            'name.unique' => 'Maklumat ini sudah wujud',
        ];
    }

    public function mount(Category $category)
    {
        Gate::authorize('Kemaskini Kategori Tugasan');

        $this->category = $category;

        $this->name = $category->name;

        $this->is_active = $category->is_active;
    }

    public function clearModalValidation()
    {
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $this->category->fill([
            'name' => $this->name,
            'is_active' => $this->is_active ? 1 : 0
        ])->save();

        $this->dispatch('categoryUpdated', [
            'id' => $this->category->id,
        ]);

    }
    public function render()
    {
        return view('livewire.categories.category-edit');
    }
}
