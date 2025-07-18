<div>
    <x-modal name="roleCreateModal" maxWidth="md" :show="$errors->isNotEmpty()" focusable>
        <div class="card bg-white rounded-lg shadow-md overflow-hidden">
            <form wire:submit.prevent="save" class="space-y-4">
                <div class="card-header p-4 border-b border-gray-200 flex justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        Daftar Peranan
                    </h2>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <x-text-input :label="__('Name')" wire:model.blur="name" id="name" class="mt-1 block w-3/4"
                            placeholder="{{ __('Name') }}" />
                    </div>
                </div>

                <div class="card-footer p-4 bg-gray-100 border-t border-gray-200 mt-6 flex justify-end">
                    <x-secondary-button type="button" x-on:click="$dispatch('close');  $wire.clearModalValidation?.();"
                        class="ms-1">
                        <x-icons.cancel size="size-4" />
                        Batal
                    </x-secondary-button>
                    <x-success-button x-on:click="watingSaveRole()" class="ms-1">
                        <x-icons.pencil size="size-4" />
                        Simpan
                    </x-success-button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
