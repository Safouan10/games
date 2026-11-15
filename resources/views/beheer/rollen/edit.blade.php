@extends('base')

@section('title', 'Rol aanpassen')

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

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Naam van de rol</label>

            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                value="{{ old('name', $role->name) }}"
                required
            >
        </div>

        <p>Guard name: <strong>web</strong></p>

        <button type="submit" class="btn btn-primary">
            Wijzigingen opslaan
        </button>

        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            Terug
        </a>
    </form>

@endsection