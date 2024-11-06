@extends('layouts.app')  
@section('title', 'Редактирование проекта')  
@section('content')  
<div class="contant">  
    <div class="menu-left">  
        <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a>  
        <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a>  
    </div>  
    <div class="container">  
        <h1>Редактирование проекта</h1>  
        <form action="{{ route('updateProject', $project->id) }}" method="POST">  
            @csrf  
            @method('PUT') <!-- Используем метод PUT для обновления --> 
            <div class="card" style="width: 100%;">  
                <div class="card-body">  
                    <div class="mb-3"> 
                        <label for="name" class="form-label">Название проекта</label> 
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required> 
                    </div> 
                    <div class="mb-3"> 
                        <label for="manager" class="form-label">Руководитель</label> 
                        <select class="form-select" id="manager" name="id_manager" required>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id }}" {{ $manager->id == $project->user_id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                    </div> 
                </div>  
                <div class="card-body">  
                    <button type="submit" class="btn btn-success">Сохранить изменения</button>  
                </div>  
            </div>  
        </form> 
    </div>  
</div>  
@endsection
