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
        <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Create Bill</h4>
               </div>
            </div>
            <div class="card-body">
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam
                  nibh finibus leo</p>
                  <form action="{{ route('create_bill') }}" method="POST">
                    @csrf()
                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                          <label for="item_name">Bill No</label>
                          <input type="text" name="bill_no" class="form-control" id="bill_no" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="detail">Detail</label>
                            <input type="text" name="detail" class="form-control" id="detail" required>
                          </div>
                        <div class="col-md-6 mb-3">
                          <label for="item_unit">Date</label>
                          <input type="date" name="date" class="form-control" id="validationDefault02" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="sale_rate">Select Party</label>
                          <select name="party" class="form-control" id="party" required>
                            <option selected disabled value="">Choose...</option>
                               @foreach ($customers as $item)
                                   <option value="{{ $item->name }}">{{ $item->name }}</option>
                               @endforeach
                         </select>
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
    <!-- Modal Quantity In -->
    {{-- <div class="modal fade" id="create_new_bill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div> --}}
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
</script>
@endsection