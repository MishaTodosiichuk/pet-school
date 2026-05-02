@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Новини', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $news, 'config' => $tableConfig])
@endsection

