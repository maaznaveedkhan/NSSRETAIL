@extends('layout.business')
@section('content')
<div class="container-fluid pl-0 pr-0 mr-0 ml-0">
      <div class="row">
        <div class="col-sm-3 main_div">
          <div class="header-issue p-3 background-dark">
            <div style="width: 100%;">
              <span class="text-center">NSS Retail</span>
            </div>
            {{-- <i class="fa-solid fa-building-columns" style="color: white !important;"></i>
            <div class="menu-nav">
              <div class="dropdown-container" tabindex="-1">
                <div class="three-dots"></div>
                <div class="dropdowns">
                  <div class="drop mb-2"><a href=""> Filter Customer List </a></div>
                  <div class="drop mb-2"><a href=""> Customer List PDF </a></div>
                  <div class="drop mb-2"><a href=""> Profile </a></div>
                  <div class="drop mb-2"><a href=""> About Us </a></div>			            
                  <div class="drop mb-2"><a href=""> Language </a></div>			            
                  <div class="drop mb-2"><a href=""> Help & Support </a></div>			            
                  <div class="drop mb-2"><a href=""> Cash Register </a></div>			            
                  <div class="drop mb-2"><a href=""> Recyle Bin </a></div>			            
                  <div class="drop mb-2"><a href=""> EasyDokan </a></div>			            
                  <div class="drop mb-2">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                  </div>			            
                </div>
              </div>
            </div> --}}
          </div>
          <span>
            <div class="text-center bg-light bg-gradient header-info p-3">Select Business</div>
            </span>
            @forelse($all_businesses as $all_business)
            <div class="profile-span mb-1"  style="background-color: #f37111">            
                <a href="{{route('business_page' , ['id'=>$all_business->id])}}" type="button" class="btn btn-div mb-2">
                  <div class="mb-1 mt-1 profile-image-div">
                    <img class="profile-image" src="{{asset('E-khata')}}/images/logo/profile.png">
                    <span class="business-name">{{$all_business->business_name}}</span>
                  </div>
                </a>
            </div>
            @empty

            @endforelse
          <div class="text-center bg-light bg-gradient buttons">
            <!-- Button trigger modal -->      
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">New Business</span>
            </button>
          </div>
        </div>
        <div class="col-sm-9">
            
        </div>
      </div>
    </div>
      
    <!-- Modal For Business Form -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Business</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('new_business')}}" method="POST">
              @csrf()
              <div class="mb-3">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Enter Business Name ">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="button-bussiness">Create Business</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Close Modal For Business Form -->

    @endsection