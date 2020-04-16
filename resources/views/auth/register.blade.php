    <!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">@lang('user.register_title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row gig-services py-3">
                    <div class="col-lg-4 col-xl-4 d-flex flex-column justify-content-between">
                        <h2 class="text-uppercase">@lang('user.register_post_gig')</h2>
                        <p>@lang('user.register_post_gig_content')</p>
                        <a href="#registerPostagigModal" class="btn btn-primary text-uppercase" data-toggle="modal">@lang('user.register_headhunter')</a>
                    </div>
                    <div class="col-lg-4 col-xl-4 offset-lg-4 offset-xl-4 d-flex flex-column justify-content-between">
                        <h2 class="text-uppercase">@lang('user.register_find_gig')</h2>
                        <p>@lang('user.register_find_gig_content')</p>
                        <a href="#registerFindagigModal" class="btn btn-primary text-uppercase" data-toggle="modal">@lang('user.register_gighunter')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerFindagigModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="modal-header pb-0">
                <h5 class="modal-title">@lang('user.register_gighunter')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form accept-charset="utf-8" id="findagig-form" action="{{ route('register') }}"  method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="role_id" value="2" class="form-control">
                    <input type="hidden" name="lang_perfix" value="{{app()->getLocale()}}">
                    <input type="hidden" name="ud_id">
                    <div class="form-row">
                        <!-- <div class="col-lg-6">
                        </div> -->
						<div class="form-group findfirst_name col-md-6 col-12">
							<label class="text-hide" for="first_name">@lang('user.register_first_name')</label>
							<input type="text" name="first_name" placeholder="@lang('user.register_first_name')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findlast_name col-md-6 col-12">
							<label class="text-hide" for="lastname">@lang('user.register_last_name')</label>
							<input type="text" name="last_name" placeholder="@lang('user.register_last_name')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findusername col-md-6 col-12">
							<label class="text-hide" for="username">@lang('user.register_user_name')</label>
							<input type="text" name="username" placeholder="@lang('user.register_user_name')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findemail col-md-6 col-12">
							<label class="text-hide" for="email">@lang('user.register_email')</label>
							<input type="email" name="email" placeholder="@lang('user.register_email')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findpassword col-md-6 col-12">
							<label class="text-hide" for="password">@lang('user.register_password')</label>
							<input type="password" name="password" placeholder="@lang('user.register_password')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findphone col-md-6 col-12">
							<label class="text-hide" for="phone">@lang('user.register_mobile')</label>
							<input type="tel" name="phone" placeholder="@lang('user.register_mobile')" class="form-control">
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findpassword_confirmation col-md-6 col-12">
							<label class="text-hide" for="retypepassword">@lang('user.register_password_retype')</label>
							<input type="password" name="password_confirmation" placeholder="@lang('user.register_password_retype')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findcity col-md-6 col-12">
							<label class="text-hide" for="city">@lang('user.register_city')</label>
							<input type="text" name="formatted_address" placeholder="@lang('user.register_city')" id="findagiglocation" class="form-control" required>
							<input type="hidden" name="city" id="findagigcity_lat_long" class="latlong">
							<script type="text/javascript">
								function findagigMapFunctions() {AutoCompleteSearchCity('findagiglocation','findagigcity_lat_long','#findagiglocation'); }
							</script>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findgender col-md-6 col-12 pt-1">
							<label class="text-hide" for="gender">@lang('user.register_gender')</label>
							<select name="gender" class="form-control" required>
								<option disabled selected>@lang('user.register_gender')</option>
								<option value="0">@lang('user.gender_male')</option>
								<option value="1">@lang('user.gender_female')</option>
							</select>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findcountry col-md-6 col-12">
							<label class="text-hide" for="country">@lang('user.register_country')</label>
							<input type="text" name="formatted_address_country" placeholder="@lang('user.register_country')" id="findagiglocationCountry" class="form-control" required>
							<input type="hidden" name="country" id="findagigcountry_lat_long" class="latlong">
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findfacebook col-md-6 col-12">
							<label class="text-hide" for="facebook">@lang('user.register_facebook')</label>
							<input type="text" name="facebook" placeholder="@lang('user.register_facebook')" class="form-control">
						</div>
						<div class="form-group findsupplier_type mb-md-1 d-flex align-items-center col-md-6 col-12">
							<label class="select-label" for="iam"></label>
							<select class="form-control" name="age_group" required>
								<?=Flexihelp::get_agegroup('options')?>
							</select>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findlinkedin col-md-6 col-12 d-flex align-items-end">
							<input type="text" name="linkedin" placeholder="@lang('user.register_linkedin')" class="form-control">
						</div>
						<div class="form-group col-md-6 col-12">
							<label class="text-hide" for="introduction">@lang('user.register_introduction')</label>
							<textarea class="form-control p-0" rows="1" name="intro" placeholder="@lang('user.register_introduction')" style="min-height: 30px;"></textarea>
						</div>
						<div class="form-group findsupplier_type col-md-6 col-12 mb-md-0">
							<label class="select-label" for="iam"></label>
							<select class="form-control" name="supplier_type" required>
								<?=Flexihelp::supplier_type("","options")?>
							</select>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findskills col-md-6 col-12 mb-md-0">
							<select class="" id="keySkills" data-placeholder="@lang('user.register_key_skills')" multiple>
								<?=Flexihelp::getSkills("slug",null,Request::segment(1))?>
							</select>
							<input type="hidden" name="skills" id="skills">
							<script type="text/javascript">
								$("#keySkills").chosen({max_selected_options: 4, width: '100%'}).change(function() {
									$("#skills").val($(this).val());
								});
							</script>
							<p>@lang('user.register_cant_find') <a href="{{route('contact-us')}}" title="">@lang('user.register_contact_us')</a></p>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group findg-recaptcha-response col-md-6 col-12 mb-md-0">
							<!-- This is for Google Reapcha  -->
							{!! Recaptcha::render() !!}
							<!-- End for Google Recapcha -->
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group col-md-6 col-12 mb-md-0 d-flex align-items-end">
							<label class="custom-file">
								<div id="targetLayer"></div>
								<div class="icon-choose-image" >
									<input name="avatar" id="userImage" type="file" class="inputFile custom-file-input" onChange="showPreview(this,'#targetLayer');"/>
								</div>
								<span class="custom-file-control text-capitalize"></span>
							</label>
						</div>
						<div class="form-group findterms d-flex align-items-center justify-content-start col-12 my-4">
							<input type="checkbox" name="terms" id="styled-check1" class="w-25 styled-checkbox">
							<label for="styled-check1" class="text-light d-flex align-items-center justify-content-between w-75">
								<p class="text-capitalize">Accept Terms & Conditions</p>
								<a href="{{route('terms')}}" class="text-light text-capitalize h6">
									<em>View Terms & Conditions</em>
								</a>
							</label>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <button type="submit" class="btn btn-default btn-block mb-sm-0" id="btnfindrecap" >@lang('user.register_title') <i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{ url(app()->getLocale().'/login/facebook?membertype=registerFindagigModal') }}" class="btn btn-default btn-block text-center text-white"><i class="icon-facebook"></i>@lang('user.register_facebook_account')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
     </div>
</div>
<div class="modal fade" id="registerPostagigModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
     <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h5 class="modal-title">@lang('user.register_headhunter')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form accept-charset="utf-8" id="postagig-form"  action="{{ route('register') }}"  method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="member_type" value="1" class="form-control">
                    <input type="hidden" name="role_id" value="3" class="form-control">
                    <input type="hidden" name="lang_perfix" value="{{app()->getLocale()}}">
                    <input type="hidden" name="ud_id">
                    <div class="form-row">
						<div class="form-group postfirst_name col-md-6 col-12">
							<label class="text-hide" for="first_name">@lang('user.register_first_name')</label>
							<input type="text" name="first_name" placeholder="@lang('user.register_first_name')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postlast_name col-md-6 col-12">
                                <label class="text-hide" for="lastname">@lang('user.register_last_name')</label>
                                <input type="text" name="last_name" placeholder="@lang('user.register_last_name')" class="form-control" required>
                                <span class="help-block d-none">
                                    <strong></strong>
                                </span>
                            </div>
						<div class="form-group postusername col-md-6 col-12">
							<label class="text-hide" for="username">@lang('user.register_user_name')</label>
							<input type="text" name="username" placeholder="@lang('user.register_user_name')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postemail col-md-6 col-12">
							<label class="text-hide" for="email">@lang('user.register_email')</label>
							<input type="email" name="email" placeholder="@lang('user.register_email')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postpassword col-md-6 col-12">
							<label class="text-hide" for="password">@lang('user.register_password')</label>
							<input type="password" name="password" placeholder="@lang('user.register_password')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postpassword_confirmation col-md-6 col-12">
							<label class="text-hide" for="retypepassword">@lang('user.register_password_retype')</label>
							<input type="password" name="password_confirmation" placeholder="@lang('user.register_password_retype')" class="form-control" required>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postphone col-md-6 col-12">
							<label class="text-hide" for="phone">@lang('user.register_phone')</label>
							<input type="tel" name="phone" placeholder="@lang('user.register_phone')" class="form-control">
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postcity col-md-6 col-12">
							<label class="text-hide" for="city">@lang('user.register_city')</label>
							<input type="text" name="formatted_address" id="postagiglocation" placeholder="@lang('user.register_city')" class="form-control" required>
							<input type="hidden" name="city" id="postagigcity_lat_long" class="latlong">
							<script type="text/javascript">
								function postagigMapFunctions() { AutoCompleteSearchCity('postagiglocation','postagigcity_lat_long','#postagiglocation'); }
							</script>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postgender col-md-6 col-12 pt-1">
							<label class="text-hide" for="gender">@lang('user.register_gender')</label>
							<select name="gender" class="form-control" required>
								<option disabled selected>@lang('user.register_gender')</option>
								<option value="0">@lang('user.gender_male')</option>
								<option value="1">@lang('user.gender_female')</option>
							</select>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postcity col-md-6 col-12">
							<label class="text-hide" for="country">@lang('user.register_country')</label>
							<input type="text" name="formatted_address_country_2" id="postagiglocationCountry2" placeholder="@lang('user.register_country')" class="form-control" required>
							<input type="hidden" name="country" id="postagigcountry_lat_long" class="latlong">
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postfacebook col-md-6 col-12">
							<label class="text-hide" for="facebook">@lang('user.register_facebook')</label>
							<input type="text" name="facebook" placeholder="@lang('user.register_facebook')" class="form-control">
						</div>
						<div class="form-group postage_group col-md-6 col-12 d-flex align-items-end">
							<label class="select-label" for="age_group"></label>
							<select class="form-control" name="age_group" required>
								<?=Flexihelp::get_agegroup('options')?>
							</select>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group postlinkedin col-md-6 col-12">
							<label class="text-hide" for="linkedin">@lang('user.register_linkedin')</label>
							<input type="text" name="linkedin" placeholder="@lang('user.register_linkedin')" class="form-control">
						</div>
						<div class="form-group col-md-6 col-12">
							<label class="text-hide" for="company">@lang('user.register_company_name')</label>
							<input type="text" name="company_name" placeholder="@lang('user.register_company_name')" class="form-control">
						</div>
						<div class="form-group postg-recaptcha-response col-md-6 col-12 mb-0">
								<!-- This is for Google Reapcha  -->
							{!! Recaptcha::render() !!}
							<!-- End for Google Recapcha -->
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
						<div class="form-group col-md-6 col-12 mb-0 d-flex align-items-start mt-sm-5">
							<label class="text-hide" for="companyURL">@lang('user.register_company_url')</label>
							<input type="text" name="site_url" placeholder="@lang('user.register_company_url')" class="form-control">
						</div>
						<div class="form-group offset-md-6 col-md-6 col-12 d-flex align-items-end mb-md-0 justify-content-end">
							<label class="custom-file">
								<div id="targetLayer2"></div>
								<div class="icon-choose-image" >
									<input name="avatar" id="userImage2" type="file" class="inputFile custom-file-input" onChange="showPreview(this,'#targetLayer2');" />
								</div>
								<span class="custom-file-control text-capitalize"></span>
							</label>
						</div>
						<div class="form-group findterms d-flex align-items-center justify-content-start col-12 my-4">
							<input type="checkbox" name="terms" id="styled-check1" class="w-25 styled-checkbox">
							<label for="styled-check1" class="text-light d-flex align-items-center justify-content-between w-75">
								<p class="text-capitalize">Accept Terms & Conditions</p>
								<a href="{{route('terms')}}" class="text-light text-capitalize h6">
									<em>View Terms & Conditions</em>
								</a>
							</label>
							<span class="help-block d-none">
								<strong></strong>
							</span>
						</div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <button type="submit" class="btn btn-default btn-block mb-sm-0" id="btnpostrecap" >@lang('user.register_title') <i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
                                </div>
                                <div class="col-12 col-md-6">
                                    <a href="{{ url(app()->getLocale().'/login/facebook?membertype=registerPostagigModal') }}" class="btn btn-default btn-block text-center "><i class="icon-facebook"></i>@lang('user.register_facebook_account')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var roles = {
        username:{presence: true },
        email:{presence: true, email: true },
        password:{
            presence: true,
            format: {
              pattern: /^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d).{8,}$/,
              message: function(value, attribute, validatorOptions, attributes, globalOptions) {
                return validate.format("^%{num} is not a valid password", {
                  num: value
                });
              }
            },
            length: {minimum: 8}    
        },
        password_confirmation:{presence: true, equality: "password"},
        first_name:{presence: true, },
        last_name:{presence:true },
        phone:{presence:true, numericality: true },
        gender:{presence:true, }, 
        age_group:{presence:true, }, 
        terms:{presence:true, }, 
        city:{presence:true, }, 
        "g-recaptcha-response":{presence:true, }
    };
    clint_validator("#findagig-form","find",roles);
    $(document).ready(function() { 
        $('#findagig-form').ajaxForm( {
            beforeSend: function(){
                $("#body-overlay").show();
                $('#findagig-form .form-group').removeClass('has-error');
                $('#findagig-form .form-group .help-block').addClass('d-none').text("");
                $('#btnfindrecap').prop('disabled',true);
                $('#btnfindrecap i').removeClass('d-none');
            },
            success: function (message) {
                $('#btnfindrecap').prop("disabled", false);
                $('#btnfindrecap>i').addClass('d-none');
                $('#findagig-form')[0].reset();
                $('#targetLayer2').html('');
                $('#targetLayer').html('');
                $('#registerFindagigModal').modal('hide');
                $('#keySkills').trigger('chosen:updated');
                $('#loginModal').modal('show');
                $('.LoginErrors').removeClass('d-none')
                                .removeClass('alert-danger')
                                .addClass('alert-success')
                                .html("@lang('user.register_success')");
                $('#findagig-form .form-group .form-control').val("");
                grecaptcha.reset(0);
                grecaptcha.reset(1);
            },
            error: function (message) {
                $('#btnfindrecap').prop("disabled", false);
                $('#btnfindrecap>i').addClass('d-none');
                grecaptcha.reset(0);
                grecaptcha.reset(1);
                findagigErrors = message.responseJSON;
                showValidate('find',message.responseJSON);

            }
        });
    clint_validator("#postagig-form","post",roles);

        $('#postagig-form').ajaxForm( {
            beforeSend: function(){
                $("#body-overlay").show();
                $('#postagig-form .form-group').removeClass('has-error');
                $('#postagig-form .form-group .help-block').addClass('d-none').text("");
                $('#btnpostrecap').prop('disabled',true);
                $('#btnpostrecap i').removeClass('d-none');
            },
            success: function (message) {
                $('#btnpostrecap').prop("disabled", false);
                $('#btnpostrecap>i').addClass('d-none');
                $('#postagig-form')[0].reset();
                $('#targetLayer2').html('');
                $('#targetLayer').html('');
                $('#registerPostagigModal').modal('hide');
                $('#loginModal').modal('show');
                $('.LoginErrors').removeClass('d-none')
                                .removeClass('alert-danger')
                                .addClass('alert-success')
                                .html("@lang('user.register_success')");

                $('#postagig-form .form-group .form-control').val("");
                grecaptcha.reset(0);
                grecaptcha.reset(1);
            },
            error: function (message) {
                $('#btnpostrecap').prop("disabled", false);
                $('#btnpostrecap>i').addClass('d-none');
                grecaptcha.reset(0);
                grecaptcha.reset(1);
                showValidate('post',message.responseJSON);
            }
        });
    });
    function showPreview(objFileInput,targetLayer2) {
        if (objFileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (e) {
                $(targetLayer2).html('<img src="'+e.target.result+'" width="100px" height="100px" class="upload-preview" />')
                .css('opacity','0.7');
                $(".icon-choose-image").css('opacity','0.5');
            }
            fileReader.readAsDataURL(objFileInput.files[0]);
        }
    }
    //handle switching registeration modals
    $('#registerFindagigModal, #registerPostagigModal').on('show.bs.modal', function(e) {
        $('#registerModal').modal('hide');
    });
    $('#registerFindagigModal, #registerPostagigModal').on('shown.bs.modal', function(e) {
        $('body').addClass('modal-open');
    });

</script>