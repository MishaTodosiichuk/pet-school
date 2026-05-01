@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Меню', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $menus, 'config' => $tableConfig])
@endsection

