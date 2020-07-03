@section('title')
Roles
@endsection

@section('pageTitle')
<div class="flex justify-between items-center mb-4" x-data="{ alertType: '', msg: '' }"
    @delete-event.window="alertType = $event.detail.type; msg = $event.detail.msg">
    <h1 class="text-gray-500 text-2xl font-semibold">
        Roles
    </h1>

    <div x-show="alertType == 'error'" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
        role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline" x-text="msg"></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
            </svg>
        </span>
    </div>

    @can('create-role')
    <a href="{{ route('roles.create') }}"
        class="block px-4 py-2 bg-indigo-600 hover:bg-indigo-500 font-semibold text-white shadow rounded-md">
        Create
    </a>
    @endcan
</div>
@endsection

<div class="w-full p-7 sm:p-9 bg-white rounded shadow-xl">
    <div class="flex flex-col">

        <div class="sm:w-full sm:flex sm:flex-row flex-col sm:justify-between">
            <div class="flex justify-end items-center sm:block">
                Per Page: &nbsp;
                <select wire:model="perPage" class="form-select">
                    <option>10</option>
                    <option>15</option>
                    <option>25</option>
                </select>
            </div>

            <div class="sm:mt-0 mt-6">
                <input wire:model="search" id="search" type="text" placeholder="Search Roles..."
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
            </div>
        </div>

        <div class="overflow-x-auto mt-10 relative">
            <div class="inline-block min-w-full overflow-hidden">
                <table class="min-w-full text-left text-gray-500 whitespace-no-wrap">
                    <thead>
                        <tr>
                            <th class="pr-4">
                                <a wire:click.prevent="sortBy('title')" role="button" href="#">
                                    Title @include('includes._sort-icon', ['field' => 'first_name'])
                                </a>
                            </th>

                            <th class="px-4 py-2">
                                <a wire:click.prevent="sortBy('name')" role="button" href="#">
                                    Name @include('includes._sort-icon', ['field' => 'name'])
                                </a>
                            </th>

                            <th class="px-4 py-2">Date Created</th>

                            <th class="px-4 py-2">Date Modified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr class="border-b border-gray-200">
                            <td class="pr-4">{{ $role->title }}</td>
                            <td class="px-4 py-4">{{ $role->name }}</td>
                            <td class="px-4 py-4">{{ $role->created_at->toDayDateTimeString() }}</td>
                            <td class="px-4 py-4">{{ $role->updated_at->toDayDateTimeString() }}</td>
                            <td>
                                <div class="" x-data="{ open: false }">
                                    <button class="p-2 text-gray-400 text-lg hover:bg-indigo-100 focus:outline-none"
                                        @click="open = true">
                                        <svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 12a2 2 0 110-4 2 2 0 010 4zm0-6a2 2 0 110-4 2 2 0 010 4zm0 12a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>

                                    <ul class="fixed right-8 sm:right-16 lg:right-20 z-10 bg-white w-32 flex flex-col shadow flex-shrink-0 h-auto"
                                        x-show="open" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-300"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90"
                                        @click.away="open = false">
                                        @can('edit-role')
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
                                            Edit
                                        </a>
                                        @endcan
                                        @can('delete-role')
                                        <a href="#" wire:click="delete('{{ encrypt($role->id) }}')"
                                            class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-indigo-50">
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
            </div>
        </div>

        <div class="mt-10 w-full">
            {{ $roles->links() }}
        </div>

    </div>
</div>