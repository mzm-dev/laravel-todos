<div x-data="permissionIndex">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permission') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <div class="title">
                        <h2 class="text-lg font-semibold">Senarai Permission</h2>
                        <p class="text-sm text-gray-600">Card subtitle or description</p>
                    </div>
                    <div>
                        <button x-on:click="syncPermissionAction()" class="px-4 py-2 bg-blue-600 text-white rounded">
                            Sync Permissions
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 divide-y divide-outline dark:divide-outline-dark">
                        <thead
                            class="font-medium text-gray-900 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse ($permissions as $permission)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $permission->name }}
                                    </th>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200">
                    {{ $permissions->links() }}
                </div>
                <div class="card-footer" x-show="!outputClear">
                    <div class="p-4">
                        <button wire:click="syncOk()" class="px-4 py-2 bg-green-600 text-white rounded">
                            Selesai
                        </button>
                        <div class="mt-4 bg-gray-100 p-4 rounded text-sm whitespace-pre-wrap">
                            {{ $output }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('permissionIndex', () => ({
            syncPermissionAction() {
                Swal.fire({
                    title: 'Adakah anda pasti?',
                    text: "Penjanaan permission akan memakan masa sebentar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $wire.syncPermissions();
                        Swal.fire({
                            // title: 'Hapus!',
                            text: 'Tunggu sebentar...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $wire.on('syncPermissionDone', (event) => {
                            Swal.fire(
                                'Berjaya',
                                'Jananaan permission telah selesai.',
                                'success'
                            );
                        });
                    }
                });
            }
        }));
    </script>
@endscript
