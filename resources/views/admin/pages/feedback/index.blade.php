@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Зворотній звʼязок', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $feedbacks, 'config' => $tableConfig])
@endsection

