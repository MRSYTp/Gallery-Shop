<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Utilities\ImageUploder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function add()
    {   

        $categories = Category::all();
        return view('admin.product-add', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();


        $users = User::where('email', 'mo.salehi1387p@gmail.com')->first();

        DB::beginTransaction();
        $createdProduct = Product::create([
            'title' => $validatedData['title'],
            'category_id' => $validatedData['category_id'],
            'owner_id' => $users->id,
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
        ]);

        if (!$createdProduct) {
            return back()->with('error' , 'محصول ساخته نشد دوباره امتحان کنید.');
        }

        try {
            $basePath = 'products/'. $createdProduct->id .'/';

            $sourceImagePath = $basePath . 'source_url_' . $validatedData['source_url']->getClientOriginalName();

            $images = [
                'thumbnail_url' => $validatedData['thumbnail_url'],
                'demo_url' => $validatedData['demo_url'],
            ];

            $uploadedImages = ImageUploder::multipleUpload($images , $basePath);

            ImageUploder::upload($validatedData['source_url'] , $sourceImagePath , 'private_storage');

            $createdProduct->update([
                'thumbnail_url' => $uploadedImages['thumbnail_url'],
                'demo_url' => $uploadedImages['demo_url'],
                'source_url' => $sourceImagePath,
            ]);

            DB::commit();
            return back()->with('success' , 'محصول با موفقیت ساخته شد.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error' , $e->getMessage());
            
        }
    }
}
