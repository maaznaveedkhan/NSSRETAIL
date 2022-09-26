@extends('layout.business')
@section('content')
<style>
</style>
@php
        use Carbon\Carbon;
        use App\Models\CashBook;
        use App\Models\Stock;
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

    <div class="container-fluid pl-0 pr-0 mr-0 ml-0">
        {{-- <h2>Vertical Tabs</h2>
		<p>Click on the buttons inside the tabbed menu:</p> --}}

        <div class="tab">
            <button class="tablinks" onclick="openCity(event, 'Main')" id="defaultOpen">Retail</button>
            <button class="tablinks" onclick="openCity(event, 'Stockbook')">Stock Book</button>
            <button class="tablinks" onclick="openCity(event, 'Billbook')">Bill book</button>
            <button class="tablinks" onclick="openCity(event, 'Cashbook')">Cash book</button>
            <button class="tablinks" onclick="openCity(event, 'Bankac')">Bank Ac</button>
        </div>
        <div id="Main" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">{{ $business['business_name'] }}</span>
                        </div>
                        <i class="fa-solid fa-building-columns"></i>
                        <div class="menu-nav">
                            <div class="dropdown-container" tabindex="-1">
                                <div class="three-dots"></div>
                                <div class="dropdowns">
                                    {{-- <div class="drop mb-2">
                                        <a href="{{ route('logout') }}">Logout</a>
                                    </div> --}}
                                    <div class="drop mb-2">
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row amount mb-2">
                        @if (isset($details))
                            <?php
                            $amount_remaning_got = $amount_remaning_given = $amount_remaning_balance = 0;
                            ?>
                            @foreach ($details as $detail)
                                <?php
                                $amount_remaning_given += $detail->given_amount;
                                $amount_remaning_got += $detail->got_amount;
                                $amount_remaning_balance += $detail->balance;
                                ?>
                            @endforeach
                            <div class="col given_amount float-right text-center" style="width:30%">
                                @if ($amount_remaning_given > $amount_remaning_got)
                                    <span>{{ abs($amount_remaning_balance - $amount_remaning_got) }}</span>
                                @endif
                                <small>You Will Give</small>
                            </div>
                            <div class="col text-center">
                                @if ($amount_remaning_balance < $amount_remaning_got)
                                    <span>{{ abs($amount_remaning_balance - $amount_remaning_got) }}</span>
                                @endif
                                <small>You Will Get</small>
                            </div>
                        @else
                            <div class="col given_amount text-center">
                                <span>0</span>
                                <small>You Will Give</small>
                            </div>
                            <div class="col float-right text-center" style="width:30%">
                                <span>0</span>
                                <small>You Will Get</small>
                            </div>
                        @endif
                    </div>
                    <!-- Report View -->
                    <div class="row text-center">
                        <div>
                            <a href="{{ route('view_report', ['id' => $b]) }}" class="btn view_report text-uppercase">View
                                Report
                                &nbsp;<i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>
                    <!-- Search Bar -->
                    <div class="row bg-light p-2 m-0">
                        <div class="col">
                            <input type="text" class="form-control rounded-pill search_bar" name="search"
                                placeholder="Search Here">
                        </div>
                    </div>
                    <!-- Buttons Main -->
                    <div class="row m-2 mt-3">
                        <div class="col">
                            <a href="{{ route('business_page', ['id' => $b]) }}"
                                class="set_btn button_main btn btn-outline-danger p-1">Customers</a>
                        </div>
                        <div class="col">
                            <a href="{{ route('all_suppliers', ['business_id' => $b]) }}"
                                class="button_main btn btn-outline-danger p-1">Suplliers</a>
                        </div>
                        {{-- <div class="col">
                            <a href="" class="button_main btn btn-outline-danger p-1">All</a>
                        </div> --}}
                    </div>
                    <!--End Buttons Main -->
                    <div style="overflow: auto; height: 20rem;">
                        @forelse($all_customers as $all_customer)
                            <div class="profile-span mb-1">
                                <a href="{{ route('customer', ['id' => $all_customer->id, 'business_id' => $b]) }}"
                                    type="button" class="btn btn-div mb-2">
                                    <div class="mb-1 mt-1 profile-image-div">
                                        <img class="profile-image" src="{{ asset('E-khata') }}/images/logo/profile.png">
                                        <span class="business-name">{{ $all_customer->name }}</span>
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="text-center buttons">
                        <!-- Button trigger modal -->
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#customer-add">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add
                                Customer</span>
                        </button>
                    </div>
                </div>
                <div class="col-sm-9 second-div">
                    <div class="bg-light bg-gradient header-info p-0">
                        <div class="header-profile">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Userimage.png" width="40"
                                class="rounded-circle" />
                            <span style="margin-left: 15px;">
                                <h3 style="margin-bottom:0rem">{{ $customer['name'] }}</h3>
                                <small>{{ $customer['phone_number'] }}</small>
                            </span>
                        </div>
                        @if (sizeof($payment) != 0)
                            <div class="header-amount">
                                <span class="">
                                    <h6>
                                        <span class="display-4"
                                            style="color:
                                          @if ($total_given_amount > $total_got_amount) red
                                          @elseif($total_given_amount < $total_got_amount)
                                              green
                                          @elseif($pay->balance == 0)
                                          black @endif">
                                            @if ($total_given_amount == $total_got_amount)
                                                Rs 0
                                            @else
                                                Rs {{ abs($total_given_amount - $total_got_amount) }}
                                            @endif
                                        </span>
                                        <small>
                                            @if ($pay->balance == 0)
                                            @elseif($total_given_amount > $total_got_amount)
                                                You Will Get
                                            @elseif($total_given_amount < $total_got_amount)
                                                You Will Give
                                            @endif
                                        </small>
                                    </h6>
                                </span>
                            </div>
                        @else
                            <div class="header-amount">
                                <span class="">
                                    <h6>
                                        <span class="display-4">
                                            Rs 0
                                        </span>
                                    </h6>
                                </span>
                            </div>
                        @endif
    
                        {{-- <div class="menu-nav">
                            <div class="dropdown-container" tabindex="-1">
                                <div class="three-dots"></div>
                                <div class="dropdown">
                                    <div class="drop mb-2"><a href=""> Customer Profile </a></div>
                                    <div class="drop mb-2"><a href=""> Customer Ledger </a></div>
                                    <div class="drop mb-2"><a href=""> Delete Customer </a></div>
                                    <div class="drop mb-2"><a href=""> Switch to Supplier </a></div>
                                    <div class="drop mb-2"><a href=""> Call </a></div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    @if (sizeof($payment) != 0)
                        <ul class="responsive-table">
                            <li class="table-header mb-2">
                                <div class="col">ENTRIES<br>
                                    ({{ sizeof($payment) }})
                                </div>
                                <div class="col">DETAIL</div>
                                <div class="col">YOU GAVE<br><small style="color:red">Rs
                                        {{ $total_given_amount }}</small>
                                </div>
                                <div class="col">YOU GOT<br><small style="color:green">{{ $total_got_amount }}</small>
                                </div>
                                <div class="col">BALANCE</div>
                            </li>
                        </ul>
                        <div style="height: 27rem; overflow: auto;">
                            <ul class="responsive-table">
                                @forelse($payment as $pay)
                                    <a href="" data-bs-toggle="modal" data-bs-target="#id{{ $pay->id }} ">
                                        <li class="table-row">
                                            <div class="col div-one" data-label="Entries"><small>{{ $pay->date }}</small>
                                            </div>
                                            <div class="col div-one" data-label="Detail"><small>{{ $pay->detail }}</small>
                                            </div>
                                            <div class="col div-two" data-label="You Give">
                                                <small>{{ $pay->given_amount }}</small>
                                            </div>
                                            <div class="col div-three" data-label="You Got">
                                                <small>{{ $pay->got_amount }}</small>
                                            </div>
                                            <div class="col div-one" data-label="Balance">
                                                <small>
                                                    {{ $pay->balance }}
                                                </small>
                                            </div>
                                        </li>
                                    </a>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    @endif
                    <div class="text-center buttons btn-give-got">
                        <!-- Button trigger modal -->
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#yougave">
                            <span class="m-2 text-white">YOU GAVE (Rs)</span>
                        </button>
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#yougot">
                            <span class="m-2 text-white">YOU GOT (Rs)</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="Stockbook" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">Stock Book</span>
                        </div>
                    </div>
                    <!-- Buttons Main -->
                    <div class="row m-2 mt-3">
                        <h3>Total Items - {{ $stock->count() }}</h3>
                    </div>
                    <!--End Buttons Main -->
                    <!-- Add new item Start -->
                    <div class="row m-2 mt-3">
                        <button class="btn background-dark" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#add_new_stock" aria-controls="add_new_stock">Add New Stock</button>
                    </div>
                    <!-- Add new item Bill End -->
                    
                    <!-- Search Bar -->
                    <div class="row bg-light p-2 m-0">
                        <div class="col">
                            <input type="text" class="form-control rounded-pill search_bar" name="search"
                                placeholder="Search Here">
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills  ms-2 me-2" role="tablist" aria-orientation="vertical">
                        <div style="overflow: auto; height: 20rem;">
                            @foreach ($stock as $item)
                                <a style="background-color: #f37111; color:black;" class="nav-link mb-2" href="#stock{{ $item->id }}" aria-controls="stock{{ $item->id }}" role="tab" aria-selected="true" data-bs-toggle="tab">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5 class="font-weight-bold">{{ $item->item_name }}</h5>
                                        </div>
                                        <div class="col-md-8">
                                            <span style="">{{ $item->created_at->format('Y-m-d')  }}</span>
                                        </div>
                                        {{-- <h5 class="font-weight-bold">{{ $item->item_name }}</h5>
                                        <span style="font-size: 0.75rem;">{{ $item->created_at }}</span> --}}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 second-div">
                    <div class="tab-content">
                        @foreach ($stock as $item)
                            <div role="tabpanel" class="tab-pane fade {{ $item->id == 1 ? 'active' : ''  }}" id="stock{{ $item->id }}">
                                {{-- <div role="tabpanel" class="tab-pane fade " id="home{{ $item->id }}"> --}}
                                    <div class="bg-light bg-gradient header-info p-0">
                                        <div class="header-profile">
                                            <span style="margin-left: 15px;">
                                                <h3 style="margin-bottom:0rem">{{ $item->item_name }}</h3>
                                            </span>
                                        </div>
                                        @php
                                            $item_id = $item->id;
                                            $stock_detail = StockQuantity::where('item_id',$item->id)->get();
                                            $balance = StockQuantity::where('item_id',$item->id)->orderby('id', 'DESC')->first();
                                            $qty_out = $stock_detail->sum('qty_out');
                                            $qty_in = $stock_detail->sum('qty_in');
                                        @endphp
                                        <div class="header-amount">
                                            <span class="">
                                                @if (!empty($balance->balance))
                                                    <h6>
                                                        Quantity in Hand - {{ $balance->balance }}
                                                    </h6>
                                                @else
                                                    <h6>
                                                        Quantity in Hand - 0
                                                    </h6>
                                                @endif
                                            </span>
                                        </div>        
                                    </div>
                                    
                                    <ul  class="responsive-table">
                                        <li class="table-header mb-2">
                                            <div class="col">ENTRIES<br>
                                                ({{ sizeof($stock_detail) }})
                                            </div>
                                            <div class="col">DETAIL</div>
                                            <div class="col">Quantity in<br><small style="color:green">
                                                 {{ $qty_in }}</small>
                                            </div>
                                            <div class="col">Quantity Out<br><small style="color:red">
                                                    {{ $qty_out }}</small>
                                            </div>                                            
                                            {{-- <div class="col">BALANCE</div> --}}
                                        </li>
                                    </ul>
                                    @if (sizeof($stock_detail) != 0)
                                        <div style="height: 27rem; overflow: auto;">
                                            <ul class="responsive-table">
                                                @forelse ($stock_detail  as $element)
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#id{{ $element->id }} ">
                                                        <li class="table-row">
                                                            <div class="col div-one" data-label="Entries"><small>{{ $element->created_at }}</small>
                                                            </div>
                                                            <div class="col div-one" data-label="Detail"><small>{{ $element->detail }}</small>
                                                            </div>
                                                            <div class="col div-three" data-label="You Got">
                                                                <small>{{ $element->qty_in }}</small>
                                                            </div>
                                                            <div class="col div-two" data-label="You Give">
                                                                <small>{{ $element->qty_out }}</small>
                                                            </div>
                                                            {{-- <div class="col div-one" data-label="Balance">
                                                                <small>
                                                                    {{ $amount_remaning_balance }}
                                                                </small>
                                                            </div> --}}
                                                        </li>
                                                    </a>
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                    @endif
                                <div class="text-center buttons btn-give-got">
                                    <!-- Button trigger modal -->
                                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                                        data-bs-target="#qty_in{{ $item->id }}">
                                        <span class="m-2 text-white">Quantity In</span>
                                    </button>
                                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                                        data-bs-target="#qty_out{{ $item_id }}">
                                        <span class="m-2 text-white">Quantity Out</span>
                                    </button>
                                </div>
                                <!-- Close Modal For Customer Form -->
                                <div class="modal fade" id="qty_in{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">
                                                    Quantity In</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="width:100%">
                                                <div style="width:100%">
                                                <form action="{{ route('qty_in') }}" method="POST">
                                                    @csrf()
                                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                                    <input type="hidden" name="item_id" id="item_id" value="{{ $item_id}}">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Quantity</label>
                                                            <input type="text" name="qty_in" id="qty_in" class="form-control"
                                                                    value="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="detail" class="col-sm-2 col-form-label">Rate</label>
                                                            <input type="text" name="rate" id="rate" class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                                            <input type="text" name="amount" id="amount" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                                        <input type="text" name="detail" id="detail" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Date</label>
                                                        <input type="date" name="date" id="date" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                            value="{{ $customer['id'] }}">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                                        <select name="party" id="">
                                                            @foreach ($suppliers as $item)
                                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="qty_out{{ $item_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">
                                                    Quantity Out</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="width:100%">
                                                <div style="width:100%">
                                                <form action="{{ route('qty_out') }}" method="POST">
                                                    @csrf()
                                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                                    <input type="hidden" name="item_id" id="item_id" value="{{ $item_id}}">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Quantity</label>
                                                            <input type="text" name="qty_out" id="qty_out" class="form-control"
                                                                    value="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="detail" class="col-sm-2 col-form-label">Rate</label>
                                                            <input type="text" name="rate" id="rate" class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                                            <input type="text" name="amount" id="amount" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                                        <input type="text" name="detail" id="detail" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Date</label>
                                                        <input type="date" name="date" id="date" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                            value="{{ $customer['id'] }}">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                                        <select name="party" id="">
                                                            @foreach ($all_customers as $item)
                                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
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
    
        <div id="Billbook" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">Bill Book</span>
                        </div>
    
                    </div>
                    <!-- Buttons Main -->
                    {{-- <div class="row m-2 mt-3">
                        @if (!empty($bills))
                            <h3>Rs. {{ count($bills) }}</h3>
                        @endif
    
                        <h6>Total Sale for {{ Carbon::now()->month }}</h6>
                    </div> --}}
                    <!--End Buttons Main -->
                    <!-- Create New Bill Start -->
                    <div class="row m-2 mt-3">
                        <button class="btn background-dark" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Create New Bill</button>
                    </div>
                    <!-- Create New Bill End -->
                    <!-- Search Bar -->
                    <div class="row bg-light p-2 m-0">
                        <div class="col">
                            <input type="text" class="form-control rounded-pill search_bar" name="search"
                                placeholder="Search Here">
                        </div>
                    </div>
                    {{-- <div class="text-center buttons">
                        <!-- Button trigger modal -->
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#customer-add">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add
                                Customer</span>
                        </button>
                    </div> --}}
                    <div class="nav flex-column nav-pills  ms-2 me-2" role="tablist" aria-orientation="vertical">
                        @foreach ($bills as $item)
                            <a style="background-color: #f37111; color:black;" class="nav-link {{ $item->id == 1 ? 'active' : '' }} mb-2" href="#bill_detail{{ $item->id }}" aria-controls="bill_detail{{$item->id}}" role="tab" aria-selected="true" data-bs-toggle="tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Bill: {{$loop->iteration}}</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <h6> {{$item->created_at}}</h6>
                                    </div>
                                    {{-- <div class="col-sm-4">
                                        <div class="" style="border-radius: 50%; width: 40px; height: 40px; background-color: white; padding-left: 0.85rem;">
                                            <h3> {{$loop->iteration}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <h5 class="font-weight-bold">Bill# {{$loop->iteration}}</h5>
                                        <span>{{$item->created_at}}</span>
                                    </div> --}}
                                    {{-- <div class="col-sm-4">
                                        <h6>Rs. {{ $item->amount }}</h6>
                                        <span style="font-size: 1rem !important;">{{$item->method}}</span>
                                    </div> --}}
                                </div>
                            </a>
                        @endforeach
                        
                        
                    </div>
                </div>
                <div class="col-sm-9 second-div">
                        {{-- <div class="bg-light bg-gradient header-info p-0">
                            <h4>Bill Detail</h4>
                        </div> --}}
                        <div class="tab-content">
                            @foreach ($bills as $item)
                            <div role="tabpanel" class="tab-pane fade {{ $item->id == 1 ? 'active' : ''  }}" id="bill_detail{{ $item->id }}">
                                {{-- <div role="tabpanel" class="tab-pane fade " id="home{{ $item->id }}"> --}}
                                    <div class="bg-light bg-gradient header-info p-0">
                                        <div class="header-profile">
                                            <span style="margin-left: 15px;">
                                                <h3 style="margin-bottom:0rem">NSS Store</h3>
                                            </span>
                                        </div>
                                        <div class="header-profile">
                                            <span style="margin-left: 15px;">
                                                <h3 style="margin-bottom:0rem">030000000</h3>
                                            </span>
                                        </div>
                                        @php
                                            $item_id = $item->id;
                                            $bill_detail = BillDetail::where('bill_id',$item->id)->get();
                                            // $balance = BillDetail::where('item_id',$item->id)->orderby('id', 'DESC')->first();
                                            // $qty_out = $stock_detail->sum('qty_out');
                                            // $qty_in = $stock_detail->sum('qty_in');
                                        @endphp
                                        {{-- <div class="header-amount">
                                            <span class="">
                                                <h6>
                                                    <span class="display-6">
                                                        030000000
                                                    </span>
                                                </h6>
                                            </span>
                                        </div>  --}}
                                    </div>
                                    {{-- <div class="bg-light bg-gradient header-info p-0">
                                        <div class="header-profile">
                                            <span style="margin-left: 15px;">
                                                <h3 style="margin-bottom:0rem">{{ $item->item_name }}</h3>
                                            </span>
                                        </div>
                                        @php
                                            $item_id = $item->id;
                                            $bill_detail = BillDetail::where('bill_id',$item->id)->get();
                                            // $balance = BillDetail::where('item_id',$item->id)->orderby('id', 'DESC')->first();
                                            // $qty_out = $stock_detail->sum('qty_out');
                                            // $qty_in = $stock_detail->sum('qty_in');
                                        @endphp
                                        <div class="header-amount">
                                            @if (!empty($balance->balance))
                                                <h6>
                                                    Quantity in Hand - {{ $balance->balance }}
                                                </h6>
                                            @else 
                                            @endif 
                                                <h6>
                                                    NSS Store
                                                </h6>
                                        </div>       
                                        <div class="header-amount">
                                            <span class="">
                                                    <h6>
                                                        0300000000
                                                    </h6>
                                                    
                                            </span>
                                        </div>   
                                    </div>--}}
                                    <div class="row p-2">
                                        <h4>{{ Carbon::today()->toDateString() }}</h4>
                                    </div>
                                    <ul  class="responsive-table">
                                        <li class="table-header mb-2">
                                            <div class="col">Item<br></div>
                                            <div class="col">Quantity</div>
                                            <div class="col">Rate</div>
                                            <div class="col">Amount</div>                                            
                                            {{-- <div class="col">BALANCE</div> --}}
                                        </li>
                                    </ul>
                                    @if (sizeof($bill_detail) != 0)
                                        <div style="height: 27rem; overflow: auto;">
                                            <ul class="responsive-table">
                                                @forelse ($bill_detail  as $element)
                                                @php
                                                    $item_name = Stock::where('id',$element->item_name)->first();
                                                @endphp
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#id{{ $element->id }} ">
                                                        <li class="table-row">
                                                            <div class="col div-one" data-label="Entries"><small>{{ $item_name['item_name'] }}</small>
                                                            </div>
                                                            <div class="col div-two" data-label="You Give">
                                                                <small>{{ $element->quantity }} {{ $item_name['item_unit'] }}</small>
                                                            </div>
                                                            <div class="col div-three" data-label="You Got">
                                                                <small>Rs. {{ $element->rate }}</small>
                                                            </div>
                                                            
                                                            <div class="col div-one" data-label="Detail"><small>Rs. {{ $element->amount }}</small>
                                                            </div>
                                                            {{-- <div class="col div-one" data-label="Balance">
                                                                <small>
                                                                    {{ $amount_remaning_balance }}
                                                                </small>
                                                            </div> --}}
                                                        </li>
                                                    </a>
                                                @empty
                                                @endforelse
                                            </ul>
                                        </div>
                                    @endif
                                <div class="justify-content-center text-center">
                                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                                        data-bs-target="#add_items{{ $item->id }}">
                                        <span class="m-2 text-white">Add Items</span>
                                    </button>
                                </div>
                                {{-- <div class="text-center buttons btn-give-got">
                                    <!-- Button trigger modal -->
                                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                                        data-bs-target="#qty_in{{ $item->id }}">
                                        <span class="m-2 text-white">Quantity In</span>
                                    </button>
                                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                                        data-bs-target="#qty_out{{ $item_id }}">
                                        <span class="m-2 text-white">Quantity Out</span>
                                    </button>
                                </div> --}}
                                <!-- Close Modal For Customer Form -->
                                <div class="modal fade" id="add_items{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">
                                                    Quantity In</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="width:100%">
                                                <div style="width:100%">
                                                <form action="{{ route('add_items') }}" method="POST">
                                                    @csrf()
                                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                                    <input type="hidden" name="bill_id" id="bill_id" value="{{ $item->id}}">
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Select Item</label>
                                                        <select name="item" id="">
                                                            @foreach ($stock as $item)
                                                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Quantity</label>
                                                            <input type="text" name="quantity" id="quantity" class="form-control"
                                                                    value="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="detail" class="col-sm-2 col-form-label">Rate</label>
                                                            <input type="text" name="rate" id="rate" class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                                            <input type="text" name="amount" id="amount" class="form-control">
                                                        </div>
                                                    </div>
                                                    {{-- <div>
                                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                                        <input type="text" name="detail" id="detail" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Date</label>
                                                        <input type="date" name="date" id="date" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                            value="{{ $customer['id'] }}">
                                                    </div> --}}
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                                        <select name="party" id="">
                                                            @foreach ($suppliers as $item)
                                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="modal fade" id="qty_out{{ $item_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">
                                                    Quantity Out</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="width:100%">
                                                <div style="width:100%">
                                                <form action="{{ route('qty_out') }}" method="POST">
                                                    @csrf()
                                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                                    <input type="hidden" name="item_id" id="item_id" value="{{ $item_id}}">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Quantity</label>
                                                            <input type="text" name="qty_out" id="qty_out" class="form-control"
                                                                    value="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="detail" class="col-sm-2 col-form-label">Rate</label>
                                                            <input type="text" name="rate" id="rate" class="form-control">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                                            <input type="text" name="amount" id="amount" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                                        <input type="text" name="detail" id="detail" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Date</label>
                                                        <input type="date" name="date" id="date" class="form-control">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                                            value="{{ $customer['id'] }}">
                                                    </div>
                                                    <div>
                                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                                        <select name="party" id="">
                                                            @foreach ($all_customers as $item)
                                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        @endforeach
                        {{-- @foreach ($bills as $item)
                            <div role="tabpanel" class="tab-pane fade {{ $item->id == 1 ? 'active' : ''  }}" id="home{{ $item->id }}">
                                <div class="row text-center">
                                    <h5>Bill # {{ $loop->iteration }}</h5>
                                </div>
                                <div class="row text-center">
                                    <h5> {{ $item->date }}</h5>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Rate</th>
                                        <th scope="col">Amount</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        @php
                                            $item_name = explode(',',$item->item);
                                            $item_quantity = explode(',',$item->quantity);
                                            $item_rate = explode(',',$item->rate);
                                        @endphp
                                        <th scope="row">
                                            @foreach ($item_name as $element)
                                                {{ $element }}<br>
                                            @endforeach
                                        </th>
                                        <td>
                                            @foreach ($item_quantity as $element)
                                                {{ $element }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($item_rate as $element)
                                                {{ $element }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            
                                        </td>
                                      </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="row"></th>
                                            <td>Total</td>
                                        <td>
                                            
                                        </td>
                                            <td>Rs. {{$item->amount}}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row float-left">
                                    <h5>Detail</h5>
                                    <p>{{$item->detail}}</p>
                                </div>
                                <div class="row text-center justify-content-center">
                                    <a href="{{ route('delete_bill',$item->id) }}" class="btn btn-outline-danger" style="width: 15rem">Delete Entry</a>
                                </div>
                                
                                </div>
                                <div class="modal fade" id="edit-bill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Add New Customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('add_customer') }}" method="POST">
                                                    @csrf()
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="name_customer" id="name_customer"
                                                            placeholder="Enter Name ">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                                                            placeholder="Enter Phone (Optional) ">
                                                        <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Create Customer</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
        <div id="Cashbook" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">Cash Book</span>
                        </div>
                    </div>
                    <!-- Buttons Main -->
                    <div class="row m-2 mt-3">
                        {{-- @if (!empty($bills))
                            <h3>Cash in Hand - {{ count($bills) }}</h3>
                        @endif --}}
                        <h3>Cash in Hand</h3>
                    </div>
                    
                    <!--End Buttons Main -->
                    <!-- Search Bar -->
                    <div class="row bg-light p-2 m-0">
                        <div class="col">
                            <input type="text" class="form-control rounded-pill search_bar" name="search"
                                placeholder="Search Here">
                        </div>
                    </div>
                    {{-- <div class="profile-span mb-1">
                            @forelse($bills as  $index => $item)
                                    <a href="#" type="button"
                                        class="btn btn-div mb-2 {{ $item->id == 1 ? 'active' : '' }}" href="#home{{ $item->id }}" aria-controls="home{{$item->id}}" role="tab" aria-selected="true" data-bs-toggle="tab">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="" style="border-radius: 50%; width: 50px; height: 50px; background-color: white; padding: 6px;">
                                                    <h3> {{$loop->iteration}}</h3>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h5 class="font-weight-bold">Bill# {{$loop->iteration}}</h5>
                                                <span style="font-size: 0.75rem !important;">{{$item->created_at}}</span>
                                            </div>
                                            <div class="col-sm-4">
                                                <h6>Rs. {{ $item->amount }}</h6>
                                                <span style="font-size: 1rem !important;">{{$item->method}}</span>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                            @endforelse
                        </div> --}}
                    {{-- <div class="row m-2 mt-3">
                        <div class="col-md-4">
                            <h6>Date</h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Daily Balance</h6>
                        </div>
                        <div class="col-md-4">
                            <h6>Balance</h6>
                        </div>
                    </div> --}}
                    <div class="nav flex-column nav-pills  ms-2 me-2" role="tablist" aria-orientation="vertical">
                        @foreach ($cash as $item)
                        <a style="background-color: #f37111; color:black;" class=" text-center p-2 nav-link {{ $item->date == 1 ? 'active' : '' }} mb-2" href="#cash{{ $item->date }}" aria-controls="cash{{$item->date}}" role="tab" aria-selected="true" data-bs-toggle="tab">
                            <h6>{{ $item->date }}</h6>
                            {{-- <div class="row ms-1 me-1">
                                <div class="col-md-4">
                                    <h6>{{ $item->date }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>Rs. 0</h6>
                                </div>
                                <div class="col-md-4">
                                    <h6>Rs. 0</h6>
                                </div>
                            </div> --}}
                        </a>
                        {{-- @endforeach --}}
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-9 second-div">
                    <div class="tab-content">
                        @foreach ($cash as $item)
                            <div role="tabpanel" class="tab-pane fade {{ $item->date == 1 ? 'active' : ''  }}" id="cash{{ $item->date }}">
                                {{-- <div role="tabpanel" class="tab-pane fade " id="home{{ $item->id }}"> --}}
                                    <div class="bg-light bg-gradient header-info p-0">
                                        <div class="header-profile">
                                            <span style="margin-left: 15px;">
                                                <h3 style="margin-bottom:0rem">{{ $item->date }}</h3>
                                            </span>
                                        </div>
                                        {{-- <div class="header-amount">
                                            <span class="">
                                                <h6>
                                                    <span class="display-6">
                                                        Today Balance - Rs 0
                                                    </span>
                                                </h6>
                                            </span>
                                        </div>  --}}
                                    </div>
                                    @php
                                        $cash_detail = CashBook::where('date',$item->date)->get();
                                        $cash_out = $cash_detail->sum('cash_out');
                                        $cash_in = $cash_detail->sum('cash_in');
                                    @endphp
                                    
                                    {{-- @if (sizeof($payment) != 0) --}}
                                        <ul class="responsive-table">
                                            <li class="table-header mb-2">
                                                <div class="col">ENTRIES<br>
                                                    ({{ sizeof($cash_detail) }})
                                                </div>
                                                <div class="col">DETAIL</div>
                                                <div class="col">Cash Out<br><small style="color:red">Rs
                                                        {{ $cash_out }}</small>
                                                </div>
                                                <div class="col">Cash in<br><small style="color:green">
                                                    Rs. {{ $cash_in }}</small>
                                                </div>
                                                {{-- <div class="col">BALANCE</div> --}}
                                            </li>
                                                @forelse ($cash_detail  as $element)
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#">
                                                        <li class="table-row">
                                                            <div class="col div-one" data-label="Entries"><small>{{ $element->date }}</small>
                                                            </div>
                                                            <div class="col div-one" data-label="Detail"><small>{{ $element->detail }}</small>
                                                            </div>
                                                            <div class="col div-two" data-label="You Give">
                                                                <small>{{ $element->cash_out }}</small>
                                                            </div>
                                                            <div class="col div-three" data-label="You Got">
                                                                <small>{{ $element->cash_in }}</small>
                                                            </div>
                                                            {{-- <div class="col div-one" data-label="Balance">
                                                                <small>
                                                                    {{ $amount_remaning_balance }}
                                                                </small>
                                                            </div> --}}
                                                        </li>
                                                    </a>
                                                @empty
                                                @endforelse
                                         
                                        </ul>
                                    {{-- @endif --}}
                                    
                                {{-- </div> --}}
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center buttons btn-give-got">
                        <!-- Button trigger modal -->
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#cash_in">
                            <span class="m-2 text-white">Cash In</span>
                        </button>
                        <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                            data-bs-target="#cash_out">
                            <span class="m-2 text-white">Cash Out</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="Bankac" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">Bank Account</span>
                        </div>
                    </div>
                    <!-- Buttons Main -->
                    <div class="row m-2 mt-3">
                        <h3>Total Accounts - {{ sizeof($bank_accounts) }}</h3>
                    </div>
                    <!--End Buttons Main -->
                    <!-- Add new item Start -->
                    <div class="row m-2 mt-3">
                        <button class="btn background-dark" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#add_new_bankac" aria-controls="add_new_bankac">Add New Account</button>
                    </div>
                    <!-- Add new item Bill End -->
                    
                    <!-- Search Bar -->
                    <div class="row bg-light p-2 m-0">
                        <div class="col">
                            <input type="text" class="form-control rounded-pill search_bar" name="search"
                                placeholder="Search Here">
                        </div>
                    </div>
                    <div class="nav flex-column nav-pills  ms-2 me-2" role="tablist" aria-orientation="vertical">
                        @foreach ($bank_accounts as $item)
                            <a style="background-color: #f37111; color:black;" class="nav-link mb-2" href="#account{{ $item->account }}" aria-controls="account{{ $item->account }}" role="tab" aria-selected="true" data-bs-toggle="tab">
                                <span style="font-size: 0.75rem;">Account No</span>
                                <h5 class="font-weight-bold">{{ $item->account }}</h5>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-9 second-div">
                    <div class="tab-content">
                        @foreach ($bank_accounts as $item)
                            <div role="tabpanel" class="tab-pane fade {{ $item->account == 1 ? 'active' : ''  }}" id="account{{ $item->account }}">
                                <div class="bg-light bg-gradient header-info p-0">
                                    <div class="header-profile">
                                        <span style="margin-left: 15px;">
                                            <h3 style="margin-bottom:0rem">Account No: {{ $item->account }}</h3>
                                        </span>
                                    </div>
                                </div>
                                @php
                                    $account_detail = BankAccount::where('account',$item->account )->get();
                                @endphp
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Cheque</th>
                                            <th scope="col">Cheque No</th>
                                            <th scope="col">Bank</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($account_detail  as $element)
                                            <tr>
                                                <td>{{ $element->account_holder_name }}</td>
                                                <td>{{ $element->amount }}</td>
                                                <td> 
                                                    <img src="{{ asset('images/cheque_images/'.$element->cheque_img) }}" alt="" class="img-fluid" height="80" width="80"> 
                                                </td>
                                                <td>{{ $element->cheque_no }}</td>
                                                <td>{{ $element->account_holder_bank }}</td>
                                                <td>{{ $element->date }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    {{-- Create Bill --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="add_new_bankac" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Add New Bank Account</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('add_bank_ac') }}" method="POST" enctype="multipart/form-data">
                @csrf()
                <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                <div class="mb-3">
                    <label for="">Account No</label>
                    <input type="text" class="form-control" name="account" id="account"
                        placeholder="Enter Account No" required>
                </div>
                <div class="mb-3">
                    <label for="Detail">Bank</label>
                    <input type="text" class="form-control" name="account_holder_bank" id="account_holder_bank"
                        placeholder="Enter Bank" required>
                </div>
                <div class="mb-3">
                    <label for="Detail">Amount</label>
                    <input type="text" class="form-control" name="amount" id="amount"
                        placeholder="Enter Amount" required>
                </div>
                <div class="mb-3">
                    <label for="Detail">Upload Cheque</label>
                    <input type="file" class="form-control" name="cheque_img" id="cheque_img" >
                </div>
                <div class="mb-3">
                    <label for="Detail">Enter Cheque</label>
                    <input type="text" class="form-control" name="cheque_no" id="cheque_no"
                        placeholder="Enter Cheque (Optional)">
                </div>
                <div class="mb-3">
                    <label for="Date">Date</label>
                    <input type="date" class="form-control" name="date" id="date" placeholder="Enter Date (Optional)">
                </div>
                <div class="mb-3">
                    <label for="Detail">Account Holder Name</label>
                    <input type="text" class="form-control" name="account_holder_name" id="account_holder_name"
                        placeholder="Enter Account Holder Name (Optional) ">
                </div>
                <div class="mb-3">
                    <label for="Detail">Account Holder Phone</label>
                    <input type="text" class="form-control" name="account_holder_phone" id="account_holder_phone"
                        placeholder="Enter Account Holder Phone (Optional) ">
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Create New Bill</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('create_bill') }}" method="POST">
                @csrf()
                <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                <div class="mb-3">
                    <label for="">Amount</label>
                    <input type="text" class="form-control" name="amount" id="amount"
                        placeholder="Enter Amount " required>
                </div>
                <div class="mb-3">
                    <label for="Detail">Detail</label>
                    <input type="text" class="form-control" name="detail" id="detail"
                        placeholder="Enter Detail (Optional) ">
                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                </div>
                <div class="mb-3">
                    <label for="Date">Date</label>
                    <input type="date" class="form-control" name="date" id="date" placeholder="Enter Date">
                </div>
                {{-- <div class="mb-3">
                    <div class="input_fields_wrap">
                        <button class="add_field_button btn btn-outline-primary">Add Items</button>
                    </div>
                </div> --}}
                {{-- <div id="items_array"></div> --}}
                <div>
                    <input type="checkbox" name="method" value="cash"> Cash
                    <input type="checkbox" name="method" value="credit">Credit
                    {{-- <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Entry to Party</h4>
                                    </div>
                                    <div class="modal-body">
                                        @forelse($suppliers as $item)
                                            <div class="profile-span mb-1">
                                                <a href="#" type="button" id="party"
                                                    class="btn btn-div mb-2">
                                                    <div class="mb-1 mt-1 profile-image-div">
                                                        <img class="profile-image" src="{{ asset('E-khata') }}/images/logo/profile.png">
                                                        <span class="business-name">{{ $item->name }}</span>
                                                    </div>
                                                </a>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="add_new_stock" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <h5 id="offcanvasRightLabel">Add New Item</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('add_item') }}" method="POST">
                @csrf()
                <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                <div class="mb-3">
                    <label for="">Item Name</label>
                    <input type="text" class="form-control" name="item_name" id="item_name"
                        placeholder="Enter Amount " required>
                </div>
                <div class="mb-3">
                    <label for="Detail">Item Unit</label>
                    <input type="text" class="form-control" name="item_unit" id="item_unit"
                        placeholder="Enter Unit" required>
                </div>
                <div class="mb-3">
                    <label for="Date">Rate (Sale)</label>
                    <input type="text" class="form-control" name="sale_rate" id="sale_rate" placeholder="Enter Purchase Rate" required>
                </div>
                <div class="mb-3">
                    <label for="Date">Rate (Purchase)</label>
                    <input type="text" class="form-control" name="purchase_rate" id="purchase_rate" placeholder="Enter Purchase Rate" required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
      </div>
    </div>

    <!-- Modal For Customer Form -->
    <!-- Modal -->
    <div class="modal fade" id="customer-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add_customer') }}" method="POST">
                        @csrf()
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name_customer" id="name_customer"
                                placeholder="Enter Name ">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                placeholder="Enter Phone (Optional) ">
                            <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="yougave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><span style="color:red">You gave to
                        </span>{{ $customer['name'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width:100%">
                    <div style="width:100%">
                        <div class="row">
                            <div class="col-sm-5">
                                <form action="{{ route('given_amount') }}" method="POST">
                                    @csrf()
                                    <div>
                                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                        <input type="text" name="amount" id="amount"
                                            class="calculator-screen z-depth-1" value="">
                                    </div>
                                    <div>
                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                        <input type="text" name="detail" id="detail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                        <input type="text" name="bill" id="bill" class="form-control">
                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                            value="{{ $customer['id'] }}">
                                    </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="calculator card">
                                    <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                    <div class="calculator-keys">

                                        <button type="button" class="operator btn btn-info" value="+">+</button>
                                        <button type="button" class="operator btn btn-info" value="-">-</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="*">&times;</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="/">&divide;</button>

                                        <button type="button" value="7"
                                            class="btn btn-light waves-effect">7</button>
                                        <button type="button" value="8"
                                            class="btn btn-light waves-effect">8</button>
                                        <button type="button" value="9"
                                            class="btn btn-light waves-effect">9</button>


                                        <button type="button" value="4"
                                            class="btn btn-light waves-effect">4</button>
                                        <button type="button" value="5"
                                            class="btn btn-light waves-effect">5</button>
                                        <button type="button" value="6"
                                            class="btn btn-light waves-effect">6</button>


                                        <button type="button" value="1"
                                            class="btn btn-light waves-effect">1</button>
                                        <button type="button" value="2"
                                            class="btn btn-light waves-effect">2</button>
                                        <button type="button" value="3"
                                            class="btn btn-light waves-effect">3</button>


                                        <button type="button" value="0"
                                            class="btn btn-light waves-effect">0</button>
                                        <button type="button" class="decimal function btn btn-secondary"
                                            value=".">.</button>
                                        <button type="button" class="all-clear function btn btn-danger btn-sm"
                                            value="all-clear">AC</button>

                                        <button type="button" class="equal-sign operator btn btn-default"
                                            value="=">=</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit	" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="yougot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><span style="color:red">You got from
                        </span>{{ $customer['name'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width:100%">
                    <div style="width:100%">
                        <div class="row">
                            <div class="col-sm-5">
                                <form action="{{ route('got_amount') }}" method="POST">
                                    @csrf()
                                    <div>
                                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                        <input type="text" name="amount" id="amount"
                                            class="calculator-screen z-depth-1" value="">
                                    </div>
                                    <div>
                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                        <input type="text" name="detail" id="detail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                        <input type="text" name="bill" id="bill" class="form-control">
                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                            value="{{ $customer['id'] }}">
                                    </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="calculator card">
                                    <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                    <div class="calculator-keys">

                                        <button type="button" class="operator btn btn-info" value="+">+</button>
                                        <button type="button" class="operator btn btn-info" value="-">-</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="*">&times;</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="/">&divide;</button>

                                        <button type="button" value="7"
                                            class="btn btn-light waves-effect">7</button>
                                        <button type="button" value="8"
                                            class="btn btn-light waves-effect">8</button>
                                        <button type="button" value="9"
                                            class="btn btn-light waves-effect">9</button>


                                        <button type="button" value="4"
                                            class="btn btn-light waves-effect">4</button>
                                        <button type="button" value="5"
                                            class="btn btn-light waves-effect">5</button>
                                        <button type="button" value="6"
                                            class="btn btn-light waves-effect">6</button>


                                        <button type="button" value="1"
                                            class="btn btn-light waves-effect">1</button>
                                        <button type="button" value="2"
                                            class="btn btn-light waves-effect">2</button>
                                        <button type="button" value="3"
                                            class="btn btn-light waves-effect">3</button>


                                        <button type="button" value="0"
                                            class="btn btn-light waves-effect">0</button>
                                        <button type="button" class="decimal function btn btn-secondary"
                                            value=".">.</button>
                                        <button type="button" class="all-clear function btn btn-danger btn-sm"
                                            value="all-clear">AC</button>

                                        <button type="button" class="equal-sign operator btn btn-default"
                                            value="=">=</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit	" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cash_in" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Cash In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width:100%">
                    <div style="width:100%">
                        {{-- <div class="row"> --}}
                                <form action="{{ route('cash_in') }}" method="POST">
                                    @csrf()
                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                    <div>
                                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                             value="">
                                    </div>
                                    <div>
                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                        <input type="text" name="detail" id="detail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                            value="{{ $customer['id'] }}">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                        <select name="party" id="">
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                            {{-- <div class="col-sm-7">
                                <div class="calculator card">
                                    <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                    <div class="calculator-keys">

                                        <button type="button" class="operator btn btn-info" value="+">+</button>
                                        <button type="button" class="operator btn btn-info" value="-">-</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="*">&times;</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="/">&divide;</button>

                                        <button type="button" value="7"
                                            class="btn btn-light waves-effect">7</button>
                                        <button type="button" value="8"
                                            class="btn btn-light waves-effect">8</button>
                                        <button type="button" value="9"
                                            class="btn btn-light waves-effect">9</button>


                                        <button type="button" value="4"
                                            class="btn btn-light waves-effect">4</button>
                                        <button type="button" value="5"
                                            class="btn btn-light waves-effect">5</button>
                                        <button type="button" value="6"
                                            class="btn btn-light waves-effect">6</button>


                                        <button type="button" value="1"
                                            class="btn btn-light waves-effect">1</button>
                                        <button type="button" value="2"
                                            class="btn btn-light waves-effect">2</button>
                                        <button type="button" value="3"
                                            class="btn btn-light waves-effect">3</button>


                                        <button type="button" value="0"
                                            class="btn btn-light waves-effect">0</button>
                                        <button type="button" class="decimal function btn btn-secondary"
                                            value=".">.</button>
                                        <button type="button" class="all-clear function btn btn-danger btn-sm"
                                            value="all-clear">AC</button>

                                        <button type="button" class="equal-sign operator btn btn-default"
                                            value="=">=</button>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit	" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cash_out" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Cash Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width:100%">
                    <div style="width:100%">
                        {{-- <div class="row"> --}}
                                <form action="{{ route('cash_out') }}" method="POST">
                                    @csrf()
                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                    <div>
                                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                            value="">
                                    </div>
                                    <div>
                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                        <input type="text" name="detail" id="detail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                            value="{{ $customer['id'] }}">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                        <select name="party" id="">
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                            {{-- <div class="col-sm-7">
                                <div class="calculator card">
                                    <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                    <div class="calculator-keys">

                                        <button type="button" class="operator btn btn-info" value="+">+</button>
                                        <button type="button" class="operator btn btn-info" value="-">-</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="*">&times;</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="/">&divide;</button>

                                        <button type="button" value="7"
                                            class="btn btn-light waves-effect">7</button>
                                        <button type="button" value="8"
                                            class="btn btn-light waves-effect">8</button>
                                        <button type="button" value="9"
                                            class="btn btn-light waves-effect">9</button>


                                        <button type="button" value="4"
                                            class="btn btn-light waves-effect">4</button>
                                        <button type="button" value="5"
                                            class="btn btn-light waves-effect">5</button>
                                        <button type="button" value="6"
                                            class="btn btn-light waves-effect">6</button>


                                        <button type="button" value="1"
                                            class="btn btn-light waves-effect">1</button>
                                        <button type="button" value="2"
                                            class="btn btn-light waves-effect">2</button>
                                        <button type="button" value="3"
                                            class="btn btn-light waves-effect">3</button>


                                        <button type="button" value="0"
                                            class="btn btn-light waves-effect">0</button>
                                        <button type="button" class="decimal function btn btn-secondary"
                                            value=".">.</button>
                                        <button type="button" class="all-clear function btn btn-danger btn-sm"
                                            value="all-clear">AC</button>

                                        <button type="button" class="equal-sign operator btn btn-default"
                                            value="=">=</button>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit	" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_items" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        Cash Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="width:100%">
                    <div style="width:100%">
                        {{-- <div class="row"> --}}
                                <form action="{{ route('cash_out') }}" method="POST">
                                    @csrf()
                                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                    <div>
                                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                            value="">
                                    </div>
                                    <div>
                                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                        <input type="text" name="detail" id="detail" class="form-control">
                                    </div>
                                    <div>
                                        <label for="date" class="col-sm-2 col-form-label">Date</label>
                                        <input type="date" name="date" id="date" class="form-control">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                        <input type="text" name="bill_no" id="bill" class="form-control">
                                        <input type="hidden" name="customer_id" id="customer_id" class="form-control"
                                            value="{{ $customer['id'] }}">
                                    </div>
                                    <div>
                                        <label for="bill" class="col-sm-2 col-form-label">Select Party</label>
                                        <select name="party" id="">
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                            {{-- <div class="col-sm-7">
                                <div class="calculator card">
                                    <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                    <div class="calculator-keys">

                                        <button type="button" class="operator btn btn-info" value="+">+</button>
                                        <button type="button" class="operator btn btn-info" value="-">-</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="*">&times;</button>
                                        <button type="button" class="operator btn btn-info"
                                            value="/">&divide;</button>

                                        <button type="button" value="7"
                                            class="btn btn-light waves-effect">7</button>
                                        <button type="button" value="8"
                                            class="btn btn-light waves-effect">8</button>
                                        <button type="button" value="9"
                                            class="btn btn-light waves-effect">9</button>


                                        <button type="button" value="4"
                                            class="btn btn-light waves-effect">4</button>
                                        <button type="button" value="5"
                                            class="btn btn-light waves-effect">5</button>
                                        <button type="button" value="6"
                                            class="btn btn-light waves-effect">6</button>


                                        <button type="button" value="1"
                                            class="btn btn-light waves-effect">1</button>
                                        <button type="button" value="2"
                                            class="btn btn-light waves-effect">2</button>
                                        <button type="button" value="3"
                                            class="btn btn-light waves-effect">3</button>


                                        <button type="button" value="0"
                                            class="btn btn-light waves-effect">0</button>
                                        <button type="button" class="decimal function btn btn-secondary"
                                            value=".">.</button>
                                        <button type="button" class="all-clear function btn btn-danger btn-sm"
                                            value="all-clear">AC</button>

                                        <button type="button" class="equal-sign operator btn btn-default"
                                            value="=">=</button>
                                    </div>
                                </div>
                            </div> --}}
                        {{-- </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit	" class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
        
    <!-- Modal -->
    @foreach ($payment as $pay)
        <?php
        $query = DB::table('bussinesses_customers')
            ->select('*')
            ->where('id', '=', $pay->id)
            ->first();
        // dd($query->given_amount);
        ?>
        <div class="modal fade" id="id{{ $pay->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="width:100%">
                        <div style="width:100%">
                            <div class="row">
                                <div class="col-sm-5">
                                    <form action="{{ route('update_amount') }}" method="POST">
                                        @csrf()
                                        @method('PUT')
                                        <div>
                                            <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                                            <input type="text" name="amount" id="amount"
                                                class="calculator-screen z-depth-1"
                                                value="{{ $query->given_amount != 0 ? $query->given_amount : $query->got_amount }}">
                                        </div>
                                        <div>
                                            <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                                            <input type="text" name="detail" id="detail" class="form-control"
                                                value="{{ $query->detail }}">
                                        </div>
                                        <div>
                                            <label for="date" class="col-sm-2 col-form-label">Date</label>
                                            <input type="date" name="date" id="date" class="form-control"
                                                value="{{ $query->date }}">
                                        </div>
                                        <div>
                                            <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                                            <input type="text" name="bill" id="bill" class="form-control"
                                                value="{{ $query->bill }}">
                                            <input type="hidden" name="customer_id" id="customer_id"
                                                class="form-control" value="{{ $query->customer_id }}">
                                            <input type="hidden" name="hidden_amount" id="hidden_amount"
                                                class="calculator-screen z-depth-1"
                                                value="{{ $query->given_amount != 0 ? $query->given_amount : $query->got_amount }}">
                                            <input type="hidden" name="id" id="id" class="form-control"
                                                value="{{ $query->id }}">
                                        </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="calculator card">
                                        <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                                        <div class="calculator-keys">

                                            <button type="button" class="operator btn btn-info"
                                                value="+">+</button>
                                            <button type="button" class="operator btn btn-info"
                                                value="-">-</button>
                                            <button type="button" class="operator btn btn-info"
                                                value="*">&times;</button>
                                            <button type="button" class="operator btn btn-info"
                                                value="/">&divide;</button>

                                            <button type="button" value="7"
                                                class="btn btn-light waves-effect">7</button>
                                            <button type="button" value="8"
                                                class="btn btn-light waves-effect">8</button>
                                            <button type="button" value="9"
                                                class="btn btn-light waves-effect">9</button>


                                            <button type="button" value="4"
                                                class="btn btn-light waves-effect">4</button>
                                            <button type="button" value="5"
                                                class="btn btn-light waves-effect">5</button>
                                            <button type="button" value="6"
                                                class="btn btn-light waves-effect">6</button>


                                            <button type="button" value="1"
                                                class="btn btn-light waves-effect">1</button>
                                            <button type="button" value="2"
                                                class="btn btn-light waves-effect">2</button>
                                            <button type="button" value="3"
                                                class="btn btn-light waves-effect">3</button>


                                            <button type="button" value="0"
                                                class="btn btn-light waves-effect">0</button>
                                            <button type="button" class="decimal function btn btn-secondary"
                                                value=".">.</button>
                                            <button type="button" class="all-clear function btn btn-danger btn-sm"
                                                value="all-clear">AC</button>

                                            <button type="button" class="equal-sign operator btn btn-default"
                                                value="=">=</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                        <form method="POST" action="{{ route('delete_amount') }}">
                            @csrf()
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $query->id }}">
                            <input type="hidden" name="customer_id" value="{{ $query->customer_id }}">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script type="text/javascript">
        const calculator = {
            displayValue: '0',
            firstOperand: null,
            waitingForSecondOperand: false,
            operator: null,
        };

        function inputDigit(digit) {
            const {
                displayValue,
                waitingForSecondOperand
            } = calculator;

            if (waitingForSecondOperand === true) {
                calculator.displayValue = digit;
                calculator.waitingForSecondOperand = false;
            } else {
                calculator.displayValue = displayValue === '0' ? digit : displayValue + digit;
            }
        }

        function inputDecimal(dot) {
            // If the `displayValue` does not contain a decimal point
            if (!calculator.displayValue.includes(dot)) {
                // Append the decimal point
                calculator.displayValue += dot;
            }
        }

        function handleOperator(nextOperator) {
            const {
                firstOperand,
                displayValue,
                operator
            } = calculator
            const inputValue = parseFloat(displayValue);

            if (operator && calculator.waitingForSecondOperand) {
                calculator.operator = nextOperator;
                return;
            }

            if (firstOperand == null) {
                calculator.firstOperand = inputValue;
            } else if (operator) {
                const currentValue = firstOperand || 0;
                const result = performCalculation[operator](currentValue, inputValue);

                calculator.displayValue = String(result);
                calculator.firstOperand = result;
            }

            calculator.waitingForSecondOperand = true;
            calculator.operator = nextOperator;
        }

        const performCalculation = {
            '/': (firstOperand, secondOperand) => firstOperand / secondOperand,

            '*': (firstOperand, secondOperand) => firstOperand * secondOperand,

            '+': (firstOperand, secondOperand) => firstOperand + secondOperand,

            '-': (firstOperand, secondOperand) => firstOperand - secondOperand,

            '=': (firstOperand, secondOperand) => secondOperand
        };

        function resetCalculator() {
            calculator.displayValue = '0';
            calculator.firstOperand = null;
            calculator.waitingForSecondOperand = false;
            calculator.operator = null;
        }

        function updateDisplay() {
            const display = document.querySelector('.calculator-screen');
            display.value = calculator.displayValue;
        }

        updateDisplay();

        const keys = document.querySelector('.calculator-keys');
        keys.addEventListener('click', (event) => {
            const {
                target
            } = event;
            if (!target.matches('button')) {
                return;
            }

            if (target.classList.contains('operator')) {
                handleOperator(target.value);
                updateDisplay();
                return;
            }

            if (target.classList.contains('decimal')) {
                inputDecimal(target.value);
                updateDisplay();
                return;
            }

            if (target.classList.contains('all-clear')) {
                resetCalculator();
                updateDisplay();
                return;
            }

            inputDigit(target.value);
            updateDisplay();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.set_btn').css({
                "background-color": "red",
                "color": "white"
            });
            $(".button_main").click(function() {
                $(this).css({
                    "background-color": "red",
                    "color": "white"
                });
            });
        });
    </script>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
    <script>
        $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var items_array = 0;
        
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $('#items_array').append(`<div class="row">
                                        <a href="#" class="remove_field">Remove</a>
                                        <div class="col-md-4">
                                            <label for="Itemname">Item </label>
                                            <input type="text" class="form-control" name="item_name[]" placeholder="Enter Quantity">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Itemquantity">Quantity</label>
                                            <input type="text" class="form-control" name="item_quantity[]">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Itemrate">Rate</label>
                                            <input type="text" class="form-control" name="item_rate[]">
                                        </div>
                                    </div>`); //add input box
                // $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        });
        
        $('#items_array').on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
    </script>
    <script type="text/javascript">
    function reply_click(clicked_id)
    {   
        var id = clicked_id;
        $("#showme" + id).toggle();
        alert(clicked_id);
    }
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
    </script>
    {{-- <script>
        $('.openmodal').click(function() {
            if ($(this).is(':checked')) {
                $('#myModal').modal('show');
            } else {
                $('#myModal').on('hidden.bs.modal', function() {
                    console.log('not working');
                    $('.openmodal').removeAttr('checked')
                });
            }
        });
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
    </script> --}}
    {{-- <script type="text/javascript">
        $(function() {
            var counter = document.getElementById('counter').value;
            counter = parseInt(counter);
            // alert(typeof(counter));
            // var counter = document.getElementById('counter').value;
                for(i=0; i<counter; i++){
                    $(`#trigger${i}`).change(function() {
                    $(`#showthis${i}`).show();
                    // alert('checked');
                })
            }
        });
    </script> --}}
@endsection
