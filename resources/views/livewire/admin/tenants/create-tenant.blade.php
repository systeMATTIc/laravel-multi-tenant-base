@section('title')
New Tenant
@endsection

<div class="leading-loose">
    <form wire:submit.prevent="submit" class="max-w-xl m-4 mx-auto p-7 sm:p-9 bg-white rounded shadow-xl">
        <p class="text-gray-700 text-2xl">New Tenant</p>
        <div class="mt-6">
            <label class="block text-sm text-gray-600" for="name">Name</label>

            <input wire:model.lazy="name" id="name" type="text" required autofocus
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="domain">(Sub) Domain</label>

            <input wire:model.lazy="domain" id="domain" type="text" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('domain')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="domain">Phone Number</label>

            <input wire:model.lazy="phoneNo" id="phoneNo" type="text" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('phone_no')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="firstName">Admin First Name</label>

            <input wire:model.lazy="firstName" id="firstName" type="text" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('admin_first_name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="lastName">Admin Last Name</label>

            <input wire:model.lazy="lastName" id="lastName" type="text" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('admin_last_name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-4">
            <label class="block text-sm text-gray-600" for="email">Admin Email</label>

            <input wire:model.lazy="email" id="email" type="email" required
                class="w-full px-5 py-2 text-gray-600 bg-gray-100 border border-transparent rounded focus:border-gray-200 focus:outline-none focus:bg-white">

            @error('admin_email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <div class="mt-6 flex justify-between">
            <a href="{{ route('admin.tenants.index') }}"
                class="px-4 py-1 text-white tracking-wider bg-orange-500 hover:bg-orange-600 rounded" type="button">
                Back
            </a>
            <button class="px-4 py-1 text-white tracking-wider bg-purple-700 hover:bg-purple-500 rounded" type="submit">
                Create
            </button>
        </div>
    </form>
</div>