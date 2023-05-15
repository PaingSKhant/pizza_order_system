@extends('user.layouts.master')

@section('content')
<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-6">
            <div class="card rounded-3 text-black bg-warning">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body p-md-5 mx-md-4">
                            <div class="text-center">
                                <h3 class="">Contact Us</h3>
                                <h5>We're here to help and answer any question you might have.</h5>
                            </div>

                            <form action="{{ route('user#contact')}}" method="post" class="mt-5">
                                @csrf
                                <div class="mb-4">
                                    <input name="userName" type="text" class="form-control @error('userName') is-invalid @enderror"  placeholder="Name"/>
                                    @error('userName')
                                    <div class="invalid-feedback">
                                        {{$message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <input name="userEmail" type="text"  class="form-control @error('userEmail') is-invalid @enderror"   placeholder="Email"/>
                                    @error('userEmail')
                                    <div class="invalid-feedback">
                                        {{$message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <textarea name="userMessage" type="text"  cols="30" rows="10" class="form-control @error('userMessage') is-invalid @enderror"    placeholder="Message" ></textarea>
                                    @error('userMessage')
                                    <div class="invalid-feedback">
                                        {{$message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <a href="#">
                                        <button class="btn btn-dark btn-block mb-3 px-5 col-12 text-white" type="submit" > <i class="fa-solid fa-paper-plane"></i> Send Message</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
