@extends('admin.layouts.default')

@section('header')
    @include('admin.includes.header', ['h1' => 'Контакти', 'breadcrumbs' => $breadcrumbs])
@endsection

@section('content')
    @include('admin.includes.table', ['items' => $contacts, 'config' => $tableConfig])
@endsection

