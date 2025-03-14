<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\Categories\StoreRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function add()
    {
        return view('admin.category-add');
    }


    public function store(StoreRequest $request)
    {   
        $validatedData = $request->validated();

        $create = Category::create(['slug' => $validatedData['slug'] , 'title' => $validatedData['title']]);
        
        if ($create) {
            return back()->with('success', 'دسته بندی با موفقیت ثبت شد');
        } else {
            return back()->with('error', 'دسته بندی ثبت نشد');

        }
    }

    public function all()
    {
        $categories = Category::paginate(10);
        return view('admin.category-all', compact('categories'));
    }
}
