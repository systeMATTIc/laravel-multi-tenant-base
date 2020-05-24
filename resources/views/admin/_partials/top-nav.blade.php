<div class="bg-white flex justify-center items-center py-5 shadow">
  <div class="w-11/12 mx-auto flex justify-between items-center">
    <a href="{{ route('admin.home') }}">
      <x-logo class="w-auto h-8 mx-auto text-indigo-600" />
    </a>
    <div class="">
      @if (Route::has('admin.login'))
        <div class="space-x-4">
          @auth('admin')
            <span class="font-medium text-gray-400 transition ease-in-out duration-150">
              {{ auth('admin')->user()->name }}
            </span>
            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
              Log out
            </a>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          @endauth
        </div>
      @endif
    </div>
  </div>
</div>
