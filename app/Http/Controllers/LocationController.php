<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    public function getLocation(): AnonymousResourceCollection
    {
        $locations = Location::all();
        return LocationResource::collection($locations);
    }
    public function storeLocation(LocationRequest $request): Response
    {
        $data = $request->validated();
        Location::create($data);
        return response('Cteated');
    }
    public function deleteLocation(): Response
    {
        $oneMinute = now()->subMinute();
        Location::where('created_at', '<=', $oneMinute)
            ->delete();
        return response('delete');
    }
}
