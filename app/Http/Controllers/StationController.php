<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use App\Http\Resources\Station as StationResource;
use App\Http\Requests\StationRequest;

class StationController extends Controller
{
	/**
	* Display a listing of the resource
	*
	* @return \Illuminate\Http\Response
	*/
    public function index()
    {
    	$stations = Station::all();

    	return response()->json($stations);
    }

    /**
	* Display the specified resource.
	*
	* @param \App\Station $station
	* @return \Illuminate\Http\Response
	*/
    public function show(Station $station)
    {
    	return response()->json($station);
    }

    /**
	* Store a newly created resource in storage.
	*
	* @param \App\Http\Requests\StationRequest
	* @return \Illuminate\Http\Response
	*/
    public function store(StationRequest $request)
    {
   		
    	$newStation = Station::create($request->all());

    	return new StationResource($newStation);

    }

    /**
	* Update the specified resource in storage.
	*
	* @param \App\Http\Requests\StationRequest
	* @param \App\Station $station
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, Station $station)
	{
		$editedStation = $station->update($request->all());

    	return response()->json(['msg' => 'resource updated'], 204);
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param \App\Station $station
	* @return \Illuminate\Http\Response
	*/
	public function destroy(Station $station)
	{
		$station->delete();
		return response()->json(['msg' => 'resource deleted'], 204);
	}

}
