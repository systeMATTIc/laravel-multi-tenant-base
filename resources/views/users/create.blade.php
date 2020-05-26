@extends('layouts.app')

@section('title')
  Users
@endsection

@section('pageTitle')
  <div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      New User
    </h1>
  </div>
@endsection

@section('content')
  <div class="w-full p-6 sm:p-10 bg-white shadow">
    @livewire('users.create')
  </div>
@endsection
