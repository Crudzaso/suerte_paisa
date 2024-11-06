<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($permission) ? 'Edit Permission' : 'Create Permission' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ isset($permission) ? 'Edit Permission' : 'Create Permission' }}</h1>
        
        <form action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST">
            @csrf
            @if (isset($permission))
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="name" class="form-label">Permission Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name ?? '') }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">{{ isset($permission) ? 'Save Changes' : 'Create Permission' }}</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
