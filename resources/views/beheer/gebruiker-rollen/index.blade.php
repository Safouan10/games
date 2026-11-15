
@extends('base')

@section('title', 'Rollen koppelen aan gebruikers')

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

    <h2>Nieuwe rol koppelen</h2>

    <form action="{{ route('admin.user-roles.store') }}" method="POST" class="mb-4">
        @csrf

        <div class="form-group">
            <label for="user_id">Kies een gebruiker</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">Selecteer een gebruiker</option>

                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

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

        <button type="submit" class="btn btn-primary">
            Rol koppelen
        </button>
    </form>

    <hr>

    <h2>Bestaande koppelingen</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Gebruiker</th>
                <th>E-mailadres</th>
                <th>Rollen</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @forelse ($user->roles as $role)
                            <div class="mb-2">
                                <span class="badge badge-info">
                                    {{ $role->name }}
                                </span>

                                <form
                                    action="{{ route('admin.user-roles.destroy', [$user->id, $role->id]) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Weet je zeker dat je deze rol wilt verwijderen bij deze gebruiker?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Verwijderen
                                    </button>
                                </form>
                            </div>
                        @empty
                            <span>Geen rollen gekoppeld</span>
                        @endforelse
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Er zijn nog geen gebruikers.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
