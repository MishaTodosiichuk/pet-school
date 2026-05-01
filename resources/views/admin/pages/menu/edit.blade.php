@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Редагування меню', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.buttons.form.form')
@endsection
