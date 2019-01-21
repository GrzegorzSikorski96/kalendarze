<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $service;
    protected $response;

    public function __construct(EventService $service, ApiResponse $response)
    {
        $this->response = $response;
        $this->service = $service;
    }

    public function all()
    {
        try {
            $events = Event::all();
        } catch (ModelNotFoundException $exception) {
            return $this->response
                ->notFound();
        }

        return $this->response
            ->setData(['events' => $events])
            ->success();
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $event = $this->service->create($request->all());
        } catch (QueryException $exception) {
            return $this->response
                ->setMessage('Error on creating event')
                ->internalServerError();
        }

        return $this->response
            ->setMessage('Event created')
            ->success();
    }

    public function event($id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['event' => $event])
            ->success();
    }

    public function edit(Request $request, $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        $this->service->edit($event, $request->all());

        return $this->response
            ->setData(['event' => $event])
            ->setMessage('Event edited')
            ->success();
    }

    public function remove($id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        $this->service->remove($event);

        return $this->response
            ->setMessage('Event removed')
            ->success();
    }
}