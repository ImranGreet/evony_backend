<?php

namespace App\Http\Controllers;

use App\Mail\SendUserLoginInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phoneNumber' => 'required',
            'zipCode' => 'required',
            'gender' => 'required',
        ]);

        $randomNumber = Str::random(10);
        $password = bcrypt($randomNumber);

        $user = new User();
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->password = $password;
        $user->streetAdressOne = $request->address['streetAdressOne'];
        $user->streetAddressTwo = $request->address['streetAddressTwo'];
        $user->city = $request->address['city'];
        $user->town = $request->address['town'];
        $user->zipCode = $request->address['zipCode'];
        $user->dateOfBirth = $request->dateOfBirth;
        $user->placeOfBirth = $request->placeOfBirth;
        $user->gender = $request->gender;
        $user->losing_weight_challenge = $request->losing_weight_challenge;
        $user->gp_practice_email = $request->gp_practice_email;
        $user->GPS_name_and_address = $request->GPS_name_and_address;
        $user->save();

        if ($request->hasFile('idCardPhoto')) {
            $path = Storage::putFileAs(
                'idCardPhotos', $request->file('idCardPhoto'), $request->user()->id
            );
            $user->idCardPhoto = $path;
            $user->save();
        }

        Mail::to($request->email)->send(new SendUserLoginInformation($randomNumber, $request->email));

        return response()->json([
            'message' => 'User created successfully',
            'password' => $randomNumber,
            'user' => $user,
        ], 201);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
