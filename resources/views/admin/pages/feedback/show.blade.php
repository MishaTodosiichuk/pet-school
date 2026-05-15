@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Перегляд повідомлення', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.form.form-show')
@endsection
