@extends('layouts.app')

@section('content')

<section>
    <div class="container">
        <h1>Nuova Tipologia</h1>

        <form action="{{ route('admin.types.store') }}" method="POST" class="p-3 w-50 m-auto">
            @csrf

            <div class="mb-3">
                <label class="form-label text-uppercase">Nome Tipologia</label>
                <input type="text" required class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Aggiungi</button>
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