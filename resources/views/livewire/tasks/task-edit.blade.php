<div>
    <x-modal name="taskEditModal{{ $task->id }}" :show="$errors->isNotEmpty()" focusable>
        <div class="card bg-white rounded-lg shadow-md overflow-hidden">
            <form wire:submit.prevent="update" class="space-y-4" x-data
                x-on:submit="Swal.fire({
                    text: 'Record sedang dikemaskini...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => Swal.showLoading()
                })">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        Kemaskini Tugasan
                    </h2>
                </div>
                <div class="card-body p-4">

                    <div class="mb-3">
                        <x-input-label for="name" value="{{ __('Tajuk') }}" />
                        <x-text-input wire:model="title" id="title" class="mt-1 block w-3/4"
                            placeholder="{{ __('Tajuk') }}" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="description" value="{{ __('Deskripsi') }}" />
                        <x-textarea-input wire:model="description" id="description" class="mt-1 block w-3/4"
                            placeholder="{{ __('Deskripsi') }}" />
                    </div>

                    <div class="mb-3">
                        <x-select-input label="Kategori" wire:model="category_id"
                            class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </x-select-input>
                    </div>

                    <div class="mb-3 ">
                        <label class="block mb-1">Tags</label>
                        <div class="flex">
                            @foreach ($tags as $key => $tag)
                                <div class="flex items-center me-4">
                                    <input type="checkbox" id="checkbox-{{ $key }}" wire:model="tag_ids"
                                        value="{{ $tag->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 ">
                                    <label for="checkbox-{{ $key }}"
                                        class="ms-2 text-sm font-medium text-gray-900">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('tag_ids')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="name" value="{{ __('Tarikh Tamat') }}" />
                        <x-text-input type="date" wire:model="due_date" id="due_date"
                            class="w-full border rounded px-3 py-2" placeholder="{{ __('Tarikh Tamat') }}" />
                    </div>

                </div>

                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200 mt-6 flex justify-end">
                    <x-secondary-button type="button" x-on:click="$dispatch('close');  $wire.clearModalValidation?.();"
                        class="ms-1">
                        <x-icons.cancel size="size-4" />
                        Batal
                    </x-secondary-button>
                    <x-success-button class="ms-1">
                        <x-icons.pencil size="size-4" />
                        Kemaskini
                    </x-success-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
