@extends('admin.layouts.auth')
@section('title', 'Sign in to your account')

@section('content')
<div>
    @livewire('admin.auth.login')
</div>
@endsection