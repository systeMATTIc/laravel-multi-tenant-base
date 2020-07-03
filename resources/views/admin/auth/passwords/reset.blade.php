@extends('admin.layouts.auth')
@section('title', 'Reset password')

@section('content')
<div>
    @livewire('admin.auth.passwords.reset', ['token' => $token])
</div>
@endsection