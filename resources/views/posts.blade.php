@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($posts as $post)
                    <div class="card my-4">
                        @if ($post->image)
                            <img src="{{ $post->get_imagen }}" class="card-img-top img-thumbnail">
                        @endif
                        @if ($post->iframe)
                            <div class="ratio ratio-16x9 mx-1">
                                {!! $post->iframe !!}
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bolder">{{ $post->title }}</h5>
                            <p class="card-text">
                                {{-- get_excerpt lo creamos a partir del campo body getAttr --}}
                                {{ $post->get_excerpt }}
                                <a href="{{ route('post', $post) }}" class="d-inline-block">Leer Más</a>
                            </p>
                            <p class="text-muted mb-0">
                                <em>
                                    &ndash; {{ $post->user->name }}
                                </em>
                                {{ $post->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
                {{-- Para poder editar la paginacion
                    php artisan vendor:publish --tag=laravel-pagination
                    Usamos dicho comando que nos permite configurarla
                --}}

                {{ $posts->links('vendor.pagination.bootstrap-4') }}



            </div>
        </div>
    </div>
@endsection
