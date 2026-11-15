@extends('base')

@section('title', 'Rol toevoegen')

@section('content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Naam van de rol</label>

            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Bijvoorbeeld: medewerker"
                required
            >
        </div>

        <p>Guard name wordt automatisch ingesteld op: <strong>web</strong></p>

        <button type="submit" class="btn btn-success">
            Opslaan
        </button>

        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            Terug
        </a>
    </form>

@endsection