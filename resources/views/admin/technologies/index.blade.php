@extends('layouts.app')

@section('content')

<div class="container p-5">
    <div class="card w-50 mx-auto">
        <div class="card-header">
          <h5 class="card-title">Tecnologie</h5>
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($technologies as $technology)
            <li class="list-group-item">{{ $technology->name }}</li>
        @empty
            
        @endforelse
        </ul>
    </div>
</div>
    
@endsection