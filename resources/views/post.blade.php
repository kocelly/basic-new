@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">

                    <h3 class="card-title"> {{$post->title}} </h3>

                    @if ($post->image)
                        <img src="{{ $post->get_image }}" alt="" class="card-img-top">
                        <br>
                    @endif
                
                    <p class="card-text">
                        {{$post->body}}
                    </p>
                    
                    @if($post->iframe)
                        <div class="embed-responsive embed-responsive-16by9">
                        {!! $post->iframe !!}
                        </div>
                        <br>
                    @endif
                                        
                    <p class="text-muted mb-0">
                        <em>
                            &ndash; {{$post->user->name}}
                        </em>
                        {{ $post->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection