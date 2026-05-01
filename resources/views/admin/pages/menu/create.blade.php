@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Створення нового меню', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.buttons.form.form')
@endsection
