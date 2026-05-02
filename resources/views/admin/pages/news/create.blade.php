@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Створення нової новини', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.form.form')
@endsection
