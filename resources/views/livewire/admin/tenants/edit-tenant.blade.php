@section('title')
Edit Tenant
@endsection

@section('pageTitle')
<div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
        Edit Tenant
    </h1>
</div>
@endsection

<div class="w-full p-6 sm:p-10 bg-white shadow">
    <form wire:submit.prevent="submit" class="w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="name" class="block text-sm font-medium text-gray-700 leading-5">
                    Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="name" id="name" type="text" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
                <label for="domain" class="block text-sm font-medium text-gray-700 leading-5">
                    (Sub) Domain
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="domain" id="domain" type="text"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('domain') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('domain')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit"
                class="flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                Update
            </button>
        </div>

    </form>
</div>