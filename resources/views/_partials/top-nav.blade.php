<div class="bg-white flex lg:flex-row flex-col lg:justify-center lg:items-center shadow" x-data="{ open: false }"
  x-cloak>

  <div class="w-full mx-auto flex justify-between items-center border-b border-indigo-100 lg:border-none">

    <a class="lg:px-12 px-6 py-5" href="{{ route('home') }}">
      <x-logo class="w-auto h-8 mx-auto text-indigo-600" />
    </a>

    <div class="flex justify-between items-center">

      @livewire('notifications')

      <div class="space-x-4 hidden lg:block px-6">
        <a href="{{ route('profile') }}"
          class="font-medium px-2 py-6 text-gray-400 hover:bg-indigo-50 cursor-pointer transition ease-in-out duration-150">
          {{ auth()->user()->name }}
        </a>
        <a href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
          Log out
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>

      <div
        class="flex items-center cursor-pointer lg:hidden hover:bg-indigo-100 text-indigo-400 focus:text-indigo-500 p-6"
        @click="open = ! open">
        <svg class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </div>
    </div>

  </div>

  <div class="flex flex-col flex-shrink-0 lg:hidden" x-show="open" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 transform -translate-y-8"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100 transform translate-y-12"
    x-transition:leave-end="opacity-0 transform -translate-y-2" @click.away="open = false">
    <div class="flex justify-end">
      @auth()
      <a href="{{ route('profile') }}"
        class="px-2 py-4 font-medium text-gray-400 hover:bg-indigo-50 cursor-pointer transition ease-in-out duration-150">
        {{ auth()->user()->name }}
      </a>
      <a href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
        class="px-8 py-4 block h-full cursor-pointer font-medium text-indigo-600 hover:text-indigo-500 hover:bg-indigo-100 focus:outline-none focus:underline transition ease-in-out duration-150">
        Log out
      </a>

      <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      @endauth
    </div>

    <a href="{{ route('home') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
      Dashboard
    </a>
    @can('view-users')
    <a href="{{ route('users.index') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
      Users
    </a>
    @endcan
    @can('view-roles')
    <a href="{{ route('roles.index') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
      Roles
    </a>
    @endcan
  </div>

</div>