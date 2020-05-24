@extends('admin.layouts.app')

@section('title')
  Administrators
@endsection

@section('pageTitle')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Administrators
    </h1>
    @can('create-administrator')
      <a href="{{ route('admin.users.create') }}" class="block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 font-semibold text-white shadow rounded-md" >Create</a>
    @endcan
  </div>
@endsection

@section('content')
  <div class="w-full p-10 bg-white shadow">
    @livewire('admin.users.users-table')
  </div>
@endsection