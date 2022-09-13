@extends('layout/business')
@section('content')
<div class="container-fluid pl-0 pr-0 mr-0 ml-0">
      <div class="row">
        <div class="col-sm-3 main_div">
          <span>
            <div class="text-center bg-light bg-gradient header-info p-3">Select Business</div>
          </span>
          <div class="profile-span mb-2">
          </div>
          <div class="text-center bg-light bg-gradient buttons">
            <!-- Button trigger modal -->      
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add Customer</span>
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
            <h5 class="modal-title" id="staticBackdropLabel">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('add_customer')}}" method="POST">
              @csrf()
              <div class="mb-3">
                <input type="text" class="form-control" name="name_customer" id="name_customer" placeholder="Enter Name ">
              </div>
               <div class="mb-3">
                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone (Optional) ">
                <input type="hidden" class="form-control" name="business_id" value="{{$b}}">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create Customer</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Close Modal For Business Form -->

    @endsection