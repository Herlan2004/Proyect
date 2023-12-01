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
                        <tbody id="idmateria">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" data-laboratorio="{{$laboratorio->id}}">{{ $laboratorio->nombre }} - Horario
                    
                </div><br>
                
                <div>
                    <select class="form-control" name="carrera" id="idcarrera">
                        <option>Seleccione una carrera</option>
                        @foreach($carreras as $carrera)
                            <option value="{{$carrera->id}}" data-carrera="{{$carrera->id}}">{{$carrera->nombre}}</option>
                        @endforeach
                    </select>
                </div><br>
                <div>
                    <select class="form-control" name="semestre" id="idsemestre">
                        <option>Seleccione el semestre</option>
                    </select>
                    
                </div>
                <div class="card-body">
                
                    <table class="table datatable">
                        <div style="text-align: right;" id="droppable_delete">
                            <a href="{{ url('laboratorios') }}" class="btn btn-info buttons-copy buttons-html5 btn-sm btn_filters">Atras</a>
                            <img src="{{ asset('storage/images/button_delete.png') }}" style="width: 90px; height: 90px; position: right;" alt="delete">
                        </div>
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
                            
                            @foreach($horarios as $horario)
                            <tr>
                                <td class="h5 text-center">{{$horario->hora_inicio}}-{{$horario->hora_fin}}</td>
                                <?php
                                    $dias=array("lunes","martes","miercoles","jueves","viernes","sabado",);
                                ?>
                                @foreach($dias as $dia)
                                    <td class="droppable draggable_delete" data-dia="{{$dia}}" data-horario="{{$horario->id}}">
                                        @php
                                            $periodoExistente = false;
                                        @endphp
                                        @foreach($periodos as $periodo)
                                            @foreach($materias as $materia)
                                                @if($materia->id == $periodo->materia_id)
                                                    @if($periodo->horario_id == $horario->id && $periodo->dia == $dia && $laboratorio->id == $periodo->laboratorio_id)
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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    Botones_exportar();
    $('#idcarrera').on('change', function(){
        $.ajax({
        url: '{{ url('buscar_carrera') }}',
            type: 'POST',
            data: {
                carrera_id: $(this).val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                var options="<option selected>Seleccione el semestre:</option>";
                //console.log(response[0]['id']);
                for(var i=0; i<response.length;i++){
                    
                    options=options+'<option value="'+response[i]['id']+'">'+response[i]['nombre']+'</option>';
                }
                //alert('Registro guardado con éxito');
                $('#idsemestre').html('');
                $('#idsemestre').html(options);
            }
        });
    })
    $('#idsemestre').on('change',function(){
        $.ajax({
            url: '{{ url('buscar_semestre')}}',
            type:'POST',
            data: {
                semestre_id:$(this).val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response)
            {
                console.log('Respuesta del servidor:', response);
                var tr=""
                console.log(response[0]['id']);
                for(var i=0; i<response.length;i++){
                    tr=tr+'<tr><td class="text-center draggable" data-materia="'+response[i]['id']+'">'+response[i]['nombre']+'</td></tr>'
                }
                $('#idmateria').html('');
                $('#idmateria').html(tr);
            }
        });
    })
    

    $('.droppable').droppable({
        accept: '.draggable',
        drop: function(event, ui) {
            const materiaId = ui.helper.data('materia');
            const horarioId = $(this).data('horario');
            const dia = $(this).data('dia');
            const laboratorioId= $(".card-header").data("laboratorio");

            // Obtén el nombre de la materia
            const materiaNombre = ui.helper.text();
            var celdaDroppable = $(this);
            var estadoInicial = celdaDroppable.html();
            celdaDroppable.text(materiaNombre);
            
            /*const revertDraggable = function() {
                ui.draggable.appendTo($(ui.sender));
            };*/
            $.ajax({
                url: '{{ route('guardar_registro_periodo') }}',
                type: 'POST',
                data: {
                    materia_id: materiaId,
                    
                    horario_id:horarioId,
                    laboratorio_id: laboratorioId,
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
                    /*else {
                        celdaDroppable.text(materiaNombre);
                    }*/
                    Botones_exportar();
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
            const dia = ui.helper.data('dia'); // Acceder a la data del elemento arrastrable
            const laboratorioId = $(".card-header").data("laboratorio");
            celdaDraggable.html("<img src='{{ asset('storage/images/suma.png') }}' alt='Imagen' style='height: 30px; width:130px' class='imagen-droppable'>");
            console.log(ui.helper.html());
            console.log(materiaId);
            // Resto del código...
            
            $.ajax({
                url: '{{ route('eliminar_periodo') }}',
                type: 'POST',
                data: {
                    materia_id: materiaId,
                    horario_id: horarioId,
                    laboratorio_id: laboratorioId,
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
                    messageTop: '{{ $laboratorio->nombre }} - Horario',
                    text:'Excel',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3,4,5,6]
                     }
                },
                {
                    extend: 'pdfHtml5',
                    messageTop: '{{ $laboratorio->nombre }} - Horario',
                    text:'PDF',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3,4,5,6,]
                     }
                },
                {
                    extend: 'print',
                    messageTop: '{{ $laboratorio->nombre }} - Horario',
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
$(document).on('mouseenter', '.draggable', function() {
    $('.draggable').draggable({
        helper: 'clone',
        revert: 'invalid',
    });

    
});
$(document).on('mouseenter','.draggable_delete', function(){
    $('.draggable_delete').draggable({
        helper: 'clone',
        revert: 'invalid',
        start: function(event, ui) {
        // Almacenar una referencia al elemento original antes de que comience el arrastre
        celdaDraggable = $(this);
    }
    });
    
    
})


</script>
@endsection