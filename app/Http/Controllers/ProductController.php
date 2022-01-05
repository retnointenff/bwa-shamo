<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = DB::table('products')
            ->join('product_categories', 'products.product_categories_id', '=', 'product_categories.id')
            ->select('products.name AS product_name', 'product_categories.name AS category_name', 'products.price', 'products.id')
            ->get();
        $category = DB::table('product_categories')->get();
        return view('products', ['product' => $product, 'category' => $category, 'i' => 0]);
    }

    public function show($id)
    {
        $product = DB::table('products AS p')
            ->join('product_categories AS pc', 'p.product_categories_id', '=', 'pc.id')
            ->select('p.*', 'pc.name AS category_name')
            ->where('p.id', $id)
            ->get();
        $category = DB::table('product_categories')->get();
        $gallery = DB::table('product_galleries')->where('product_id', '=', $id)->get();
        return view('edit_products', ['product' => $product, 'category' => $category, 'i' => 0, 'gallery' => $gallery]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_categories_id' => 'required',
            'name'                  => 'required',
            'price'                 => 'required'
        ]);
        Products::create($request->all());
        return redirect()->route('products.index')->with('success', 'Data berhasil di input');
    }

    public function imageStore(Request $request)
    {
        $request->validate([
            'image'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id' => 'required'
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        ProductGallery::create(['product_id' => $request->product_id, 'url' => url('images/') . '/' . $imageName]);
        return redirect()->route('products.show', $request->product_id)->with('success', 'Data berhasil di input');
    }

    public function destroy($id)
    {
        DB::table('products')->where('id', '=', $id)->delete();
        return redirect()->route('products.index')->with('success', 'Data berhasil di hapus');
    }
}
