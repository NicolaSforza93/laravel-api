@extends('layouts.app')

@section('content')

<div class="container p-5">
    <div class="card w-50 mx-auto">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Tipologie</h5>
            <button class="btn btn-success btn-sm">
                <a href="{{ route('admin.types.create') }}" class="text-white text-decoration-none">Nuovo</a>
            </button>
        </div>
        <ul class="list-group list-group-flush">
            @forelse ($types as $type)
            <li class="list-group-item d-flex justify-content-between">
                <a href="{{ route('admin.types.show', $type->id) }}" class="text-decoration-none text-dark">
                    {{ $type->name }}
                </a>

                <div>
                    <span class="edit">
                        <a href="{{ route('admin.types.edit', $type->id) }}" class="text-decoration-none">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </span>
                    <span class="remove" data-bs-toggle="modal" data-bs-target="#modal-{{$type->id}}">

                        <i class="fa-solid fa-circle-minus text-danger"></i>

                        <div class="modal fade" id="modal-{{ $type->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Attenzione</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h6>Vuoi davvero eliminare <br> {{ $type->name }}?</h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Annulla</button>
                                        <form action="{{ route('admin.projects.destroy', $type->id) }}" method="POST">
                    
                                            @csrf
                    
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-danger btn-sm">Cancella</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
            </li>
        @empty
            <li class="list-group-item">Non ci sono Tipologie</li>
        @endforelse
        </ul>
    </div>
</div>

@endsection