<?php

namespace Pirategram\Http\Controllers;

use Illuminate\Http\Request;

class PruebaController extends Controller
{
    public function index(){
        return 'Prueba de controlador';
    }

    public function MyName($name){
        return 'Mi nombre es: '.$name;
    }
}
