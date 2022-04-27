@extends('layouts.app')

@section('title')
    Store Category
@endsection

@section('content')
  <!-- page content -->
    <div class="page-content page-home">
      <!-- trend categories -->
      <section class="store-trend-categories">
        <div class="container">
          <div class="row">
            <div class="col-12" data-aos="fade-up">
              <h5>All Categories</h5>
            </div>
          </div>
          <div class="row">
            @php
                $incrementCategory = 0;
            @endphp
             @forelse ($categories as $item)
                <div class="col-6 col-md-3 col-lg-2" data-aos-delay="{{ $incrementCategory+=100 }}">
              <a href="{{ route('categories-detail',$item->slug) }}" class="component-categories d-block">
                <div class="categories-image">
                  <img src="{{ Storage::url($item->photo) }}" alt="" class="w-100" />
                </div>
                <p class="categories-text">{{ $item->name }}</p>
              </a>
            </div>
            @empty
            <div class="col-12 tex-center py-5" data-aos="fade-up" data-aos-delay="100">
              No Categories Found
            </div>
          @endforelse
          </div>
        </div>
      </section>
    </div>
    <!-- trend products -->
    <section class="new-store-products">
      <div class="container">
        <div class="row">
          <div class="col-12" data-aos="fade-up">
            <h5>All Products</h5>
          </div>
        </div>
         <div class="row">
           @php
                $incrementProduct = 0;
            @endphp
          @forelse ($products as $item)
               <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $incrementProduct +=100 }}">
            <a class="component-products d-block" href="{{ route('detail',$item->slug) }}">
              <div class="products-thumbnail">
                <div class="products-image" style="
                @if($item->galleries->count())
                  background-image:url({{ Storage::url($item->galleries->first()->photos) }})
                @else
                backgorund-color: #eee
                @endif">
                </div>
              </div>
              <div class="products-text">{{ $item->name }}</div>
              <div class="products-price">${{ $item->price }}</div>
            </a>
          </div>
          @empty
               <div class="col-12 tex-center py-5" data-aos="fade-up" data-aos-delay="100">
              No Products Found
            </div>
          @endforelse
        </div>
        <div class="row">
          <div class="col-12 mt-4">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </section>
@endsection