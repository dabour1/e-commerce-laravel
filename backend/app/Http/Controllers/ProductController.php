<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\GeneralTrait;
class ProductController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->uploadImage($request);
        }
        DB::beginTransaction();
        try{
            $product = Product::create($validatedData);
            $this->attachCategories($product,$validatedData);
            $this->attachAttributes($product,$validatedData);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
      

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('categories', 'attributes');
        return new ProductResource($product);
    }

     

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData =$request->validated();
        if($request->hasfile('image')){
            $validatedData['image'] = $this->uploadImage($request,$product);
        }
        DB::beginTransaction();
        try{
            $product->update($validatedData);
            $this->attachCategories($product,$validatedData);
            $this->attachAttributes($product,$validatedData);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->image){
            Storage::delete($product->image);
           }
           $product->delete();
           return response()->json(null, 204);
    }

    // public function uploadImage($request,$product=null){
    //     $imagePath="";
    //     if ($product!=null and $product->image) {
    //         Storage::delete($product->image);
    //         $imageName = $product->id. $request->file('image')->getClientOriginalExtension();
    //         $request->file('image')->storeAs('public/images', $imageName);
    //     }else{
    //         $imageName = $product->id. $request->file('image')->getClientOriginalName();
    //         $request->file('image')->store('public/images');
    //     }
    //     return  $imageName;
    // }

    public function attachCategories($product,$validatedData){
        if (isset($validatedData['categories'])){
            $product->categories()->sync($validatedData['categories']);  
        }
    }
    public function attachAttributes($product,$validatedData){
        if (isset($validatedData['attributes'])) {
            $product->attributes()->detach();
            foreach ($validatedData['attributes'] as $attribute) {
                $product->attributes()->attach($attribute['id'], ['value' => $attribute['value']]);
            }
        }
    }
}
