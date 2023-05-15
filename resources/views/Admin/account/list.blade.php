@extends('admin.layouts.master')

@section('title', 'Category List Page')


@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

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
                        <div class="col-3">
                            <h4> Search Key : {{ request('key') }}</h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..."
                                        value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-2 bg-warning rounded shadow-sm text-center p-2 my-1">
                            <h3 class="bg-warning"> <i class="fa-sharp fa-solid fa-database"></i> {{ $admin->total()}}</h3>
                        </div>
                    </div>


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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $a)
                                        <tr class="tr-shadow ">
                                            <td class="col-2">
                                                @if ($a->image == null)
                                                    @if ($a->gender == 'male')
                                                        <img src="{{ asset( 'image/user_photo.png')}}" class="img-thumbnail shadow-sm rounded">
                                                    @else
                                                        <img src="{{ asset( 'image/female_default.jpg')}}" class="img-thumbnail shadow-sm rounded">
                                                    @endif
                                                @else
                                                    <img src="{{ asset( 'storage/' . $a->image)}}" class="img-thumbnail shadow-sm rounded">
                                                @endif
                                            </td>
                                            <td>{{ $a->name}}</td>
                                            <td>{{ $a->email}}</td>
                                            <td>{{ $a->gender}}</td>
                                            <td>{{ $a->phone}}</td>
                                            <td>{{ $a->address}}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    @if (Auth::user()->id == $a->id)

                                                    @else
                                                    <a href="{{ route('admin#changeRole', $a->id)}}">
                                                        <button class="item me-2" data-toggle="tooltip" data-placement="top"
                                                            title="Change Admin Role">
                                                            <i class="fa-solid fa-right-left"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('admin#delete', $a->id)}}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete text-danger"></i>
                                                        </button>
                                                    </a>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="">
                                {{$admin->links()}}
                                {{-- {{ $categories->appends(request()->query())->links() }} --}}
                            </div>
                        </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection
