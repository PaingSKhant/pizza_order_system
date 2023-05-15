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
                                <h2 class="title-1">Contact Message List</h2>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <h4> Search Key : {{ request('key') }}</h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#userContactListPage') }}" method="get">
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
                            <h3 class=""> <i class="fa-sharp fa-solid fa-database"></i> {{ $message->total()}}</h3>
                        </div>
                    </div>
                        @if (count($message) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($message as $m )
                                    <tr class="tr-shadow">
                                        <td class="">{{ $m['name']}}</td>
                                        <td class="">{{ $m['email']}}</td>
                                        <td class="">{{ $m['message']}}</td>
                                        <td >
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#deleteMessage',$m['id'])}}">
                                                    <button class="item " data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                         <i class="zmdi zmdi-delete text-danger"></i>
                                                     </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $message->links()}}
                            </div>
                        </div>
                        @else
                        <h3 class="text-secondary text-center mt-5">There is no message here!</h3>

                        @endif







                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

@endsection
