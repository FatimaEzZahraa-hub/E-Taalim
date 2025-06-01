@extends('layouts.admin')

@section('title', 'Cru00e9er un Niveau')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Cru00e9er un Niveau</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.classes.index') }}">Classes</a></li>
        <li class="breadcrumb-item active">Cru00e9er un niveau</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-layer-group me-1"></i>
            Nouveau niveau
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.classes.niveaux.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom du niveau</label>
                    <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    <div class="form-text">Une description courte et claire du niveau (optionnel).</div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Cru00e9er le niveau</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
