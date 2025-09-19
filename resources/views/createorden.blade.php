<x-layouts.app :title="__('Dashboard')">

    <div class="flex justify-between items-center mx-10">
        <flux:heading size="xl">ORDEN DE SERVICIO Y REPARACION</flux:heading>
        <div class="flex">
            <flux:icon.document-text class="mr-2" />
            <flux:heading size="lg">Orden No: 120</flux:heading>
        </div>
    </div>
    <form action="" method="post">
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="Area" placeholder="Escribe el area" name="area" required/>
            {{-- datalist --}}
            <flux:input label="Zona" value="MERIDA" name="zona" required/>
            <flux:input label="Departamento" value="COMERCIAL" name="departamento" required/>
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="No. Economico" placeholder="Escribe No" name="noeconomico" required/>
            {{-- datalist --}}
            {{-- autoacompletar input --}}
            <flux:input label="Marca" placeholder="Escribe marca" name="marca" required/>
            {{-- datalist --}}
            {{-- autoacompletar input --}}
            <flux:input label="Placas" placeholder="Escribe placa" name="placas" required/>
            {{-- placas --}}
            {{-- autoacompletar input --}}
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="Taller" placeholder="Escribe taller" name="taller" />
            <flux:input label="Kilometraje" placeholder="Escribe kilometraje" name="kilometraje" />
            <flux:input type="date" label="Fecha de recepción" name="fecharecep" autocomplete="on"/>

        </div>
        <div class="mx-10 my-5">
            <flux:separator />
        </div>
        {{-- Listo solo falta datalist --}}

        <flux:heading size="lg" class="mx-10 my-5">MARCAR LA (S) CASILLA (S) QUE INDIQUE LA EXISTENCIA:
        </flux:heading>

        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Radiocomunicación" name="radiocom" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />

            <x-radio-group label="Llanta de Refacción" name="llantaref" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
            <x-radio-group label="Autoestereo" name="autoestereo" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Gato Hidráulico" name="gatoh" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />

            <x-radio-group label="Llave de Cruz" name="llavecruz" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
            <x-radio-group label="Extintor" name="extintor" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si  X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No  X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Botiquín" name="botiquin" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />

            <x-radio-group label="Escaleras sencilla" name="escalera" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
            <x-radio-group label="Escaleras Doble" name="escalerad" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si X', 'label_opcion' => 'SI'],
                ['id' => 'opcion2', 'value' => 'No X', 'label_opcion' => 'NO', 'checked' => 'checked'],
            ]" />
        </div>

        <div class="mx-10">
            <flux:heading class="my-5" size="lg">Seleccione el nivel de gasolina:</flux:heading>

            <input name="gasolina" type="range" min="0" max="100" value="50" class="range w-full"
                step="25" aria-label="range" />
            <div class="w-full flex justify-between text-xs px-2">
                <span class="text-base">Vacio</span>
                <span class="text-base">1/4</span>
                <span class="text-base">1/2</span>
                <span class="text-base">3/4</span>
                <span class="text-base">Lleno</span>
            </div>

        </div>
        <div class="mx-10 my-5">
            <flux:separator />
        </div>
        <flux:heading size="lg" class="mx-10">PARA SER LLENADO POR LA PERSONAL QUE ORDENA LOS TRABAJOS MARCAR LA
            (S)
            CASILLA (S) QUE INDIQUE LA REPARACION (ES) A EFECTUAR:</flux:heading>
        <div class="grid grid-cols-2 gap-2 mx-10">
            <flux:checkbox.group label="">
                <flux:checkbox label="Afincacion mayor" name="vehicle1" value="X" />
                <flux:checkbox label="Ajuste motor" name="vehicle2" value="X" />
                <flux:checkbox label="Alineacion y balanceo" name="vehicle3" value="X" />
                <flux:checkbox label="Amortiguadores" name="vehicle4" value="X" />
                <flux:checkbox label="Cambio de aceite y filtro" name="vehicle5" value="X" />
                <flux:checkbox label="Clutch" name="vehicle6" value="X" />
                <flux:checkbox label="Diagnostico" name="vehicle7" value="X" />
                <flux:checkbox label="Dirección" name="vehicle8" value="X" />
                <flux:checkbox label="Servicio lavado y engrasado" name="vehicle9" value="X" />
                <flux:checkbox label="Hojalateria y pintura" name="vehicle10" value="X" />
            </flux:checkbox.group>

            <flux:checkbox.group label="">
                <flux:checkbox label="Medio motor" name="vehicle11" value="X" />
                <flux:checkbox label="Motor completo" name="vehicle12" value="X" />
                <flux:checkbox label="Parabrisas y vidrios" name="vehicle13" value="X" />
                <flux:checkbox label="Frenos" name="vehicle14" value="X" />
                <flux:checkbox label="Sistema electrico" name="vehicle15" value="X" />
                <flux:checkbox label="Sistema de enfriamiento" name="vehicle16" value="X" />
                <flux:checkbox label="Suspension" name="vehicle17" value="X" />
                <flux:checkbox label="Transmision y diferencial" name="vehicle18" value="X" />
                <flux:checkbox label="Tapiceria" name="vehicle19" value="X" />
                <flux:checkbox label="Otro" name="vehicle20" value="X" checked />
            </flux:checkbox.group>
        </div>
        <div class="mx-10 my-5 grid grid-cols-2 gap-2">
            <flux:input name="observacion" icon="list-bullet" label="Observaciones:" placeholder="Escribe aqui" required/>
            <flux:input type="date" label="Fecha de firma" name="fechafirm" />

        </div>
        <div class="mx-10 my-5">
            <flux:separator />
        </div>

        <div class="mx-10 my-5">
            <div class="grid grid-cols-3 gap-4 mb-5">
                <flux:field>
                    <flux:badge>SOLICITA AREA USUARIA</flux:badge>
                    <flux:input icon="user" name="areausuaria" required/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rpeusuaria" />
                    {{-- autoacompletar input --}}
                </flux:field>
                <flux:field>
                    <flux:badge>AUTORIZA JEFE DE DEPTO. AREA USUARIA</flux:badge>
                    <flux:input icon="user" name="autoriza" required/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rpejefedpt" />
                    {{-- autoacompletar input --}}
                </flux:field>
                <flux:field>
                    <flux:badge>SERVICIOS AUTORIZADOS Y RECIBIDOS POR RESPONSABLE DE PV</flux:badge>
                    <flux:input icon="user" name="resppv" required/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rperesppv" />
                    {{-- autoacompletar input --}}
                </flux:field>
            </div>
            <div class="flex justify-center ">
                <flux:button variant="primary" class="w-72" type="submit">GENERAR DOCUMENTO</flux:button>
            </div>

        </div>
        </form>

</x-layouts.app>
