@extends('layouts.app')

@section('title')
Store Category
@endsection

@section('content')
<div class="page-content page-cart">
  <!-- breadcrumbs -->
  <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/index.html">Home</a>
              </li>
              <li class="breadcrumb-item">Cart</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <section class="store-cart">
    <div class="container">
      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-12 table-responsive">
          <table class="table table-borderless table-cart">
            <thead>
              <tr>
                <td>Image</td>
                <td>Name &amp; Seller</td>
                <td>Price</td>
                <td>Menu</td>
              </tr>
            </thead>
            <tbody>
              @php
              $totalPrice = 0
              @endphp
              @foreach ($carts as $item)
              <tr>
                @if($item->product->galleries)
                <td width="25%"><img src="{{ Storage::url($item->product->galleries->first()->photos) }}" alt=""
                    class="cart-image" /></td>
                @endif
                <td width="35%">
                  <div class="product-title">{{ $item->product->name }}</div>
                  <div class="product-subtitle">{{ $item->product->user->store_name }}</div>
                </td>
                <td width="35%">
                  <div class="product-title">${{ number_format($item->product->price) }}</div>
                  <div class="product-subtitle">USD</div>
                </td>
                <td width="20%">
                  <form action="{{ route('cart-delete',$item->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger"> Remove </button>
                  </form>
                </td>
              </tr>
              @php
              $totalPrice += $item->product->price
              @endphp
              @endforeach

            </tbody>
          </table>
        </div>
      </div>
      <div class="row" data-aos="fade-up" data-aos-delay="150">
        <div class="col-12">
          <hr />
        </div>
        <div class="col-12">
          <h2 class="mb-4">Shipping Detail</h2>
        </div>
      </div>
      <form action="{{ route('checkout') }}" id="locations" method="POST">
        @csrf
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
          <div class="col-md-6">
            <div class="form-group">
              <label for="addressOne">Address 1</label>
              <input type="text" class="form-control" name="addreess_one" id="addressOne" value="Tawang Tasikmalaya" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="address_one">Address 2</label>
              <input type="text" class="form-control" id="address_one" name="address_two" value="Kawali Ciamis" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="provinces_id">Province</label>
              <select name="provinces_id" id="provinces_id" class="form-control" v-model="provinces_id"
                v-if="provinces">
                <option v-for="province in provinces" :value="province.id">@{{ province.name }}</option>
              </select>
              <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="city">City</label>
              <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id"
                v-if="regencies">
                <option v-for="regency in regencies" :value="regency.id">@{{ regency.name }}</option>
              </select>
              <select v-else class="form-control"></select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="postalCode">Postal Code</label>
              <input type="text" class="form-control" id="postalCode" name="zip_code" value="129312" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" value="Indonesia" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="mobile">Mobile</label>
              <input type="text" class="form-control" id="mobile" name="phone_number" value="+6282118418130" />
            </div>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="150">
          <div class="col-12">
            <hr />
          </div>
          <div class="col-12">
            <h2 class="mb-2">Payment Information</h2>
          </div>
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="200">
          <div class="col-4 col-md-2">
            <div class="product-title">$10</div>
            <div class="product-subtitle">Country Tax</div>
          </div>
          <div class="col-4 col-md-3">
            <div class="product-title">$280</div>
            <div class="product-subtitle">Product Insurance</div>
          </div>

          <div class="col-4 col-md-2">
            <div class="product-title">$580</div>
            <div class="product-subtitle">Ship to Jakarta</div>
          </div>

          <div class="col-4 col-md-2">
            <div class="product-title text-success">${{ number_format($totalPrice) ?? 0 }}</div>
            <div class="product-subtitle">Total</div>
          </div>
          <div class="col-8 col-md-3">
            <button type="submit" class="btn btn-success mt-4 px-4 btn-block">Checkout Now</button>
          </div>
        </div>

      </form>
    </div>
  </section>
</div>
@endsection
@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
  var locations = new Vue({
    el: "#locations",
    
    mounted() {
      AOS.init();
    this.getProvincesData();
    },
data: {
  provinces: null,
  regencies: null,
  provinces_id: null,
  regencies_id: null,
},
methods: {
  getProvincesData() {
    var self = this;
    axios.get('{{ route('api-provinces') }}')
    .then(function (response) {
    self.provinces = response.data;
    })
  },
  getRegenciesData() {
    var self = this;
    axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
    .then(function (response) {
    self.regencies = response.data;
    })
    },
  },
  watch: {
  provinces_id: function (val, oldVal) {
    this.regencies_id = null;
    this.getRegenciesData();
    },
    }
 });

</script>
@endpush