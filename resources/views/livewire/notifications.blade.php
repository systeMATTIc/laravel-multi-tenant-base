<div wire:poll.5000ms="updateNotifications" class="relative inline-block" x-data="{ open: false }" x-cloak>
    <div class="flex items-center p-6 cursor-pointer hover:bg-indigo-100" @click="open = !open">
        @if($unreadNotifications->count() > 0)
        <span id="notification-badge"
            class="inline-block bg-indigo-600 text-indigo-100 text-xs px-2 rounded-full uppercase font-semibold tracking-wide">
            {{ $unreadNotifications->count() }}
        </span>
        @endif

        <svg class="fill-current h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path
                d="M6 8v7h8V8a4 4 0 10-8 0zm2.03-5.67a2 2 0 113.95 0A6 6 0 0116 8v6l3 2v1H1v-1l3-2V8a6 6 0 014.03-5.67zM12 18a2 2 0 11-4 0h4z" />
        </svg>
    </div>

    <ul style="max-height: 82vh;"
        class="absolute z-10 right-0 w-64 bg-white flex flex-col shadow flex-shrink-0 overflow-auto" x-show="open"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="open = false">
        @if($unreadNotifications->isEmpty())
        <a href="#" class="text-gray-300 border-b border-indigo-100 cursor-not-allowed">
            <div class="p-6">
                You have no notifications
            </div>
        </a>
        @endif
        @foreach($unreadNotifications as $notification)
        <a href="#" class="text-gray-500 border-b border-indigo-100">
            <div class="p-6">
                <div class="flex justify-between items-center ">
                    <p class="font-semibold">{{ $notification->data['title'] }}</p>
                    <button type="button" wire:click="markAsRead('{{ $notification->id }}')" title="Mark as Read"
                        class="px-2 py-1 bg-indigo-600 ml-2 hover:bg-indigo-400 ">
                        <svg class="fill-current w-4 h-4 text-indigo-50 font-bold" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" /></svg>
                    </button>
                </div>
                <p class="mt-2 break-words">{{ $notification->data['message'] }}</p>
            </div>
        </a>
        @endforeach
    </ul>
</div>