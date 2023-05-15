@extends('user.layouts.master')

@section('content')

<!-- Shop Detail Start -->
<div class="container-fluid pb-5 mt-4">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">

            <a href="{{ route('user#home')}}" class="text-decoration-none text-dark">
                <i class="fa-solid fa-left-long "></i> Back
            </a>
            <div id="product-carousel" class="carousel slide mt-3" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="{{ asset('storage/'.$pizza->image)}}" alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30 mt-4">
            <div class="h-100 bg-light p-30 ">
                <h3 class="ms-4">{{$pizza->name}}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        {{-- <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small> --}}
                    </div>
                    <small class="pt-1 fs-5 ms-4"> {{ $pizza->view_count + 1}}  <i class="fa-solid fa-eye"></i> </small>
                </div>
                <h3 class="font-weight-semi-bold mb-4 ms-4"> {{ $pizza->price}} Kyats</h3>
                <p class="mb-4 ms-4">{{ $pizza->description}}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-warning btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center ms-1" value="1" id="orderCount">
                        <input type="hidden" value="{{ Auth::user()->id}}" id="userId">
                        <input type="hidden" value="{{ $pizza->id}}" id="pizzaId">
                        <div class="input-group-btn">
                            <button class="btn btn-warning btn-plus ms-1">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning px-3 ms-2" id="addCartBtn"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->
@endsection

@section('scriptSource')
<script>
    //increase view count

    $.ajax({
        type: 'get',
        url: 'http://localhost:8000/user/ajax/increase/viewCount',
        data: { 'productId' : $('#pizzaId').val()} ,
        dataType: 'json',

    })


    //click add to cart btn
    $(document).ready(function(){
        $('#addCartBtn').click(function(){

            $source = {
                'userId' : $('#userId').val() ,
                'pizzaId' : $('#pizzaId').val() ,
                'count' : $('#orderCount').val()
            };


            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/addToCart',
                data: $source ,
                dataType: 'json',
                success: function(response) {

                    if(response.status == 'success'){
                        window.location.href = "http://localhost:8000/user/homePage";
                    }

                }
            })
        })
    })
</script>

@endsection

