@section('title')
Administrators
@endsection

<div class="leading-loose">
    <form wire:submit.prevent="submit" class="max-w-xl m-4 mx-auto p-7 sm:p-9 bg-white rounded shadow-xl">
        <p class="text-gray-700 text-2xl">New Administrator</p>
        <div class="mt-6">
            <label class="block text-sm text-gray-600" for="first_name">First Name</label>

            <input wire:model.lazy="firstName" id="first_name" type="text" required autofocus
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('firstName')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="last_name">Last Name</label>

            <input wire:model.lazy="lastName" id="last_name" type="text"
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('lastName')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="email">Email Address</label>

            <input wire:model.lazy="email" id="email" type="email" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="password">Password</label>

            <input wire:model.lazy="password" id="password" type="password"
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="roles">Roles</label>
            <div wire:ignore>
                <select
                    class="select2 w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white"
                    multiple required>
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

        <div class="mt-8 flex justify-between">
            <div class="flex items-center">
                <input wire:model.lazy="superadmin" id="superadmin" type="checkbox"
                    class="form-checkbox w-4 h-4 text-indigo-600 transition duration-150 ease-in-out" />
                <label for="superadmin" class="block ml-2 text-sm text-gray-900 leading-5">
                    Super Admin
                </label>
            </div>

            <button class="px-4 py-1 text-white tracking-wider bg-teal-700 hover:bg-teal-500 rounded" type="submit">
                Create
            </button>
        </div>
    </form>
</div>


@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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