@extends('dashboard.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard v2</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v2</li>
                        </ Demol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        {{-- main content --}}
        <div class="container">
            <a href="{{ route('dashboard.create') }}" class="btn btn-primary mb-3">إضافة منتج جديد</a>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>الصورة</th>
                        <th>العلامة التجارية</th>
                        <th>الاسم</th>
                        <th>الوصف</th>
                        <th>السعر</th>
                        <th>السعر القديم</th>
                        <th>تاريخ التوصيل</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ asset($product->image) }}" width="50" alt="{{ $product->title }}"></td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ Str::limit($product->description, 50) }}</td> <!-- قص الوصف لو طويل -->
                            <td>EGP {{ number_format($product->price, 2) }}</td>
                            <td>EGP {{ number_format($product->old_price, 2) }}</td>
                            <td>{{ date('D, d M', strtotime($product->delivery_date)) }}</td>
                            <td>
                                <a href="{{ route('dashboard.edit', $product->id) }}"
                                    class="btn btn-sm btn-warning">تعديل</a>
                                <form action="{{ route('dashboard.destroy', $product->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
