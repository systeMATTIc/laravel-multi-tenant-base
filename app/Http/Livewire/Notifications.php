<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notifications extends Component
{
    public $unreadNotifications;

    protected $notificationId;

    public function mount()
    {
        $this->updateNotifications();
    }

    public function updateNotifications()
    {
        /** @var \App\User */
        $user = auth()->user();

        $this->unreadNotifications = $user->unreadNotifications;
    }

    public function markAsRead($notificationId)
    {
        $this->notificationId = $notificationId;

        $this->getCurrentNotification()->markAsRead();

        $this->updateNotifications();
    }

    public function getCurrentNotification()
    {
        /** @var \App\User */
        $user = auth()->user();

        return $user->notifications()->getQuery()->where([
            'id' => $this->notificationId
        ])->first();
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
