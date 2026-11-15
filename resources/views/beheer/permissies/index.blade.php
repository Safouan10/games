@extends('base')

@section('title', 'Permissies beheren')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.permissions.create') }}" class="btn btn-success mb-3">
        Permissie toevoegen
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
            @forelse($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->guard_name }}</td>

                    <td>
                        <a href="{{ route('admin.permissions.edit', $permission) }}"
                           class="btn btn-primary btn-sm">
                            Bewerken
                        </a>
                    </td>

                    <td>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}"
                              method="POST"
                              onsubmit="return confirm('Weet je zeker dat je deze permissie wilt verwijderen?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm">
                                Verwijderen
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Er zijn nog geen permissies.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection