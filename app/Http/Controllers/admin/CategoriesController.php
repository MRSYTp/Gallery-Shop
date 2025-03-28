<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
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

    public function all(Request $request)
    {   

        $categories = Category::paginate(10);

        if ($request->search) {
            $categories = Category::where('title' , 'like' , '%' . $request->search . '%')->paginate(10);
        }
        return view('admin.category-all', compact('categories'));
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return back()->with('success', 'دسته بندی با موفقیت حذف شد');
        } else {
            return back()->with('error', 'دسته بندی یافت نشد');
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $validatedData = $request->validated();
        $category = Category::find($id);
        if (!$category) {
            return back()->with('error', 'دسته بندی یافت نشد');
        }
        $category->update(['slug' => $validatedData['slug'] , 'title' => $validatedData['title']]);
        return back()->with('success', 'دسته بندی با موفقیت ویرایش شد');
    }
}
