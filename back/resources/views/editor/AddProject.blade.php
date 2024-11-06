@extends('layouts.app') 
@section('title', 'Создание проекта') 
@section('content') 
<div class="container"> 
@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form action="{{ route('projects.store') }}" method="post"> 
        @csrf 
        <div class="mb-3"> 
            <label for="name" class="form-label">Название</label> 
            <input type="text" class="form-control" id="name" name="name" required> 
        </div> 
        <div class="mb-3"> 
            <label for="description" class="form-label">Описание</label> 
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div> 
        <div class="mb-3"> 
            <label for="date_start" class="form-label">Дата начала</label> 
            <input type="date" class="form-control" id="date_start" name="date_start" required> 
        </div> 
        <div class="mb-3"> 
            <label for="date_end" class="form-label">Дата окончания</label> 
            <input type="date" class="form-control" id="date_end" name="date_end" required> 
        </div> 
        <div class="mb-3"> 
            <label for="manager" class="form-label">Руководитель</label> 
            <select class="form-select" id="manager" name="id_manager" required>
                <option value="">Выберите руководителя</option>
                @foreach($editors as $editor)
                    <option value="{{ $editor->id }}">{{ $editor->name }}</option>
                @endforeach
            </select>
        </div> 
        <button type="submit" class="btn btn-primary">Создать проект</button> 
    </form> 
</div> 
@endsection
