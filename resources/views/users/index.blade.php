@extends('layouts.app')

@section('title')
  Users
@endsection

@section('pageTitle')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Users
    </h1>
    @can('create-user')
      <a href="{{ route('users.create') }}" class="block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 font-semibold text-white shadow rounded-md" >Create</a>
    @endcan
  </div>
@endsection

@section('content')
  <div class="w-full sm:p-10 p-6 bg-white shadow">
    @livewire('users.users-table')
  </div>
@endsection