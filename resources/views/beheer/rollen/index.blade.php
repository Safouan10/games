@extends('base')

@section('title', 'Rollen beheren')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('admin.roles.create') }}" class="btn btn-success mb-3">
        Rol toevoegen
    </a>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Guard</th>
                <th>Bewerken</th>
                <th>Verwijderen</th>
            </tr>
        </thead>

        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>

                    <td>
                        <a href="{{ route('admin.roles.edit', $role) }}"
                           class="btn btn-primary btn-sm">
                            Bewerken
                        </a>
                    </td>

                    <td>
                        @if($role->name !== 'admin')
                            <form action="{{ route('admin.roles.destroy', $role) }}"
                                  method="POST"
                                  onsubmit="return confirm('Weet je zeker dat je deze rol wilt verwijderen?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    Verwijderen
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Beschermde rol</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Er zijn nog geen rollen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection