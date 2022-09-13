@extends('layout/business')
@section('content')
<style type="text/css">
	.main_dots{
		position: absolute;
	    right: 10px;
	    top: 0.9rem;
	}
</style>
	<?php
		$total_given_amount = $total_got_amount = 0 ?>
		@foreach($payment as $pay)
			<?php
				$total_given_amount += $pay->given_amount;
				$total_got_amount += $pay->got_amount; 
			?>
		@endforeach
	<div class="container-fluid pl-0 pr-0 mr-0 ml-0">
	    <div class="row">
	      	<div class="col-sm-3 main_div">
		      	<div class="bg-light bg-gradient header-issue  p-3">
		      		<div style="width: 100%;">
		      			<span class="text-center">{{$business[0]->business_name}}</span>
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
		      	<span data-href="/tasks" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">Export</span>

<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
		      	<div class="row amount mb-2">
			      	@if(isset($details))
			      	<?php 
			      		$amount_remaning_got = $amount_remaning_given = $amount_remaning_balance =0;
			      	?>
		      		@foreach($details as $detail)
		      			<?php
		      				$amount_remaning_given += $detail->given_amount;
		      				$amount_remaning_got += $detail->got_amount;
		      				$amount_remaning_balance += $detail->balance;
		      			?>
		      		@endforeach
				      	<div class="col given_amount float-right text-center" style="width:30%">
				      			@if($amount_remaning_given > $amount_remaning_got)
				      				<span>{{abs($amount_remaning_balance - $amount_remaning_got)}}</span>
				      			@endif
				      		<small>You Will Give</small>
				      	</div>
				      	<div class="col text-center">
				      			@if($amount_remaning_balance < $amount_remaning_got)
				      				<span>{{abs($amount_remaning_balance - $amount_remaning_got)}}</span>
				      			@endif
				      		<small>You Will Get</small>
				      	</div>
			      	@else
				      	<div class="col given_amount text-center">
				      			<span>0</span>
				      		<small>You Will Give</small>
				      	</div>
				      	<div class="col float-right text-center" style="width:30%">
				      			<span>0}</span>
				      		<small>You Will Get</small>
				      	</div> 
			      	@endif
				</div>

				<!-- Report View -->

			    <div class="row text-center">
			      	<div>
			      		<a href="{{route('view_report', ['id'=>$id])}}" class="btn view_report text-uppercase">View Report &nbsp;<i class="fa-solid fa-angle-right"></i></a>
			      	</div>
			    </div>

			      <!-- Search Bar -->
			    <div class="row bg-light p-2 m-0">
			      	<div class="col">
			      		<input type="text" class="form-control rounded-pill search_bar" name="search" placeholder="Search Here">
			      	</div>
			    </div>

			      <!-- Buttons Main -->
			    <div class="row m-2 mt-3">
			      	<div class="col">
			      		<a href="{{route('business_page', ['id'=>$id])}}" class="set_btn button_main btn btn-outline-danger p-1">Customers</a>
			      	</div>
			      	<div class="col">
			      		<a href="{{route('all_suppliers', ['business_id'=>$id])}}" class="button_main btn btn-outline-danger p-1">Suplliers</a>
			      	</div>
			      	<div class="col">
			      		<a href="" class="button_main btn btn-outline-danger p-1">All</a>
			      	</div>
			    </div>
			      <!--End Buttons Main -->

		        @forelse($all_customers as $all_customer)
		     		<div class="profile-span mb-1">            

			            <a href="{{route('customer' , ['id'=>$all_customer->id, 'business_id'=>$id])}}" type="button" class="btn btn-div mb-2">
			              <div class="mb-1 mt-1 profile-image-div">
			                <img class="profile-image" src="{{asset('E-khata')}}/images/logo/profile.png">
			                <span class="business-name">{{ $all_customer->name }}</span>
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
		      	<div class="bg-light bg-gradient header-info p-0 m-0">
		      		<a href="" class="btn"><div class="header-profile">
		      			<i class="fa-solid fa-chevron-left" style="font-size:25px"></i>
		      			<span style="margin-left: 15px;">
		      				<p class="fs-5" style="margin-bottom:0rem">All Transactions</p>
		      			</span>
		      		</div>
		      		</a>				
	      			<div class="menu-nav">
				        <div class="dropdown-container">
				          	<div class="three-dots main_dots"></div>
				          	<div class="dropdown">
				            	<a href="{{route('import_file')}}"><div class="drop mb-2">Customer Profile</div></a>
				            	<div class="drop mb-2"><a href="{{route('import_file')}}"> Customer Ledger </a></div>
				            	<div class="drop mb-2"><a href="{{route('import_file')}}"> Delete Customer </a></div>
                                <div class="drop mb-2"><a href="{{route('import_file')}}"> Switch to Supplier </a></div>                        
				            	<div class="drop mb-2"><a href="{{route('import_file')}}"> Import File </a></div>			            
				            	<div class="drop mb-2"><a href="{{route('import_file')}}"> Call </a></div>			            
				          	</div>
				        </div>
				    </div>
	      		</div>

	      		<div class="row mb-2">
	      			<div class="col">
	      				<select class="form-control" style="width:200px">
						  <option selected>All</option>
						  <option value="1">This Month</option>
						  <option value="2">Last Week</option>
						  <option value="3">Last Month</option>
						  <option value="3">Single Date</option>
						  <option value="3">Between Dates</option>
						</select>
	      			</div>	      			
	      		</div>

	      		@if(sizeof($payment) != 0)
				  	<table id="report_table" class="table">
					    <thead class="table-header mb-2">
					      <tr>
					      	<th>ENTRIES<br>
					      		({{sizeof($payment)}})
					      	</th>
					      	<th>DETAIL</th>
					      	<th>YOU GAVE<br><small style="color:red">Rs {{$total_given_amount}}</small></th>
					      	<th>YOU GOT<br><small style="color:green">{{$total_got_amount}}</small></th>
					      	<th>BALANCE</th>
					      </tr>
					    </thead>
					    <tbody>
					    	<?php $sum_given = $sum_got = 0 ?>
					    	@forelse($payment as $pay)

					    		<?php
					    			$sum_given += $pay->given_amount;
					    			$sum_got += $pay->got_amount;
					    		?>
	  							<tr class="table-row">	      							
		      						<td data-label="Entries"><h5>{{ $pay->name }}</h5><br/><small>{{ $pay->date }}</small></td>
		      						<td data-label="Detail"><small>{{ $pay->detail }}</small></td>
		      						<td data-label="You Give"><small>{{ $pay->given_amount }}</small></td>
		      						<td data-label="You Got"><small>{{ $pay->got_amount }}</small></td>
		      						<td data-label="Balance">
		      							<small>
			      							{{ abs($sum_given-$sum_got) }}
			      						</small>
			      					</td>			      					
	      						</tr>
		      					@empty
	      					@endforelse
	      				</tbody>
				    
				  	</table>
	      		@endif
	      	</div>
	    </div>
  	</div>

  	<!-- Modal For Customer Form -->
    <!-- Modal -->
    <div class="modal fade" id="customer-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Customer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('add_customer')}}" method="POST">
              @csrf()
              <div class="mb-3">
                <input type="text" class="form-control" name="name_customer" id="name_customer" placeholder="Enter Name ">
              </div>
               <div class="mb-3">
                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone (Optional) ">
                <input type="hidden" class="form-control" name="business_id" value="{{$id}}">
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

    <script type="text/javascript">
		$(document).ready(function(){
		  $('.set_btn').css({"background-color": "red", "color":"white"});
			$(".button_main").click(function(){
		    $(this).css({"background-color": "red", "color":"white"});
		  });
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			// alert('as');
		    $('#report_table').DataTable( {
		        dom: 'Bfrtip',
		        buttons: [
		            'csv', 'excel', 'pdf'
		        ]
		    } );
		} );
	</script>
@endsection