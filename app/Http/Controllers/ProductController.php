<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // عرض الـ Dashboard مع قائمة المنتجات
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
            'brand' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'rating' => 'required|integer|min:1|max:5',
            'reviews_count' => 'required|integer|min:0',
            'delivery_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // صورة بحد أقصى 2MB
        ]);

        // تعديل: حفظ الصورة مباشرة في public/products/ بدل storage
        $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
        $imagePath = $request->file('image')->move(public_path('products'), $imageName);  // حفظ في public/products/
        $imagePath = 'products/' . $imageName;  // مسار للـ DB (بدون storage/)

        Product::create([
            'brand' => $request->brand,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'rating' => $request->rating,
            'reviews_count' => $request->reviews_count,
            'delivery_date' => $request->delivery_date,
            'image' => $imagePath,  // مسار جديد: products/filename.jpg
        ]);

        return redirect()->route('dashboard')->with('success', 'تم إضافة المنتج بنجاح!');
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
            'brand' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'rating' => 'required|integer|min:1|max:5',
            'reviews_count' => 'required|integer|min:0',
            'delivery_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['brand', 'title', 'description', 'price', 'old_price', 'rating', 'reviews_count', 'delivery_date']);

        if ($request->hasFile('image')) {
            // تعديل: حفظ الصورة الجديدة مباشرة في public/products/
            $imageName = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('products'), $imageName);
            $data['image'] = 'products/' . $imageName;  // مسار جديد
        }

        $product->update($data);

        return redirect()->route('dashboard')->with('success', 'تم تحديث المنتج بنجاح!');
    }

    // حذف منتج
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('dashboard')->with('success', 'تم حذف المنتج بنجاح!');
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
        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة!');
    }
}