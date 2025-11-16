<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @include('sweetalert2::index')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css"/>   
</head>

<body class="min-h-screen bg-neutral-50 dark:bg-zinc-800">
    <flux:header sticky class="border-b bg-slate-100 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <a href="{{ route('dashboard') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Inicio') }}
            </flux:navbar.item>

            {{--<flux:navbar.item icon="document-text" :href="route('ordenvehiculos.index')" :current="request()->routeIs('ordenvehiculos.index')"
                wire:navigate>
                {{ __('Orden Vehiculos') }}
            </flux:navbar.item>
            <flux:navbar.item icon="truck" :href="route('vehiculos.index')" :current="request()->routeIs('vehiculos.index')"
                wire:navigate>
                {{ __('Vehiculos') }}
            </flux:navbar.item>--}}

             <flux:dropdown>
                <flux:navbar.item icon:trailing="chevron-down">Opciones</flux:navbar.item>
                <flux:menu class="bg-slate-50!">
                    <flux:navmenu.item icon="document-text" href="{{ route('ordenvehiculos.index') }}" class="hover:text-green-700! hover:bg-zinc-800/5">Generación de órdenes</flux:navmenu.item>
                    <flux:navmenu.item icon="truck" href="{{ route('vehiculos.index') }}" class="hover:text-green-700! hover:bg-zinc-800/5">Vehiculos</flux:navmenu.item>
                    <flux:navmenu.item icon="user" href="{{ route('users.index') }}" class="hover:text-green-700! hover:bg-zinc-800/5">Usuarios</flux:navmenu.item>
                    <flux:menu.submenu icon="clipboard-document-check" heading="Supervisiones" class="hover:text-green-700! bg-slate-50! hover:bg-zinc-800/5">
                        <flux:menu.item icon="calendar" href="{{ route('supervicion_semanal.index') }}" class="hover:text-green-700! hover:bg-zinc-800/5">Semanal</flux:menu.item>
                        <flux:menu.item icon="calendar" href="{{ route('supervicion_diaria.index') }}" class="hover:text-green-700! hover:bg-zinc-800/5">Diario</flux:menu.item>
                        </flux:menu.submenu>
                </flux:menu>
            </flux:dropdown> 

        </flux:navbar>

        <flux:spacer />

        {{--
        <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
            <flux:tooltip :content="__('Buscar')" position="bottom">
                <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#"
                    :label="__('Buscar')" />
            </flux:tooltip>

        </flux:navbar>
         --}}

        <!-- Desktop User Menu -->
        <livewire:mostrar-notificaciones />
        <flux:dropdown position="top" align="end">
            <flux:profile name="{{ auth()->user()->name }}" class="cursor-pointer" :initials="auth()->user()->initials()"  avatar:color="emerald"/>

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Configuración') }}</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Cerrar sesión') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Plataforma')">
                <flux:navlist.item icon="layout-grid" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Inicio') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repositorio') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentación') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>

    {{ $slot }}

    @fluxScripts  
    @include('sweetalert2::index')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Fancybox.bind('[data-fancybox]', {
                // Opciones de Fancybox
                Toolbar: {
                    display: {
                        left: ['infobar'],
                        middle: [],
                        right: ['close'],
                    },
                },
                Thumbs: {
                    type: 'classic',
                },
            });
        });
    </script>
</body>

</html>
