<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    return ProductResource::collection(Product::where('stock', '>', 0)->get());
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->uploadImage($request,"products");
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
            $validatedData['image'] = $this->uploadImage($request,"products",$product);
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
            Storage::delete('public/images/products/'.$product->image);
           }
           $product->delete();
           return response()->json(null, 204);
    }

    public function filter(Request $request)
   {
       $request->validate([
           'query' => 'required|string|min:1', 
       ]);
       
       $query = $request['query'];  
       
       $products = Product::where('name', 'LIKE', "%{$query}%")->get();  

       return response()->json($products);
   }
   
   public function sortedProducts(Request $request)
{
    $request->validate([ 
        'sort' => 'required|string|in:newest,highest_price,lowest_price',
    ]);

    $sortOptions = [
        'newest' => ['created_at', 'desc'],
        'highest_price' => ['price', 'desc'],
        'lowest_price' => ['price', 'asc']
    ];

    $sort = $sortOptions[$request->input('sort')];
    $products = Product::where('stock', '>', 0)
                        ->orderBy($sort[0], $sort[1])
                        ->get();

    return ProductResource::collection($products);
}

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
