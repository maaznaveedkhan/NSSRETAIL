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
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black; height: 30rem; overflow: auto;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>Invoice Record</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <a href="{{ route('new_invoice',$b) }}">Create New Invoice</a>
                </div>
                <div class="row p-2 justify-content-center">
                    <ul class="nav nav-tabs" style="width: 10rem;" id="tabMenu">
                        @forelse ($invoices as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2" >
                                <a class="btn btn-primary btn-block" style="width: 10rem;" href="#item{{ $item->id }}" data-toggle="tab">Invoice: {{ $item->invoice_no }}</a>
                            </li>
                        @empty
                            <p>No Record Present</p>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($invoices as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="item{{ $item->id }}" class="active">
                            
                            <div class="card" id="pdf">
                                <div class="card-body">
                                  <div class="container mb-5 mt-3">
                                    <div class="row justify-content-between p-3" style="background-color:#50508b; color: white; ">
                                        <h6 class="" style="color: ">AL-Haj Muhammad Alam Muhammad Hussni</h6>
                                        <div class="row">
                                            <div class="col" style="color: ">
                                                <h6 class="">Prop: Haji Izzatullah</h6>
                                                <h6 class="">Prop: Habib ur Rehman</h6>
                                            </div>    
                                        </div>
                                        <div class="row">
                                            <div class="col" style="color: white;">
                                                <h6 class=""><i class="fa fa-whatsapp" style="color: white;"></i>03134000039</h6>
                                                <h6 class="">Tel#0182450576</h6>
                                            </div>    
                                        </div>
                                    </div>
                                    {{-- <div class="row d-flex align-items-baseline" style="background-color: #50508b; color: white;">
                                      <div class="col-xl-9">
                                        <p style="font-size: 20px;"><strong>AL-Haj Muhammad Alam Muhammad Hussni</strong></p>
                                      </div>
                                      
                                      </div>
                                      <hr>
                                    </div> --}}
                                    <div class="container">
                                        <div class="row pt-1" style="">
                                            <div class="col-xl-6">
                                            <ul class="list-unstyled">
                                                <li class="">From: {{ $item->supplier }}</li>
                                                <li class="">Invoice No: {{ $item->invoice_no }}</li>
                                            </ul>
                                            </div>
                                            <div class="col-xl-6">
                                                <ul class="list-unstyled">
                                                    <li class="">Date: {{ $item->date }}</li>
                                                    <li>Address: Shop # 155-156 Barrich Market, Muhammad Husni Plaza, Sarki Road, Quetta</li>
                                                </ul>
                                            </div>
                                        </div>
                                      <div class="row my-2 mx-1 justify-content-center">
                                        <table class="table table-striped table-borderless">
                                          <thead style="background-color:#50508b ;" class="text-white">
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Item</th>
                                              <th scope="col">Qty</th>
                                              <th scope="col">Unit Price</th>
                                              <th scope="col">Amount</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @php
                                                $item_id = $item->id;
                                                $sale_rate = $item->sale_rate;
                                                $invoice_detail = InvoiceDetail::where('invoice_id',$item->id)->get();
                                                $sum = 0;
                                            @endphp
                                            @if (sizeof($invoice_detail) != 0)
                                            @forelse ($invoice_detail  as $element)
                                                @php
                                                    $sum = $sum + $element->amount; 
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    @if(!empty($invoice_detail))
                                                    <td>{{ $element['item_name'] }}</td>
                                                    @endif
                                                    <td>{{ $element['quantity'] }}</td>
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
                                        <div class="row">
                                            <div class="col-xl-8">
                                            {{-- <p class="ms-3">Add additional notes and payment information</p> --}}
                                            </div>
                                            <div class="col-xl-4">
                                            <ul class="list-unstyled">
                                                <li class="text-muted ms-3"><span class="text-black me-4">SubTotal</span> {{ $sum }}</li>
                                            </ul>
                                            <p class="text-black float-start"><span class="text-black me-3"> Total Amount</span><span
                                                style="font-size: 25px;">{{ $sum }}</span></p>
                                            </div>
                                        </div>
                              
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_items{{ $item_id }}">
                                Add Items
                        </button>
                        <!-- Modal Quantity In -->
                        <div class="modal fade" id="add_items{{ $item_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('add_invoice_items') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="{{ $item_id }}">
                                        <input type="hidden" name="party" id="party" value="{{ $item->supplier }}">
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="item">Item Name</label>
                                                <input type="text" name="item_name" class="form-control" id="validationDefault01" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="item">Item Unit</label>
                                                <input type="text" name="item_unit" class="form-control" id="validationDefault01" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                              <label for="quantity">Quantity</label>
                                              <input type="text" name="quantity" class="form-control" id="validationDefault01" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="rate">Rate</label>
                                                <input type="text" name="rate" class="form-control" id="validationDefault01" required>
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
<script src= "https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js">
</script>
<script>
    function generatePDF() {
    var doc = new jsPDF();  //create jsPDF object
    doc.fromHTML(document.getElementById("pdf"), // page element which you want to print as PDF
    15,
    15, 
    {
        'width': 170  //set width
    },
    function(a) 
    {
        doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
    });
    }
</script>
{{-- <script>
    var button = document.getElementById("pdfButton{{ $item->id }}");
    button.addEventListener("click", function () {
       var doc = new jsPDF("p", "mm", [300, 300]);
       var makePDF = document.querySelector("#pdf");
       // fromHTML Method
       doc.fromHTML(makePDF);
       doc.save("output.pdf");
    });
 </script> --}}
{{-- <script>
    var button = document.getElementById("pdfButton");
    var makepdf = document.getElementById("pdf");
    button.addEventListener("click", function () {
       var mywindow = window.open("", "PRINT", "height=600,width=600");
       mywindow.document.write(makepdf.innerHTML);
       mywindow.document.close();
       mywindow.focus();
       mywindow.print();
       return true;
    });
 </script> --}}
@endsection
