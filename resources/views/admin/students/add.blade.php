@extends('layouts.admin')

@section('title', 'Ajouter un u00e9tudiant')

@section('page_title', 'Gestion des u00e9tudiants')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="modal-add-student">
                <span class="close-btn" onclick="window.history.back()">&times;</span>
                <h3>Ajouter un u00e9tudiant</h3>
                
                <form action="{{ route('admin.users.store-student') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="code">Code :</label>
                        <input type="text" id="code" name="code" class="form-control" value="R34678906" required>
                    </div>
                    

                    
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Pru00e9nom:</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="telephone">Téléphone:</label>
                        <input type="tel" id="telephone" name="telephone" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance:</label>
                        <input type="date" id="date_naissance" name="date_naissance" class="form-control">
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="add-btn">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    
    .modal-add-student {
        max-width: 500px;
        margin: 30px auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: relative;
    }
    
    .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
        color: #999;
    }
    
    h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #8668FF;
        font-weight: 600;
        font-size: 1.5rem;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }
    
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .form-group input:focus {
        border-color: #8668FF;
        outline: none;
        box-shadow: 0 0 0 2px rgba(134, 104, 255, 0.2);
    }
    
    .add-btn {
        background-color: #8668FF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s;
    }
    
    .add-btn:hover {
        background-color: #7559e8;
    }
</style>
@endsection
