<!-- @extends('layouts.app') -->
@section('title')
@section('content')
 
    <div class="contant"> 
    <div class="menu-left"> 
        <a href="{{ route('home') }}" type="button" class="btn btn-light">Пользователи</a> 
        <a href="{{ route('project') }}" type="button" class="btn btn-light">Проекты</a> 
    </div> 
    <div class="container"> 
        <div class="add-user"> 
            <h1>Пользователи системы</h1> 
        </div> 
        <div class="table-container"> 
            <table> 
                <thead> 
                    <tr> 
                        <th>№</th> 
                        <th>Имя</th> 
                        <th>Email</th> 
                        <th>Должность</th> 
                        <th></th> 
                    </tr> 
                </thead> 
                <tbody> 
                    @foreach($users as $key => $user)   
                        <tr> 
                            <td>{{ $key + 1 }}</td> 
                            <td>{{ $user->name }}</td> 
                            <td>{{ $user->email }}</td> 
                            <td>{{ $user->role ?? 'Не указана' }}</td> 
                            <td> 
                            <a href="{{ route('adminUpdateUser', $user->id) }}"> <button type="button" class="btn btn-success">Редактировать</button> </a>
                               <!-- <a href=""> <button type="button" class="btn btn-success">Редактировать</button> </a> -->

                                <!-- Форма для удаления пользователя --> 
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;"> 
                                    @csrf 
                                    @method('DELETE') 
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</button> 
                                </form> 
                            </td> 
                        </tr> 
                    @endforeach 
                </tbody> 
            </table> 
        </div> 
    </div> 
</div> 
@endsection('content')