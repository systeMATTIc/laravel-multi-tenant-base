@section('title')
Tenants
@endsection

@section('pageTitle')
<div class="flex justify-between items-center mb-4">
	<h1 class="text-gray-500 text-2xl font-semibold">
		Tenants
	</h1>
	@can('create-tenant')
	<a href="{{ route('admin.tenants.create') }}"
		class="block px-4 py-2 bg-teal-600 hover:bg-teal-500 font-semibold text-white shadow rounded-md">Create</a>
	@endcan
</div>
@endsection

<div class="w-full p-7 sm:p-9 bg-white rounded shadow-xl">
	<div class="flex flex-col">

		<div class="sm:w-full sm:flex sm:flex-row flex-col sm:justify-between">
			<div class="flex justify-end items-center sm:block">
				Per Page: &nbsp;
				<select wire:model="perPage" class="form-select">
					<option>10</option>
					<option>15</option>
					<option>25</option>
				</select>
			</div>

			<div class="sm:mt-0 mt-6">
				<input wire:model="search" id="search" type="text" placeholder="Search Tenants..."
					class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
			</div>
		</div>

		<div class="overflow-x-auto mt-10 relative">
			<div class="inline-block min-w-full overflow-hidden">
				<table class="min-w-full text-left text-gray-500 whitespace-no-wrap">
					<thead>
						<tr>
							<th class="pr-4">
								<a wire:click.prevent="sortBy('name')" role="button" href="#">
									Name @include('includes._sort-icon', ['field' => 'name'])
								</a>
							</th>
							<th class="px-4 py-2">
								<a wire:click.prevent="sortBy('domain')" role="button" href="#">
									Domain @include('includes._sort-icon', ['field' => 'domain'])
								</a>
							</th>
							<th class="px-4 py-2">Date Created</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tenants as $tenant)
						<tr class="border-b border-gray-200 last:border-b-0">
							<td class="pr-4">{{ $tenant->name }}</td>
							<td class="px-4 py-4">{{ $tenant->domain }}</td>
							<td class="px-4 py-4">{{ $tenant->created_at->toDayDateTimeString() }}</td>
							<td>
								<div class="" x-data="{ open: false }">
									<button class="p-2 text-gray-400 text-lg hover:bg-teal-100 focus:outline-none"
										@click="open = !open">
										<svg class="fill-current h-5" xmlns="http://www.w3.org/2000/svg"
											viewBox="0 0 20 20">
											<path
												d="M10 12a2 2 0 110-4 2 2 0 010 4zm0-6a2 2 0 110-4 2 2 0 010 4zm0 12a2 2 0 110-4 2 2 0 010 4z" />
										</svg>
									</button>

									<ul class="fixed right-8 sm:right-16 lg:right-20 z-10 bg-white w-32 flex flex-col shadow flex-shrink-0 h-auto"
										x-show="open" x-transition:enter="transition ease-out duration-300"
										x-transition:enter-start="opacity-0 transform scale-90"
										x-transition:enter-end="opacity-100 transform scale-100"
										x-transition:leave="transition ease-in duration-300"
										x-transition:leave-start="opacity-100 transform scale-100"
										x-transition:leave-end="opacity-0 transform scale-90"
										@click.away="open = false">
										@if(auth('admin')->user()->can('edit-tenant'))
										<a href="{{ route('admin.tenants.edit', $tenant->uuid) }}"
											class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-teal-50">
											Edit
										</a>
										@endif
										@if(auth('admin')->user()->can('delete-tenant'))
										<a href="#" class="py-4 px-6 text-gray-500 cursor-pointer hover:bg-teal-50">
											Delete
										</a>
										@endif
									</ul>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>


		<div class="mt-0 w-full">
			{{ $tenants->links() }}
		</div>


	</div>
</div>