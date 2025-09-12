<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    //  عرض صفحة الفورم
    public function create()
    {
        return view('checkout.create');
    }

    //  حفظ البيانات بعد ما المستخدم يملأ الفورم
    public function store(Request $request)
    {
        //  التحقق من البيانات (Validation)
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|string',
        ]);

        //  إنشاء سجل جديد في قاعدة البيانات
        Checkout::create($validatedData);

        //  بعد الحفظ يرجع رسالة نجاح
        return redirect()->back()->with('success', 'Checkout data has been submitted successfully!');
    }

    //  عرض كل الطلبات (CRUD - Read)
    public function index()
    {
        $checkouts = Checkout::all();
        return view('checkout.index', compact('checkouts'));
    }

    //  تعديل بيانات طلب
    public function edit($id)
    {
        $checkout = Checkout::findOrFail($id);
        return view('checkout.edit', compact('checkout'));
    }

    public function update(Request $request, $id)
    {
        $checkout = Checkout::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'payment_method' => 'required|string',
        ]);

        $checkout->update($validatedData);

        return redirect()->route('checkout.index')->with('success', 'The checkout has been updated successfully!');
    }

    //  حذف طلب
    public function destroy($id)
    {
        $checkout = Checkout::findOrFail($id);
        $checkout->delete();

        return redirect()->route('checkout.index')->with('success', 'The checkout has been deleted successfully!');
    }
}
