@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">
                            {{-- get_excerpt lo creamos a partir del campo body getAttr --}}
                            {{ $post->body }}
                        </p>
                        <p class="text-muted mb-0">
                            <em>
                                &ndash; {{ $post->user->name }}
                            </em>
                            {{ $post->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
