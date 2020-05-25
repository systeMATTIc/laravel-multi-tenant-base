    <form wire:submit.prevent="submit" class="w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="name" class="block text-sm font-medium text-gray-700 leading-5">
                    Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="name" id="name" type="text" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
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
                    <input wire:model.lazy="domain" id="domain" type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('domain') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('domain')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 -mx-4">
            <div class="flex items-center mx-4">
                <input wire:model.lazy="isFullDomain" id="isFullDomain" type="checkbox" class="form-checkbox w-4 h-4 text-indigo-600 transition duration-150 ease-in-out" />
                <label for="isFullDomain" class="block ml-2 text-sm text-gray-900 leading-5">
                    Domain
                </label>
            </div>

            <!-- <span class="block w-full rounded-md shadow-sm"> -->
                <button type="submit" class="mx-4 flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    Create
                </button>
            <!-- </span> -->
        </div>
        
    </form>
