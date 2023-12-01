@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Docentes</div>
                <div>
                    <a href="{{url('docentes/create')}}">
                        <button class="btn btn-success">Crear Docente</button>
                    </a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class='table datatable'>
                        <thead>
                            <td>Fotografia</td>
                            <td>Nombre</td>
                            <td>Correo</td>
                            <td>Telefono</td>
                            <td>Materias</td>
                            <td>Fecha creacion</td>
                            <td>Acciones</td>
                        </thead>
                
                        <tbody>
                            
                            @foreach($docentes as $docente)
                            <tr>
                                <td>
                                @if ($docente->foto)
                                    <img style="width: 50px; height:50px;" src="{{ asset('storage/images/docentes/' .$docente->foto) }}" alt="{{ $docente->nombre }}">
                                @else
                                    <img style="width: 50px; height:50px;" src="{{ asset('storage/images/docentes/docente.png') }}" alt="Sin foto">
                                @endif
                                </td>
                                <td>{{$docente->nombre}}</td>
                                <td>{{$docente->correo}}</td>
                                <td>{{$docente->telefono}}</td>
                                <td>@foreach($docente->materias as $materia)<li>
                                    {{$materia->nombre}}</li>@endforeach
                                </td>
                                <td>{{$docente->created_at}}</td>
                                <td>
                                    <a href="{{url('docentes/'.$docente->id.'/edit')}}" class="btn btn-warning">Editar</a>
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"  onclick="return confirm('¿Estás seguro de eliminar este docente?')">Eliminar</button>
                                </td>
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

<script type="text/javascript">

    table = $('.datatable').DataTable( {
            /****************  EXPORTAR *********************/
            bDeferRender: true,
            dom: '<"row"<"col-md-12"B>><"row"<"col-md-6"l><"col-md-6"f>><"row"<"col-md-12"t>><"row"<"col-md-6"i><"col-md-6"p>>',
            buttons: [
                {
                    extend: 'excel',
                    messageTop: 'Docentes',
                    text:'Excel',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [1,2,3,4,5]
                     }
                },
                {
                    extend: 'pdfHtml5',
                    messageTop: 'Docentes',
                    text:'PDF',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [1,2,3,4,5]
                     }
                },
                {
                    extend: 'print',
                    messageTop: 'Docente',
                    text:'Imprimir',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [1,2,3,4,5]
                     }
                }
            ],
            /**************** FIN EXPORTAR *********************/
            language: {
                "decimal": "",
                "emptyTable": "No existen datos",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
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
            
        } );

    table.columns([1,2,3,4,5]).every( function () {
        var column = this;

        var select = $('<select data-target="'+column[0][0]+'" class="form-control select_filters" style="width:auto; float:left; max-width:200px; height:35px;"><option value="">'+$(column.header()).text()+'</option></select>')
            //.appendTo( $(column.footer()).empty() )
            .appendTo( '#section_filters' )
            .on( 'change', function () {
                table
                .column( $(this).data('target'))
                .search( $(this).val() )
                .draw();
            } );

        column.data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
    } );

    $('#table_items_filter').hide();
    $(".dt-buttons").appendTo($('#datatable_button_stack' )).css('display', 'block');
    $(".btn_filters").removeClass("dt-button");
</script>
@endsection
