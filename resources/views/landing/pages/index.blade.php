@extends('landing.layouts.main')

@section('content')
<!-- Slider -->
<section class="section-slide">
    <div class="wrap-slick1 rs2-slick1">
        <div class="slick1">
            <div class="item-slick1 bg-overlay1" style="background-image: url({{ asset('landing/foto/1.png') }});" data-thumb="{{ asset('landing/foto/1.png') }}" data-caption="">
                <div class="container h-full">
                    <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            {{-- <span class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                PKS
                            </span> --}}
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                Bersama Melayani Rakyat
                            </h2>
                        </div>
                        {{-- <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="item-slick1 bg-overlay1" style="background-image: url({{ asset('landing/foto/2.png') }});" data-thumb="{{ asset('landing/foto/2.png') }}" data-caption="">
                <div class="container h-full">
                    <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            {{-- <span class="ltext-202 txt-center cl0 respon2">
                                PKS
                            </span> --}}
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                Bersama Melayani Rakyat
                            </h2>
                        </div>
                        {{-- <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="item-slick1 bg-overlay1" style="background-image: url({{ asset('landing/foto/3.png') }});" data-thumb="{{ asset('landing/foto/3.png') }}" data-caption="">
                <div class="container h-full">
                    <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            {{-- <span class="ltext-202 txt-center cl0 respon2">
                                PKS
                            </span> --}}
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                Bersama Melayani Rakyat
                            </h2>
                        </div>
                        {{-- <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="item-slick1 bg-overlay1" style="background-image: url({{ asset('landing/foto/4.png') }});" data-thumb="{{ asset('landing/foto/4.png') }}" data-caption="">
                <div class="container h-full">
                    <div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
                        <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                            {{-- <span class="ltext-202 txt-center cl0 respon2">
                                PKS
                            </span> --}}
                        </div>

                        <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                            <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                Bersama Melayani Rakyat
                            </h2>
                        </div>
                        {{-- <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                            <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Shop Now
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="wrap-slick1-dots p-lr-10"></div>
    </div>
</section>
<!-- Related Products -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <div class="p-b-45">
            <h3 class="ltext-106 cl5 txt-center">
                Daftar Calon
            </h3>
        </div>

        @if($caleg->isEmpty())
        <div class="alert alert-danger" role="alert">
            <strong>Maaf!</strong> Belum ada calon yang terdaftar.
        </div>

        @endif
        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                @foreach ($caleg as $data )
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ asset('/admin/foto/caleg/' . $data['foto']) }}" alt="IMG-PRODUCT">
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{$data->name}}
                                </a>

                                {{-- <span class="stext-105 cl3">
                                    $16.64
                                </span> --}}
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
