<div class="lg:bg-gray-50 bg-teal-900 w-full flex lg:flex-row flex-col lg:justify-center lg:items-center"
	x-data="{ open: false }">

	<div class="w-full mx-auto flex justify-end items-center">

		{{-- <a class="lg:px-0 lg:hidden" href="{{ route('home') }}">
		<x-logo class="w-auto h-16 mx-auto text-white fill-current" />
		</a> --}}

		<div class="flex justify-between items-center">

			<div x-cloak>
				@livewire('admin.notifications')
			</div>

			<div class="space-x-4 hidden lg:block px-6">
				<a href="{{ route('admin.profile') }}"
					class="font-medium px-2 py-6 text-gray-400 hover:bg-teal-50 cursor-pointer transition ease-in-out duration-150">
					{{ auth('admin')->user()->name }}
				</a>
				<a href="{{ route('admin.logout') }}"
					onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
					class="font-medium text-teal-600 hover:text-teal-500 focus:outline-none focus:underline transition ease-in-out duration-150">
					Log out
				</a>

				<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
					@csrf
				</form>
			</div>

			<div class="flex items-center cursor-pointer lg:hidden hover:bg-teal-800 hover:text-teal-100 text-teal-200 focus:text-teal-100 p-6"
				@click="open = ! open">
				<svg class="fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
				</svg>
			</div>
		</div>

	</div>


	<div class="flex flex-col flex-shrink-0 lg:hidden" x-show="open"
		x-transition:enter="transition ease-out duration-500"
		x-transition:enter-start="opacity-0 transform -translate-y-8"
		x-transition:enter-end="opacity-100 transform translate-y-0"
		x-transition:leave="transition ease-in duration-500"
		x-transition:leave-start="opacity-100 transform translate-y-12"
		x-transition:leave-end="opacity-0 transform -translate-y-2" @click.away="open = false">

		<div class="flex justify-end">
			@auth('admin')
			<a href="{{ route('admin.profile') }}"
				class="px-2 py-4 font-medium text-teal-200 hover:bg-teal-800 cursor-pointer transition ease-in-out duration-150">
				{{ auth('admin')->user()->name }}
			</a>
			<a href="{{ route('admin.logout') }}"
				onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
				class="px-8 py-4 block h-full cursor-pointer font-medium lg:text-teal-600 lg:hover:text-teal-500 text-teal-200 hover:bg-teal-800 lg:hover:bg-teal-100 focus:outline-none focus:underline transition ease-in-out duration-150">
				Log out
			</a>

			<form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
			@endauth
		</div>

		<a href="{{ route('admin.home') }}"
			class="py-4 px-6 text-teal-200 cursor-pointer border-l-4 border-transparent hover:bg-teal-800 hover:border-teal-100 hover:text-teal-50 {{ (strpos(Route::currentRouteName(), 'admin.home') === 0) ? 'bg-teal-800 border-teal-100' : '' }}">
			Dashboard
		</a>

		@can('view-tenant-list')
		<a href="{{ route('admin.tenants.index') }}"
			class="py-4 px-6 text-teal-200 cursor-pointer border-l-4 border-transparent hover:bg-teal-800 hover:border-teal-100 hover:text-teal-50 {{ (strpos(Route::currentRouteName(), 'admin.tenants') === 0) ? 'bg-teal-800 border-teal-100' : '' }}">
			Tenants
		</a>
		@endcan

		@can('view-administrator-list')
		<a href="{{ route('admin.users.index') }}"
			class="py-4 px-6 text-teal-200 cursor-pointer border-l-4 border-transparent hover:bg-teal-800 hover:border-teal-100 hover:text-teal-50 {{ (strpos(Route::currentRouteName(), 'admin.users') === 0) ? 'bg-teal-800 border-teal-100' : '' }}">
			Administrators
		</a>
		@endcan
		@can('view-roles')
		<a href="{{ route('admin.roles.index') }}"
			class="py-4 px-6 text-teal-200 cursor-pointer border-l-4 border-transparent hover:bg-teal-800 hover:border-teal-100 hover:text-teal-50 {{ (strpos(Route::currentRouteName(), 'admin.roles') === 0) ? 'bg-teal-800 border-teal-100' : '' }}">
			Roles
		</a>
		@endcan
	</div>

</div>