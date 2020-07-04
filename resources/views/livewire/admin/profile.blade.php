@section('title')
Profle
@endsection

@section('pageTitle')
<div class="flex justify-between items-center mb-4" x-data="{ alertToShow: 'none' }">
    <h1 class="text-gray-500 text-2xl font-semibold">
        Profile
    </h1>

    <div @updated-profile.window="alertToShow = $event.detail.name" x-show="alertToShow == 'pwd'"
        @click.away="alertToShow = 'none'"
        class="p-3 bg-teal-800 items-center text-teal-100 leading-none lg:rounded-full flex lg:inline-flex"
        role="alert">
        <span class="font-semibold mr-2 text-left flex-auto">Password changed successfully</span>
        <svg @click="alertToShow = 'none'" class="fill-current opacity-75 h-4 w-4" role="button"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </div>

    <div @updated-profile.window="alertToShow = $event.detail.name;" x-show="alertToShow == 'data'"
        @click.away="alertToShow = 'none'"
        class="p-3 bg-teal-800 items-center text-teal-100 leading-none lg:rounded-full flex lg:inline-flex"
        role="alert">
        <span class="font-semibold mr-2 text-left flex-auto">Profile updated successfully</span>
        <svg @click="alertToShow = 'none'" class="fill-current opacity-75 h-4 w-4" role="button"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
        </svg>
    </div>

</div>
@endsection

<div class="w-full sm:p-10 p-6 bg-white shadow" x-data="{ tab: 'edit-profile' }">

    <ul class="flex border-b">
        <li class="-mb-px mr-1" @click="tab = 'edit-profile'">
            <a class="bg-white inline-block text-gray-400 hover:text-teal-500 py-2 px-4"
                :class="{ 'border-l border-t border-r rounded-t text-teal-600 font-semibold': tab == 'edit-profile' }"
                href="#">
                Edit Profile
            </a>
        </li>
        <li class="mr-1" :class="{ '-mb-px': tab == 'change-password' }" @click="tab = 'change-password'">
            <a class="bg-white inline-block py-2 px-4 text-gray-400 hover:text-teal-500"
                :class="{ 'border-l border-t border-r border-b-0 rounded-t text-teal-600 font-semibold': tab == 'change-password' }"
                href="#">
                Change Password
            </a>
        </li>
    </ul>

    <form wire:submit.prevent="update" class="w-full mt-10" x-show="tab == 'edit-profile'">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="firstName" class="block text-sm font-medium text-gray-700 leading-5">
                    First Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="firstName" id="firstName" type="text" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('firstName') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('firstName')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
                <label for="lastName" class="block text-sm font-medium text-gray-700 leading-5">
                    Last Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="lastName" id="lastName" type="text"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('lastName') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('lastName')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 w-full">
            <button type="submit"
                class="flex justify-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:shadow-outline-teal active:bg-teal-700 transition duration-150 ease-in-out">
                Update
            </button>
        </div>
    </form>


    <form wire:submit.prevent="changePassword" class="w-full mt-10" x-show="tab == 'change-password'">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                    New Password
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="password" id="password" type="password" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('password') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
                <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700 leading-5">
                    Confirm New Password
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="passwordConfirmation" id="passwordConfirmation" type="password"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 w-full">
            <button type="submit"
                class="flex justify-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-500 focus:outline-none focus:border-teal-700 focus:shadow-outline-teal active:bg-teal-700 transition duration-150 ease-in-out">
                Change Password
            </button>
        </div>
    </form>
</div>