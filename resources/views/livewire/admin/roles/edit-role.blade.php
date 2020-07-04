@section('title')
Edit Role
@endsection

<div class="leading-loose" x-data="{ tab: 'role' }">
    <form wire:submit.prevent="submit" class="max-w-xl m-4 mx-auto p-7 sm:p-9 bg-white rounded shadow-xl">
        <p class="text-gray-700 text-2xl">Edit Role</p>
        <ul class="mt-6 flex border-b">
            <li class="-mb-px mr-1" @click="tab = 'role'">
                <a class="bg-white inline-block text-gray-400 hover:text-teal-500 py-2 px-4"
                    :class="{ 'border-l border-t border-r rounded-t text-teal-600 font-semibold': tab == 'role' }"
                    href="#">
                    Role
                </a>
            </li>
            <li class="mr-1" :class="{ '-mb-px': tab == 'abilities' }" @click="tab = 'abilities'">
                <a class="bg-white inline-block py-2 px-4 text-gray-400 hover:text-teal-500"
                    :class="{ 'border-l border-t border-r border-b-0 rounded-t text-teal-600 font-semibold': tab == 'abilities' }"
                    href="#">
                    Abilities
                </a>
            </li>
        </ul>

        <div x-show="tab == 'role'">
            <div class="mt-6">
                <label class="block text-sm text-gray-600" for="title">Title</label>

                <input wire:model.lazy="title" id="title" type="text" required autofocus
                    class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

                @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label class="block text-sm text-gray-600" for="name">Name</label>

                <input wire:model.lazy="name" id="name" type="text"
                    class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col mt-6  overflow-x-hidden" x-show="tab == 'abilities'">
            <x-app-abilities :abilities="$mappedAbilities" abilities-key="mappedAbilities" />
        </div>

        <div class="mt-8 flex justify-end">
            <button class="px-4 py-1 text-white tracking-wider bg-teal-700 hover:bg-teal-500 rounded" type="submit">
                Update
            </button>
        </div>
    </form>
</div>