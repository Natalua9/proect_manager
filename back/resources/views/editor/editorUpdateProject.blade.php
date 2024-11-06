@extends('layouts.app')   
@section('title', 'Редактирование проекта')   
@section('content')   
<div class="contant">   
    <div class="menu-left">   
        <!-- <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a>   
        <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a>   --> 
    </div>   
    <div class="container">   
        <h1>Редактирование проекта</h1>   

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('updateProjectEditor', $project->id) }}" method="POST">   
            @csrf   
            @method('PUT')  
            <div class="card" style="width: 100%;">   
                <div class="card-body">   
                    <div class="mb-3">  
                        <label for="name" class="form-label">Название проекта</label>  
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $project->name) }}" required>  
                    </div>  
                    <div class="mb-3">  
                        <label for="description" class="form-label">Описание проекта</label>  
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $project->description) }}" required>  
                    </div>  
                    <div class="mb-3">   
                        <label for="status" class="form-label">Статус</label>   
                        <select class="form-select" id="status" name="status"> 
                            <option value="Создан" {{ old('status', $project->status) == 'Создан' ? 'selected' : '' }}>Создан</option> 
                            <option value="В процессе" {{ old('status', $project->status) == 'В процессе' ? 'selected' : '' }}>В процессе</option>

                            <option value="Завершен" {{ old('status', $project->status) == 'Завершен' ? 'selected' : '' }}>Завершен</option> 
                        </select> 
                    </div>  
                    <div class="mb-3">  
                        <label for="date_start" class="form-label">Дата начала</label>  
                        <input type="date" class="form-control" id="date_start" name="date_start" value="{{ old('date_start', $project->date_start) }}" required>  
                    </div> 
                    <div class="mb-3">  
                        <label for="date_end" class="form-label">Дата окончания</label>  
                        <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', $project->date_end) }}" required>  
                    </div> 
                    <div class="mb-3">  
                        <label for="manager" class="form-label">Руководитель: {{$project->user->name}}</label>  
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