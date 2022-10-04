@extends('frontend.layouts.app')
@section('content')
@php
    use App\Models\BankAccount;
@endphp
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3" style="border: 2px solid black;">
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h2>Bank Accounts</h2>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <h4>Total Accounts - {{ $bank_accounts->count() }}</h4>
                </div>
                <div class="row p-2 justify-content-center" style="border-bottom: 1px solid black;">
                    <button type="button" class="btn btn-block btn-primary mt-2" data-toggle="modal" data-target="#add_bank_ac">
                        Add New Account
                    </button>
                </div>
                {{-- <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical"> --}}
                <div class="row p-2 justify-content-center">
                    <ul class="nav nav-tabs" style="width: 12rem;" id="tabMenu">
                        @foreach ($bank_accounts as $item)
                            <li class="{{ $item->account == 1 ? 'active' : ''  }} mt-2">
                                <a class="btn btn-primary btn-block" style="width: 12rem;" href="#bank_ac{{ $item->account }}" data-toggle="tab">{{ $item->account }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content">
                    @foreach ($bank_accounts as $item)
                        <div class="tab-pane {{ $item->account == 1 ? 'active' : ''  }}" id="bank_ac{{ $item->account }}" class="active">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="card-title">Account No: {{ $item->account }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php
                                        $account_detail = BankAccount::where('account',$item->account )->get();
                                    @endphp
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="table">
                                                <th scope="col">Name</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Cheque</th>
                                                <th scope="col">Cheque No</th>
                                                <th scope="col">Bank</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($account_detail  as $element)
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Cash In -->
    <div class="modal fade" id="add_bank_ac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Bank Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_bank_ac') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <input type="hidden" class="form-control" name="business_id" value="{{ $b }}">
                    <div class="form-row">
                        <div class="mb-3 col-md-12">
                            <label for="">Account No</label>
                            <input type="text" class="form-control" name="account" id="account"
                                placeholder="Enter Account No" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Detail">Bank</label>
                            <input type="text" class="form-control" name="account_holder_bank" id="account_holder_bank"
                                placeholder="Enter Bank" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Detail">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount"
                                placeholder="Enter Amount" required>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="Detail">Upload Cheque</label>
                            <input type="file" class="form-control" name="cheque_img" id="cheque_img" >
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Detail">Enter Cheque</label>
                            <input type="text" class="form-control" name="cheque_no" id="cheque_no"
                                placeholder="Enter Cheque (Optional)">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Date">Date</label>
                            <input type="date" class="form-control" name="date" id="date" placeholder="Enter Date (Optional)">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Detail">Account Holder Name</label>
                            <input type="text" class="form-control" name="account_holder_name" id="account_holder_name"
                                placeholder="Enter Account Holder Name (Optional) ">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="Detail">Account Holder Phone</label>
                            <input type="text" class="form-control" name="account_holder_phone" id="account_holder_phone"
                                placeholder="Enter Account Holder Phone (Optional) ">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.2.js" integrity="sha256-4/zUCqiq0kqxhZIyp4G0Gk+AOtCJsY1TA00k5ClsZYE=" crossorigin="anonymous"></script>

<script>    
// $.noConflict();
$(document).ready(function () {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>
@endsection
