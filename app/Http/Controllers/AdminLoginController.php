<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \App\Models\Utilidades;
use Validator;
use Auth;
use Route;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    
    public function showLoginForm()
    {
      return view('Backend.sistema.login');
    }
    public function GenerarContrasena(){
      $pass="123456";
      $pass= Hash::make($pass);
      echo $pass;
    }
    
    public function login(Request $request)
    {
      // Validate the form data
      $msjVal = Utilidades::MensajesValidacion();
      $niceNames = [
          'alias'           =>  'Usuario',
          'password'         =>  'Contraseña',
          
      ]; 
      $rules = array(
          'alias'           =>  'required',
          'password'         =>  'required',               
      );
      
      $validator = Validator::make($request->all(), $rules, $msjVal, $niceNames);
      if(!$validator->passes()){
         return redirect()->back()->withErrors($validator, 'login');
       
      }else if (Auth::guard('admin')->attempt(['alias'=>\mb_strtoupper($request->alias), 'password'=>\mb_strtoupper($request->password)])) {
        return redirect()->intended(route('admin.dashboard'));
      }else{
        //regresar atras.
        return redirect()->back()->with('fail',"Los datos ingresados no coinciden con nuestros registros.");
      }
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
