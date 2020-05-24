@extends('admin.layouts.app')

@section('title')
  Administrators
@endsection

@section('pageTitle')
  <div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
      Edit Administrator
    </h1>
  </div>
@endsection

@section('content')
  <div class="w-full p-10 bg-white shadow">
    @livewire('admin.users.edit', ['administrator' => $administrator])
  </div>
@endsection
