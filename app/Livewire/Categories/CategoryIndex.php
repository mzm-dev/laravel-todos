<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CategoryIndex extends Component
{

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        Gate::authorize('Urus Kategori Tugasan');
    }

    #[On('deleteCategoryAction')]
    public function deleteCategory(Category $category)
    {
        Gate::authorize('Hapus Kategori Tugasan');

        $category->delete();

        $this->dispatch('categoryDeleted');
    }

    #[On('categoryCreated')]
    #[On('categoryUpdated')]
    public function render()
    {
        $categories = Category::paginate();

        return view('livewire.categories.category-index', [
            'categories' => $categories
        ])->layout('layouts.app');
    }
}
