@extends('layouts.auth')
@section('title', 'Create a new account')

@section('content')
    <div>
        @livewire('admin.auth.register')
    </div>
@endsection
