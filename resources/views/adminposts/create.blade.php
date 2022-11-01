@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="d-inline-block mt-2">Crear Artículo</h6>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container">
                            <div class="row">
                                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label"> Título *</label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="Titulo del Post">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Imagen</label>
                                        <input class="form-control" name="file" type="file" id="formFile">
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="body" placeholder="Ingrese El Contenido del Post" id="floatingTextarea2"
                                                rows="6" required style="min-height:150px "></textarea>
                                            <label for="floatingTextarea">Contenido *</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-floating">
                                            <textarea class="form-control" name="iframe" placeholder="Ingrese El Contenido del Post" id="floatingTextarea"
                                                rows="6" style="min-height: 100px;"></textarea>
                                            <label for="floatingTextarea">Contenido Embebido</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
