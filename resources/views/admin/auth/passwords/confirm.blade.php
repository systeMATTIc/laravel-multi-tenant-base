@extends('admin.layouts.auth')
@section('title', 'Confirm your password')

@section('content')
<div>
    @livewire('admin.auth.passwords.confirm')
</div>
@endsection