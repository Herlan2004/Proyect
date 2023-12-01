@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">USUARIOS</div>
                <div>
                    <a href="{{url('users/create')}}">
                        <button class="btn btn-success">Crear Usuario</button>
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
                            <td>Nombre</td>
                            <td>Rol</td>
                            <td>email</td>
                            <td>Fecha creacion</td>
                            <td>Acciones</td>
                        </thead>
                        
                        <tbody>
                            
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{ $user->role->nombre }}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{url('users/'.$user->id.'/edit')}}">Editar</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</button>
                                    </form>
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
                    messageTop: 'Usuarios',
                    text:'Excel',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3]
                     }
                },
                {
                    extend: 'pdfHtml5',
                    messageTop: 'Usuarios',
                    text:'PDF',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3]
                     }
                },
                {
                    extend: 'print',
                    messageTop: 'Usuarios',
                    text:'Imprimir',
                    className: 'btn btn-info buttons-copy buttons-html5 btn-sm btn_filters',
                    exportOptions: {
                         columns: [0,1,2,3]
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

    table.columns([0,1,2,3]).every( function () {
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
