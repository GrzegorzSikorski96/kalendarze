<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;

class EventService
{
    public function create($data): Event
    {
        $event = new Event();

        $event->fill($data);
        $event->save();

        return $event;
    }

    public function edit(Event $event, $data): void
    {
        $event->update($data);

        $event->save();
    }

    public function remove(Event $event): void
    {
        $event->deleted_at = Carbon::now();
        $event->save();
    }
}