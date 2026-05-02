@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Галереї', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $gallery, 'config' => $tableConfig])
@endsection

