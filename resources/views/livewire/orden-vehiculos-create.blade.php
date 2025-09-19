<div>
    <form action="{{ isset($ordenEditar) ? route('ordenvehiculos.update', $ordenEditar->id): route('ordenvehiculos.store')}}" method="post">
        route('ordenvehiculos.store')
        @csrf
        @if (isset($ordenEditar))
            @method('PUT')
        @endif
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="Area" placeholder="Escribe el area" name="area" required value="{{ isset($ordenEditar) ? $ordenEditar->area : '' }}"/>
            {{-- datalist --}}
            <flux:input label="Zona" name="zona" required value="{{ isset($ordenEditar) ? $ordenEditar->zona : 'MERIDA' }}"/>
            <flux:input label="Departamento" name="departamento" required value="{{ isset($ordenEditar) ? $ordenEditar->departamento : 'COMERCIAL' }}"/>
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="No. Economico" placeholder="Escribe No" name="noeconomico" required value="{{ isset($ordenEditar) ? $ordenEditar->noeconomico : '' }}"/>
            {{-- datalist --}}
            {{-- autoacompletar input --}}
            <flux:input label="Marca" placeholder="Escribe marca" name="marca" required value="{{ isset($ordenEditar) ? $ordenEditar->marca : '' }}"/>
            {{-- datalist --}}
            {{-- autoacompletar input --}}
            <flux:input label="Placas" placeholder="Escribe placa" name="placas" required value="{{ isset($ordenEditar) ? $ordenEditar->placas : '' }}"/>
            {{-- placas --}}
            {{-- autoacompletar input --}}
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10 my-5">
            <flux:input label="Taller" placeholder="Escribe taller" name="taller" value="{{ isset($ordenEditar) ? $ordenEditar->taller : '' }}"/>
            <flux:input label="Kilometraje" placeholder="Escribe kilometraje" name="kilometraje" value="{{ isset($ordenEditar) ? $ordenEditar->kilometraje : '' }}"/>
            <flux:input type="date" label="Fecha de recepción" name="fecharecep" value="{{ isset($ordenEditar) ? $ordenEditar->fecharecep : '' }}"/>
        </div>
        <div class="mx-10 my-5">
            <flux:separator />
        </div>
        {{-- Listo solo falta datalist --}}

        <flux:heading size="lg" class="mx-10 my-5">MARCAR LA (S) CASILLA (S) QUE INDIQUE LA EXISTENCIA:
        </flux:heading>

        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Radiocomunicación" name="radiocom" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI','checked' => isset($ordenEditar) && trim($ordenEditar->radiocom) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->radiocom) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />

            <x-radio-group label="Llanta de Refacción" name="llantaref" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->llantaref) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->llantaref) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
            <x-radio-group label="Autoestereo" name="autoestereo" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->autoestereo) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->autoestereo) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Gato Hidráulico" name="gatoh" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->gatoh) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->gatoh) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />

            <x-radio-group label="Llave de Cruz" name="llavecruz" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->llavecruz) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->llavecruz) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
            <x-radio-group label="Extintor" name="extintor" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si ', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->extintor) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No ', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->extintor) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
        </div>
        <div class="grid grid-cols-3 gap-4 mx-10">
            <x-radio-group label="Botiquín" name="botiquin" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->botiquin) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->botiquin) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />

            <x-radio-group label="Escaleras sencilla" name="escalera" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->escalera) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->escalera) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
            <x-radio-group label="Escaleras Doble" name="escalerad" :opciones="[
                ['id' => 'opcion1', 'value' => 'Si', 'label_opcion' => 'SI' ,'checked' => isset($ordenEditar) && trim($ordenEditar->escalerad) == 'Si' ? 'checked' : null],
                ['id' => 'opcion2', 'value' => 'No', 'label_opcion' => 'NO', 'checked' => isset($ordenEditar) && trim($ordenEditar->escalerad) == 'No' || !isset($ordenEditar) ? 'checked' : null],
            ]" />
        </div>

        <div class="mx-10">
            <flux:heading class="my-5" size="lg">Seleccione el nivel de gasolina:</flux:heading>

            <input name="gasolina" type="range" min="0" max="100" value="{{ isset($ordenEditar) ? $ordenEditar->gasolina : '50' }}" class="range w-full"
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
        <flux:heading size="lg" class="mx-10 mb-5">PARA SER LLENADO POR LA PERSONA QUE ORDENA LOS TRABAJOS MARCAR LA
            (S)
            CASILLA (S) QUE INDIQUE LA REPARACION (ES) A EFECTUAR:</flux:heading>
        <div class="grid grid-cols-2 gap-2 mx-10">
    <div>
        <flux:checkbox
            class="mb-1"
            label="Afinacion mayor"
            name="vehicle1"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle1 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Ajuste motor"
            name="vehicle2"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle2 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Alineacion y balanceo"
            name="vehicle3"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle3 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Amortiguadores"
            name="vehicle4"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle4 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Cambio de aceite y filtro"
            name="vehicle5"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle5 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Clutch"
            name="vehicle6"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle6 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Diagnostico"
            name="vehicle7"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle7 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Dirección"
            name="vehicle8"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle8 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Servicio lavado y engrasado"
            name="vehicle9"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle9 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Hojalateria y pintura"
            name="vehicle10"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle10 == 'X'"
        />
    </div>

    <div>
        <flux:checkbox
            class="mb-1"
            label="Medio motor"
            name="vehicle11"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle11 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Motor completo"
            name="vehicle12"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle12 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Parabrisas y vidrios"
            name="vehicle13"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle13 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Frenos"
            name="vehicle14"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle14 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Sistema electrico"
            name="vehicle15"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle15 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Sistema de enfriamiento"
            name="vehicle16"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle16 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Suspension"
            name="vehicle17"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle17 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Transmision y diferencial"
            name="vehicle18"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle18 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Tapiceria"
            name="vehicle19"
            value="X"
            :checked="isset($ordenEditar) && $ordenEditar->vehicle19 == 'X'"
        />
        <flux:checkbox
            class="mb-1"
            label="Otro"
            name="vehicle20"
            value="X"
            :checked="(isset($ordenEditar) && $ordenEditar->vehicle20 == 'X') || !isset($ordenEditar)"
        />
    </div>
</div>
        <div class="mx-10 my-5 grid grid-cols-2 gap-2">
            <flux:input name="observacion" icon="list-bullet" label="Observaciones:" placeholder="Escribe aqui"
                required value="{{ isset($ordenEditar) ? $ordenEditar->observacion : '' }}"/>
            <flux:input type="date" label="Fecha de firma:" name="fechafirm" value="{{ isset($ordenEditar) ? $ordenEditar->fechafirm : '' }}"/>

        </div>
        <div class="mx-10 my-5">
            <flux:separator />
        </div>

        <div class="mx-10 my-5">
            <div class="grid grid-cols-3 gap-4 mb-5">
                <flux:field>
                    <flux:badge>SOLICITA AREA USUARIA</flux:badge>
                    <flux:input icon="user" name="areausuaria" placeholder="Escribe aqui" required value="{{ isset($ordenEditar) ? $ordenEditar->areausuaria : '' }}"/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rpeusuaria" placeholder="Escribe aqui" value="{{ isset($ordenEditar) ? $ordenEditar->rpeusuaria : '' }}"/>
                    {{-- autoacompletar input --}}
                </flux:field>
                <flux:field>
                    <flux:badge>AUTORIZA JEFE DE DEPTO. AREA USUARIA</flux:badge>
                    <flux:input icon="user" name="autoriza" placeholder="Escribe aqui" required value="{{ isset($ordenEditar) ? $ordenEditar->autoriza : '' }}"/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rpejefedpt" placeholder="Escribe aqui" value="{{ isset($ordenEditar) ? $ordenEditar->rpejefedpt : '' }}"/>
                    {{-- autoacompletar input --}}
                </flux:field>
                <flux:field>
                    <flux:badge>SERVICIOS AUTORIZADOS Y RECIBIDOS POR RESPONSABLE DE PV</flux:badge>
                    <flux:input icon="user" name="resppv" placeholder="Escribe aqui" required value="{{ isset($ordenEditar) ? $ordenEditar->resppv : '' }}"/>
                    {{-- datalist --}}
                    <flux:badge>R.P.E</flux:badge>
                    <flux:input icon="identification" name="rperesppv" placeholder="Escribe aqui" value="{{ isset($ordenEditar) ? $ordenEditar->rperesppv : '' }}"/>
                    {{-- autoacompletar input --}}
                </flux:field>
            </div>
            <div class="flex justify-center ">
                {{--  --}}

                <flux:button variant="primary" class="w-72" type="submit">
                    {{ isset($ordenEditar) ? 'ACTUALIZAR DOCUMENTO' : 'GENERAR DOCUMENTO' }}
                </flux:button>

                {{-- Modal de confirmacion --}}
                <flux:modal name="confirmar" class="md:min-w-lg" wire:model.live="showModal">
                    <div class="space-y-6">
                        <div>
                            <h1 class="text-xl">{{isset($ordenEditar) ? 'El documento se actualizó correctamente!':'El documento se generó correctamente!'}}</h1>
                            <flux:text class="mt-2">{{isset($ordenEditar) ? 'Se ha actualizado correctamente la informacion.':'Se ha guardado correctamente la informacion.'}}</flux:text>
                        </div>
                        <div class="flex">
                            <flux:spacer />
                            <flux:button icon="arrow-down-tray" class="ml-5"
                                href="{{ route('ordenvehiculos.descargar', ['id' => $ordenId]) }}">
                                Descargar Documento
                            </flux:button>
                            <flux:button variant="primary" class="ml-5" href="{{ route('ordenvehiculos.index') }}">
                                Aceptar</flux:button>
                        </div>
                    </div>
                </flux:modal>
            </div>

        </div>
    </form>
</div>
