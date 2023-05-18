<?php

namespace App\Http\Controllers;
use Illuminate\Support\str;

use App\Models\Category;
use Illuminate\Http\Request;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at','DESC')->paginate(20);
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:categories,name',
        ]);
        $category=Category::create([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name, '-'),
            'description'=> $request->description,
        ]);
        Session::flash('success','Category created successfully');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => "required|unique:categories,name,$category->id",
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name, '-');
        $category->description = $request->description;
        $category->save();

        Session::flash('success', 'Category updated successfully');
        return redirect()->route('admin.category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category){
            $category->delete();

            Session::flash('success', 'Category deleted successfully');
            return redirect()->route('admin.category');
        }
    }
}
