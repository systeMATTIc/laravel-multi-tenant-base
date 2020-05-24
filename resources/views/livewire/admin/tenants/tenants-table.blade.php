<div class="flex flex-col">

    <div class="w-full flex justify-between">
        <div class="">
            Per Page: &nbsp;
            <select wire:model="perPage" class="form-select">
                <option>10</option>
                <option>15</option>
                <option>25</option>
            </select>
        </div>

        <div class="">
            <input wire:model="search" class="form-input" type="text" placeholder="Search Tenants...">
        </div>
    </div>


    <table class="mt-10 table-auto w-full text-left text-gray-500">
      <thead>
        <tr>
            <th class="">
                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                    Name @include('includes._sort-icon', ['field' => 'name'])
                </a>
            </th>
            <th class="py-2">
                <a wire:click.prevent="sortBy('domain')" role="button" href="#">
                    Domain @include('includes._sort-icon', ['field' => 'domain'])
                </a>
            </th>
            <th class=" py-2">Date Created</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tenants as $tenant)
          <tr class="border-b border-gray-200">
            <td class="">{{ $tenant->name }}</td>
            <td class=" py-4">{{ $tenant->domain }}</td>
            <td class=" py-4">{{ $tenant->created_at->toDayDateTimeString() }}</td>
            <td>
            <div class="relative" x-data="{ open: false }">
              <button class="p-2 text-gray-400 text-lg hover:bg-indigo-100 focus:outline-none" @click="open = true">
                <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12a2 2 0 110-4 2 2 0 010 4zm0-6a2 2 0 110-4 2 2 0 010 4zm0 12a2 2 0 110-4 2 2 0 010 4z"/></svg>
              </button>

              <ul class="absolute right-0 z-10 bg-white w-32 flex flex-col shadow flex-shrink-0 h-auto" x-show="open" @click.away="open = false">
                @can('edit-tenant')
                  <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
                    Edit
                  </a>
                @endcan
                @can('delete-tenant')
                  <a href="#" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
                    Delete
                  </a>
                @endcan
              </ul>
            </div>
            </td>
          </tr>      
        @endforeach
      </tbody>
    </table>


    <div class="mt-10 w-full">
        {{ $tenants->links() }}
    </div>


</div>
