@extends('layouts.app')
@section('title', 'Подробнее о задаче')
@section('content')
<div class="contant">
  <div class="menu-left">
    <a href="{{ route('index') }}" type="button" class="btn btn-light">Пользователи</a>
    <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a>
  </div> 
  <div class="container">
    <h1>Подробнее о задаче</h1>

      <div class="card border-success mb-3" style="max-width: 18rem;">
        <a href="{{ route('infoTask',  $tasks->id) }}">
          <div class="card-header">{{ $tasks->name }}</div>
        </a>
        <div class="card-body">
          <h5 class="card-title">{{ $tasks->title }}</h5>
          <p class="card-text">{{ $tasks->description }}</p>
          <p class="card-text">Дата начала: {{ $tasks->date_start }}</p>
          <p class="card-text">Дата окончания: {{ $tasks->date_end }}</p>
        </div>
        <div class="card-footer text-body-secondary">
          Статус: {{ $tasks->status }}<br>
          Приоритет: {{ $tasks->priority }}
        </div>
      </div>

  </div>
</div>
@endsection
