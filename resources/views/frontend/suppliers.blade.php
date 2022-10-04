@extends('frontend.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\Stock;
    use App\Models\SupplierDetail;
    use App\Models\BillDetail;
    use App\Models\BankAccount;
@endphp
@if(isset($details))
<?php
    $amount_purchase = $amount_payment = $amount_remaning_balance =0;
?>
@foreach($details as $detail)
    <?php
    $amount_purchase += $detail->purchase;
    $amount_payment += $detail->payment;
    $amount_remaning_balance += $detail->balance;
    ?>
@endforeach
@endif
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>{{ $customer['business_name'] }}</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Total Items - {{ $all_suppliers->count() }}</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <button type="button" class="btn btn-block btn-primary mt-2" data-toggle="modal" data-target="#add_supplier">
                        Add Suppliers
                    </button>
                </div>
                {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> --}}
                <div class="row p-2 justify-content-center" style="height: 15rem; overflow: auto;">
                    <ul class="nav nav-tabs" id="tabMenu">
                        @foreach ($all_suppliers as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }}" style="display: block !important; width: 100% !important;">
                                <a class="btn btn-primary btn-block mt-2" href="#supplier{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- </div> --}}
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($all_suppliers as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="supplier{{ $item->id }}" class="active">
                            @php
                                $supplier_id = $item->id;
                                $supplier_detail = SupplierDetail::where('supplier_id',$item->id)->get();
                                $balance = SupplierDetail::where('supplier_id',$item->id)->orderby('id', 'DESC')->first();
                                $purchase = $supplier_detail->sum('purchase');
                                $payment = $supplier_detail->sum('payment');
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        @if (!empty($supplier) )
                                            <div class="col-md-6">
                                                <h4 class="card-title">{{ $item['name'] }}</h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="card-title">{{ $item['phone_number'] }}</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body" style="height: 21rem; overflow: auto;">
                                   <table class="table" >
                                      <thead>
                                         <tr class="ligth">
                                            <th scope="col">Enteries <br> {{ $payment }}</th>
                                            <th scope="col">Detail <br></th>
                                            <th scope="col">Purchase <br>({{ $purchase }}) </th>
                                            <th scope="col">Payment <br> ({{ $payment }})</th>
                                            <th scope="col">Balance <br></th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                            @forelse($supplier_detail as $pay)
                                                <tr>
                                                    <td>{{ $pay->date }}</td>
                                                    <td>{{ $pay->detail }}</td>
                                                    <td>{{ $pay->purchase }}</td>
                                                    <td>{{ $pay->payment }}</td>
                                                    <td>{{ $pay->balance }}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        </tbody>
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#purchase{{ $item->id }}">
                                Purchase
                            </button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#payment{{ $supplier_id }}">
                                Payment
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="purchase{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Purchase From {{ $item['name'] }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('purchase') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $item->id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="amount" class="">Amount</label>
                                                    <input type="text" name="amount" id="amount" class="form-control" value="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail" class="">Detail</label>
                                                    <input type="text" name="detail" id="detail" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date" class="">Date</label>
                                                    <input type="date" name="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bill" class="">Bill No</label>
                                                    <input type="text" name="bill" id="bill" class="form-control">
                                                    <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{ $supplier['id'] }}">
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
                            <!-- Modal Quantity Out-->
                            <div class="modal fade" id="payment{{ $supplier_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Payment to </span>{{ $item['name'] }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('payment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="supplier_id" id="supplier_id" value="{{ $supplier_id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="amount" class="">Amount</label>
                                                    <input type="text" name="amount" id="amount" class="form-control" value="">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="detail" class="">Detail</label>
                                                    <input type="text" name="detail" id="detail" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date" class="">Date</label>
                                                    <input type="date" name="date" id="date" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="bill" class="">Bill No</label>
                                                    <input type="text" name="bill" id="bill" class="form-control">
                                                    <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{ $supplier['id'] }}">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{ route('add_supplier') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="">Name</label>
                            <input type="text" class="form-control" name="name_supplier" id="name_supplier" placeholder="Enter Name ">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="detail" class="">Phone</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone (Optional) ">
                        </div>
                    </div>
                    <div class="form-group">
                       <button class="btn btn-primary" type="submit">Create Supplier</button>
                    </div>
                 </form>
            </div>
        </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-2.2.2.js" integrity="sha256-4/zUCqiq0kqxhZIyp4G0Gk+AOtCJsY1TA00k5ClsZYE=" crossorigin="anonymous"></script>
<script>    
    $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
        });
</script>
@endsection
