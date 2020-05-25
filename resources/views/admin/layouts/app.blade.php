@extends('layouts.base')

@section('body')
    <div class="min-h-screen bg-gray-50 overflow-auto w-full">
        @include('admin._partials.top-nav')
        <div class="w-11/12 mt-10 mx-auto flex">

            @include('admin._partials.sidebar-nav')

            <div class="flex flex-col lg:ml-16 w-full overflow-auto">
                @hasSection('pageTitle')
                    @yield('pageTitle')
                @endif

                @yield('content')
            </div>
        </div>
    </div>
@endsection
