<div x-data="userIndex">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <div class="title">
                        <h2 class="text-lg font-semibold">Senarai Pengguna</h2>
                        <p class="text-sm text-gray-600">Card subtitle or description</p>
                    </div>
                    <div>
                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'userCreateModal')">
                            <x-icons.plus size="size-4" />
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div>
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 divide-y divide-outline dark:divide-outline-dark">
                            <thead
                                class="font-medium text-gray-900 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Peranan</th>
                                    <th scope="col" class="px-6 py-3 w-24">Status</th>
                                    <th scope="col" class="px-6 py-3 w-40">Tindakan</th>
                                </tr>
                            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                                @forelse ($users as $user)
                                    <tr
                                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200  hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->name }}
                                        </th>
                                        <td class="px-6 py-2">
                                            @foreach ($user->roles->pluck('name') ?? [] as $item)
                                                <span
                                                    class="rounded-radius w-fit border border-outline bg-surface-alt px-2 py-1 text-xs font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark mr-1">
                                                    {{ $item }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-2">
                                            @if ($user->is_active)
                                                <x-badge color='green'>
                                                    Aktif
                                                </x-badge>
                                            @else
                                                <x-badge color='red'>
                                                    Tidak Aktif
                                                </x-badge>
                                            @endif

                                        </td>
                                        <td class="px-6 py-2">
                                            <div class="flex gap-2">

                                                <x-warning-button x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'userEditModal{{ $user->id }}')">
                                                    <x-icons.pencil size="size-4" />
                                                    Kemaskini
                                                </x-warning-button>


                                                <x-danger-button x-data=""
                                                    x-on:click="deleteUserAction({{ $user->id }})">
                                                    <x-icons.trash size="size-4" />
                                                    Padam
                                                </x-danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                    <div wire:ignore>
                                        <livewire:users.user-edit :user="$user" />
                                    </div>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore>
        <livewire:users.user-create />
    </div>
</div>

@script
    <script>
        Alpine.data('userIndex', () => ({
            watingSaveUser() {
                Swal.fire({
                    text: 'Record sedang disimpan.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('userCreated', (event) => {
                    $wire.dispatch('close-modal', 'userCreateModal');

                    Swal.fire(
                        'Simpan!',
                        'Record telah disimpan.',
                        'success'
                    );
                });
            },
            watingUpdateUser() {
                Swal.fire({
                    text: 'Record sedang dikemaskini.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('userUpdated', (event) => {

                    $wire.dispatch('close-modal', 'userEditModal' + event[0].id);

                    Swal.fire(
                        'Kemaskini!',
                        'Record telah dikemaskini.',
                        'success'
                    );
                });
            },
            deleteUserAction(userId) {
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
                        $wire.deleteuser(userId);
                        Swal.fire({
                            // title: 'Hapus!',
                            text: 'Tunggu sebentar...',
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $wire.on('userDeleted', (event) => {
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
