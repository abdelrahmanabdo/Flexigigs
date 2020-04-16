@if (Auth::check())
    @if (@Auth::user()->id == $userdata->id||Auth::user()->hasRole('admin'))
	<div class="side mt-5 d-flex flex-column px-4">
	    <div class="w-100">
			<h2 class="h2 text-capitalize text-align-left font-weight-bold">@lang('service_category.dashboard_supplier_bank_account_info')</h2>
		</div>
		<div class="content d-flex flex-column">
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_beneficiary_name')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->beneficiary_name)?$userdata->beneficiary_name:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_beneficiary_account')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->iban)?$userdata->iban:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_beneficiary_full')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->beneficiary_address)?$userdata->beneficiary_address:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_beneficiary_mobile')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->beneficiary_mobile_number)?$userdata->beneficiary_mobile_number:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_name')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->bank_name)?$userdata->bank_name:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_address')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->banks_address)?$userdata->banks_address:"-"}}</small>
			</div>
			<div class="py-2 d-flex flex-row justify-content-between w-100 border border-right-0 border-top-0 border-left-0">
				<small class="h6 font-weight-bold text-dark text-capitalize">@lang('service_category.dashboard_supplier_bank_swift')</small>
				<small class="h6 text-secondary text-capitalize">{{($userdata->swift_code)?$userdata->swift_code:"-"}}</small>
			</div>
		</div>
	</div>
	@endif
@endif