<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories=category::latest()->get();
        return view('admin.allcategory',compact('categories'));
    }

    public function addCategory(){
        return view('admin.addcategory');
    }

    public function StoreCategory(Request $request){
        $request->validate([
            'category_name' => 'required|unique:categories'
        ]);
        
        category::insert([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ','-',$request->category_name))
        ]);
        return redirect()->route('allcategory')->with('message','Category Added successfully');
    }
    public function EditCategory($id){
        $category_info = category::findOrFail($id);

        return view('admin.editcategory',compact('category_info'));
    }

    public function UpdateCategory(Request $request){
        $category_id = $request->category_id;


        $request->validate([
            'category_name' => 'required|unique:categories'
        ]);

        category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ','-',$request->category_name))
        ]);


        return redirect()->route('allcategory')->with('message','Category Updatted successfully');

    }
    
    public function DeleteCategory($id){
        category::findOrFail($id)->delete();

        return redirect()->route('allcategory')->with('message', 'Category Deleted successfully');
    }
}
