<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->get();
        return view('dashboard.products.index', compact('products'));
    }

    // عرض المنتجات في صفحة الـ Products (للـ frontend)
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('theme.product', compact('products'));
    }

    // عرض نموذج إضافة منتج
    public function create()
    {
        return view('dashboard.products.create');
    }

    // تخزين منتج جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // تعديل: حفظ الصورة مباشرة في public/products/ بدل storage
        $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->move(public_path('products'), $imageName);  // حفظ في public/products/
        $imagePath = 'products/' . $imageName;

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Product added successfully');
    }

    // عرض نموذج تعديل منتج
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.edit', compact('product'));
    }

    // تحديث منتج
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['name', 'description', 'price', 'stock']);

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('products'), $imageName);
            $data['image'] = 'products/' . $imageName;  // مسار جديد
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('dashboard')->with('success', 'Product deleted successfully');
    }



    // عرض منتج فردي (للـ frontend)
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('theme.single_product', compact('product'));
    }

    // إضافة للسلة
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = $request->session()->get('cart', []);
        $cart[] = $product->id;
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart');
    }
}
