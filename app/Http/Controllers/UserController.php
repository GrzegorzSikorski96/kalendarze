<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $response;

    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }

    public function users(): JsonResponse
    {
        try {
            $users = User::all();
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['users' => $users])
            ->success();
    }

    public function calendars(): JsonResponse
    {
        try {
            $calendars = Auth::user()->calendars;
        } catch (ErrorException $exception) {
            return $this->response->unauthorized();
        }

        return $this->response
            ->setData(['calendars' => $calendars])
            ->success();
    }

    public function calendarsWithEvents()
    {
        try {
            $calendars = auth()->user()->calendars()->with('events')->get();
        } catch (ModelNotFoundException $exception) {
            return $this->response->notFound();
        }

        return $this->response
            ->setData(['calendars' => $calendars])
            ->success();
    }
}