<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-500">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-red-400/70">
            Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500 text-white"
    >
        Hapus Akun
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#161b22] border border-gray-700 text-white">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                Apakah Anda yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-[#0f1115] border-gray-700 text-white"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-700 text-white hover:bg-gray-600 border-none">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ml-3 bg-red-600 hover:bg-red-500">
                    Hapus Akun Permanen
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>