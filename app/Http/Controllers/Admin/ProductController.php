<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\product;
use App\Models\subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = product::latest()->get();
        return view('admin.allproduct', compact('products'));
    }

    public function addProduct()
    {
        $categories = category::latest()->get();
        $subcategories = subcategory::latest()->get();
        return view('admin.addproduct', compact('categories', 'subcategories'));
    }
    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products',
            'price' => 'required',
            'quantity' => 'required',
            'product_short_des' => 'required',
            'product_long_des' => 'required',
            'product_category_id' => 'required',
            'product_subcategory_id' => 'required',
            'product_img' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('product_img');
        $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'), $img_name);
        $img_url = 'upload/' . $img_name;

        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;

        $category_name = category::where('id', $category_id)->value('category_name');
        $subcategory_name = subcategory::where('id', $subcategory_id)->value('subcategory_name');


        product::insert([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_des,
            'product_long_des' => $request->product_long_des,
            'price' => $request->price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $request->product_category_id,
            'product_subcategory_id' => $request->product_subcategory_id,
            'product_img' => $img_url,
            'quantity' => $request->quantity,
            'slug' => strtolower(str_replace(' ', '-', $request->product_name)),

        ]);


        category::where('id', $category_id)->increment('product_count', 1);
        subcategory::where('id', $subcategory_id)->increment('product_count', 1);

        return redirect()->route('allProduct')->with('message', 'Product Added successfully');
    }


    public function EditProductImg($id)
    {
        $productinfo = product::findOrFail($id);
        return view('admin.editproductimg', compact('productinfo'));
    }



    public function UpdateProductImg(Request $request)
    {


        $request->validate([
            'product_img' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $id = $request->id;
        $image = $request->file('product_img');
        $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'), $img_name);
        $img_url = 'upload/' . $img_name;


        product::findOrFail($id)->update([
            'product_img' => $img_url,

        ]);

        return redirect()->route('allProduct')
            ->with('message', 'Product Image Updated successfully');
    }

    public function EditProduct($id)
    {
        $productinfo = product::findOrFail($id);

        return view('admin.editproduct', compact('productinfo'));
    }

    public function UpdateProduct(Request $request, product $product)
    {
        $request->validate([
            'product_name' => "required|unique:products,id,{$product->id}",
            'price' => 'required',
            'quantity' => 'required',
            'product_short_des' => 'required',
            'product_long_des' => 'required',
        ]);

        $product->update([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_des,
            'product_long_des' => $request->product_long_des,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'slug' => strtolower(str_replace(' ', '-', 
            $request->product_name)),
        ]);

        return redirect()
            ->route('allProduct')
            ->with('message', 'Product informatison Updated successfully');
    }
    public function DeleteProduct($id){
        
        $cat_id = product::where('id', $id)->value('product_category_id');
        $subcat_id = product::where('id', $id)->value('product_subcategory_id');

        category::where('id', $cat_id)->decrement('product_count',1);
        subcategory::where('id', $subcat_id)->decrement('product_count',1);
        product::findOrFail($id)->delete(); 


        return redirect()
            ->route('allProduct')
            ->with('message', 'Product Image Updated successfully');


    }

    
}
