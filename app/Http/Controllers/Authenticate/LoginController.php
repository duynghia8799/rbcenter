<?php

namespace App\Http\Controllers\Authenticate;

use App\Api\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.index');
    }

    public function login(LoginRequest $request)
    {
        $api = new Api();
        $data = $request->all();
        try {
           $user = $api->sendRequest('post', 'login', $data)->data;
           if($user->role_id !=1 && $user->role_id != 100){
               $request->session()->flash('role_error');
               return redirect(route('admin.login'));
           }
           else{
               $request->session()->put('admin' , $user);
               return redirect(route('admin.index'));
           }
        }catch (\Exception $e){
                $request->session()->flash('login_error');
                return redirect(route('admin.login'));
        }
    }
}