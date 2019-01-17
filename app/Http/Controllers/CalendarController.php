<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Calendar;
use App\Services\CalendarService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected $service;
    protected $response;

    /**
     * CalendarController constructor.
     * @param CalendarService $service
     * @param ApiResponse $response
     */
    public function __construct(CalendarService $service, ApiResponse $response)
    {
        $this->response = $response;
        $this->service = $service;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $calendar = $this->service->create($request->all());
        } catch (QueryException $exception) {
            return $this->response
                ->setMessage('Error on creating calendar')
                ->internalServerError();
        }

        return $this->response
            ->setMessage('Calendar created')
            ->setData(['calendar' => $calendar])
            ->success();
    }

    public function calendar($id): JsonResponse
    {
        try {
            $calendar = Calendar::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['calendar' => $calendar])
            ->success();
    }

    public function calendars(): JsonResponse
    {
        try {
            $calendars = Calendar::all();
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['calendars' => $calendars])
            ->success();
    }

    public function edit(Request $request, $id): JsonResponse
    {
        try {
            $calendar = Calendar::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        $this->service->edit($calendar, $request->all());

        return $this->response
            ->setMessage('Calendar edited')
            ->setData(['calendar' => $calendar])
            ->success();
    }

    public function remove($id): JsonResponse
    {
        try {
            $calendar = Calendar::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        $this->service->remove($calendar);

        return $this->response
            ->setMessage('Calendar removed')
            ->success();
    }

    public function events($calendar_id): JsonResponse
    {
        try {
            $calendar = Calendar::findOrFail($calendar_id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['calendar_id' => $calendar_id, 'events' => $this->service->events($calendar)])
            ->success();
    }
}