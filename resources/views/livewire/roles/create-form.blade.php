@section('title')
Roles
@endsection

@section('pageTitle')
<div class="flex justify-between mb-4">
    <h1 class="text-gray-500 text-2xl font-semibold">
        Create Role
    </h1>
</div>
@endsection

<div class="w-full p-6 sm:p-10 bg-white shadow">
    <form wire:submit.prevent="submit" class="w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:-mx-4">
            <div class="sm:w-1/2 sm:mx-4">
                <label for="title" class="block text-sm font-medium text-gray-700 leading-5">
                    Title
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="title" id="title" type="text" required autofocus
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('name') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="sm:w-1/2 sm:mx-4 mt-4 sm:mt-0">
                <label for="name" class="block text-sm font-medium text-gray-700 leading-5">
                    Name
                </label>

                <div class="mt-1 rounded-md shadow-sm">
                    <input wire:model.lazy="name" id="name" type="text"
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('domain') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror" />
                </div>

                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-col mt-4  overflow-x-hidden">
            <div class="">
                <label for="selectedAbilities" class="block text-sm font-medium text-gray-700 leading-5">
                    Abilities
                </label>

                <div wire:ignore class="mt-1 rounded-md shadow-sm">
                    <select
                        class="select2 w-full @error('selectedAbilities') border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:shadow-outline-red @enderror"
                        multiple required>
                        @foreach($abilities as $ability)
                        <option value="{{ $ability->id }}">
                            {{ $ability->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                @error('selectedAbilities')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-6 w-full">
            <button type="submit"
                class="flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
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
                @this.set('selectedAbilities', currentValue);
            });
        });
</script>
@endpush