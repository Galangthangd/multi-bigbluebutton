@extends('layouts.app')

@section('header')
    <link href="{{ asset('css/index-page.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <h1>Welcome to Big Blue Button Load Balance System Management</h1>
        <br>
        <h2>Please <a href="{{ url('/admin/login') }}">Login</a> to continue...</h2>
    </div>
@endsection
