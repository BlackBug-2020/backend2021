<?php

namespace App\Http\Controllers;

use App\Models\Model\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Profile\ProfileCollection;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = new Profile;
        $profile->user_id = Auth::id();
        $profile->purok = $request->purok;
        $profile->barangay = $request->barangay;
        $profile->phone = $request->phone;
        $profile->save();
        return response([
            'data' => new ProfileResource($profile)
        ],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Model\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $id = ProfileUserGet($profile);
        return new ProductResource($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Model\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Model\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $this->ProfileUserCheck($profile);
        $request['phone'] = $request->phone;
        $request['barangay'] = $request->barangay;
        $request['purok'] = $request->purok;
        $profile->update($request->all());
        return response([
            'data' => new ProfileResource($profile)
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Model\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function ProfileUserCheck($profile)
    {
        if (Auth::id() !== $profile->user_id) {
            throw new ProductNotBelongsToUser;

        }

    }
    public function ProfileUserGet($profile)
    {
        if (Auth::id() !== $profile->user_id) {
            return $profile->id;
            throw new ProductNotBelongsToUser;
            
        }

    }
}
