<div class="flex justify-center">
@switch($nivelGasolina)
        @case(0)
            <img class="p-2 h-36 w-66" src="{{ asset('plantillas/tablero_gasolina/gasolina-0.png')}}" alt="Vacío">
            @break

        @case(25)
            <img class="p-2 h-36 w-66" src="{{ asset('plantillas/tablero_gasolina/gasolina-25.png')}}" alt="1/4">
            @break

        @case(50)
            <img class="p-2 h-36 w-66" src="{{ asset('plantillas/tablero_gasolina/gasolina-50.png')}}" alt="1/2">
            @break

        @case(75)
            <img class="p-2 h-36 w-66" src="{{ asset('plantillas/tablero_gasolina/gasolina-75.png')}}" alt="3/4">
            @break

        @case(100)
            <img class="p-2 h-36 w-66" src="{{ asset('plantillas/tablero_gasolina/gasolina-100.png')}}" alt="Lleno">
            @break
    @endswitch

</div>
