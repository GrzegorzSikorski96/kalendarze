<?php

namespace App\Services;

use App\Models\Calendar;
use Carbon\Carbon;

class CalendarService
{
    public function create($data): Calendar
    {
        $data['owner_id'] = auth()->id();

        $calendar = auth()->user()->calendars()->create($data);

        return $calendar;
    }

    public function edit(Calendar $calendar, $data): void
    {
        $calendar->update($data);

        $calendar->save();
    }

    public function remove(Calendar $calendar): void
    {
        $calendar->deleted_at = Carbon::now();
        $calendar->save();
    }

    public function events(Calendar $calendar)
    {

        foreach ($calendar->events as $event) {
                $event->date = Carbon::parse($event->date)->format('Y/m/d');
        }

        return $calendar->events->all();
    }
}