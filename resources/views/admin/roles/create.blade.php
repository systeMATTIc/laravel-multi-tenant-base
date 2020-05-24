@extends('admin.layouts.app')

@section('title')
  Roles
@endsection

@section('pageTitle')
  <div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Create Role
    </h1>
  </div>
@endsection

@section('content')
  <div class="w-full p-10 bg-white shadow">
    @livewire('admin.roles.create-form', ['abilities' => $abilities])
  </div>
@endsection
