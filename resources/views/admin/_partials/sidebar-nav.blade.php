<div style="height: 640px" class="bg-white w-64 flex flex-col shadow flex-shrink-0">
  <div class="py-6 px-6 text-gray-500 border-b border-gray-200">
    <p class="font-bold ">Welcome, {{ auth('admin')->user()->first_name }}</p>
  </div>
  <a href="{{ route('admin.home') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
    Dashboard
  </a>
  @can('view-tenant-list')
  <a href="{{ route('admin.tenants.index') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
    Tenants
  </a>
  @endcan
  @can('view-administrator-list')
  <a href="{{ route('admin.users.index') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
    Administrators
  </a>
  @endcan
  @can('view-roles')
  <a href="{{ route('admin.roles.index') }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
    Roles
  </a>
  @endcan
</div>