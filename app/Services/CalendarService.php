<?php

namespace App\Services;

use App\Models\Calendar;
use Carbon\Carbon;

class CalendarService
{
    public function create($data): Calendar
    {
        $data['owner_id']= auth()->id();

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
        return $calendar->events->where('deleted_at', null)->all();
    }
}