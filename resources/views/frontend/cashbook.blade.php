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
    use App\Models\CashDetail;
@endphp
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black; height: 30rem; overflow: auto;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>Cash Book</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Cash in Hand - 1</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <button type="button" class="btn btn-block btn-primary mt-2" data-toggle="modal" data-target="#add_entry">
                        Add Cash Entery
                    </button>
                </div>
                {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> --}}
                    <ul class="nav nav-tabs" style="width: 5rem; margin-left:2rem; ">
                        @foreach ($cashes as $item)
                            <li class="{{ $item->id == 1 ? 'active' : ''  }} mt-2" style="width: 5rem; margin-left:2rem;">
                                <a class="btn btn-primary btn-block" href="#item{{ $item->id }}" data-toggle="tab">{{ $item->party }}</a>
                            </li>
                        @endforeach
                    </ul>
                {{-- </div> --}}
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($cashes as $item)
                        <div class="tab-pane {{ $item->id == 1 ? 'active' : ''  }}" id="item{{ $item->id }}" class="active">
                            @php
                                $cash_id = $item->id;
                                $sale_rate = $item->sale_rate;
                                $cash_detail = CashDetail::where('cash_id',$item->id)->get();
                                $balance = CashDetail::where('cash_id',$item->id)->orderby('id', 'DESC')->first();
                                $cash_out = $cash_detail->sum('cash_out');
                                $cash_in = $cash_detail->sum('cash_in');
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $item->date }}</h4>
                                        </div>
                                        <div class="col-md-6">
                                            {{-- @foreach ($balance as $value)
                                                <h4 class="card-title">Stock in hand - {{ $value }}</h4>
                                            @endforeach --}}

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                   <table class="table">
                                      <thead>
                                         <tr class="ligth">
                                            <th scope="col">Enteries <br> ({{ sizeof($cash_detail) }})</th>
                                            <th scope="col">Detail <br></th>
                                            <th scope="col">IN <br>({{ $cash_in }}) </th>
                                            <th scope="col">Out <br> ({{ $cash_out }})</th>
                                            <th scope="col">Balance <br></th>
                                         </tr>
                                      </thead>
                                      <tbody>
                                        @if (sizeof($cash_detail) != 0)
                                            @forelse ($cash_detail  as $element)
                                                <tr>
                                                    <th scope="row">{{ $element->created_at }}</th>
                                                    <td>{{ $element->detail }}</td>
                                                    <td>{{ $element->cash_in }} </td>
                                                    <td>{{ $element->cash_out }}</td>
                                                    <td>{{ $element->balance }}</td>
                                                </tr>
                                            @empty
                                            @endforelse
                                        @endif
                                      </tbody>
                                   </table>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#cash_in{{ $item->id }}">
                                Cash IN
                            </button>
                            <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#cash_out{{ $cash_id }}">
                                Cash OUT
                            </button>
                            <!-- Modal Quantity In -->
                            <div class="modal fade" id="cash_in{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Quantity In</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('cash_in') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="cash_id" id="cash_id" value="{{ $item->id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                  <label for="cash_in">Amount</label>
                                                  <input type="text" name="cash_in" class="form-control" id="validationDefault01" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="detail">Detail</label>
                                                  <input type="text" name="detail" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" value="" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="validationDefault04">Select Party</label>
                                                  <select name="party" class="form-control" id="party" required>
                                                     <option selected disabled value="">Choose...</option>
                                                        @foreach ($suppliers as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                               <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                         </form>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div> --}}
                                </div>
                                </div>
                            </div>
                            <!-- Modal Quantity Out-->
                            <div class="modal fade" id="cash_out{{ $cash_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Cash OUT</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('cash_out') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                                            <input type="hidden" name="cash_id" id="cash_id" value="{{ $cash_id}}">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                  <label for="qty_in">Amount</label>
                                                  <input type="text" name="cash_out" class="form-control" id="validationDefault01" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="detail">Detail</label>
                                                  <input type="text" name="detail" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" class="form-control" id="validationDefault03" required>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                  <label for="validationDefault04">Select Party</label>
                                                  <select name="party" class="form-control" id="party" required>
                                                     <option selected disabled value="">Choose...</option>
                                                        @foreach ($customers as $item)
                                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                                        @endforeach
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                               <button class="btn btn-primary" type="submit">Save</button>
                                            </div>
                                         </form>
                                    </div>
                                    {{-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div> --}}
                                </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
                {{-- <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Sugar</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="card-title">Stock in hand - 1</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <table class="table">
                          <thead>
                             <tr class="ligth">
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                             </tr>
                          </thead>
                          <tbody>
                             <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                             </tr>
                             <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                             </tr>
                             <tr>
                                <th scope="row">3</th>
                                <td>Larry</td>
                                <td>the Bird</td>
                                <td>@twitter</td>
                             </tr>
                          </tbody>
                       </table>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- Modal Quantity In -->
    <div class="modal fade" id="add_entry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_entry') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_id" id="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="item_name">Party</label>
                          <input type="text" name="party" class="form-control" id="item_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="item_unit">Date</label>
                          <input type="date" name="date" class="form-control" id="validationDefault02" required>
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
@endsection
