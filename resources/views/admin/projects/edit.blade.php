@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h1>Modifica Progetto</h1>

        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="p-3 w-50 m-auto" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label text-uppercase">Nome Progetto</label>
                <input type="text" required class="form-control" name="name_project" id="name_project" value="{{ old('name_project', $project->name_project) }}">
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label text-uppercase">Tipologia</label>
                <select class="form-select" name="type_id" id="type_id" aria-label="Floating label select example">
                    <option value="">Seleziona una Tipologia</option>
                    @foreach ($types as $type)
                        <option @selected( old('type_id', optional($project->type)->id ) == $type->id ) value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label text-uppercase">Stato</label>
                <select class="form-select" name="status" id="status" aria-label="Default select example">
                    <option>Seleziona uno Stato</option>
                    <option @selected(old('status', $project->status) === 'Completato') value="Completato">Completato</option>
                    <option @selected(old('status', $project->status) === 'In corso') value="In corso">In corso</option>
                    <option @selected(old('status', $project->status) === 'Non completato') value="Non completato">Non completato</option>
                </select>
            </div> 

            <div class="mb-3">
                <p class="mb-0 text-uppercase">Seleziona le tecnologie:</p>
                @foreach ($technologies as $technology)
                    <div class="form-check form-check-inline">
                        <input name="technologies[]" class="form-check-input" type="checkbox" id="technology-{{ $technology->id }}" value="{{ $technology->id }}" @checked( in_array($technology->id, old('technologies', $project->technologies->pluck('id')->toArray())) )>
                        <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->name }}</label>
                    </div>
                @endforeach                
            </div>

            <div class="mb-3">
                <label for="cover_image" class="form-label text-uppercase">Immagine</label>
                <input class="form-control" type="file" name="cover_image" id="cover_image">
            </div>

            <div class="mb-3">
                <label for="basic-url" class="form-label text-uppercase">Data Creazione</label>
                <input type="date" required class="form-control" name="date_creation" value="{{ old('date_creation', $project->date_creation) }}"">
            </div>
            
            <button type="submit" class="btn btn-primary">Modifica</button>
                
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</section>
    
@endsection