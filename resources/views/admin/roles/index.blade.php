@extends('admin.layouts.app')

@section('title')
  Roles
@endsection

@section('pageTitle')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Roles
    </h1>
    <a href="{{ route('admin.roles.create') }}" class="block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 font-semibold text-white shadow rounded-md">Create</a>
  </div>
@endsection

@section('content')
  <div class="w-full p-6 sm:p-10 bg-white shadow">
    @livewire('admin.roles.roles-table')
  </div>
@endsection