@extends('layouts.home')
@section('title', 'Dashboard')
@section('bodyClass', 'inner dashboard')
@section('search')
    @include('parts.search')
@endsection
@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h1 class="text-uppercase text-primary m-0 text-left">gighunter dashboard</h1>
                </div>
                <div class="col-6">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">@lang('home.title')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('home.menu_my_dashboard')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <section class="container">
        <div class="row">
            <div class="col-md-4">
                @include('supplier.parts.sidecard')
            </div>
            <div class="col-md-8">
                @include('supplier.parts.nav')
                <div class="tab-content" id="dashboardTabsContent">
                    <div class="tab-pane fade show active py-4" id="myBank" role="tabpanel">
                        <p class="lato-bold text-capitalize mb-3 h4">@lang('general.dashboard_nav_bank_info')</p>
                        @if($userdata->has_transaction)
                            <h3>You cannot change your payment method while you have transaction</h3>
                    @endif
                    <!--
                            new Design from ashraf
                        =============================
                        -->
                        <div class="item refund_item">
                            <!-- refund triger -->
                            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList"
                                 data-target="#bank-1" aria-expanded="true">
                                <div class="item-info-collapsed row refund_item_collapsed">
                                    @if($userdata->cashout=="0")
                                        <div class="col-2 text-right">
                                            <p class="py-2 px-1 border border-secondary  rounded font-weight-bold text-uppercase text-center"
                                               style="border-width: 2px !important;">@lang('general.selected')</p>
                                        </div>
                                    @endif
                                    <div class="col-6 d-flex align-items-center justify-content-start">
                                        <h2 class="text-black text-capitalize font-weight-bold m-0 mr-3">@lang('general.method.fawry')</h2>
                                        <img src="{{asset('images/fawry.png')}}" height="30px" alt="fawry logo">
                                    </div>
                                    @if($userdata->cashout=="1")
                                        <div class="col-5 text-right">
                                            @if(!$userdata->has_transaction)
                                                <a href="{{route('cashout',['type'=>'fawry'])}}"
                                                   class="btn btn-outline-primary rounded text-uppercase py-2 px-3">@lang('general.select_as_my_earning_method')</a>
                                            @endif

                                        </div>
                                    @endif
                                    <div class="col-1 text-right">
                                        <i class="icon-angle-down mr-2 d-inline-block"></i>
                                    </div>
                                </div>
                                <div class="item-info row refund_item_info">
                                    <div class="col-6 d-flex align-items-center justify-content-start">
                                        <h2 class="text-black text-capitalize font-weight-bold m-0 mr-3">@lang('general.cash_though_fawry')</h2>
                                        <img src="{{asset('images/fawry.png')}}" height="30px" alt="fawry logo">
                                    </div>
                                    @if($userdata->cashout=="1")
                                        <div class="col-5 text-right">
                                            @if(!$userdata->has_transaction)
                                                <a href="{{route('cashout',['type'=>'fawry'])}}"
                                                   class="btn btn-outline-primary rounded text-uppercase py-2 px-3">@lang('general.select_as_my_earning_method')</a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-1">
                                        <i class="icon-angle-down m-0 d-inline-block"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- refund triger end -->
                            <!-- refund content -->
                            <div id="bank-1" class="item-content collapse pt-4 refund_item_content" role="tabpanel">
                                <div class="container">
                                    <div class="row flex-column">
                                        @if($userdata->cashout=="0")
                                            <div class="col-2 text-right">
                                                <p class="py-2 px-1 border border-secondary  rounded font-weight-bold text-uppercase text-center"
                                                   style="border-width: 2px !important;">@lang('general.selected')</p>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                                Minus vitae eaque nobis ab dolore ipsum, fugiat quas maxime labore quo
                                                quaerat voluptatibus dolorem recusandae nesciunt, suscipit qui error
                                                quia ipsam?</p>
                                        </div>
                                        <div class="col-12">
                                            <p class="font-weight-bold h5 mt-3">flexi fees:</p>
                                            <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                            <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item refund_item">

                            <!-- refund triger -->
                            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#ordersList"
                                 data-target="#bank-2" aria-expanded="true">
                                <div class="item-info-collapsed row refund_item_collapsed">
                                    @if($userdata->cashout=="1")
                                        <div class="col-2 text-right">
                                            <p class="py-2 px-1 border border-secondary  rounded font-weight-bold text-uppercase text-center"
                                               style="border-width: 2px !important;">@lang('general.selected')</p>
                                        </div>
                                    @endif
                                    <div class="col-6 d-flex align-items-center justify-content-start">
                                        <h2 class="text-black text-capitalize font-weight-bold m-0 mr-3">@lang('general.method.bank')</h2>
                                        <img src="{{asset('images/fawry.png')}}" height="30px" alt="fawry logo">
                                    </div>
                                    @if($userdata->cashout=="0")
                                        <div class="col-5 text-right">
                                            @if(!$userdata->has_transaction)
                                                <a href="{{route('cashout',['type'=>'bank'])}}"
                                                   class="btn btn-outline-primary rounded text-uppercase py-2 px-3">@lang('general.select_as_my_earning_method')</a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-1 text-right">
                                        <i class="icon-angle-down mr-2 d-inline-block"></i>
                                    </div>
                                </div>
                                <div class="item-info row refund_item_info">
                                    <div class="col-6 d-flex align-items-center justify-content-start">
                                        <h2 class="text-black text-capitalize font-weight-bold m-0 mr-3">@lang('general.method.bank')</h2>
                                        <img src="{{asset('images/fawry.png')}}" height="30px" alt="fawry logo">
                                    </div>
                                    @if($userdata->cashout=="0")
                                        <div class="col-5 text-right">
                                            @if(!$userdata->has_transaction)
                                                <a href="{{route('cashout',['type'=>'bank'])}}"
                                                   class="btn btn-outline-primary rounded text-uppercase py-2 px-3">@lang('general.select_as_my_earning_method')</a>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-1">
                                        <i class="icon-angle-down m-0 d-inline-block"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- refund triger end -->
                            <!-- refund content -->
                            <div id="bank-2" class="item-content collapse pt-4 refund_item_content" role="tabpanel">
                                <div class="container">
                                    <div class="row flex-column">
                                        @if($userdata->cashout=="1")
                                            <div class="col-2 text-right">
                                                <p class="py-2 px-1 border border-secondary  rounded font-weight-bold text-uppercase text-center"
                                                   style="border-width: 2px !important;">@lang('general.selected')</p>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <p class="m-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                                Minus vitae eaque nobis ab dolore ipsum, fugiat quas maxime labore quo
                                                quaerat voluptatibus dolorem recusandae nesciunt, suscipit qui error
                                                quia ipsam?</p>
                                        </div>
                                        <div class="col-12">
                                            <p class="font-weight-bold h5 mt-3">flexi fees:</p>
                                            <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                            <p class="m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                        </div>
                                        <form method="post" class="bankForm">
                                            {{ csrf_field() }}
                                            <div class="col-12 row m-0 p-0">
                                                <div class="col-12">
                                                    <h2 class="font-weight-bold text-capitalize align-self-start my-4 h5 refund_item_content_title">
                                                        gig hunter bank account info</h2>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('beneficiary_name') ? ' has-error' : '' }}">
                                                        <span class="text-capitalize text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_beneficiary_name')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="beneficiary_name"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_beneficiary_name')"
                                                               value="{{(old('beneficiary_name'))?old('beneficiary_name'):$userdata->beneficiary_name}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('beneficiary_name'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('beneficiary_name') }}</strong>
                                                        </p>
                                                    @endif
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('bank_number') ? ' has-error' : '' }}">
                                                        <span class="text-capitalize text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_account_number')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="account_number"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_account_number')"
                                                               value="{{(old('bank_account_number'))?old('bank_account_number'):$userdata->bank_account_number}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('bank_number'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('bank_number') }}</strong>
                                                        </p>
                                                    @endif
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('iban') ? ' has-error' : '' }}">
                                                        <span class="text-uppercase text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_beneficiary_account')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="iban"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_beneficiary_account')"
                                                               value="{{(old('iban'))?old('iban'):$userdata->iban}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('iban'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('iban') }}</strong>
                                                        </p>
                                                    @endif

                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                                                        <span class="text-capitalize text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_name')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="bank_name"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_name')"
                                                               value="{{(old('bank_name'))?old('bank_name'):$userdata->bank_name}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('bank_name'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('bank_name') }}</strong>
                                                        </p>
                                                    @endif
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('banks_address') ? ' has-error' : '' }}">
                                                        <span class="text-capitalize text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_address')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="banks_address"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_address')"
                                                               value="{{(old('banks_address'))?old('banks_address'):$userdata->banks_address}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('banks_address'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('banks_address') }}</strong>
                                                        </p>
                                                    @endif
                                                    <div class="refund_item_content_single d-flex align-items-center justify-content-between w-100 py-2 border border-top-0 border-right-0 border-left-0{{ $errors->has('swift_code') ? ' has-error' : '' }}">
                                                        <span class="text-uppercase text-black text-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_swift')</span>
                                                        <input type="text"
                                                               class="form-control border-0 text-secondary text-right text-capitalize bg-transparent w-50"
                                                               name="swift_code"
                                                               placeholder="@lang('service_category.dashboard_supplier_bank_swift')"
                                                               value="{{(old('swift_code'))?old('swift_code'):$userdata->swift_code}}"
                                                               disabled>
                                                    </div>
                                                    @if ($errors->has('swift_code'))
                                                        <p class="help-block">
                                                            <strong>{{ $errors->first('swift_code') }}</strong>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-12 py-4 d-block">
                                                <button type="button"
                                                        class="btn btn-outline-primary text-uppercase editBank">edit
                                                </button>
                                            </div>
                                            <div class="col-12 py-4 d-none">
                                                <button type="submit"
                                                        class="btn btn-outline-primary text-uppercase saveBank">save
                                                </button>
                                                <button type="button"
                                                        class="btn btn-outline-danger text-uppercase cancelBank">cancel
                                                </button>
                                            </div>
                                        </form>

                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                var $bankForm = $('.bankForm');
                                                var $bankInputs = $bankForm.find('.form-control');
                                                var $editButton = $bankForm.find('.editBank');
                                                var $saveButton = $bankForm.find('.saveBank');
                                                var $cancelButton = $bankForm.find('.cancelBank');

                                                $editButton.on('click', function (e) {
                                                    e.preventDefault();
                                                    $bankInputs.each(function (i, elem) {
                                                        var isDisabled = $(elem).prop('disabled');
                                                        if (isDisabled) {
                                                            $(elem).removeAttr('disabled');
                                                            $bankInputs.eq(0).focus();
                                                            if ($editButton.parent().hasClass('d-block') && $saveButton.parent().hasClass('d-none')) {
                                                                $editButton.parent().removeClass('d-block').addClass('d-none');
                                                                $saveButton.parent().removeClass('d-none').addClass('d-block');
                                                            }
                                                        }
                                                    });
                                                });

                                                $cancelButton.on('click', function (e) {
                                                    e.preventDefault();
                                                    $bankInputs.each(function (i, elem) {
                                                        var isDisabled = $(elem).prop('disabled');
                                                        location.reload();
                                                    });
                                                });
                                            });

                                        </script>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection