@extends('frontend.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\MoneyReceiveBook;
    use App\Models\StockQuantity;
    use App\Models\BillDetail;
    use App\Models\BankAccount;
@endphp
<?php
    $total_money_out = $total_money_in = 0;
?>
@foreach ($payment as $pay)
    <?php
    $total_money_out += $pay->money_out;
    $total_money_in += $pay->money_in;
    ?>
@endforeach
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Money Receive Book</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Total Parties - {{ $all_customers->count() }}</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black; height: 23rem; overflow: auto;">
                    <ul class="nav nav-tabs" style="width: 10rem;" id="tabMenu">
                        @forelse ($data as $key => $item)
                            <li class="{{ $key == 0 ? 'active' : ''  }} mt-2">
                                <a class="btn btn-primary btn-block" style="width: 10rem;" href="#customer{{ $key }}" data-toggle="tab">{{ $item->name }}</a>
                            </li>
                        @empty
                        <p>No Record Present</p>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @forelse ($data as $key => $item)
                        <div class="tab-pane {{ $key == 0 ? 'active' : ''  }}" id="customer{{ $key }}" class="active">
                            @php
                                // $item = $key;
                                $party_detail = MoneyReceiveBook::where('customer_id',$key)->get();
                                // dd($party_detail);
                                $balance = MoneyReceiveBook::where('customer_id',$item)->orderby('id', 'DESC')->first();
                                $money_out = $party_detail->sum('money_out');
                                $money_in = $party_detail->sum('money_in');                                
                            @endphp
                            <div class="card">
                                <div class="card-header" style="color: white; background-color: #50508b;">
                                    <div class="row justify-content-between pl-1 pr-1"  style="height: 2rem;">
                                        <h6 class="" style="color: ">AL-Haj Muhammad Alam Muhammad Hussni</h6>
                                        <div class="row">
                                            <div class="col" style="color: ">
                                                <h6 class="">Prop: Haji Izzatullah</h6>
                                                <h6 class="">Prop: Habib ur Rehman</h6>
                                            </div>    
                                        </div>
                                        <div class="row">
                                            <div class="col" style="color: white;">
                                                <h6 class="">Ph#03320559987</h6>
                                                <h6 class="">Ph#03134000039</h6>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header pb-2 pt-1" style="background-color: #50508b; color: white; height: 2rem;">
                                    <h6 class="">Office# 3, 5th Floor, Mohammad Hassni Plaza, Duble Road, Quetta</h6>
                                </div>
                                <div class="card-header">
                                    <div class="row" style="height: 1rem;">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item['name'] }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item['phone_number'] }}</h4>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 16rem; overflow: auto;">
                                   <table class="table">
                                      <thead>
                                        @if (sizeof($party_detail) != 0)
                                         <tr class="ligth">
                                            <th scope="col">Enteries <br> ({{ sizeof($party_detail) }})</th>
                                            <th scope="col">Detail <br></th>
                                            <th scope="col">Money Out <br>({{ $money_out }}) </th>
                                            <th scope="col">Money In <br> ({{ $money_in }})</th>
                                            <th scope="col">Balance <br></th>
                                         </tr>
                                        @else
                                            <tr class="ligth">
                                                <th scope="col">Enteries</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">Money Out </th>
                                                <th scope="col">Money In</th>
                                                <th scope="col">Balance</th>
                                            </tr>
                                        @endif
                                      </thead>
                                      <tbody>
                                        {{-- @if (sizeof($payment) != 0) --}}
                                            @forelse ($party_detail  as $pay)
                                                <tr>
                                                    <th scope="row">{{ $pay->date }}</th>
                                                    <td>{{ $pay->detail }}</td>
                                                    <td>{{ $pay->money_out }} </td>
                                                    <td>{{ $pay->money_in }}</td>
                                                    <td>{{ $pay->balance }}</td>
                                                </tr>
                                            @empty
                                            
                                                <p>No Record!</p>
                                                
                                            @endforelse
                                        {{-- @endif --}}
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#you_gave{{ $key }}">
                                Money Out
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#you_got{{ $key }}">
                                Money In
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="you_gave{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">You gave to </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('money_out') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                        value="{{ $key }}">
                                            {{-- <input type="hidden" name="item_id" id="item_id" value="{{ $item->id}}"> --}}
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
                            <div class="modal fade" id="you_got{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">You got from </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('money_in') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="customer_id" id="customer_id" class="form-control" value="{{ $key }}">
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
    <div class="modal fade" id="add_party" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<script src="https://code.jquery.com/jquery-2.2.2.js" integrity="sha256-4/zUCqiq0kqxhZIyp4G0Gk+AOtCJsY1TA00k5ClsZYE=" crossorigin="anonymous"></script>

<script>    
// $.noConflict();
$(document).ready(function () {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>
@endsection