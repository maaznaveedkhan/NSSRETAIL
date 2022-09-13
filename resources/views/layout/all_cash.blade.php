@extends('layout.business')
@section('content')
<div class="container-fluid pl-0 pr-0 mr-0 ml-0">
    <div class="row">
        <div class="col-sm-3 main_div">
          <span>
            <div class="text-center bg-light bg-gradient header-info p-3">Cash Book</div>
            </span>
            @forelse($all_businesses as $all_business)
            <div class="profile-span mb-1">            
                <a href="{{route('business_page' , ['id'=>$all_business->id])}}" type="button" class="btn btn-div mb-2">
                  <div class="mb-1 mt-1 profile-image-div">
                    <img class="profile-image" src="{{asset('E-khata')}}/images/logo/profile.png">
                    <span class="business-name">{{$all_business->business_name}}</span>
                  </div>
                </a>
            </div>
            @empty
            @endforelse
          <div class="text-center bg-light bg-gradient buttons">
            <!-- Button trigger modal -->      
            <button class="btn m-3 mt-2 mb-2 button-bussiness" data-bs-toggle="modal" data-bs-target="#cashmodal">
              <i class="fa fa-plus-circle" aria-hidden="true"></i><span class="m-2 text-white">Add Cash</span>
            </button>
          </div>
        </div>
        <div class="col-sm-9 second-div">
          <div class="bg-light bg-gradient header-info p-0">
            <div class="header-profile">
              <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Userimage.png" width="40" class="rounded-circle" />
              <h3>Date</h3>
            </div>
            {{-- @if(sizeof($cashes) != 0)
              <div class="header-amount">
                <span class="">
                  <h6>
                      
                    <span class="display-4"  style="color:
                        @if($cash_in > $cash_out)
                        red
                        @elseif($cash_in < $cash_out)
                          green
                        @elseif($cashes->balance == 0)
                        black
                      @endif">
                      @if($cash_in == $cash_out)
                        Rs 0
                      @else
                      Rs {{ abs($cash_out - $cash_in) }}      					
                      @endif
                    </span>
                    <small>
                      @if($pay->balance == 0)
                        
                      @elseif($cash_out > $cash_in)
                        You Will Get
                      @elseif($cash_out < $cash_in)
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
          <table class="bordered ">
            <thead>
              <th>
                Name
              </th>
              <th>
                Detail
              </th>
              <th>
                Cash In 
              </th>
              <th>
                Cash Out
              </th>
            </thead>
            <tbody>
              @foreach ($cashes as $cash)
              <tr>
                <td>{{ $cash->name }}</td>
                <td>{{ $cash->detail }}</td>
                <td>{{ $cash->cash_in }}</td>
                <td>{{ $cash->cash_out }}</td>
                <td>{{ $cash->date }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
      
    <!-- Modal For Business Form -->
    <!-- Modal -->
    <div class="modal fade" id="cashin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Cash In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="{{route('cash_in')}}" method="POST">
              @csrf()
              <div class="row">
                <div class="col-sm-5">
                  <input type="hidden" class="form-control" name="business_id" value="{{$b}}">
                  <div class="mb-3">
                    <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount">
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="detail" id="detail" placeholder="Enter Detail ">
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="bill_no" id="bill_no" placeholder="Enter Bill">
                  </div>
                  <div class="mb-3">
                    <select name="" id="">
                      <option value="">Test Supplier</option>
                    </select>
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
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Add Cash</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Close Modal For Business Form -->
    @isset($payment)
    @foreach($cashes as $cash)
      <?php
        $query = DB::table('businesses_cashes')->select('*')->where('id', '=', $cash->id)->first(); 
      ?>
      <div class="modal fade" id="id{{$cash->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Cash In</h5>
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
                        <input type="text" name="amount" id="amount" class="calculator-screen z-depth-1" value="{{ $cash->amount != 0 ?$cash->amount:$cash->amount }}">
                      </div>
                      <div>
                        <label for="detail" class="col-sm-2 col-form-label">Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" value="{{$cash->detail}}">
                      </div>
                      <div>
                        <label for="bill" class="col-sm-2 col-form-label">Bill No</label>
                        <input type="text" name="bill_no" id="bill_no" class="form-control" value="{{$cash->bill_no}}">
                      </div>
                      <div class="mb-3">
                        <select name="" id="">
                          <option value="">Test Supplier</option>
                        </select>
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
            <form method="POST" action="{{route('delete_cash')}}">
              @csrf()
              @method('DELETE')
              <input type="hidden" name="id" value="{{$cash->id}}">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    @endisset
@endsection
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