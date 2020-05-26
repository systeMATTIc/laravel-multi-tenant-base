<div style="height: 640px" class="bg-white w-64 hidden lg:flex flex-col shadow flex-shrink-0">
  <div class="py-6 px-6 text-gray-500 border-b border-gray-200">
    <p class="font-bold ">Welcome, {{ auth()->user()->first_name }}</p>
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