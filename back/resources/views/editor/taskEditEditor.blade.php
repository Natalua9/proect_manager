@extends('layouts.app') 
@section('title', 'Редактировать задачу') 
@section('content') 
<div class="container"> 
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">     
        @csrf     
        @method('PUT')    
        <div class="card" style="width: 100%;">     
            <div class="card-body">     
                <div class="mb-3">    
                    <label for="name" class="form-label">Название задачи</label>    
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $task->name) }}" required>    
                </div>    
                <div class="mb-3">    
                    <label for="description" class="form-label">Описание задачи</label>    
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description', $task->description) }}" required>    
                </div>    
                <div class="mb-3">     
                    <label for="status" class="form-label">Статус</label>     
                    <select class="form-select" id="status" name="status">   
                        <option value="Назначена" {{ old('status', $task->status) == 'Назначена' ? 'selected' : '' }}>Назначена</option>   
                        <option value="Выполняется" {{ old('status', $task->status) == 'Выполняется' ? 'selected' : '' }}>Выполняется</option>  
                        <option value="Завершена" {{ old('status', $task->status) == 'Завершена' ? 'selected' : '' }}>Завершена</option>   
                    </select>   
                </div>    
                <div class="mb-3">     
                    <label for="priority" class="form-label">Приоритет</label>     
                    <select class="form-select" id="priority" name="priority">   
                        <option value="Низкий" {{ old('priority', $task->priority) == 'Низкий' ? 'selected' : '' }}>Низкий</option>   
                        <option value="Средний" {{ old('priority', $task->priority) == 'Средний' ? 'selected' : '' }}>Средний</option>  
                        <option value="Высокий" {{ old('priority', $task->priority) == 'Высокий' ? 'selected' : '' }}>Высокий</option>   
                    </select>   
                </div>    
                <div class="mb-3">    
                    <label for="date_start" class="form-label">Дата начала</label>    
                    <input type="date" class="form-control" id="date_start" name="date_start" value="{{ old('date_start', $task->date_start) }}" required>    
                </div>   
                <div class="mb-3">    
                    <label for="date_end" class="form-label">Дата окончания</label>    
                    <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', $task->date_end) }}" required>    
                </div>   
            </div>     
            <div class="card-body">     
                <button type="submit" class="btn btn-success">Сохранить изменения</button>     
            </div>     
        </div>     
    </form> 
</div> 
@endsection
