
@extends('base')

@section('title', 'Permissies koppelen aan rollen')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h2>Nieuwe koppeling maken</h2>

    <form action="{{ route('admin.role-permissions.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="form-group">
            <label for="role_id">Kies een rol</label>
            <select name="role_id" id="role_id" class="form-control" required>
                <option value="">Selecteer een rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="permission_id">Kies een permissie</label>
            <select name="permission_id" id="permission_id" class="form-control" required>
                <option value="">Selecteer een permissie</option>
                @foreach ($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ old('permission_id') == $permission->id ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Permissie koppelen
        </button>
    </form>

    <hr>

    <h2>Bestaande koppelingen</h2>

    @forelse ($roles as $role)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Rol: {{ $role->name }}</strong>
            </div>

            <div class="card-body">
                @if ($role->permissions->isEmpty())
                    <p>Deze rol heeft nog geen permissies.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Permissie</th>
                                <th>Actie</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role->permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <form
                                            action="{{ route('admin.role-permissions.destroy', [$role->id, $permission->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Weet je zeker dat je deze koppeling wilt verwijderen?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Loskoppelen
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @empty
        <p>Er zijn nog geen rollen beschikbaar.</p>
    @endforelse

@endsection
