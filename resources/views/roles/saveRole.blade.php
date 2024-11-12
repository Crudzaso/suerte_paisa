<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($role) ? 'Edit Role' : 'Create Role' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h1>
        
        <form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
            @csrf
            @if (isset($role))
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name ?? '') }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">{{ isset($role) ? 'Save Changes' : 'Create Role' }}</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
