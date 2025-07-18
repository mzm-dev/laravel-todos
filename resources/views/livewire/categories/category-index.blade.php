<div x-data="categoryIndex">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kategori') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <div class="title">
                        <h2 class="text-lg font-semibold">Senarai Kategori</h2>
                        <p class="text-sm text-gray-600">Card subtitle or description</p>
                    </div>
                    <div>
                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'categoryCreateModal')">
                            <x-icons.plus size="size-4" />
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div>
                         <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 divide-y divide-outline dark:divide-outline-dark">
                            <thead
                                class="font-medium text-gray-900 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3 w-24">Status</th>
                                    <th scope="col" class="px-6 py-3 w-40">Tindakan</th>
                                </tr>
                            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                                @forelse ($categories as $category)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200  hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $category->name }}
                                        </th>
                                        <td class="px-6 py-2">
                                            @if ($category->is_active)
                                                <x-badge color='green'>
                                                    Aktif
                                                </x-badge>
                                            @else
                                                <x-badge color='gray'>
                                                    Tidak Aktif
                                                </x-badge>
                                            @endif

                                        </td>
                                        <td class="px-6 py-2">
                                            <div class="flex gap-2">

                                                <x-warning-button x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'categoryEditModal{{ $category->id }}')">
                                                    <x-icons.pencil size="size-4" />
                                                    Kemaskini
                                                </x-warning-button>


                                                <x-danger-button x-data=""
                                                    x-on:click="deleteCategoryAction({{ $category->id }})">
                                                    <x-icons.trash size="size-4" />
                                                    Padam
                                                </x-danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div wire:ignore>
                                        <livewire:categories.category-edit :category="$category" />
                                    </div>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore>
        <livewire:categories.category-create />
    </div>
</div>

@script
    <script>
        Alpine.data('categoryIndex', () => ({
            watingSaveCategory() {
                Swal.fire({
                    text: 'Record sedang disimpan.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('categoryCreated', (event) => {
                    $wire.dispatch('close-modal', 'categoryCreateModal');

                    Swal.fire(
                        'Simpan!',
                        'Record telah disimpan.',
                        'success'
                    );
                });
            },
            watingUpdateCategory() {
                Swal.fire({
                    text: 'Record sedang dikemaskini.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('categoryUpdated', (event) => {

                    $wire.dispatch('close-modal', 'categoryEditModal' + event[0].id);

                    Swal.fire(
                        'Kemaskini!',
                        'Record telah dikemaskini.',
                        'success'
                    );
                });
            },
            toggleCompleteAction(categoryId) {
                Swal.fire({
                    title: 'Adakah anda pasti?',
                    text: "Anda tidak boleh membatalkan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.toggleComplete(categoryId);
                        Swal.fire({
                            // title: 'Kemaskini!',
                            text: 'Record sedang dikemaskini.',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $wire.on('categoryUpdated', (event) => {
                            Swal.fire(
                                'Kemaskini!',
                                'Record telah dikemaskini.',
                                'success'
                            );
                        });
                    }
                });
            },
            deleteCategoryAction(categoryId) {
                Swal.fire({
                    title: 'Adakah anda pasti?',
                    text: "Anda tidak boleh membatalkan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.deleteCategory(categoryId);
                        Swal.fire({
                            // title: 'Hapus!',
                            text: 'Tunggu sebentar...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $wire.on('categoryDeleted', (event) => {
                            Swal.fire(
                                'Telah dihapus!',
                                'Record telah dihapus.',
                                'success'
                            );
                        });
                    }
                });
            }
        }));
    </script>
@endscript
