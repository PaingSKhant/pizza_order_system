@extends('user.layouts.master')

@section('content')

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5 mt-4">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>

                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ( $cartList as $c )

                    <tr>
                        <td class="align-middle">{{ $c->pizza_name}}
                            <input type="hidden" class="orderId" value="{{ $c->id}}">
                            <input type="hidden" class="productId" value="{{ $c->product_id}}">
                            <input type="hidden" class="userId" value="{{ $c->user_id}}">
                        </td>
                        <td class="align-middle" id="price">{{ $c->pizza_price}} kyats</td>
                        <td class="align-middle">
                            {{-- <input type="hidden" name="" value="{{ $c->pizza_price}}" id="price"> --}}
                            <div class="input-group quantity mx-auto" style="width: 100px;">

                                <div class="input-group-btn me-2">
                                    <button class="btn btn-sm btn-warning btn-minus" >
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>

                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $c->qty}}" id="qty">

                                <div class="input-group-btn ms-2">
                                    <button class="btn btn-sm btn-warning btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle" id="total">{{ $c->pizza_price * $c->qty}} kyats</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i class="fa fa-times"></i></button></td>
                    </tr>

                    @endforeach


                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class=" ">Cart Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6 id="subTotalPrice">{{ $totalPrice}}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Delivery</h6>
                        <h6 class="font-weight-medium">3000 kyats</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5 id="finalPrice">{{ $totalPrice+3000}}kyats</h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">
                        <span class="text-white">Proceed To Checkout</span>
                    </button>

                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">
                        <span class="text-white">Clear Cart</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('scriptSource')
    <script>
        //when order button click
        $('#orderBtn').click(function(){

            $orderList = [];
            $random = Math.floor(Math.random() * 100000000001);

            $('#dataTable tbody tr').each(function(index,row){
                $orderList.push({
                    'user_id' : $(row).find('.userId').val() ,
                    'product_id' : $(row).find('.productId').val() ,
                    'qty' : $(row).find('#qty').val() ,
                    'total' : $(row).find('#total').text().replace('kyats', '')*1 ,
                    'order_code' : 'POS' + $random
                });
            });

            $.ajax({
                type: 'get',
                url: 'http://localhost:8000/user/ajax/order',
                data: Object.assign({}, $orderList),
                dataType: 'json',
                success: function(response) {
                    if(response.status == "true"){
                        window.location.href = "http://localhost:8000/user/homePage"
                    }

                }
            })


        })
        //when plus button click
        $(document).ready(function(){
            $('.btn-plus').click(function(){
                $parentNode = $(this).parents("tr");
                $price = Number($parentNode.find('#price').text().replace("kyats",""));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price*$qty;
                $parentNode.find('#total').html($total + "kyats");

                summaryCalculation();
            })
            //when minus button click
            $('.btn-minus').click(function(){
                $parentNode = $(this).parents("tr");
                $price = Number($parentNode.find('#price').text().replace("kyats",""));
                $qty = Number($parentNode.find('#qty').val());
                $total = $price*$qty;
                $parentNode.find('#total').html($total + "kyats")

                summaryCalculation();
            })

            //calculate final price for order
            function summaryCalculation(){
                $totalPrice = 0 ;
                    $('#dataTable tbody tr').each(function(index,row){
                        $totalPrice += Number($(row).find('#total').text().replace("kyats"," "));
                    });

                   $('#subTotalPrice').html(`${$totalPrice} kyats`)
                   $('#finalPrice').html(`${$totalPrice + 3000} kyats`)
            }

            //when click clear cart button
            $('#clearBtn').click(function(){
                // console.log('clear')

                $('#dataTable tbody tr').remove();
                $('#subTotalPrice').html("0 Kyats");
                $('#finalPrice').html("3000 Kyats");

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/user/ajax/clear/cart',
                    dataType: 'json',
                })

            })

            //remove current product
             //when cross button click
             $('.btnRemove').click(function(){
                $parentNode = $(this).parents("tr");
                $productId = $parentNode.find(".productId").val();
                $orderId = $parentNode.find(".orderId").val();

                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/user/ajax/clear/current/product',
                    data : {'productId' : $productId, 'orderId' : $orderId} ,
                    dataType: 'json',
                })
                $parentNode.remove();
                summaryCalculation();

            })
        })
    </script>

@endsection


