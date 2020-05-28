<?php

namespace App\Http\Livewire\Admin;

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
        /** @var \App\Administrator */
        $user = auth('admin')->user();

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
        /** @var \App\Administrator */
        $admin = auth('admin')->user();

        return $admin->notifications()->getQuery()->where([
            'id' => $this->notificationId
        ])->first();
    }

    public function render()
    {
        return view('livewire.admin.notifications');
    }
}
