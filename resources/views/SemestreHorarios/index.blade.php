@extends('layouts.app')

@section('content')
<style>
    .draggable {
    z-index: 1000; /* O un valor mayor que el z-index del card */
}

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <div class="card">
                <div class="card-body">
                        <table class="table">
                            <thead>
                                <th class="text-center">Materias</th>
                            </thead>
                            <tbody>
                                @foreach($materias as $materia)
                                <tr>
                                    <td class="text-center draggable" data-materia="{{$materia->id}}">{{$materia->nombre}}</td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
            </div>

        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" data-semestre="{{$semestre->id}}">{{$semestre->nombre}}-HORARIO</div>
                <div>
                </div><br>
                <div class="card-body">
                    <table class="table datatable">
                
                        <thead>
                            <th class="text-center">Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miercoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sabado</th>
                        </thead>
                        <tbody>
                            <div style="text-align: right;" id="droppable_delete">
                                <a href="{{ url('carreras/'.$semestre->carrera_id.'/semestres') }}" class="btn btn-info buttons-copy buttons-html5 btn-sm btn_filters">Atras</a>
                                <img src="{{ asset('storage/images/button_delete.png') }}" style="width: 90px; height: 90px; position: right;" alt="delete">
                            </div>
                            @foreach($horarios as $horario)
                            <tr>
                                <td class="h5 text-center">{{$horario->hora_inicio}}-{{$horario->hora_fin}}</td>
                                <?php
                                    $dias=array("lunes","martes","miercoles","jueves","viernes","sabado",);
                                ?>
                                @foreach($dias as $dia)
                                    <td class="droppable draggable_delete" data-dia="{{$dia}}" data-horario="{{$horario->id}}" >
                                        @php
                                            $periodoExistente = false;
                                        @endphp
                                        @foreach($periodos as $periodo)
                                            @foreach($materias as $materia)
                                                @if($materia->id == $periodo->materia_id)
                                                    @if($periodo->horario_id == $horario->id && $periodo->dia == $dia)
                                                    {{$periodo->materia->nombre}}
                                                    @php
                                                        $periodoExistente = true;
                                                    @endphp
                                                    @endif
                                                @endif
                                            @endforeach
                                            
                                        @endforeach

                                        @if(!$periodoExistente)
                                            <img src="{{ asset('storage/images/suma.png') }}" alt="Imagen" style="height: 30px; width:130px" class="imagen-droppable">
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    Botones_exportar();
    $('.draggable').draggable({
        helper: 'clone',
        revert: 'invalid'
    });
    $('.draggable_delete').draggable({
        helper: 'clone',
        revert: 'invalid',
        start: function(event, ui) {
        celdaDraggable = $(this);
    }
    });
    $('.droppable').droppable({
        accept: '.draggable',
        drop: function(event, ui) {
            const materiaId = ui.helper.data('materia');
            const horarioId = $(this).data('horario');
            const dia = $(this).data('dia');
            const semestreId = $(".card-header").data("semestre");
            console.log(semestreId);
            // Obtén el nombre de la materia
            const materiaNombre = ui.helper.text();
            var celdaDroppable = $(this);
            var estadoInicial = celdaDroppable.html();
            celdaDroppable.text(materiaNombre);

            // Aquí puedes guardar el registro en tu tabla periodo
            // utilizando una solicitud AJAX a tu controlador de Laravel.
            // Asegúrate de enviar materiaId y dia al controlador.

            // Ejemplo de solicitud AJAX (puedes usar Axios u otra librería):
            $.ajax({
                url: '{{ route('guardar_registro_periodo') }}',
                type: 'POST',
                data: {
                    materia_id: materiaId,
                    horario_id:horarioId,
                    semestre_id: semestreId,
                    dia: dia,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response);
                    
                    if (response.error) {
                        celdaDroppable.html(estadoInicial);
                        alert('Error: ' + response.error);
                        
                        //evertDraggable();
                    }
                    Botones_exportar();
                    //alert('Registro guardado con éxito');
                }
            });
        }
    });
    $('#droppable_delete').droppable({
        accept: '.draggable_delete',
        drop: function (event, ui) {
            // Acceder a los datos del elemento arrastrable (ui.helper)
            const materiaId = ui.helper.data('materia');
            const horarioId = ui.helper.data('horario');
            const dia = ui.helper.data('dia');
            const semestreId = $(".card-header").data("semestre"); 
            celdaDraggable.html("<img src='{{ asset('storage/images/suma.png') }}' alt='Imagen' style='height: 30px; width:130px' class='imagen-droppable'>");
            console.log(materiaId);
            // Resto del código...
            $.ajax({
                url: '{{ route('eliminar_periodo') }}',
                type: 'POST',
                data: {
                    materia_id: materiaId,
                    horario_id: horarioId,
                    semestre_id: semestreId,
                    dia: dia,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log('Respuesta del servidor:', response);
                    Botones_exportar();
                }
            });
        }
    });
});
function Botones_exportar(){
    if ($.fn.DataTable.isDataTable('.datatable')) {
        $('.datatable').DataTable().destroy();
    }
    table = $('.datatable').DataTable( {
            /****************  EXPORTAR *********************/
            bDeferRender: false,
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: '{{ $semestre->nombre }} - Horario',
                    text:'Excel',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3,4,5,6]
                     }
                },
                {
                    extend: 'pdfHtml5',
                    messageTop: '{{ $semestre->nombre }} - Horario',
                    text:'PDF',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3,4,5,6,]
                     }
                },
                {
                    extend: 'print',
                    messageTop: '{{ $semestre->nombre }} - Horario',
                    text:'Imprimir',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3,4,5,6,]
                     }
                }
            ],
            /**************** FIN EXPORTAR *********************/
            language: {
                "decimal": "",
                "emptyTable": "No existen datos",
                "info": "",
                "infoEmpty": "Sin resultados encontrados",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Resultados",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            ordering: false, // Deshabilita la ordenación de columnas
            paging: false, // Deshabilita la paginación
            searching: false
        } );
    
    $(".dt-buttons").appendTo($('#datatable_button_stack' )).css('display', 'block');
    $(".btn_filters").removeClass("dt-button");
}
</script>

@endsection