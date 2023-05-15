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
                                <h2 class="title-1">Products List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon bg-warning au-btn--small text-dark">
                                    <i class="zmdi zmdi-plus"></i>Add Pizza
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon bg-warning au-btn--small text-dark">
                                CSV download
                            </button>
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
                        <div class="col-3">
                            <h4> Search Key : {{ request('key') }}</h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('product#list') }}" method="get">
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
                        <div class="col-2 bg-warning rounded shadow-sm text-center p-2 my-1">
                            <h3 class=""> <i class="fa-sharp fa-solid fa-database"></i> {{ $pizzas->total()}}</h3>
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

                        @if (count($pizzas) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pizzas as $p)
                                        <tr class="tr-shadow ">
                                            <td class="col-2 "> <img src="{{ asset( 'storage/' . $p->image)}}" class="img-thumbnail shadow-sm rounded"></td>
                                            <td class="col-3 ">{{ $p->name}}</td>
                                            <td class="col-2 ">{{ $p->price}}</td>
                                            <td class="col-2 ">{{ $p->category_name}}</td>
                                            <td class="col-2 "> <i class="fa-solid fa-eye"></i>  {{ $p->view_count}}</td>
                                            <td class="col-2 ">
                                                <div class="table-data-feature ">
                                                    <button class="item me-2 " data-toggle="tooltip" data-placement="top"
                                                        title="Send">
                                                        <i class="zmdi zmdi-mail-send text-primary"></i>
                                                    </button>
                                                    <a href="{{ route('product#updatePage',$p->id)}}">
                                                        <button class="item me-2" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit "></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete',$p->id)}}">
                                                        <button class="item me-2" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete text-danger"></i>
                                                        </button>
                                                    </a>
                                                  <a href="{{ route('product#edit',$p->id)}}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top"
                                                    title="More">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>
                                                  </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $pizzas->links()}}
                            </div>
                        </div>
                        @else
                        <h3 class="text-secondary text-center mt-5">There is no pizza here!</h3>
                        @endif

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection
