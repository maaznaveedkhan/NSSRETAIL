@extends('layout.business')
@section('content')
<style type="text/css">
</style>
    <?php
		$out = $in = 0 
    ?>
	@foreach($stock_details as $stock)
		<?php
			$out += $stock->out;
			$in += $stock->in; 
		?>
	@endforeach
	<div class="container-fluid pl-0 pr-0 mr-0 ml-0">
    <div class="row">
      <div class="col-sm-3 main_div">
      	<div class="bg-light bg-gradient header-issue  p-3">
      		<div style="width: 100%;">
      			<span class="text-center">{{ count($stocks) }}</span>
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
			@if(isset($businesses_stocks))
			<?php 
				$out = $in = $balance =0;
			?>
				@foreach($businesses_stocks as $business_stock)
					<?php
						$out += $detail->out;
						$in += $detail->in;
						$balance += $detail->balance;
					?>
				@endforeach
				<div class="col given_amount float-right text-center" style="width:30%">
						@if($out > $in)
							<span>{{abs($balance - $in)}}</span>
						@endif
					<small>You Will Give</small>
				</div>
				<div class="col text-center">
						@if($balance < $in)
							<span>{{abs($balance - $in)}}</span>
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
	      		<a href="" class="btn view_report text-uppercase">Click Here to View Settings &nbsp;<i class="fa-solid fa-angle-right"></i></a>
	      	</div>
			  <div>
				<h4>Total Items - <span>{{ count($stocks) }} </span> </h4>
				<p>Stock in Hand</p>
			</div>
	      </div>

	      <!-- Search Bar -->
	      <div class="row bg-light p-2 m-0">
	      	<div class="col">
	      		<input type="text" class="form-control rounded-pill search_bar" name="search" placeholder="Search Here">
	      	</div>
	      </div>

	      <!-- Buttons Main -->
	      
	      <!--End Buttons Main -->
		<div class="profile-span mb-1">            
            <button type="button" class="btn btn-div mb-2"  data-bs-toggle="modal" data-bs-target="#add-item">
              <div class="mb-1 mt-1">
				<div class="mb-1 mt-1 profile-image-div">
					<i class="fa fa-plus-circle"> </i> 
					<span class="business-name">Add New Item</span> 
					<i class="fa fa-angle-right"></i>
				  </div>
              </div>
            </button>
      	</div>
        @forelse($stocks as $all_stock)
     		<div class="profile-span mb-1">            
				<a href="{{route('stock-page', ['id'=>$all_stock->id])}}" type="button" class="btn btn-div mb-2">
				<div class="mb-1 mt-1 profile-image-div">
					<img class="profile-image" src="{{asset('E-khata')}}/images/logo/profile.png">
					<span class="business-name">{{ $all_stock->item_name }}</span>
					<span class="business-name">{{ $all_stock->quantity }}</span>
					{{-- <span class="business-name">{{ $all_customer->name }}</span> --}}
				</div>
				</a>
      		</div>
          @empty
        @endforelse
        <div class="text-center buttons">
          <!-- Button trigger modal -->      
          <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#customer-add">
            <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add Customer</span>
          </button>
        </div>
      </div>
      <div class="col-sm-9 second-div">
      	<div class="bg-light bg-gradient header-info p-0">
      		<div class="header-profile">
      			<img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Userimage.png" width="40" class="rounded-circle" />
      			<span style="margin-left: 15px;">
      				{{-- <h3 style="margin-bottom:0rem">{{ $stock_details['item_name'] }}</h3>
      				<small>{{ $stock_details['item_unit'] }}</small> --}}
      			</span>
      		</div>
					{{-- @if(sizeof($stock) != 0)
	      		<div class="header-amount">
	      			<span class="">
	      				<h6>
	      					<span class="display-4"  style="color:
								@if($out > $in)
									red
								@elseif($out < $in)
									green
								@elseif($pay->balance == 0)
									black
	      						@endif">
	      						@if($out == $in)
	      							Rs 0
	      						@else
	      							Rs {{ abs($out - $in) }}      					
	      						@endif
	      					</span>
	      					<small>
	      						@if($pay->balance == 0)
	      						@elseif($out > $in)
	      							You Will Get
	      						@elseif($out < $in)
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
						@endif --}}
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
				{{-- @if(sizeof($in) != 0) --}}
				  <ul class="responsive-table">
				    <li class="table-header mb-2">
					
				      <div class="col">ENTRIES<br>
				      			{{-- {{ count($stock_details) }} --}}
				      	{{-- ({{sizeof($payment)}}) --}}
				      </div>
				      <div class="col">DETAIL</div>
				      <div class="col">In<br><small style="color:red">Kg</small>
						@php
							$sum_in = DB::table('businesses_stocks')->where('item_id', $id)->sum('in');
							$sum_out = DB::table('businesses_stocks')->where('item_id', $id)->sum('out');
						@endphp
						{{ $sum_in }}
					  </div>
				      <div class="col">Out<br><small style="color:green">Kg </small>
						{{ $sum_out }}	
					   </div>
				      <div class="col">BALANCE</div>
				    </li>
					@forelse($stock_details as $stock_business)
      					<a href="" data-bs-toggle="modal" data-bs-target="#id{{ $stock_business->id}}">
      						<li class="table-row">	      							
								<div class="col div-one" data-label="Entries"><small>{{ $stock_business->date }}</small></div>
								<div class="col div-one" data-label="Detail"><small>{{ $stock_business->detail }}</small></div>
								<div class="col div-two" data-label="You Give"><small>{{ $stock_business->in }}</small></div>
								<div class="col div-three" data-label="You Got"><small>{{ $stock_business->out }}</small></div>
								<div class="col div-one" data-label="Balance">
									<small>
										{{ $stock_business->balance }}
									</small>
								</div>			      					
	      					</li>
						</a>					
	      				@empty
      				@endforelse
				
				  </ul>
	      {{-- @endif --}}


      	
      	<div class="text-center buttons btn-give-got">
            <!-- Button trigger modal -->   
			<button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#in">
				<span class="m-2 text-white">In (Rs)</span>
			  </button>   
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#out">
              <span class="m-2 text-white">Out (Rs)</span>
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
<!-- Modal for new item-->
<div class="modal fade" id="add-item" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
	  <div class="modal-header">
		  <h5 class="modal-title" id="staticBackdropLabel">Add New Item</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
	  <div class="modal-body">
		  <form action="{{ route('add-item') }}" method="POST">
			@csrf()
		  <div class="mb-3">
			  <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Enter Item Name ">
		  </div>
		  <div class="mb-3">
			  <input type="text" class="form-control" name="item_unit" id="item_unit" placeholder="Enter Item Unit">              
		  </div>
		  <div class="mb-3">
			  <input type="text" class="form-control" name="sale_rate" id="sale_rate" placeholder="Rate (Sale)">              
		  </div>
		  <div class="mb-3">
			  <input type="text" class="form-control" name="purchase_rate" id="purchase_rate" placeholder="Rate (Purchase)">              
		  </div>
	  </div>
	  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary">Save</button>
	  </div>
		</form>
	  </div>
	</div>
  </div>
  <!-- Close Modal For Item -->

<!-- Modal For Quantity Form -->
    <!-- Modal -->
    <div class="modal fade" id="in" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Quantity In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body">
        <form action="{{ route('qty-in',['id'=>$id]) }}" method="POST">
        @csrf()
            <div class="row mb-3">
				<div class="col-md-4">
					<label for="quantity">Quantity</label>
					<input type="text" class="form-control" name="in" id="in" placeholder="Enter Quantity">
				</div>
				<div class="col-md-4">
					<label for="">Rate</label>
					<input type="text" class="form-control" name="purchase_rate" id="purchase_rate" placeholder="Rate (Purchase)">              
				</div>
				<div class="col-md-4">
					<label for="amount">Amount</label>
					<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">              
				</div>
			</div>
			<div class="mb-3">
				<label for="detail">Detail</label>
            	<input type="text" class="form-control" name="detail" id="detail" placeholder="detail">              
			</div>
			<div class="mb-3">
				<label for="date">Date</label>
            	<input type="date" class="form-control" name="date" id="date" placeholder="Date">              
			</div>
			<div class="mb-3">
				<label for="detail">Bill No</label>
            	<input type="text" class="form-control" name="bill" id="bill" placeholder="detail">              
			</div>
			<select name="party" id="party">
				<option value="test_supplier1">Test Supplier 1</option>
				<option value="test_supplier2">Test Supplier 2</option>
				<option value="test_supplier3">Test Supplier 3</option>
				<option value="test_supplier4">Test Supplier 4</option>
				<option value="test_supplier5">Test Supplier 5</option>
			</select>
		</div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
        </form>
        </div>
      </div>
    </div>
{{-- Quantity Out Modal Start --}}
<div class="modal fade" id="out" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
	  <div class="modal-content">
	  <div class="modal-header">
		  <h5 class="modal-title" id="staticBackdropLabel">Quantity Out</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
	  <div class="modal-body">
	  <form action="{{ route('qty-out',['id'=>$id]) }}" method="POST">
	  @csrf()
		  <div class="row mb-3">
			  <div class="col-md-4">
				  <label for="quantity">Quantity</label>
				  <input type="text" class="form-control" name="out" id="out" placeholder="Enter Quantity">
			  </div>
			  <div class="col-md-4">
				  <label for="">Rate</label>
				  <input type="text" class="form-control" name="purchase_rate" id="purchase_rate" placeholder="Rate (Sale)">              
			  </div>
			  <div class="col-md-4">
				  <label for="amount">Amount</label>
				  <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">              
			  </div>
		  </div>
		  <div class="mb-3">
			  <label for="detail">Detail</label>
			  <input type="text" class="form-control" name="detail" id="detail" placeholder="detail">              
		  </div>
		  <div class="mb-3">
			  <label for="date">Date</label>
			  <input type="date" class="form-control" name="date" id="date" placeholder="Date">              
		  </div>
		  <div class="mb-3">
			  <label for="detail">Bill No</label>
			  <input type="text" class="form-control" name="bill" id="bill" placeholder="detail">              
		  </div>
		  <select name="party" id="party">
			  <option value="test_supplier1">Test Supplier 1</option>
			  <option value="test_supplier2">Test Supplier 2</option>
			  <option value="test_supplier3">Test Supplier 3</option>
			  <option value="test_supplier4">Test Supplier 4</option>
			  <option value="test_supplier5">Test Supplier 5</option>
		  </select>
	  </div>
	  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary">Save</button>
	  </div>
	  </form>
	  </div>
	</div>
  </div>
		<!-- Modal -->
		{{-- @foreach($quantity as $quan) --}}
	
			{{-- $query = DB::table('businesses_stocks')->select('*')->where('id', '=', $quan->id)->first();  --}}
			{{-- // dd($query->given_amount); --}}
		{{-- <div class="modal fade" id="id{{$pay->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog  modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body" style="width:100%">
					<div style="width:100%">
						<div class="row">
					      	<form action="{{route('update_stock')}}" method="POST">
							@csrf()
							@method('PUT')
								<div class="col-sm-12">
								<form action="{{route('stock_out')}}" method="POST">
								@csrf()
								<div class="row">
									<div class="form-control col-md-4">
										<label for="quantity">Quantity</label>
										<input type="text" name="quantity" id="quantity" class="form-control" value="">
									</div>
									<div class="form-control col-md-4">
										<label for="quantity">Rate</label>
										<input type="text" name="quantity" id="quantity" class="form-control" value="">
									</div>
									<div class="form-control col-md-4">
										<label for="amount">Amount</label>
										<input type="text" name="amount" id="amount" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="detail">Detail</label>
										<input type="text" name="detail" id="detail" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label for="date">Date</label>
										<input type="text" name="date" id="date" class="form-control" value="">
									</div>
								</div>
								<div class="row">
									<label for="bill" class="form-control">Enter Bill</label>
									<input type="text" name="bill" id="bill" class="form-control">
								</div>
								<div class="row">
									<label for="bill" class="form-control">Party</label>
									<select name="party" id="party">
										<option value="">Test Supplier</option>
									</select>
									<input type="hidden" name="party" id="party" class="form-control" value="">
								</div>
								<div>
							</div>
					    </div>
					</div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Save changes</button>
		      </form>
		      <form method="POST" action="{{route('delete_amount')}}">
		      	@csrf()
					  @method('DELETE')
					  <input type="hidden" name="id" value="">
					  <input type="hidden" name="customer_id" value="">
		        <button type="submit" class="btn btn-danger">Delete</button>
		      </form>
		      </div>
		    </div>
		  </div>
		</div> --}}
		{{-- @endforeach --}}

		<script type="text/javascript">
			  	const calculator = {
					  displayValue: '0',
					  firstOperand: null,
					  waitingForSecondOperand: false,
					  operator: null,
					};

					function inputDigit(digit) {
					  const { displayValue, waitingForSecondOperand } = calculator;

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
					  const { firstOperand, displayValue, operator } = calculator
					  const inputValue = parseFloat(displayValue);

					  if (operator && calculator.waitingForSecondOperand)  {
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
					  const { target } = event;
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
			$(document).ready(function(){
			  $('.set_btn').css({"background-color": "red", "color":"white"});
				$(".button_main").click(function(){
			    $(this).css({"background-color": "red", "color":"white"});
			  });
			});
		</script>
@endsection

