@extends('layouts.app')

@section('content')

<section>
    @if(session()->has('message_edit'))
    <div class="container p-2">
        <div class="alert alert-primary">
            <i class="fa-solid fa-circle-check"></i>
            {{ session()->get('message_edit') }}
        </div>
    </div>
    @endif
    <div class="container py-4">
        <div class="row">
            @if ($project->cover_image)
            <div class="col order-1">
                <div class="project-mockup">
                    @if ($project->cover_image)
                        <figure class="ratio ratio-1x1">
                            <img src="{{ asset('storage/' . $project->cover_image) }}" class="object-fit-contain" alt="">
                        </figure>            
                    @endif
                </div>
            </div>                
            @endif

            <div class="col">
                <div class="project-details">
                    <h1>{{ $project->name_project }}</h1>
                    @if ($project->type)
                        <p class="text-decoration-underline">{{ $project->type->name }}</p>
                    @endif
        
                    <ul class="d-flex gap-3 ps-0">
                        @foreach ($project->technologies as $technology)
                            <li class="badge text-bg-dark p-2 fw-medium">{{ $technology->name }}</li>
                        @endforeach
                    </ul>
                    
                    <p>{{ $project->date_creation }}</p>
                    <p>{{ $project->description }}</p>
        
                    <button type="button" class="btn btn-primary btn-sm">
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-white text-decoration-none">Modifica</a>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{$project->id}}">Cancella</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Attenzione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h6>Vuoi davvero eliminare <br> {{ $project->name_project }}?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Annulla</button>
                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">

                        @csrf

                        @method('DELETE')
                        
                        <button type="submit" class="btn btn-danger btn-sm">Cancella</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
    
@endsection