@extends('admin.layouts.master')

@section('title', 'Category List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>

                    {{-- category create success validation --}}
                    @if (session('categorySuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-check"></i> {{ session('categorySuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        {{-- <div class="col-3">
                            <h4> Search Key : {{ request('key') }}</h4>
                        </div> --}}
                        <div class="col-3 offset-9">
                            <form action="{{ route('admin#orderList') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..."
                                        value="{{ request('key') }}">
                                    <button class="btn bg-warning text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-2 bg-warning rounded shadow-sm text-center p-2 ms-3">
                            <h3 class=""> <i class="fa-sharp fa-solid fa-database"></i> {{ count($order)}}</h3>
                        </div>
                    </div>

                    <form action="{{ route('admin#changeStatus')}}" method="get">
                        @csrf
                        <div class="">
                            <label for="" class="me-2 mt-2 d-block"><h4>Order Status :</h4></label>
                            <select name="orderStatus" id="orderStatus" class="form-control col-2 d-inline">
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>

                                <button type="submit" class="btn btn-sm btn-dark text-white "> <i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>

                    </form>




                    {{-- category delete success validation --}}
                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-trash "></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($order as $o)
                                        <tr class="tr-shadow ">
                                            <input type="hidden" class="orderId" value="{{ $o->id}}">
                                            <td>{{ $o->user_id}}</td>
                                            <td>{{ $o->user_name}}</td>
                                            <td>{{ $o->created_at->format('F-j-Y')}}</td>
                                            <td>
                                                <a href="{{route('admin#listInfo',$o->order_code)}}" class="text-primary">{{ $o->order_code}}</a>
                                            </td>
                                            <td>{{ $o->total_price}} Kyats</td>
                                            <td>
                                                <select name="status" class="form-control statusChange">
                                                    <option value="0" @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1" @if ($o->status == 1) selected @endif>Accept</option>
                                                    <option value="2" @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>


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

<script>
    $(document).ready(function(){
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val();
        //     // console.log($status);

        //     $.ajax({
        //         type : 'get' ,
        //         url : 'http://localhost:8000/order/ajax/status' ,
        //         data : {
        //             'status' : $status ,
        //         } ,
        //         dataType : 'json' ,
        //         success : function(response){
        //             $list = '';
        //             for ($i = 0; $i < response.length; $i++) {

        //                 $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        //                 $dbDate = new Date(response[$i].created_at);
        //                 $finalDate = $months[$dbDate.getMonth()]+"-"+ $dbDate.getDate()+"-"+ $dbDate.getFullYear();

        //                 if(response[$i].status == 0 ){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;
        //                 }else if(response[$i].status == 1){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>
        //                     `;

        //                 }else if(response[$i].status == 2){
        //                     $statusMessage = `
        //                     <select name="status" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>
        //                     `;
        //                 }



        //                 $list += `
        //                 <tr class="tr-shadow ">
        //                     <input type="hidden" class="orderId" value="${response[$i].id }">
        //                     <td> ${response[$i].user_id} </td>
        //                     <td> ${response[$i].user_name} </td>
        //                     <td> ${$finalDate} </td>
        //                     <td> ${response[$i].order_code} </td>
        //                     <td> ${response[$i].total_price}  Kyats</td>
        //                     <td> ${$statusMessage}</td>


        //                 </tr>

        //                 `;
        //         }
        //         $('#dataList').html($list);
        //     }
        //     })
        // })

        //change status

        $('.statusChange').change(function(){
            console.log('click event');
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $orderId = $parentNode.find('.orderId').val();

            $data = {
                'orderId' : $orderId ,
                'status' : $currentStatus
            };

            console.log($data);

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/order/ajax/change/status' ,
                data : $data,
                dataType : 'json' ,
            })
        })


    })
</script>

@endsection
