<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function CategoryPage($id)
    {
        $category = category::findOrFail($id);
        $products = product::where('product_category_id', $id)->latest()->get();
        
        return view('user_template.Category', compact('category'));
    }

    public function SingleProduct($id)
    {
        $product = product::findOrFail($id);

        $subcat_id = product::where('id', $id)
            ->value('product_subcategory_id');

        $related_product = product::query()
            ->where('product_subcategory_id', $subcat_id)
            ->latest();

        return view(
            'user_template.SingleProduct',
            compact('product', 'related_product')
        );
    }
    public function AddToCart()
    {
        return view('user_template.AddToCart');
    }
    public function CheckOut()
    {
        return view('user_template.CheckOut');
    }
    public function UserProfile()
    {
        return view('user_template.UserProfile');
    }
    public function NewRelease()
    {
        return view('user_template.NewRelease');
    }
    public function TodaysDeal()
    {
        return view('user_template.TodaysDeal');
    }
    public function CostomerService()
    {
        return view('user_template.CostomerService');
    }
}
