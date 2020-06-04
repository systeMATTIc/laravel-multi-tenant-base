@section('title')
New Tenant
@endsection

@section('pageTitle')
<div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
        New Tenant
    </h1>
</div>
@endsection

<div class="w-full p-6 sm:p-10 bg-white shadow">
    <form wire:submit.prevent="submit" class="w-full" x-data="{ submitting: false }">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="name" class="block text-sm font-medium text-gray-700 leading-5">
                    Tenant Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="name" id="name" type="text" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-6 sm:mt-0">
                <label for="firstName" class="block text-sm font-medium text-gray-700 leading-5">
                    Admin First Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="firstName" id="firstName" type="text" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('admin_first_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('admin_first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4 mt-6">

            <div class="sm:w-1/2 sm:mx-4">
                <label for="lastName" class="block text-sm font-medium text-gray-700 leading-5">
                    Admin Last Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="lastName" id="lastName" type="text" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('admin_last_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('admin_last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-6 sm:mt-0">
                <label for="email" class="block text-sm font-medium text-gray-700 leading-5">
                    Admin Email
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="email" id="email" type="email" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('admin_email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('admin_email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="flex flex-col sm:flex-row sm:items-end sm:-mx-4 mt-6">
            <div class="sm:w-1/2 sm:mx-4">
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

            <div class="sm:w-1/2 sm:mx-4 sm:mt-0 mt-6 flex items-center justify-end">
                <div class="flex items-center mx-4">
                    <input wire:model.lazy="isFullDomain" id="isFullDomain" type="checkbox"
                        class="form-checkbox w-4 h-4 text-indigo-600 transition duration-150 ease-in-out" />
                    <label for="isFullDomain" class="block ml-2 text-sm text-gray-900 leading-5">
                        Domain
                    </label>
                </div>

                <button @submitting.window="submitting = true" type="submit"
                    x-text="submitting ? 'Please wait...' : 'Create Tenant'" :disabled="submitting"
                    class="flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                </button>
            </div>

        </div>


    </form>
</div>