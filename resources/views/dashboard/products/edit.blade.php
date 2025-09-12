@extends('dashboard.master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">تعديل المنتج</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                            <li class="breadcrumb-item active">تعديل المنتج</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">تعديل المنتج</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="brand" class="form-label">العلامة التجارية</label>
                                    <input type="text" class="form-control" name="brand" value="{{ old('brand', $product->brand) }}" required>
                                    @error('brand')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">اسم المنتج</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $product->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">الوصف</label>
                                    <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">السعر (EGP)</label>
                                    <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}" required>
                                    @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="old_price" class="form-label">السعر القديم (EGP)</label>
                                    <input type="number" step="0.01" class="form-control" name="old_price" value="{{ old('old_price', $product->old_price) }}">
                                    @error('old_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="rating" class="form-label">التقييم (1-5)</label>
                                    <input type="number" class="form-control" name="rating" value="{{ old('rating', $product->rating) }}" min="1" max="5" required>
                                    @error('rating')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="reviews_count" class="form-label">عدد التقييمات</label>
                                    <input type="number" class="form-control" name="reviews_count" value="{{ old('reviews_count', $product->reviews_count) }}" min="0" required>
                                    @error('reviews_count')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="delivery_date" class="form-label">تاريخ التوصيل</label>
                                    <input type="date" class="form-control" name="delivery_date" value="{{ old('delivery_date', $product->delivery_date) }}" required>
                                    @error('delivery_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">صورة المنتج (اتركه فارغًا إذا لم ترغب في التغيير)</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    <img src="{{ asset($product->image) }}" width="100" alt="Current Image">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">تحديث المنتج</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
