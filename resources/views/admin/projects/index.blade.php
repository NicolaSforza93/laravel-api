@extends('layouts.app')

@section('content')

<section>
    <div class="container py-4">
        <h1>Progetti realizzati</h1>
        <table class="table table-striped table-hover">
            <thead class="table-light">
              <tr>
                <th scope="col">Nome Progetto</th>
                <th scope="col">Tipologia</th>
                <th scope="col">Data Creazione</th>
                <th scope="col">Stato</th>
                @if (request()->has('trashed'))
                <th scope="col" class="text-end"></th>
                @else
                <th scope="col" class="text-end">
                    <button class="btn btn-success btn-sm">
                        <a href="{{ route('admin.projects.create') }}" class="text-white text-decoration-none">Nuovo</a>
                    </button>
                </th>
                @endif
                <th scope="col" class="text-end">
                    @if (request()->has('trashed'))
                    <button class="btn btn-secondary btn-sm">
                        <a href="{{ route('admin.projects.index') }}" class="text-white text-decoration-none">Tutti i Progetti</a>
                    </button>
                    @else
                    <button class="btn btn-secondary btn-sm position-relative">
                        <a href="{{ route('admin.projects.index', ['trashed']) }}" class="text-white text-decoration-none">Cestino 
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                {{ $trashedElements }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                    </button>                                          
                    @endif
                </th>
              </tr>
            </thead>
            <tbody class="border">
                @forelse ($projects as $project)
                <tr>
                    <td>
                        <a href="{{ route('admin.projects.show', $project->id) }}" class="text-decoration-none">
                            {{ $project->name_project }}
                        </a>
                    </td>
                    <td>
                        {{ isset($project->type) ? $project->type->name : '-' }}
                        {{-- {{ optional($project->type)->name }} --}}
                    </td>
                    <td>{{ $project->date_creation }}</td>
                    <td>{{ $project->status }}</td>
                    @if ($project->trashed())
                    <td class="text-end">
                        <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST">
                            @csrf
    
                            <button type="submit" class="btn btn-success btn-sm">Ripristina</button>
    
                        </form> 
                    </td>                       
                    @else
                    <td class="text-end">
                        <button type="button" class="btn btn-primary btn-sm">
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-white text-decoration-none">Modifica</a>
                        </button>
                    </td>                        
                    @endif
                    <td class="text-end">
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
                                            
                                            <button type="submit" class="btn btn-danger btn-sm">{{ $project->trashed() ? 'Cancella definitivamente' : 'Cancella' }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{$project->id}}">Cancella</button
                    </td>
                </tr>
                @empty
                    <tr>
                        <td>Non ci sono Progetti</td>    
                    </tr>        
                @endforelse
            </tbody>
          </table>
    </div>
</section>
    
@endsection