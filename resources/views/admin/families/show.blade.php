@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Visualización de Familia</h1>
@stop

@section('content')
    <div class="card">

        <div class="card-body">

            <div class="form-group">
                <label for="">Nombre</label> <br>
                {{ $family->name }}
            </div>

            <div class="form-group">
                <label for="">Descripción</label> <br>
                {{ $family->description }}
            </div>

            <a href={{ route('admin.families.edit', $family) }} class="btn btn-success"><i
                    class="bi bi-pencil-fill"></i>&nbsp;&nbsp;Editar</a>

            <a href={{ route('admin.families.index') }} class="btn btn-danger"><i
                    class="bi bi-backspace-fill"></i>&nbsp;&nbsp;Retornar</a>



            <div class="card mt-3">

                <div class="card-header">
                    <h5>Carga de imágenes</h5>
                </div>

                <div class="card-body">

                    <div class="row">

                        @foreach ($photos as $photo)
                            <div class="col-md-2">

                                <div class="card img-thumbnail mb-3" style="width: 150px;height:150px; border: 1px solid #ccc; position: relative;">
                                    <img src="{{ asset($photo->url) }}" alt="" style="width: 100%;height:100%">
                                    <form action="{{ route('admin.familyphotos.destroy', $photo->id) }}" method="post" style="position: absolute; top: 5px; right: 5px;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="card-footer">
                    <form action={{ route('admin.familyphotos.store') }} method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $family->id }}" name="family_id">
                        <div class="form-group">
                            <div class="custom-file">
                                <div class="input-group mb-3">
                                    <div class="custom-file" style="max-width: 300px;">
                                        <input type="file" class="custom-file-input" id="url" name="url" accept="image/*" onchange="previewImage()" required>
                                        <label class="custom-file-label" for="url" data-browse="Buscar">Seleccionar imagen</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-success" id="upload-btn" disabled>
                                            <i class="fas fa-cloud-upload-alt"></i>&nbsp;&nbsp;Cargar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img id="preview" src="#" class="mb-2 rounded" alt="Vista previa de la imagen" style="display: none; max-width: 100%; max-height: 200px; margin-top: 10px;">                    </form>

                </div>

            </div>

        </div>





    </div>

    <script>
        function previewImage() {
            var preview = document.querySelector('#preview');
            var file = document.querySelector('#url').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
                preview.style.display = "block";
                document.getElementById('upload-btn').disabled = false;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
