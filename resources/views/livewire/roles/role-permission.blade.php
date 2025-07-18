<div>
    <x-modal name="rolePermissionModal{{ $role->id }}" :escapeClose="false" maxWidth="xl" :show="$errors->isNotEmpty()" focusable>
        <div class="card bg-white rounded-lg shadow-md overflow-hidden">
            <form wire:submit.prevent="update" class="space-y-4">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        Kemaskini Permission
                    </h2>
                </div>
                <div class="card-body p-4">
                    @foreach ($permissions as $key => $permission)
                        <div class="flex items-center me-4 mb-2">
                            <input type="checkbox" id="checkbox-{{ $permission->id }}-{{ $key }}" wire:model="permission_ids"
                                value="{{ $permission->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600  focus:ring-2 ">
                            <label for="checkbox-{{ $permission->id }}-{{ $key }}" class="ms-2 text-sm font-medium text-gray-900">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200 mt-6 flex justify-end">
                    <x-secondary-button type="button" x-on:click="$dispatch('close');  $wire.clearModalValidation?.();"
                        class="ms-1">
                        <x-icons.cancel size="size-4" />
                        Batal
                    </x-secondary-button>
                    <x-success-button class="ms-1" x-on:click="watingUpdatePermission()">
                        <x-icons.pencil size="size-4" />
                        Kemaskini
                    </x-success-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
