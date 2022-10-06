@extends('frontend.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\Stock;
    use App\Models\StockQuantity;
    use App\Models\InvoiceDetail;
    use App\Models\BankAccount;
@endphp
<div class="content-page">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Create Invoice</h4>
               </div>
            </div>
            <div class="card-body">
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vulputate, ex ac venenatis mollis, diam
                  nibh finibus leo</p>
                  <form action="{{ route('create_invoice') }}" method="POST">
                    @csrf()
                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                          <label for="item_name">Invoice No</label>
                          <input type="text" name="invoice_no" class="form-control" id="invoice_no" required>
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
                          <select name="supplier" class="form-control" id="party" required>
                            <option selected disabled value="">Choose...</option>
                               @foreach ($suppliers as $item)
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