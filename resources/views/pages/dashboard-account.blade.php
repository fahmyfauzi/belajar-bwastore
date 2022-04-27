@extends('layouts.dashboard')

@section('title')
Store Category
@endsection

@section('content')

<div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">My Account</h2>
      <p class="dashboard-subtitle">Update your current profile</p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-12">
          <form action="{{ route('dashboard-settings-redirect','dashboard-settings-account') }}" method="POST"
            enctype="multipart/form-data" id="locations">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Your name</label>
                  <input type="text" class="form-control" id="name" value="{{ $user->name }}" name="name" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="email">Your Email</label>
                  <input type="email" class="form-control" id="email" value="{{ $user->email }}" name="email" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="addressOne">Address 1</label>
                  <input type="text" class="form-control" id="addressOne" value="{{ $user->address_one }}"
                    name="address_one" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="addressTwo">Address 2</label>
                  <input type="text" class="form-control" id="addressTwo" value="{{ $user->address_two }}"
                    name="address_two" />
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
                  <label for="regencies_id">City</label>
                  <select name="regencies_id" id="regencies_id" class="form-control" v-model="regencies_id"
                    v-if="regencies">
                    <option v-for="regency in regencies" :value="regency.id">@{{regency.name}}</option>
                  </select>
                  <select v-else class="form-control"></select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="postalCode">Postal Code</label>
                  <input type="text" class="form-control" id="postalCode" name="zip_code"
                    value="{{ $user->zip_code }}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="country">Country</label>
                  <input type="text" class="form-control" id="country" value="{{ $user->country }}" name="country" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="mobile">Mobile</label>
                  <input type="text" class="form-control" id="mobile" value="+{{ $user->phone_number }}"
                    name="phone_number" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col text-right">
                <button type="submit" class="btn btn-success">Save Now</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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