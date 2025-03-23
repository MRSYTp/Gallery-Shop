<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Utilities\ImageUploder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

        $result = $this->uploadImage($createdProduct , $validatedData);

        if (!$result) {
            File::deleteDirectory(public_path('storage/products/'.$createdProduct->id));
            File::deleteDirectory(storage_path('app/private_storage/products/'.$createdProduct->id));
            DB::rollBack();
            return back()->with('error' , 'تصاویر آپلود نشد.');
        }

        DB::commit();
        return back()->with('success' , 'محصول با موفقیت ساخته شد.');

    }

    public function all()
    {   

        $products = Product::paginate(10);
        
        return view('admin.product-all', compact('products'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        File::deleteDirectory(public_path('storage/products/'.$product->id));
        File::deleteDirectory(storage_path('app/private_storage/products/'.$product->id));
        $product->delete();

        return back()->with('success' , 'محصول با موفقیت حذف شد.');
    }


    public function edit($id)
    {   
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.product-edit' , compact('product' , 'categories'));
    }

    public function update(UpdateRequest $request , $id)
    {
        $validatedData = $request->validated();

        $product = Product::findOrFail($id);

        if (!$product) {
            return back()->with('error' , 'محصول یافت نشد.');
        }

        DB::beginTransaction();

        $product->update([
            'title' => $validatedData['title'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'description' => $validatedData['description'],
        ]);


        $result = $this->uploadImage($product , $validatedData);

        if (!$result) {
            DB::rollBack();
            return back()->with('error' , 'تصاویر آپلود نشد.');
        }


        DB::commit();
        return back()->with('success' , 'محصول با موفقیت ویرایش شد.');

    }
    public function downloadDemo($id)
    {
        $product = Product::findOrFail($id);
        return response()->download(public_path('storage/'.$product->demo_url));
    }

    public function downloadSource($id)
    {
        $product = Product::findOrFail($id);
        return response()->download(storage_path('app/private_storage/'.$product->source_url));
    }


    private function uploadImage($createdProduct , $validatedData)
    {
        try {

            $basePath = 'products/'. $createdProduct->id .'/';

            $uploadedImages = [];

            if (isset($validatedData['thumbnail_url'])) {
                $thumbnailImagePath = $basePath . 'thumbnail_url_' . $validatedData['thumbnail_url']->getClientOriginalName();
                File::delete(public_path('storage/' . $createdProduct->thumbnail_url));
                ImageUploder::upload($validatedData['thumbnail_url'] , $thumbnailImagePath , 'public_storage');
                $uploadedImages += ['thumbnail_url' => $thumbnailImagePath];
            }


            if (isset($validatedData['demo_url'])) {
                $demoImagePath = $basePath . 'demo_url_' . $validatedData['demo_url']->getClientOriginalName();
                File::delete(public_path('storage/' . $createdProduct->demo_url));
                ImageUploder::upload($validatedData['demo_url'] , $demoImagePath , 'public_storage');
                $uploadedImages += ['demo_url' => $demoImagePath];
            }

            if (isset($validatedData['source_url'])) {
                $sourceImagePath = $basePath . 'source_url_' . $validatedData['source_url']->getClientOriginalName();
                File::cleanDirectory(storage_path('app/private_storage/products/'.$createdProduct->id));
                ImageUploder::upload($validatedData['source_url'] , $sourceImagePath , 'private_storage');
                $uploadedImages += ['source_url' => $sourceImagePath];

            }

            $createdProduct->update($uploadedImages);

            
            return true;

        } catch (\Exception $e) {

            return false;
            
        }
    }
}
