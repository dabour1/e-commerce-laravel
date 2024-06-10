<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Traits\GeneralTrait;
class AdminController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  AdminResource::collection(Admin::all());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $validatedData = $request->validated();

        if($request->hasfile('image')){
            $validatedData['image'] = $this->uploadImage($request);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $validatedData['image'] = $imagePath;
        }
        $validatedData['password'] = bcrypt($validatedData['password']);
        $admin = Admin::create($validatedData);
        return response()->json(['message' => 'Admin created successfully', 'admin' => new AdminResource($admin) ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return new AdminResource($admin);
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validatedData =$request->validated();
        
            if($request->hasfile('image')){
                $validatedData['image'] = $this->uploadImage($request,$admin);
            }
        
        $admin->update( $validatedData);
    return response()->json(['message' => 'Admin updated successfully', 'admin' =>  new AdminResource($admin)], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->image){
            Storage::delete($admin->image);}
            $admin->delete();
    }
}
