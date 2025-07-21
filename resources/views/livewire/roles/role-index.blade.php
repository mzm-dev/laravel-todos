<div x-data="roleIndex">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peranan') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <div class="title">
                        <h2 class="text-lg font-semibold">Senarai Peranan</h2>
                        <p class="text-sm text-gray-600">Card subtitle or description</p>
                    </div>
                    <div>
                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'roleCreateModal')">
                            <x-icons.plus size="size-4" />
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 divide-y divide-outline dark:divide-outline-dark">
                        <thead
                            class="font-medium text-gray-900 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-full">Name</th>
                                <th scope="col" class="px-6 py-4">Permission</th>
                                <th scope="col" class="px-6 py-4">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse ($roles as $role)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $role->name }}
                                    </th>
                                    <td class="px-6 py-2">
                                        <div class="flex gap-2">
                                            <x-primary-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'rolePermissionModal{{ $role->id }}')">
                                                Permission
                                            </x-primary-button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex gap-2">
                                            <x-warning-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'roleEditModal{{ $role->id }}')">
                                                <x-icons.pencil size="size-4" />
                                                Kemaskini
                                            </x-warning-button>
                                        </div>
                                    </td>
                                </tr>
                                <div wire:ignore>
                                    <livewire:roles.role-edit :role="$role" />
                                    <livewire:roles.role-permission :role="$role" />
                                </div>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>

        <livewire:roles.role-create />
    </div>
</div>

@script
    <script>
        Alpine.data('roleIndex', () => ({
            watingSaveRole() {
                Swal.fire({
                    text: 'Record sedang disimpan.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('roleCreated', (event) => {
                    $wire.dispatch('close-modal', 'roleCreateModal').then(() => {
                        Swal.fire(
                            'Simpan!',
                            'Record telah disimpan.',
                            'success'
                        );
                    });
                });
            },
            watingUpdateRole() {
                Swal.fire({
                    text: 'Record sedang dikemaskini.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('roleUpdated', (event) => {

                    $wire.dispatch('close-modal', 'roleEditModal' + event[0].id);

                    Swal.fire(
                        'Kemaskini!',
                        'Record telah dikemaskini.',
                        'success'
                    );
                });
            },
            watingUpdatePermission() {
                Swal.fire({
                    text: 'Record sedang dikemaskini.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('syncPermissionUpdated', (event) => {

                    $wire.dispatch('close-modal', 'rolePermissionModal' + event[0].id);

                    Swal.fire(
                        'Kemaskini!',
                        'Record telah dikemaskini.',
                        'success'
                    );
                });
            },
        }));
    </script>
@endscript
