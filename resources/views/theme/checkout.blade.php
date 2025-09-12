<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light py-5">

        @include('theme.layout.header')


  <div class="container my-5">

    <form action="{{ route('checkout.store') }}" method="POST">
      @csrf

      <div class="row g-4">
        {{-- Billing --}}
        <div class="col-lg-7">
          <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Billing Details</h2>

            @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
                {{-- للـ debug فقط --}}
                {{-- <pre>{{ print_r(session('data'), true) }}</pre> --}}
              </div>
            @endif

            <div class="mb-3">
              <label for="first_name" class="form-label">First Name*</label>
              <input id="first_name" name="first_name" type="text"
                     class="form-control @error('first_name') is-invalid @enderror"
                     value="{{ old('first_name') }}" required>
              @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="company" class="form-label">Company Name</label>
              <input id="company" name="company" type="text" class="form-control"
                     value="{{ old('company') }}">
            </div>

            <div class="mb-3">
              <label for="street" class="form-label">Street Address*</label>
              <input id="street" name="street" type="text"
                     class="form-control @error('street') is-invalid @enderror"
                     value="{{ old('street') }}" required>
              @error('street') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="apartment" class="form-label">Apartment, floor, etc. (optional)</label>
              <input id="apartment" name="apartment" type="text" class="form-control"
                     value="{{ old('apartment') }}">
            </div>

            <div class="mb-3">
              <label for="city" class="form-label">Town/City*</label>
              <input id="city" name="city" type="text"
                     class="form-control @error('city') is-invalid @enderror"
                     value="{{ old('city') }}" required>
              @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number*</label>
              <input id="phone" name="phone" type="tel"
                     class="form-control @error('phone') is-invalid @enderror"
                     value="{{ old('phone') }}" required>
              @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email Address*</label>
              <input id="email" name="email" type="email"
                     class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email') }}" required>
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-check mb-3">
              <input id="save" class="form-check-input" type="checkbox" name="save_info"
                     {{ old('save_info') ? 'checked' : '' }}>
              <label class="form-check-label" for="save">Save this information for faster check-out next time</label>
            </div>

          </div>
        </div>

        {{-- Order Summary --}}
        <div class="col-lg-5">
          <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Your Order</h2>

            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between"><span>LCD Monitor</span><strong>$650</strong></li>
              <li class="list-group-item d-flex justify-content-between"><span>H1 Gamepad</span><strong>$1100</strong></li>
              <li class="list-group-item d-flex justify-content-between"><span>Subtotal</span><strong>$1750</strong></li>
              <li class="list-group-item d-flex justify-content-between"><span>Shipping</span><strong>Free</strong></li>
              <li class="list-group-item d-flex justify-content-between"><span>Total</span><strong>$1750</strong></li>
            </ul>

            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <div class="form-check">
                <input id="pay_bank" class="form-check-input" type="radio" name="payment" value="bank"
                       {{ old('payment-method') == 'bank' ? 'checked' : '' }} required>
                <label class="form-check-label" for="pay_bank">Bank</label>
              </div>
              <div class="form-check">
                <input id="pay_cash" class="form-check-input" type="radio" name="payment" value="cash"
                       {{ old('payment-method') == 'cash' ? 'checked' : '' }}>
                <label class="form-check-label" for="pay_cash">Cash on Delivery</label>
              </div>
              @error('payment-method') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Place Order</button>
          </div>
        </div>
      </div>
    </form>
  </div>


    @include('theme.layout.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
