@extends('admin.layouts.master')

@section('title', 'Category List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <a href="{{ route('admin#orderList') }}" class="text-dark">
                        <i class="fa-solid fa-arrow-left "></i> Back
                    </a>

                    <div class="row col-5">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h3> <i class="fa-solid fa-utensils"></i> Order Info </h3>
                                <small class="text-warning"> Inclute Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"> <i class="fa-solid fa-user"></i> Name</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name)}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col"> <i class="fa-solid fa-barcode"></i> OrderCode</div>
                                    <div class="col">{{ $orderList[0]->order_code}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col"> <i class="fa-solid fa-calendar-days"></i> OrderDate</div>
                                    <div class="col">{{  $orderList[0]->created_at->format('F-j-Y')}}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col"> <i class="fa-solid fa-circle-dollar-to-slot"></i> Total</div>
                                    <div class="col">{{ $order->total_price}} Kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Order Date</th>
                                <th>Qty</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($orderList as $o)
                                <tr class="tr-shadow ">
                                    <td></td>
                                    <td>{{ $o->user_id }}</td>
                                    <td>{{ $o->user_name }}</td>
                                    <td class="col-2"> <img src="{{ asset('storage/' . $o->product_image) }}"
                                            class="img-thumbails rounded "></td>
                                    <td>{{ $o->product_name }}</td>
                                    <td>{{ $o->created_at->format('F-j-Y') }}</td>
                                    <td>{{ $o->qty }}</td>
                                    <td>{{ $o->total }} Kyats</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="mt-3">

                    </div>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection

@section('scriptSection')


@endsection
