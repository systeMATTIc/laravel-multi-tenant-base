@extends('admin.layouts.app')

@section('title')
  Tenants
@endsection

@section('pageTitle')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Tenants
    </h1>
    @can('create-tenant')
      <a href="{{ route('admin.tenants.create') }}" class="block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 font-semibold text-white shadow rounded-md" >Create</a>
    @endcan
  </div>
@endsection

@section('content')
  <div class="w-full p-10 bg-white shadow">
    @livewire('admin.tenants.tenants-table')
  </div>
@endsection