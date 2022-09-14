@extends('layout.business')
@section('content')
    @php
        use Carbon\Carbon;
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
            <button class="tablinks" onclick="openCity(event, 'Paris')">Stock Book</button>
            <button class="tablinks" onclick="openCity(event, 'Billbook')">Bill book</button>
        </div>

        <div id="Main" class="tabcontent">
            <div class="row">
                <div class="col-sm-3 main_div">
                    <div class="background-dark header-issue  p-3">
                        <div style="width: 100%;">
                            <span class="text-center">{{ $customer['business_name'] }}</span>
                        </div>
                        <i class="fa-solid fa-building-columns"></i>
                        <div class="menu-nav">
                            <div class="dropdown-container" tabindex="-1">
                                <div class="three-dots"></div>
                                <div class="dropdowns">
                                    <div class="drop mb-2"><a href=""> Filter Customer List </a></div>
                                    <div class="drop mb-2"><a href=""> Customer List PDF </a></div>
                                    <div class="drop mb-2"><a href=""> Profile </a></div>
                                    <div class="drop mb-2"><a href=""> About Us </a></div>
                                    <div class="drop mb-2"><a href=""> Language </a></div>
                                    <div class="drop mb-2"><a href=""> Help & Support </a></div>
                                    <div class="drop mb-2"><a href=""> Cash Register </a></div>
                                    <div class="drop mb-2"><a href=""> Recyle Bin </a></div>
                                    <div class="drop mb-2"><a href=""> EasyDokan </a></div>
                                    <div class="drop mb-2"><a href=""> Logout </a></div>
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
                        <div class="col">
                            <a href="" class="button_main btn btn-outline-danger p-1">All</a>
                        </div>
                    </div>
                    <!--End Buttons Main -->
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

                        <div class="menu-nav">
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
                        </div>
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
    </div>

    <div id="Paris" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Billbook" class="tabcontent">
        <div class="row">
            <div class="col-sm-3 main_div">
                <div class="background-dark header-issue  p-3">
                    <div style="width: 100%;">
                        <span class="text-center">Bill Book</span>
                    </div>
                    {{-- <i class="fa-solid fa-building-columns"></i>
                        <div class="menu-nav">
                            <div class="dropdown-container" tabindex="-1">
                                <div class="three-dots"></div>
                                <div class="dropdowns">
                                    <div class="drop mb-2"><a href=""> Filter Customer List </a></div>
                                    <div class="drop mb-2"><a href=""> Customer List PDF </a></div>
                                    <div class="drop mb-2"><a href=""> Profile </a></div>
                                    <div class="drop mb-2"><a href=""> About Us </a></div>
                                    <div class="drop mb-2"><a href=""> Language </a></div>
                                    <div class="drop mb-2"><a href=""> Help & Support </a></div>
                                    <div class="drop mb-2"><a href=""> Cash Register </a></div>
                                    <div class="drop mb-2"><a href=""> Recyle Bin </a></div>
                                    <div class="drop mb-2"><a href=""> EasyDokan </a></div>
                                    <div class="drop mb-2"><a href=""> Logout </a></div>
                                </div>
                            </div>
                        </div> --}}
                </div>
                {{-- <div class="row amount mb-2">
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
                            <a href="{{ route('view_report', ['id' => $b]) }}" class="btn view_report text-uppercase">View Report
                                &nbsp;<i class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div> --}}
                <!-- Buttons Main -->
                <div class="row m-2 mt-3">
                    @if (!empty($bills))
                        <h3>Rs. {{ count($bills) }}</h3>
                    @endif

                    <h6>Total Sale for {{ Carbon::now()->month }}</h6>
                </div>
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

                <div class="text-center buttons">
                    <!-- Button trigger modal -->
                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                        data-bs-target="#customer-add">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add
                            Customer</span>
                    </button>
                </div>

                <div
                    class="nav flex-column nav-tabs text-center"
                    id="v-tabs-tab"
                    role="tablist"
                    aria-orientation="vertical"
                    >
                    <a
                        class="nav-link active"
                        id="v-tabs-home-tab"
                        data-mdb-toggle="tab"
                        href="#v-tabs-home"
                        role="tab"
                        aria-controls="v-tabs-home"
                        aria-selected="true"
                        >Home</a
                        >
                    <a
                        class="nav-link"
                        id="v-tabs-profile-tab"
                        data-mdb-toggle="tab"
                        href="#v-tabs-profile"
                        role="tab"
                        aria-controls="v-tabs-profile"
                        aria-selected="false"
                        >Profile</a
                        >
                    <a
                        class="nav-link"
                        id="v-tabs-messages-tab"
                        data-mdb-toggle="tab"
                        href="#v-tabs-messages"
                        role="tab"
                        aria-controls="v-tabs-messages"
                        aria-selected="false"
                        >Messages</a
                        >
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
                    <div class="menu-nav">
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
                    </div>
                </div>
               
                <!-- Tab content -->
                <div class="tab-content" id="v-tabs-tabContent">
                    <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel"
                        aria-labelledby="v-tabs-home-tab">
                        Home content
                    </div>
                    <div class="tab-pane fade" id="v-tabs-profile" role="tabpanel"
                        aria-labelledby="v-tabs-profile-tab">
                        Profile content
                    </div>
                    <div class="tab-pane fade" id="v-tabs-messages" role="tabpanel"
                        aria-labelledby="v-tabs-messages-tab">
                        Messages content
                    </div>
                </div>
                <!-- Tab content -->
                
                {{-- @if (sizeof($payment) != 0)
                            <ul class="responsive-table">
                                <li class="table-header mb-2">
                                    <div class="col">ENTRIES<br>
                                        ({{ sizeof($payment) }})
                                    </div>
                                    <div class="col">Item</div>
                                    <div class="col">Quantity<br><small style="color:red">Rs {{ $total_given_amount }}</small>
                                    </div>
                                    <div class="col">Rate<br><small style="color:green">{{ $total_got_amount }}</small>
                                    </div>
                                    <div class="col">Amount</div>
                                </li>
                                @forelse($payment as $pay)
                                    <a href="" data-bs-toggle="modal" data-bs-target="#id{{ $pay->id }} ">
                                        <li class="table-row">
                                            <div class="col div-one" data-label="Entries"><small>{{ $pay->date }}</small>
                                            </div>
                                            <div class="col div-one" data-label="Detail"><small>{{ $pay->detail }}</small></div>
                                            <div class="col div-two" data-label="You Give">
                                                <small>{{ $pay->given_amount }}</small></div>
                                            <div class="col div-three" data-label="You Got"><small>{{ $pay->got_amount }}</small>
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
                        @endif
                        <div class="text-center buttons btn-give-got">
                            <!-- Button trigger modal -->
                            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#yougave">
                                <span class="m-2 text-white">YOU GAVE (Rs)</span>
                            </button>
                            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#yougot">
                                <span class="m-2 text-white">YOU GOT (Rs)</span>
                            </button>
                        </div> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>
    {{-- Create Bill --}}
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
                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                </div>
                <div class="mb-3">
                    <label for="Date">Select party</label>
                    <select name="" id="">
                        <option value="">Select Party</option>
                        @foreach ($all_customers as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                </div>
                <div>
                    <input type="checkbox" value="cash" name="method" id=""> Cash
                    <input type="checkbox" name="method" value="credit" class="openmodal" value="">Credit
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
    {{-- <div class="row">
            <div class="col-sm-3 main_div">
                <div class="background-dark header-issue  p-3">
                    <div style="width: 100%;">
                        <span class="text-center">{{ $customer['business_name'] }}</span>
                    </div>
                    <i class="fa-solid fa-building-columns"></i>
                    <div class="menu-nav">
                        <div class="dropdown-container" tabindex="-1">
                            <div class="three-dots"></div>
                            <div class="dropdowns">
                                <div class="drop mb-2"><a href=""> Filter Customer List </a></div>
                                <div class="drop mb-2"><a href=""> Customer List PDF </a></div>
                                <div class="drop mb-2"><a href=""> Profile </a></div>
                                <div class="drop mb-2"><a href=""> About Us </a></div>
                                <div class="drop mb-2"><a href=""> Language </a></div>
                                <div class="drop mb-2"><a href=""> Help & Support </a></div>
                                <div class="drop mb-2"><a href=""> Cash Register </a></div>
                                <div class="drop mb-2"><a href=""> Recyle Bin </a></div>
                                <div class="drop mb-2"><a href=""> EasyDokan </a></div>
                                <div class="drop mb-2"><a href=""> Logout </a></div>
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
                        <a href="{{ route('view_report', ['id' => $b]) }}" class="btn view_report text-uppercase">View Report
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
                    <div class="col">
                        <a href="" class="button_main btn btn-outline-danger p-1">All</a>
                    </div>
                </div>
                <!--End Buttons Main -->
                @forelse($all_customers as $all_customer)
                    <div class="profile-span mb-1">
                        <a href="{{ route('customer', ['id' => $all_customer->id, 'business_id' => $b]) }}" type="button"
                            class="btn btn-div mb-2">
                            <div class="mb-1 mt-1 profile-image-div">
                                <img class="profile-image" src="{{ asset('E-khata') }}/images/logo/profile.png">
                                <span class="business-name">{{ $all_customer->name }}</span>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse
                <div class="text-center buttons">
                    <!-- Button trigger modal -->
                    <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal"
                        data-bs-target="#customer-add">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add Customer</span>
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

                    <div class="menu-nav">
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
                    </div>
                </div>
				@if (sizeof($payment) != 0)
					<ul class="responsive-table">
						<li class="table-header mb-2">
							<div class="col">ENTRIES<br>
								({{ sizeof($payment) }})
							</div>
							<div class="col">DETAIL</div>
							<div class="col">YOU GAVE<br><small style="color:red">Rs {{ $total_given_amount }}</small>
							</div>
							<div class="col">YOU GOT<br><small style="color:green">{{ $total_got_amount }}</small>
							</div>
							<div class="col">BALANCE</div>
						</li>
						@forelse($payment as $pay)
							<a href="" data-bs-toggle="modal" data-bs-target="#id{{ $pay->id }} ">
								<li class="table-row">
									<div class="col div-one" data-label="Entries"><small>{{ $pay->date }}</small>
									</div>
									<div class="col div-one" data-label="Detail"><small>{{ $pay->detail }}</small></div>
									<div class="col div-two" data-label="You Give">
										<small>{{ $pay->given_amount }}</small></div>
									<div class="col div-three" data-label="You Got"><small>{{ $pay->got_amount }}</small>
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
				@endif
					<div class="text-center buttons btn-give-got">
						<!-- Button trigger modal -->
						<button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#yougave">
							<span class="m-2 text-white">YOU GAVE (Rs)</span>
						</button>
						<button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#yougot">
							<span class="m-2 text-white">YOU GOT (Rs)</span>
						</button>
					</div>
            	</div>
        	</div>
    	</div> --}}
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
    <!-- Close Modal For Customer Form -->

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
        $('.openmodal').click(function() {
            if ($(this).is(':checked')) {
                $('#myModal').modal('show');
            } else {
                $('#myModal').on('hidden.bs.modal', function() {
                    console.log('not working');
                    $('.openmodal').removeAttr('checked')
                });
            }

            // });
            // $('#myModal').on('hide.bs.modal', function () { 
            //      $('.openmodal').removeAttr('checked')
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
    </script>
@endsection
