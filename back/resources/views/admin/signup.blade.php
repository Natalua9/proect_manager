@extends('layouts.app')
@section('title', 'Регистрация')
@section('content')
<div class="container">
<form action="{{route('signup')}}" method="post">
    @csrf
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Имя</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "name">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Почта</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name = "email">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Пароль</label>
    <input type="password" class="form-control" id="exampleInputPassword1"  name = "password">
  </div>
  <div class="mb-3">
  <select class="form-select" name="role" aria-label="Default select example">
    <option selected disabled>Роль</option>
    <option value="user">Исполнитель</option>
    <option value="editor">Руководитель</option>
  </select>
</div>
  <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
</div>

@endsection