<form wire:submit.prevent="submit" class="w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
        <div class="sm:w-1/2 sm:mx-4">
            <label for="first_name" class="block text-sm font-medium text-gray-700 leading-5">
                First Name
            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="firstName" id="first_name" type="text" required autofocus class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('first_name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
            </div>

            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
            <label for="last_name" class="block text-sm font-medium text-gray-700 leading-5">
                Last Name
            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="lastName" id="last_name" type="text" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('lastName') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
            </div>

            @error('lastName')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4 sm:mt-6 mt-4">
        <div class="sm:w-1/2 sm:mx-4">
            <label for="email" class="block text-sm font-medium text-gray-700 leading-5">
                Email
            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="email" id="email" type="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
            </div>

            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
            <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                Password
            </label>

            <div class="mt-1 rounded-md shadow-sm">
                <input wire:model.lazy="password" id="password" type="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
            </div>

            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-col mt-4  overflow-x-hidden">
        <div class="">
            <label for="roles" class="block text-sm font-medium text-gray-700 leading-5">
                Roles
            </label>

            <div wire:ignore class="mt-1 rounded-md shadow-sm">
                <select class="select2 block w-full @error('selectedRoles') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            @error('selectedRoles')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex items-center justify-end mt-6 -mx-4">
        <div class="flex items-center mx-4">
            <input wire:model.lazy="superadmin" id="superadmin" type="checkbox" class="form-checkbox w-4 h-4 text-indigo-600 transition duration-150 ease-in-out" />
            <label for="superadmin" class="block ml-2 text-sm text-gray-900 leading-5">
                Super Admin
            </label>
        </div>

        <button type="submit" class="mx-4 flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
            Create
        </button>
    </div>
    
</form>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.select2').on('change', function (e) {
                let currentValue = $(this).val();
                currentValue.push(e.target.value);
                @this.set('selectedRoles', currentValue);
            });
        });
    </script>
@endpush