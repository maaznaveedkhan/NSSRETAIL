@extends('layout/business')
@section('content')
<style type="text/css">
  .total_purchase {
    position: absolute;
    right: 6rem;
}
.yougive {
    position: absolute;
    right: 20rem;
}
</style>

@if(isset($details))
            <?php 
              $amount_purchase = $amount_payment = $amount_remaning_balance =0;
            ?>
            @foreach($details as $detail)          
              <?php
                $amount_purchase += $detail->purchase;
                $amount_payment += $detail->payment;
                $amount_remaning_balance += $detail->balance;
              ?>
            @endforeach
          @endif
    <div class="container-fluid pl-0 pr-0 mr-0 ml-0">
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
          <div class="profile-span mb-2">
          </div>
          <div class="text-center bg-light bg-gradient buttons">
            <!-- Button trigger modal -->      
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add Supplier</span>
            </button>
          </div>

          <div class="row">
            <div class="col m-2 mb-2">
              <small class="text-center">Total Purchase for <b>May</b></small><span class="text-end"><br />Rs.</span>
              <span></span>
            </div>
          </div>
          <div class="row bg-success m-0" style="width: 100%;">
            <div class="col m-0">
              <p>You will give <span class="float-right">Rs 0</span></p>
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
              <a href="{{route('business_page', ['id'=>$b])}}" class="set_btn button_main btn btn-outline-info p-1">Customers</a>
            </div>
            <div class="col">
              <a href="{{route('all_suppliers', ['business_id'=>$b])}}" class="set_btn_t button_main btn btn-outline-info p-1">Suplliers</a>
            </div>
          </div>
          <!--End Buttons Main -->

          @forelse($all_suppliers as $all_supplier)
            <div class="profile-span mb-1">            

              <a href="{{route('supplier' , ['id'=>$all_supplier->id, 'business_id'=>$b])}}" type="button" class="btn btn-div mb-2">
                <div class="mb-1 mt-1 profile-image-div">
                  <img class="profile-image" src="{{asset('E-khata')}}/images/logo/profile.png">
                  <span class="business-name">{{ $all_supplier->name }}</span>
                </div>
              </a>
            </div>
            @empty

          @endforelse
        </div>
        <div class="col-sm-9">
          <div class="bg-light bg-gradient header-info p-0">
            <div class="header-profile">
              <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Userimage.png" width="40" class="rounded-circle" />
              @if (!empty($supplier) )
                <span style="margin-left: 15px;">
                  <h3 style="margin-bottom:0rem">{{ $supplier['name'] }}</h3>
                  <small>{{ $supplier['phone_number'] }}</small>
                </span>
              @endif
            </div>
            <div class="yougive">
              <small>You Will Give<br />Rs. 0</small>
            </div>
            <div class="total_purchase">
              <small class="text-center">Total Purchase for <b>May</b></small><span class="text-end"><br />Rs. 0</span>
            </div>
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

          

          @isset($payment)
            @if(sizeof($payment) != 0)
              <ul class="responsive-table">
                <li class="table-header mb-2">
                  <div class="col">ENTRIES<br>
                    ({{sizeof($payment)}})
                  </div>
                  <div class="col">DETAIL</div>
                  <div class="col">Purchase<br><small style="color:red">Rs {{ $amount_purchase }}</small></div>
                  <div class="col">Payment<br><small style="color:green">{{ $amount_payment }}</small></div>
                  <div class="col">BALANCE</div>
                </li>

                @forelse($payment as $pay)

                      <a href="" data-bs-toggle="modal" data-bs-target="#id{{ $pay->id}} ">
                      <li class="table-row">                      
                          <div class="col div-one" data-label="Entries"><small>{{ $pay->date }}</small></div>
                          <div class="col div-one" data-label="Detail"><small>{{ $pay->detail }}</small></div>
                          <div class="col div-two" data-label="You Give"><small>{{ $pay->purchase }}</small></div>
                          <div class="col div-three" data-label="You Got"><small>{{ $pay->payment }}</small></div>
                          <div class="col div-one" data-label="Balance">
                            <small>
                              {{ $pay->balance }}
                            </small>
                          </div>                      
                      </li>      </a>         
                      @empty
                @endforelse
                
              </ul>
            @endif
          @endisset
          <div class="text-center buttons btn-give-got">
            <!-- Button trigger modal -->      
            <button class="btn m-3 mt-2 bg-success mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#purchase">
              <span class="m-2 text-white">Purchase (Rs)</span>
            </button>
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#payment" style="background-color:#d0010e">
              <span class="m-2 text-white">Payment (Rs)</span>
            </button>
          </div>
        </div>
      </div>
    </div>
      
    <!-- Modal For Business Form -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add New Supplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('add_supplier')}}" method="POST">
              @csrf()
              <div class="mb-3">
                <input type="text" class="form-control" name="name_supplier" id="name_supplier" placeholder="Enter Name ">
              </div>
               <div class="mb-3">
                <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone (Optional) ">
                <input type="hidden" class="form-control" name="business_id" value="{{$b}}">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create Supplier</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Close Modal For Business Form -->


    <div class="modal fade" id="purchase" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"><span style="color:green">Purchase From </span>{{ $supplier['name'] }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="width:100%">
            <div style="width:100%">
              <div class="row">
                <div class="col-sm-5">
                  <form action="{{route('purchase')}}" method="POST">
                    @csrf()
                    <div>
                      <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                      <input type="text" name="amount" id="amount" class="calculator-screen z-depth-1" value="">
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
                      <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{ $supplier['id'] }}">
                    </div>
                </div>
                <div class="col-sm-7">              
                  <div class="calculator card">
                    <div class="calculator-keys">

                      <button type="button" class="operator btn btn-info" value="+">+</button>
                      <button type="button" class="operator btn btn-info" value="-">-</button>
                      <button type="button" class="operator btn btn-info" value="*">&times;</button>
                      <button type="button" class="operator btn btn-info" value="/">&divide;</button>

                      <button type="button" value="7" class="btn btn-light waves-effect">7</button>
                      <button type="button" value="8" class="btn btn-light waves-effect">8</button>
                      <button type="button" value="9" class="btn btn-light waves-effect">9</button>


                      <button type="button" value="4" class="btn btn-light waves-effect">4</button>
                      <button type="button" value="5" class="btn btn-light waves-effect">5</button>
                      <button type="button" value="6" class="btn btn-light waves-effect">6</button>


                      <button type="button" value="1" class="btn btn-light waves-effect">1</button>
                      <button type="button" value="2" class="btn btn-light waves-effect">2</button>
                      <button type="button" value="3" class="btn btn-light waves-effect">3</button>


                      <button type="button" value="0" class="btn btn-light waves-effect">0</button>
                      <button type="button" class="decimal function btn btn-secondary" value=".">.</button>
                      <button type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear">AC</button>

                      <button type="button" class="equal-sign operator btn btn-default" value="=">=</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit  " class="btn btn-primary">Save</button>
                  </form>

          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="payment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel"><span style="color:red">Payment to </span>{{ $supplier['name'] }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" style="width:100%">
            <div style="width:100%">
              <div class="row">
                <div class="col-sm-5">
                  <form action="{{route('payment')}}" method="POST">
                    @csrf()
                    <div>
                      <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                      <input type="text" name="amount" id="amount" class="calculator-screen z-depth-1" value="">
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
                      <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{ $supplier['id'] }}">
                    </div>
                </div>
                <div class="col-sm-7">              
                  <div class="calculator card">
                    <div class="calculator-keys">

                      <button type="button" class="operator btn btn-info" value="+">+</button>
                      <button type="button" class="operator btn btn-info" value="-">-</button>
                      <button type="button" class="operator btn btn-info" value="*">&times;</button>
                      <button type="button" class="operator btn btn-info" value="/">&divide;</button>

                      <button type="button" value="7" class="btn btn-light waves-effect">7</button>
                      <button type="button" value="8" class="btn btn-light waves-effect">8</button>
                      <button type="button" value="9" class="btn btn-light waves-effect">9</button>


                      <button type="button" value="4" class="btn btn-light waves-effect">4</button>
                      <button type="button" value="5" class="btn btn-light waves-effect">5</button>
                      <button type="button" value="6" class="btn btn-light waves-effect">6</button>


                      <button type="button" value="1" class="btn btn-light waves-effect">1</button>
                      <button type="button" value="2" class="btn btn-light waves-effect">2</button>
                      <button type="button" value="3" class="btn btn-light waves-effect">3</button>


                      <button type="button" value="0" class="btn btn-light waves-effect">0</button>
                      <button type="button" class="decimal function btn btn-secondary" value=".">.</button>
                      <button type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear">AC</button>

                      <button type="button" class="equal-sign operator btn btn-default" value="=">=</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit  " class="btn btn-primary">Save</button>
                  </form>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    @isset($payment)
      @foreach($payment as $pay)
        <?php
          $query = DB::table('bussinesses_suppliers')->select('*')->where('id', '=', $pay->id)->first(); 
        ?>
        <div class="modal fade" id="id{{$pay->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <form action="{{route('update_payment')}}" method="POST">
                        @csrf()
                        @method('PUT')
                        <div>
                          <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                          <input type="text" name="amount" id="amount" class="calculator-screen z-depth-1" value="{{ $query->purchase != 0 ?$query->purchase:$query->payment }}">
                        </div>
                        <div>
                          <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                          <input type="text" name="detail" id="detail" class="form-control" value="{{$query->detail}}">
                        </div>
                        <div>
                          <label for="date" class="col-sm-2 col-form-label">Date</label>
                          <input type="date" name="date" id="date" class="form-control" value="{{$query->date}}">
                        </div>
                        <div>
                          <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                          <input type="text" name="bill" id="bill" class="form-control" value="{{$query->bill}}">
                          <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="{{$query->supplier_id}}">
                          <input type="hidden" name="hidden_amount" id="hidden_amount" class="calculator-screen z-depth-1" value="{{ $query->purchase != 0 ? $query->purchase:$query->balance }}">
                          <input type="hidden" name="id" id="id" class="form-control" value="{{$query->id}}">
                        </div>
                    </div>
                    <div class="col-sm-7">              
                      <div class="calculator card">
                        <!-- <input type="text" class="calculator-screen z-depth-1" value="" disabled /> -->
                        <div class="calculator-keys">

                          <button type="button" class="operator btn btn-info" value="+">+</button>
                          <button type="button" class="operator btn btn-info" value="-">-</button>
                          <button type="button" class="operator btn btn-info" value="*">&times;</button>
                          <button type="button" class="operator btn btn-info" value="/">&divide;</button>

                          <button type="button" value="7" class="btn btn-light waves-effect">7</button>
                          <button type="button" value="8" class="btn btn-light waves-effect">8</button>
                          <button type="button" value="9" class="btn btn-light waves-effect">9</button>


                          <button type="button" value="4" class="btn btn-light waves-effect">4</button>
                          <button type="button" value="5" class="btn btn-light waves-effect">5</button>
                          <button type="button" value="6" class="btn btn-light waves-effect">6</button>


                          <button type="button" value="1" class="btn btn-light waves-effect">1</button>
                          <button type="button" value="2" class="btn btn-light waves-effect">2</button>
                          <button type="button" value="3" class="btn btn-light waves-effect">3</button>


                          <button type="button" value="0" class="btn btn-light waves-effect">0</button>
                          <button type="button" class="decimal function btn btn-secondary" value=".">.</button>
                          <button type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear">AC</button>

                          <button type="button" class="equal-sign operator btn btn-default" value="=">=</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
              </form>
              <form method="POST" action="{{route('delete_payment')}}">
                @csrf()
                @method('DELETE')
                <input type="hidden" name="id" value="{{$query->id}}">
                <input type="hidden" name="supplier_id" value="{{$query->supplier_id}}">
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endisset

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
        $('.set_btn_t').css({"background-color": "#133d67", "color":"white"});       
      });
    </script>

    @endsection