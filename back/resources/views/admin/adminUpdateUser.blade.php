@extends('layouts.app')

@section('title', 'Редактирование пользователя')

@section('content')
<div class="container">
    <h1>Редактирование пользователя</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Имя</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group  mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group mb-3"> 
            <label for="role">Должность</label> 
            <select name="role" id="role" class="form-control">
                @foreach($roles as $key => $role)
                    <option value="{{ $key }}" {{ (old('role', $user->role) == $key) ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div> 

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection
