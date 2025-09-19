<div class="flex flex-col">
    {{-- <label class="flex justify-center">{{ $label }}</label> --}}
    <div class="flex justify-center mb-2">
        <flux:badge color="emerald">{{ $label }}</flux:badge>
    </div>

    <div class="justify-center flex gap-2">
        @foreach ($opciones as $opcion)
        <label for="{{ $opcion['id'] }}">{{ $opcion['label_opcion'] }}</label>
            <input
                type="radio"
                name="{{ $name }}"
                id="{{ $opcion['id'] }}"
                value="{{ $opcion['value'] }}"
                {{ $opcion['checked'] ?? '' }}
            >
        @endforeach
    </div>
</div>
{{-- Asi se usa el componente

<x-radio-group label="Elige una opción" name="respuestas_encuesta1" :opciones="[
            ['id' => 'opcion1', 'value' => 'SI', 'label_opcion' => 'Sí, me gusta'],
            ['id' => 'opcion2', 'value' => 'NO', 'label_opcion' => 'No, no me gusta'],
        ]" />

--}}
