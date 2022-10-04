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
                    <h2>Bil Book</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <a href="{{ route('new_bill',$b) }}">Create New Bill</a>
                </div>
                <div class="row p-2 justify-content-center">
                    <ul class="nav nav-tabs" style="width: 10rem;" id="tabMenu">
                        @foreach ($bills as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2" >
                                <a class="btn btn-primary btn-block" style="width: 10rem;" href="#item{{ $item->id }}" data-toggle="tab">Bill: {{ $item->bill_no }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($bills as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="item{{ $item->id }}" class="active">
                            @php
                                $item_id = $item->id;
                                $sale_rate = $item->sale_rate;
                                $bill_detail = BillDetail::where('bill_id',$item->id)->get();
                            @endphp
                            <div class="card" >
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">Bill No # {{ $item->bill_no }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item->party }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="height:20rem; overflow: auto;">
                                   <table class="table">
                                      <thead>
                                         <tr class="ligth">
                                            <th scope="col">Item </th>
                                            <th scope="col">Quantity </th>
                                            <th scope="col">Rate </th>
                                            <th scope="col">Amount <br></th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @if (sizeof($bill_detail) != 0)
                                            @forelse ($bill_detail  as $element)
                                                @php
                                                    $item_name = Stock::where('id',$element->item_name)->first();
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $item_name['item_name'] }}</th>
                                                    <td>{{ $element->quantity }} {{ $item_name['item_unit'] }}</td>
                                                    <td>Rs. {{ $element->rate }} </td>
                                                    <td>{{ $element->amount }}</td>
                                                    {{-- <td>{{ $element->balance }}</td> --}}
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
                                      </tbody>
                                      
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_items{{ $item_id }}">
                                Add Items
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="add_items{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Quantity In</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('add_items') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="bill_id" id="bill_id" value="{{ $item_id }}">
                                            <div class="form-row">
                                                <div class="col-md-12 mb-3">
                                                    <label for="validationDefault04">Select item</label>
                                                    <select id="myselect" name="item_id" class="form-control" id="item" required>
                                                        <option selected disabled value="">Choose...</option>
                                                        @foreach ($stocks as $stock)
                                                            <option sale_rate="{{ $stock->sale_rate }}" value="{{ $stock->id }}" >{{ $stock->item_name }}</option>
                                                        
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="rate" id="rate" value="">
                                                </div>
                                                
                                                <div class="col-md-12 mb-3">
                                                  <label for="quantity">Quantity</label>
                                                  <input type="text" name="quantity" class="form-control" id="validationDefault01" required>
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
    <!-- Modal Quantity In -->
    <div class="modal fade" id="create_new_bill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="col-md-12 mb-3">
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
                        <div class="col-md-12 mb-3">
                            <input type="checkbox" name="method" value="cash"> Cash
                            <input type="checkbox" name="method" value="credit">Credit
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
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}

<script src="https://code.jquery.com/jquery-2.2.2.js" integrity="sha256-4/zUCqiq0kqxhZIyp4G0Gk+AOtCJsY1TA00k5ClsZYE=" crossorigin="anonymous"></script>

<script>    
// $.noConflict();
$(document).ready(function () {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>
<script>
    // the selector will match all input controls of type :checkbox
    // and attach a click event handler
    $("input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
    var $box = $(this);
    if ($box.is(":checked")) {
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $box.prop("checked", true);
    } else {
        $box.prop("checked", false);
    }
    });

    $("select").on("change", function() {
        var value = $('option:selected', this).attr('value');
        var sale_rate = $('option:selected', this).attr('sale_rate');
        // var counter = $('option:selected', this).attr('sale_rate');
        var test = $("input[name=rate]:hidden").val(sale_rate);
        console.log(sale_rate);
        console.log(value);
        console.log(test);

    });
</script>
    

@endsection

{{-- <script>
    var url = document.location.toString();
    if (url.match('#')) {
        $('#tabMenu a[href=#'+url.split('#')[1]+']').tab('show') ;
    }

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });
</script> --}}