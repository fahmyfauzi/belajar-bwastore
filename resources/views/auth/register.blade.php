@extends('layouts.auth')

@section('content')
<div class="page-content page-auth" id="register">
  <div class="section-store-auth" data-aos="fade-up">
    <div class="container">
      <div class="row align-items-center justify-content-center row-login">
        <div class="col-lg-6">
          <h2>
            Memulai untuk jual beli <br />
            dengan cara terbaru
          </h2>
          <form method="POST" action="{{ route('register') }}" class="mt-3">
            @csrf
            <div class="form-group">
              <label for="">Full Name</label>
              <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" v-model="name" autofocus>

              @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="">Email Address</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" v-model="email" required autocomplete="email"
                @change="checkForEmailAvailablility()" :class="{'is-invalid' : this.email_unavailable}">

              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

              @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="">Password Confirmation</label>
              <input id="password_confirmation" type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                required autocomplete="new-password">

              @error('password_confirmation')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="form-group">
              <label>Store</label>
              <p class="text-muted">Apakah anda juga ingin membuka toko?</p>
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" type="radio" name="is_store_open" id="openStoreTrue"
                  v-model="is_store_open" :value="true" />
                <label class="custom-control-label" for="openStoreTrue">Iya, boleh</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" type="radio" name="is_store_open" id="openStoreFalse"
                  v-model="is_store_open" :value="false" />
                <label makasih class="custom-control-label" for="openStoreFalse">Enggak, makasih</label>
              </div>
              <div class="form-group" v-if="is_store_open">
                <label for="">Nama Toko</label>
                <input type="text" class="form-control" v-model="store_name" id="store_name" name="store_name" required
                  autocomplete="store_name" autofocus />
                @error('store_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group" v-if="is_store_open">
                <label for="">Kategory</label>
                <select name="categories_id" class="form-control">
                  <option value="" disabled>Select Category</option>
                  @foreach ($categories as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <button type="submit" class="btn btn-success btn-block mt-4" :disabled="this.email_unavailable">Sign Up
              Now</button>
            <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-4">Back to Sign In</a>
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
  Vue.use(Toasted);

      var register = new Vue({
        el: '#register',
        mounted() {
          AOS.init();
         
        },
        methods:{
          checkForEmailAvailablility: function(){
            var self = this;
            axios.get('{{ route('api-register-check') }}',{
              params:{
                email: this.email
              }

            })
            .then(function (response) {
               if(response.data == 'Available'){
              self.$toasted.show('Email anda tersedia! Silahkan lanjut langkah selanjutnya.', {
              position: 'top-center',
              className: 'rounded',
              duration: 1000,
                 });
                 self.email_unavailable = false;
               }else{
                 self.$toasted.error('Maaf, tampaknya email sudah terdaftar pada sistem kami.', {
              position: 'top-center',
              className: 'rounded',
              duration: 1000,
                 });
                 self.email_unavailable = true;
               }
              console.log(response);
            });

          }
        },
        data() {
          return{
          name: 'Fahmy Fauzi',
          email: 'fahmyfauziii@gmail.com',
          is_store_open: true,
          email_unavailable: false
          }
        },
      });
</script>
@endpush