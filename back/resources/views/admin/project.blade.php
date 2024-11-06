@extends('layouts.app')
@section('title', 'Проекты')
@section('content')

<div class="contant">
  <div class="menu-left">
    <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a>
    <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a>
  </div>

  <div class="container">
    <h1>Проекты системы</h1>
    <div class="all-project">
    @foreach($projects as $key => $project) 

    <div class="card" style="width: 18rem;">
      <div class="card-body">
      <h5 class="card-title">Название проекта:
        {{ $project->name }}
      </h5>
      <h5 class="card-title">Руководитель:{{ $project->user->name  }}</h5>
      <p class="card-text"> {{ $project->description }}</p>
      <p class="card-text">Дата начала:{{ $project->date_start }}</p>
      <p class="card-text">Дата окончания:{{ $project->date_end }}</p>
      <h4>Задачи:</h4>

      @foreach($project->projectTask as $task)
      <div class="card border-success  mb-3" style="max-width: 18rem;">
      <a href="{{ route('infoTask' , $task->id) }}">
      <div class="card-header">{{ $task->name }}</div>
      </a>
      </div>
    @endforeach
      <div class="card-body">
        <p class="card-text">Статус:{{ $project->status }}</p>
        <a href="{{ route('adminUpdateProject', $project->id) }}"><button type="button" class="btn btn-success">Изменить</button></a>

      </div>
      </div>
    </div>

    @endforeach

    </div>
  </div>
  @endsection('content')