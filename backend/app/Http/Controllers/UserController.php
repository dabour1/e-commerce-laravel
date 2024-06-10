<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Traits\GeneralTrait;
class UserController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasfile('image')){
            $validatedData['image'] = $this->uploadImage($request);
        }
        $validatedData['password'] = bcrypt($validatedData['password']);
         $user=User::create($validatedData);
        return response()->json(['message' => 'User created successfully', 'user' => new UserResource($user),  ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData =$request->validated();
        if($request->hasfile('image')){
            $validatedData['image'] = $this->uploadImage($request,$user);
        }
        $user->update( $validatedData);
    return response()->json(['message' => 'User updated successfully', 'user' => new UserResource($user)], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image){
            Storage::delete($user->image);}
            $user->delete();
    }
}
