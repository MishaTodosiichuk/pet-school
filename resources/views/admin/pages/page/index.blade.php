@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Сторінки', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $pages, 'config' => $tableConfig])
@endsection

