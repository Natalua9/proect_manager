<?php

namespace App\Http\Controllers;

use Hash;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tasks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 
// use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function show_reg()
    {
        return view('admin/signup');
    }
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'role' => 'required|in:user,editor',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
 if($user){
    return response()->json($request->name);
 }else{
    return response()->json("error");
 }
        // Если администратор залогинен, не выполняем Auth::login($user)
        if (!Auth::check()) {
            Auth::login($user);
        }
        return redirect()->route('home')->with('success', 'Пользователь успешно создан.');

    }
    public function show_signin()
    {
        return view('signin');
    }
    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            if ($user) {
                return response()->json(['role' => $user->role, 'email' => $user->email , 'id'=>$user->id]); // Возвращаем роль и почту пользователя
            } else {
                return response()->json("error");
            }
        }
        
        return response()->json("Unauthorized", 401); // Возвращаем ошибку, если авторизация не удалась
    }
    
    public function logout()
    {
        Auth::logout();
        Session::forget('auth'); 
        Session::forget('user_email'); 
        // return redirect()->route('index');
      
            return response()->json("");
        
    }

    
}
