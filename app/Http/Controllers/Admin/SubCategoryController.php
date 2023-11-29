<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        return view('admin.allsubcategory', [
            'subCategories' => subcategory::query()->get()
        ]);
    }

    public function addSubCategory()
    {
        $categories = category::latest()->get();
        return view('admin.addsubcategory', compact('categories'));
    }

    public function StoreSubCategory(Request $request)
    {
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
            'category_id' => 'required'
        ]);

        $category_id = $request->category_id;
        $category_name = category::where('id', $category_id)->value('category_name');

        subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            'category_id' => $category_id,
            'category_name' => $category_name,
        ]);

        category::where('id', $category_id)->increment('subcategory_count', 1);
        return redirect()->route('allSubcategory')->with('message', 'sub Category Added successfully');

    }
         public function editSubCat($id){
            $subcatinfo = subcategory::findOrFail($id);

            return view('admin/editsubcat', compact('subcatinfo'));
         }
         public function updateSubCat(Request $request){
            $request->validate([
                'subcategory_name' => 'required|unique:subcategories',
            ]);

            $subcatid = $request->subcatid;

            subcategory::findOrFail($request->subcatid)->update([
                'subcategory_name' => $request->subcategory_name,
                'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            ]);

            return redirect()->route('allSubcategory')->with('message', 'sub Category Updated successfully');
            
        }
        public function DeleteSubCat($id){
            $cat_id = subcategory::where('id', $id)->value('category_id');
            subcategory::findOrFail($id)->delete();
            
            category::where('id', $cat_id)->decrement('subcategory_count',1);

            return redirect()->route('allSubcategory')->with('message', 'sub Category Deleted successfully');

        }
}