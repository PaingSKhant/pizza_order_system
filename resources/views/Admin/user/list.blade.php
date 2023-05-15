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
                                <h2 class="title-1">User List</h2>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <h4> Search Key : {{ request('key') }}</h4>
                        </div>
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
                        <div class="table-responsive table-responsive-data2">

                            <h3>Total - {{ $users-> total()}}</h3>
                            <table class="table table-data2">
                                <thead>

                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                    </tr>



                                </thead>
                                <tbody id="dataList">
                                    @foreach ($users as $u)
                                    <tr>
                                        <td class="col-2">
                                            @if ($u->image == null)
                                            @if ($u->gender == 'male')
                                                <img src="{{ asset( 'image/user_photo.png')}}" class="img-thumbnail shadow-sm rounded">
                                            @else
                                                <img src="{{ asset( 'image/female_default.jpg')}}" class="img-thumbnail shadow-sm rounded">
                                            @endif
                                        @else
                                        <img src="{{ asset('storage/'.Auth::user()->image) }}"  />
                                        @endif
                                        </td>
                                        <input type="hidden" id="userId" value="{{ $u->id}}">
                                        <td>{{ $u->name}}</td>
                                        <td>{{ $u->email}}</td>
                                        <td>{{ $u->gender}}</td>
                                        <td>{{ $u->phone}}</td>
                                        <td>{{ $u->address}}</td>
                                        <td>
                                            <select  class="form-control rounded statusChange">
                                                <option value="user" @if($u->role == 'user') selected @endif>User</option>
                                                <option value="admin" @if($u->role == 'admin') selected @endif>Admin</option>
                                            </select>
                                        </td>
                                       </tr>

                                    @endforeach


                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $users->links()}}

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
        $('.statusChange').change(function(){

            $currentStatus = $(this).val();

            $parentNode = $(this).parents("tr");
            $userId = $parentNode.find('#userId').val();
            console.log($userId  );

            $data = {
                'userId' :  $userId ,
                'role' : $currentStatus ,

            };
            $.ajax({
                type : 'get' ,
                url : '/user/change/role' ,
                data : $data,
                dataType : 'json' ,
            })
            location.reload();

        })
    })

</script>

@endsection
