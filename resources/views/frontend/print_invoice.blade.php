<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NSS Retail</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.ico')}}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/backend.css?v=1.0.0')}}" >
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/remixicon/fonts/remixicon.css')}}">

    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/backend.css?v=1.0.0')}}" media="print">
    <link href="{{ asset('dashboard/assets/print.css')}}" media="print" rel="stylesheet">
</head>
@php
    use Illuminate\Support\Facades\Session;
    use Carbon\Carbon;
    use App\Models\CashBook;
    use App\Models\Stock;
    use App\Models\StockQuantity;
    use App\Models\InvoiceDetail;
    use App\Models\BankAccount;
@endphp
<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

    {{-- @include('frontend.layouts.sidebar')
    @include('frontend.layouts.topbar') --}}

    {{-- @yield('content') --}}
    <div class="container-fluid">
        <div class="" >
            <div class="" id="content">
                <div class="container mb-5 mt-3" >
                <div class="row justify-content-between p-3" style="background-color:#50508b; color: white; border:2px solid black;">
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
                <div class="container"  >
                    <div class="row pt-1" style="">
                        <div class="col-md-4">
                        <ul class="list-unstyled">
                            <li class="">From: {{ $id->supplier }}</li>
                            <li class="">Invoice No: {{ $id->invoice_no }}</li>
                        </ul>
                        </div>
                        <div class="offset-2 col-md-6">
                            <ul class="list-unstyled">
                                <li class="">Date: {{ $id->date }}</li>
                                <li>Address: Shop # 155-156 Barrich Market, Muhammad Husni Plaza, Sarki Road, Quetta</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-bordered" style="border: 2px solid black;">
                        <thead style="background-color:#50508b ; color: white;" class="text-white">
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
                                $item_id = $id->id;
                                $invoice_detail = InvoiceDetail::where('invoice_id',$id->id)->get();
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
                                    <li class="text-black "><h6>SubTotal: {{ $sum }}</h6></li>
                                    <li class="text-black font-weight-bold"><h3>Total: {{ $sum }}</h3></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
 <footer class="iq-footer">

</footer> 
<!-- Backend Bundle JavaScript -->
<script src="{{ asset('dashboard/assets/js/backend-bundle.min.js')}}"></script>

<!-- Table Treeview JavaScript -->
<script src="{{ asset('dashboard/assets/js/table-treeview.js')}}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('dashboard/assets/js/customizer.js')}}"></script>

<!-- Chart Custom JavaScript -->
<script async src="{{ asset('dashboard/assets/js/chart-custom.js')}}"></script>

<!-- app JavaScript -->
<script src="{{ asset('dashboard/assets/js/app.js')}}"></script>
{{-- <script src="https://code.jquery.com/jquery-2.2.2.js" integrity="sha256-4/zUCqiq0kqxhZIyp4G0Gk+AOtCJsY1TA00k5ClsZYE=" crossorigin="anonymous"></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> --}}
</body>

</html>