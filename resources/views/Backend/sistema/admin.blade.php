@extends('Backend.layouts.body')

@section('title', 'Bienvenido')

@section('seccion', 'Panel de Administración')

@section('bread')
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="feather icon-home"></i></a></li>
@endsection

@section('contenido')
    <h1>Bienvenido {{$user->alias}}</h1>

@endsection