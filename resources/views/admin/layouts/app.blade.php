@extends('layouts.base')

@section('body')
<div class="bg-gray-50 overflow-auto w-full text-sm">
    <div class="flex min-h-screen">

        <div class="fixed top-0 left-0 overflow-x-hidden overflow-y-auto z-50">
            @include('admin._partials.sidebar-nav')
        </div>

        <div class="flex flex-col w-full">
            <div class="fixed top-0 w-full lg:pl-64 z-40">
                @include('admin._partials.top-nav')
            </div>

            <div class="lg:px-20 sm:px-12 px-6 lg:ml-64 mt-24">

                <div x-data="{ show: false, type: '', message: ''}" x-show.transition.opacity="show" x-text="message"
                    x-bind:class="{ 'bg-green-200 text-green-600': type == 'success', 'bg-red-200 text-red-600': type == 'error' }"
                    x-on:flash.window="
                        message = $event.detail.message;
                        type = $event.detail.type;
                        show = true;
                        setTimeout(() => show = false, 3000);
                    " class="w-full py-4 px-6 my-10">
                </div>

                <div>
                    @hasSection('pageTitle')
                    @yield('pageTitle')
                    @endif
                </div>

                <div class="mb-8">
                    @yield('content')
                </div>
            </div>
            {{-- Flash Component --}}

        </div>

    </div>
</div>
@endsection