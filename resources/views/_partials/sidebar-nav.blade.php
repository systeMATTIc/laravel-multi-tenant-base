<div class="bg-purple-900 w-64 py-6 h-screen hidden lg:flex flex-col flex-shrink-0">
  {{-- <div class="py-2 px-6 text-purple-200">
    <x-logo class="w-auto h-32 mx-auto text-white" />
  </div> --}}
  <a href="{{ route('home') }}"
    class="py-4 px-6 text-purple-200 cursor-pointer border-l-4 border-transparent hover:bg-purple-800 hover:border-purple-100 hover:text-purple-50 {{ (strpos(Route::currentRouteName(), 'home') === 0) ? 'bg-purple-800 border-purple-100' : '' }}">
    >
    Dashboard
  </a>
  @can('view-users')
  <a href="{{ route('users.index') }}"
    class="py-4 px-6 text-purple-200 cursor-pointer border-l-4 border-transparent hover:bg-purple-800 hover:border-purple-100 hover:text-purple-50 {{ (strpos(Route::currentRouteName(), 'users') === 0) ? 'bg-purple-800 border-purple-100' : '' }}">
    >
    Users
  </a>
  @endcan
  @can('view-roles')
  <a href="{{ route('roles.index') }}"
    class="py-4 px-6 text-purple-200 cursor-pointer border-l-4 border-transparent hover:bg-purple-800 hover:border-purple-100 hover:text-purple-50 {{ (strpos(Route::currentRouteName(), 'roles') === 0) ? 'bg-purple-800 border-purple-100' : '' }}">
    >
    Roles
  </a>
  @endcan
</div>