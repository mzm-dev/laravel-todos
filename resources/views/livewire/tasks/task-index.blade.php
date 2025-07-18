<div x-data="taskIndex">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tugasan') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="card bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <div class="title">
                        <h2 class="text-lg font-semibold">Senarai Tugasan</h2>
                        <p class="text-sm text-gray-600">Card subtitle or description</p>
                    </div>
                    <div>
                        <x-primary-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'taskCreateModal')">
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
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-4 w-32">Kategori</th>
                                <th scope="col" class="px-6 py-4">Tag</th>
                                <th scope="col" class="px-6 py-4 w-24">Status</th>
                                <th scope="col" class="px-6 py-4 w-40">Tindakan</th>
                            </tr>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse ($tasks as $task)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <h3
                                            class="text-lg font-semibold {{ $task->is_completed ? 'line-through text-gray-400' : '' }}">
                                            {{ $task->title }}
                                        </h3>
                                    </th>
                                    <td class="px-6 py-2">
                                        {{ $task->category->name ?? 'Tiada Kategori' }}
                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex gap-2">

                                            @foreach ($task->tags as $tag)
                                                <span
                                                    class="rounded-radius w-fit border border-outline bg-surface-alt px-2 py-1 text-xs font-medium text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark mr-1">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach

                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        @if ($task->is_completed)
                                            <x-badge color='green' class="cursor-pointer"
                                                x-on:click.prevent="toggleCompleteAction({{ $task->id }})">
                                                Selesai
                                            </x-badge>
                                        @else
                                            <x-badge color='gray' class="cursor-pointer"
                                                x-on:click.prevent="toggleCompleteAction({{ $task->id }})">
                                                Belom
                                            </x-badge>
                                        @endif

                                    </td>
                                    <td class="px-6 py-2">
                                        <div class="flex gap-2">

                                            <x-warning-button x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'taskEditModal{{ $task->id }}')">
                                                <x-icons.pencil size="size-4" />
                                                Kemaskini
                                            </x-warning-button>

                                            <x-danger-button x-data=""
                                                x-on:click="deleteTaskAction({{ $task->id }})">
                                                <x-icons.trash size="size-4" />
                                                Padam
                                            </x-danger-button>
                                        </div>
                                    </td>
                                </tr>

                                <livewire:tasks.task-edit :task="$task" key="{{ $task->id }}" />

                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>

    <livewire:tasks.task-create />

</div>

@script
    <script>
        window.addEventListener('livewire:form-failed', function() {
            Swal.close(); // Tutup loading Swal
        });
        Alpine.data('taskIndex', () => ({

            watingUpdateTask() {
                Swal.fire({
                    text: 'Record sedang dikemaskini.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                $wire.on('taskUpdated', (event) => {

                    $wire.dispatch('close-modal', 'taskEditModal' + event[0].id);

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
