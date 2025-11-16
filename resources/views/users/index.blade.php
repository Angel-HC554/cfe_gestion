<x-layouts.app>
    <div class="flex items-center justify-between mb-6 mx-10">
        <flux:heading size="xl">Usuarios</flux:heading>

        <!-- Modal trigger with Alpine.js -->
        <div x-data="{ showModal: false }" @user-created.window="showModal = false" @refresh-users-list.window="location.reload()">
            <flux:button variant="primary" icon="user-plus" @click="showModal = true">
                Crear usuario
            </flux:button>

            <!-- Modal with Alpine.js control -->
            <div
                x-show="showModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 overflow-y-auto"
                style="display: none;"
                @click.self="showModal = false">

                <!-- Modal backdrop -->
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-zinc-950/20 "></div>

                <!-- Modal content -->
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="relative min-h-screen flex items-center justify-center p-4">

                    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
                        <!-- Modal header -->
                        <div class="flex items-center justify-end px-4 pt-4">
                            <button @click="showModal = false"
                                    class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Modal body with Livewire component -->
                        <div class="pb-6 px-6">
                            <livewire:auth.register />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-10">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-1">
            <thead class="text-xs text-green-950 uppercase bg-accent-content/20 dark:bg-green-900 dark:text-amber-50">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">RPE</th>
                    <th scope="col" class="px-6 py-3">Agencia</th>
                    <th scope="col" class="px-6 py-3">Cargo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->usuario }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->agencia }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">{{ $user->cargo }}</a></td>
                    </tr>
                @empty
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 text-center" colspan="5">
                            <flux:heading size="lg" class="inline-flex"><flux:icon.exclamation-circle
                                    class="mr-2" />No se encontraron usuarios.</flux:heading>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    @if (method_exists($users, 'links'))
        <div class="mt-4  mx-10">
            {{ $users->links() }}
        </div>
    @endif

</x-layouts.app>
