<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex justify-between">
        <flux:heading size="xl">Ordenes de servicio y reparación</flux:heading>
        <flux:button variant="primary" href="{{ route('ordenvehiculos.create') }}">CREAR ORDEN</flux:button>
        </div>

         {{-- Mensajes  --}}
        <div id="flash-message-container"
            style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999;">

            <script>
                window.addEventListener('orden-eliminada', event => {
                    const container = document.getElementById('flash-message-container');

                    const div = document.createElement('div');
                    div.style.transition = 'opacity 0.5s';
                    div.style.background = '#d4edda'; // Verde claro
                    div.style.color = '#155724';
                    div.style.border = '1px solid #c3e6cb';
                    div.style.padding = '1rem';
                    div.style.borderRadius = '5px';
                    div.style.marginBottom = '1rem';
                    div.innerText = event.detail.message;

                    container.appendChild(div);

                    setTimeout(() => {
                        div.style.opacity = '0';
                        setTimeout(() => div.remove(), 500);
                    }, 2000);
                });
            </script>
        </div>


        <livewire:ordenes-table lazy/>
    </div>
</x-layouts.app>
