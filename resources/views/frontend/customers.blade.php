@extends('frontend.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\CustomerDetail;
    use App\Models\StockQuantity;
    use App\Models\BillDetail;
    use App\Models\BankAccount;
@endphp
<?php
    $total_given_amount = $total_got_amount = 0;
?>
@foreach ($payment as $pay)
    <?php
    $total_given_amount += $pay->given_amount;
    $total_got_amount += $pay->got_amount;
    ?>
@endforeach
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>Customers</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Total Customers - {{ $all_customers->count() }}</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <button type="button" class="btn btn-block btn-primary mt-2" data-toggle="modal" data-target="#add_customer">
                        Add Customer
                    </button>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black; height: 18rem; overflow: auto;">
                    <ul class="nav nav-tabs" style="width: 10rem;">
                        @forelse($all_customers as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2">
                                <a class="btn btn-primary btn-block" style="width: 10rem;" href="#customer{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a>
                            </li>
                        @empty
                        @endforelse
                    </ul> 
                </div>
                {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> --}}
                    {{-- <ul class="nav nav-tabs" style="width: 5rem;">
                        @forelse($all_customers as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2">
                                <a class="btn btn-primary btn-block" style="width: 10rem; margin-left:2rem;" href="#customer{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a>
                            </li>
                        @empty
                        @endforelse
                    </ul>  --}}
                {{-- </div> --}}
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @forelse ($all_customers as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="customer{{ $item->id }}" class="active">
                            @php
                                $customer_id = $item->id;
                                $customer_detail = CustomerDetail::where('customer_id',$item->id)->get();
                                $balance = CustomerDetail::where('customer_id',$item->id)->orderby('id', 'DESC')->first();
                                $given_amount = $customer_detail->sum('given_amount');
                                $got_amount = $customer_detail->sum('got_amount');                                
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item['name'] }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item['phone_number'] }}</h4>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 20rem; overflow: auto;">
                                   <table class="table">
                                      <thead>
                                        @if (sizeof($payment) != 0)
                                         <tr class="ligth">
                                            <th scope="col">Enteries <br> ({{ sizeof($payment) }})</th>
                                            <th scope="col">Detail <br></th>
                                            <th scope="col">You Gave <br>({{ $given_amount }}) </th>
                                            <th scope="col">You Got <br> ({{ $got_amount }})</th>
                                            <th scope="col">Balance <br></th>
                                         </tr>
                                        @endif
                                      </thead>
                                      <tbody>
                                        @if (sizeof($payment) != 0)
                                            @forelse ($customer_detail  as $pay)
                                                <tr>
                                                    <th scope="row">{{ $pay->date }}</th>
                                                    <td>{{ $pay->detail }}</td>
                                                    <td>{{ $pay->given_amount }} </td>
                                                    <td>{{ $pay->got_amount }}</td>
                                                    <td>{{ $pay->balance }}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#you_gave{{ $item->id }}">
                                You Gave
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#you_got{{ $customer_id }}">
                                You Got
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="you_gave{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Quantity In</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('given_amount') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="item_id" id="item_id" value="{{ $item->id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="amount">Amount</label>
                                                    <input type="text" name="amount" id="amount"
                                                        class="form-control" value="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail" >Detail</label>
                                                    <input type="text" name="detail" id="detail" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date" >Date</label>
                                                    <input type="date" name="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bill" >Bill No</label>
                                                    <input type="text" name="bill" id="bill" class="form-control">
                                                    <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                        value="{{ $customer['id'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                               <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                         </form>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div> --}}
                                </div>
                                </div>
                            </div>
                            <!-- Modal Quantity Out-->
                            <div class="modal fade" id="you_got{{ $customer_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">You got from {{ $customer['name'] }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('got_amount') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="item_id" id="item_id" value="{{ $customer_id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="amount">Amount</label>
                                                    <input type="text" name="amount" id="amount"
                                                        class="from-control" value="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                                    <input type="text" name="detail" id="detail" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date" class="col-sm-2 col-form-label">Date</label>
                                                    <input type="date" name="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                                    <input type="text" name="bill" id="bill" class="form-control">
                                                    <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                        value="{{ $customer['id'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                               <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                         </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    @empty    
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Quantity In -->
    <div class="modal fade" id="add_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_customer') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="name_customer" id="name_customer"
                                placeholder="Enter Name ">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                placeholder="Enter Phone (Optional) ">
                        </div>
                    </div>
                    <div class="form-group">
                       <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                 </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection