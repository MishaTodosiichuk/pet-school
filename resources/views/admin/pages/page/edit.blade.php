@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Редагування сторінки', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.form.form')
@endsection
