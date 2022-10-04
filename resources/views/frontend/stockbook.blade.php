@extends('frontend.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\Stock;
    use App\Models\StockQuantity;
    use App\Models\BillDetail;
    use App\Models\BankAccount;
@endphp
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black; height: 30rem; overflow: auto;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>Stock Book</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Total Items - {{ $stocks->count() }}</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <button type="button" class="btn btn-block btn-primary mt-2" data-toggle="modal" data-target="#add_item">
                        Add Items
                    </button>
                </div>
                {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> --}}
                <div class="row p-2 justify-content-center">
                    <ul class="nav nav-tabs" style="width: 10rem;">
                        @forelse ($stocks as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2" id="tabMenu">
                                <a class="btn btn-primary btn-block" style="width: 10rem" href="#item{{ $item->id }}" data-toggle="tab">{{ $item->item_name }}</a>
                            </li>
                        @empty
                            <p>No Record Present</p>
                        @endforelse
                    </ul> 
                </div>
                {{-- </div> --}}
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($stocks as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="item{{ $item->id }}" class="active">
                            @php
                                $item_id = $item->id;
                                $sale_rate = $item->sale_rate;
                                $stock_detail = StockQuantity::where('item_id',$item->id)->get();
                                $balance = StockQuantity::where('item_id',$item->id)->orderby('id', 'DESC')->first();
                                $qty_out = $stock_detail->sum('qty_out');
                                $qty_in = $stock_detail->sum('qty_in');                                
                            @endphp
                            <div class="card" style="">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item->item_name }}</h4>
                                        </div>
                                        <div class="col-md-6 float-lg-right">
                                            <a href="{{ route('delete_stock',$item->id) }}" class="btn btn-danger">Delete Item</a>
                                            {{-- @foreach ($balance as $value)
                                                <h4 class="card-title">Stock in hand - {{ $value }}</h4>
                                            @endforeach --}}
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="height:20rem; overflow: auto;">
                                   <table class="table">
                                      <thead>
                                         <tr class="ligth">
                                            <th scope="col">Enteries <br> ({{ sizeof($stock_detail) }})</th>
                                            <th scope="col">Detail <br></th>
                                            <th scope="col">IN <br>({{ $qty_in }}) </th>
                                            <th scope="col">Out <br> ({{ $qty_out }})</th>
                                            <th scope="col">Balance <br></th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @if (sizeof($stock_detail) != 0)
                                            @forelse ($stock_detail  as $element)
                                                <tr>
                                                    <th scope="row">{{ $element->created_at }}</th>
                                                    <td>{{ $element->detail }}</td>
                                                    <td>{{ $element->qty_in }} </td>
                                                    <td>{{ $element->qty_out }}</td>
                                                    <td>{{ $element->balance }}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#qty_in{{ $item->id }}">
                                Quantity IN
                            </button>
                            <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#qty_out{{ $item_id }}">
                                Quantity OUT
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="qty_in{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Quantity In</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('qty_in') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="item_id" id="item_id" value="{{ $item->id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                  <label for="qty_in">Quantity</label>
                                                  <input type="text" name="qty_in" class="form-control" id="validationDefault01" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                  <label for="rate">Rate</label>
                                                  <input type="text" name="rate" value="{{ $item->purchase_rate }}" class="form-control" id="validationDefault02" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="detail">Detail</label>
                                                  <input type="text" name="detail" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" value="" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Bill">Bill No</label>
                                                    <input type="text" name="bill_no" class="form-control" id="validationDefault03" required>
                                                  </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="validationDefault04">Select Party</label>
                                                  <select name="party" class="form-control" id="party" required>
                                                     <option selected disabled value="">Choose...</option>
                                                        @foreach ($suppliers as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                  </select>
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
                            <div class="modal fade" id="qty_out{{ $item_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Quantity OUT</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('qty_out') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="item_id" id="item_id" value="{{ $item_id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                  <label for="qty_in">Quantity</label>
                                                  <input type="text" name="qty_out" class="form-control" id="validationDefault01" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                  <label for="rate">Rate</label>
                                                  <input type="text" name="rate" value="{{ $sale_rate }}" class="form-control" id="validationDefault02" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="detail">Detail</label>
                                                  <input type="text" name="detail" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="Bill">Bill No</label>
                                                    <input type="text" name="bill_no" class="form-control" id="validationDefault03" required>
                                                  </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="validationDefault04">Select Party</label>
                                                  <select name="party" class="form-control" id="party" required>
                                                     <option selected disabled value="">Choose...</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                  </select>
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
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Quantity In -->
    <div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_item') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="item_name">Item Name</label>
                          <input type="text" name="item_name" class="form-control" id="item_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="item_unit">Item Unit</label>
                          <input type="text" name="item_unit" class="form-control" id="validationDefault02" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="sale_rate">Rate Sale</label>
                          <input type="text" name="sale_rate" class="form-control" id="validationDefault03" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="purchase_rate">Rate Purchase</label>
                            <input type="text" name="purchase_rate" value="" class="form-control" id="validationDefault03" required>
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