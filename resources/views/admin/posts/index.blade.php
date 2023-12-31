@extends('adminlte::page')

@section('title', 'Listado de Publicaciones')

@section('content')
    <div class="p-2"></div>
    <div class="card">
        <div class="card-header">


            <button type="button" class="btn btn-success float-right" id="btnRegistrar">
                <i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Registrar</button>

            <h4>Listado de Publicaciones</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped" id="table_list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TITULO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>IMAGEN</th>
                        <th>ESTADO</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>
                                <a href="{{ asset($post->image) }}" target="_blank">
                                    <img src="{{ asset($post->image) }}" alt="" width="100px">
                                </a>
                            </td>
                            <td>
                                @if ($post->is_active)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td width="10px">
                                <button class="btn btn-secondary btn-sm btnEditar" data-id={{ $post->id }}><i
                                        class="fas fa-edit"></i></button>
                            </td>
                            <td width="10px">
                                <a href="{{ route('admin.posts.show', $post->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                            </td>

                            <td width="10px">
                                <form action={{ route('admin.posts.destroy', $post->id) }} method='post'
                                    class="frmDelete">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formulario de familias</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>

            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        $(document).ready(function() {

            $('#btnRegistrar').click(function() {
                $.ajax({
                    url: "{{ route('admin.posts.create') }}",
                    type: 'GET',
                    success: function(response) {

                        $("#Modal .modal-body").html(response);
                        $("#Modal").modal('show');
                    }
                })
            })

            $('.btnEditar').click(function() {

                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('admin.posts.edit', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {

                        $("#Modal .modal-body").html(response);
                        $("#Modal").modal('show');
                    }
                })
            })


            $('.frmDelete').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Seguro de eliminar?',
                    text: "Este proceso es irreversible",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            })

            var table = $('#table_list').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                },
            });

        });
    </script>

    @if (null !== session('success'))
        <script>
            Swal.fire(
                'Proceso Exitoso',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (null !== session('error'))
        <script>
            Swal.fire(
                'Ocurrió un error',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif
@endsection
