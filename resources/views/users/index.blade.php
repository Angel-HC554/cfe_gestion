<x-layouts.app >
    <div class="flex items-center justify-between mb-6 mx-10">
        <flux:heading size="xl">Usuarios</flux:heading>
        <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-10">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-1">
            <thead class="text-xs text-green-950 uppercase bg-accent-content/20 dark:bg-green-900 dark:text-amber-50">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Usuario</th>
                    <th scope="col" class="px-6 py-3">Agencia</th>
                    <th scope="col" class="px-6 py-3">Cargo</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->usuario }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->agencia }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $user->cargo }}</td>
                    </tr>
                @empty
                    <tr class="bg-zinc-50 border-b dark:bg-green-950 dark:border-gray-700 border-zinc-200">
                        <td class="px-6 py-4 text-center" colspan="5">
                            <flux:heading size="lg" class="inline-flex"><flux:icon.exclamation-circle class="mr-2" />No se encontraron usuarios.</flux:heading>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    @if (method_exists($users, 'links'))
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</x-layouts.app>
