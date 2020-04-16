<!-- add service modal -->
<div class="modal fade add-service" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">@lang('service_category.dashboard_admin_add_service')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  onreset="$('.add-service').modal('hide');" method="post" id="add-service" action="{{ url(app()->getLocale().'/admin/addservice') }}">
                    <div class="container">
                        {{ csrf_field() }}      
                        <div class="row">
                            <div class="col-12">
                                <label class="form-group has-float-label addname mb-0">
                                    <input type="text" name="name" maxlength="200" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_service_name')" required>
                                    <span>@lang('service_category.dashboard_admin_service_name')</span>
                                    <p class="char mb-0">0/200</p>
                                    <p class="help-block d-none"> <strong></strong> </p>
                                </label>
                                <div class="ml-0 mb-5">
                                    
                                    <div class="form-group mb-0" id="parent">
                                        <label class="text-hide" for="gig">@lang('service_category.dashboard_admin_select_category')</label>
                                        <select class="form-control" id="parentselector" name="parent" required>
                                            <option disabled selected>@lang('service_category.dashboard_supplier_select_category')</option>
                                            @foreach($parents_categories as $cat):
                                            <option value="{{$cat->slug}}">{{(app()->getLocale()=='ar'&&$cat->name_ar)?$cat->name_ar:$cat->name}}</option>
                                            @endforeach
                                        </select>
                                        <script type="text/javascript">
                                            $('#parentselector').on('change',function (e) {
                                                $.post('{{url(app()->getLocale()."/category/dependancy")}}',
                                                        { _token:$('meta[name="csrf-token"]').attr('content'),
                                                        slug: $('#parentselector').val(),
                                                        stage: 1 
                                                        })
                                                .done(function(content){
                                                    $( "#sub" ).empty().append( content );
                                                    $( "#subsub" ).empty();
                                                });
                                            });
                                        </script>
                                    </div>
                                    <div class="form-group mb-0" id="sub">
                                    </div>
                                    <div class="form-group mb-0" id="subsub">
                                    </div>
									<div class="d-flex flex-column">
										<p class="help-block addcategory mb-0"></p>
										<p class="h6 text-right">@lang('service_category.no_cat') <a href="{{route('contact-us')}}" class="text-primary">@lang('service_category.no_cat_contact_us')</a></p>
									</div>
								</div>             
                                <div class="ml-0 mb-5">
                                    <label class="form-group d-flex justify-content-between addprice has-float-label mt-5">
                                        <input type="number" name="price_per_unit"  min="0" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_add_price')" required>
                                        <span>@lang('service_category.dashboard_admin_add_price')</span>
                                        <p class="help-block d-none"> <strong></strong> </p>
                                    </label>
                                    <label class="form-group d-flex justify-content-between addunit has-float-label mt-5" required>
                                        <select class="form-control mt-3" name="price_unit" required>
                                            <option disabled selected>@lang('service_category.dashboard_admin_price_unit')</option>
                                            <option value="hour">@lang('service_category.dashboard_admin_price_hours')</option>
                                            <option value="project">@lang('service_category.dashboard_admin_price_project')</option>
                                        </select>
                                        <span>@lang('service_category.dashboard_admin_price_unit')</span>
                                        <p class="help-block d-none"> <strong></strong> </p>
                                    </label>
                                    <label class="form-group has-float-label mt-5 adddays_to_delever">
                                    </label>
                                    <script>
                                        // to change project scope input based on types of aggrement (hourly or project)
                                        (function(){
                                            // caching DOM
                                            var $UnitContainer = $('.addunit');
                                            var $priceUnitSelection = $UnitContainer.find('select[name="price_unit"]');
                                            var $daysContainer = $('.adddays_to_delever');
                                        
                                            $priceUnitSelection.change(function(){
                                                if($(this).val() === 'hour'){
                                                    $daysContainer.html('<input type="number" name="days_to_deliver" min="0" class="form-control" placeholder="Hours to deliver*" required> <span>Hours to deliver*</span> ');
                                                } else if ($(this).val() === 'project'){
                                                    $daysContainer.html('<input type="number" name="days_to_deliver" min="0" class="form-control" placeholder="Days to deliver*" required> <span>Days to deliver*</span> ');
                                                } else {
                                                    $daysContainer.html('');
                                                }                                            
                                            });
                                        })();
                                    </script>
                                    <label class="form-group adddescription has-float-label mt-5" required>
                                        <textarea name="description" rows="1" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_description')"></textarea>
                                        <span>@lang('service_category.dashboard_admin_description')</span>
                                        <p class="help-block d-none" style="margin-top: 90px;"> <strong></strong> </p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">


                                <label class="form-group has-float-label addterms">
                                    <textarea name="terms" class="form-control counted" maxlenght="2500" placeholder="@lang('service_category.dashboard_admin_terms_conditions')" rows="1" required></textarea>
                                    <span>@lang('service_category.dashboard_admin_terms_conditions')</span>
                                    <p class="char">0/2500</p>
                                    <p class="help-block d-none" style=" color: red;font-size: 14px;font-family: Lato-Regular;top: 20px;left: 0!important;text-transform: lowercase!important;float: left; position:relative;margin-top: 0;"> <strong></strong> </p>
                                </label>
                                <label class="form-group has-float-label mb-0 addquestion1" style="margin-top:5rem;">
                                    <input name="question1" class="form-control" placeholder="@lang('service_category.dashboard_admin_requirements')*" maxlenght="200" type="text" required>
                                    <span>@lang('service_category.dashboard_admin_requirements')*</span>
                                    <p class="help-block d-none"> <strong></strong> </p>
                                    <small><a href="#" class="first-add" onclick="$(this).addClass('d-none');$('.question2').removeClass('d-none');" title="">@lang('service_category.dashboard_admin_add_question')</a></small>                                        
                                </label>

                                <label class="form-group question2 has-float-label d-none mt-5 mb-0">
                                    <input type="text" name="question2" class="form-control" placeholder="@lang('service_category.dashboard_admin_requirements')" maxlenght="200">
                                    <span>@lang('service_category.dashboard_admin_requirements')</span>
                                    <small><a href="#" class="secound-add" onclick="$(this).addClass('d-none');$('.question3').removeClass('d-none');" title="">@lang('service_category.dashboard_admin_add_question')</a></small>
                                    <p><a class="text-danger" style="cursor:pointer; position: absolute; bottom: 35px; right: 5px;text-decoration: none;" onclick="$(this).closest('.form-group').addClass('d-none');$(this).closest('.form-group').find('input').val(''); $(this).closest('.form-group').find('.form-control').val('');$('.first-add').removeClass('d-none');" title="">X</a></p>
                                </label>
                                <label for="" class="form-group question3 has-float-label d-none mt-5 mb-0">
                                    <input type="text" name="question3" class="form-control" placeholder="@lang('service_category.dashboard_admin_requirements')" maxlenght="200">
                                    <span>@lang('service_category.dashboard_admin_requirements')</span>
                                    <p><a class="text-danger" style="cursor:pointer; position: absolute; bottom: 15px; right: 5px;text-decoration: none;" onclick="$(this).closest('.form-group').addClass('d-none');$(this).closest('.form-group').find('input').val(''); $(this).closest('.form-group').find('.form-control').val('');$('.secound-add').removeClass('d-none');" title="">X</a></p>
                                </label>






                                <div class="form-group mt-5">
                                    <div id="add-s-img">
                                        <label class="mb-0">@lang('service_category.dashboard_admin_portfolio')</label>
                                        <label class="custom-file">
                                            <input type="file" name="img[]" required class="custom-file-input"  accept="image/*">
                                            <span class="custom-file-control"></span>
                                        </label>
                                    </div>
                                    <small><a href="#" class="mt-0" id="add_moreimg">@lang('service_category.dashboard_admin_portfolio_add')</a></small>
                                    <p class="mb-4">png - jpg - gif</p>
                                    <script>
                                        $(document).ready(function(){
                                            var id = 1;
                                            var showId = 0;
                                            $("#add_moreimg").click(function(){
                                                var images = $('#add-s-img .custom-file-input');
                                                showId = ++id;
                                                if(images.length <= 9){
                                                    $('#add-s-img').append('<label class="custom-file img-'+showId+'"> <input type="file" name="img[]" class="custom-file-input"  accept="image/*"> <span class="custom-file-control"></span> <p><a href="#" class="text-danger add-s-removeimage"style="text-decoration:none;cursor:pointer;position:absolute;top:5px;right:5px;" onclick="$(\'.img-'+showId+'\').remove();$(\'#add_moreimg\').removeClass(\'d-none\');showId = --id;" title="">X</a></p> </label>');
                                                    if(images.length == 9){
                                                        $('#add_moreimg').addClass('d-none');
                                                    }
                                                }
                                            });
                                            $(".add-s-removeimage").click(function(){
                                                alert("test");
                                                
                                            });


                                            // change image name
                                            $('body').on('change', 'input[type="file"]', function() {
                                                var input = $(this),
                                                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                                                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                                                input.trigger('fileselect', [numFiles, label]);
                                            });
                                            $('body').on('fileselect','.custom-file-input', function(
                                                event,
                                                numFiles,
                                                label
                                            ) {
                                                $(this).siblings('.custom-file-control').text(label);
                                            });


                                        });
                                    </script>
                                    <label class="has-float-label form-group" id="add-s-video">
                                        <input type="text" name="videourl[]" class="form-control" placeholder="@lang('service_category.dashboard_admin_video_URL')">
                                        <span>@lang('service_category.dashboard_admin_video_URL')</span>
                                        <script>
                                            $(document).ready(function(){
                                                var id = 1;
                                                showId = 0;
                                                $("#add_morevideo").click(function(){
                                                    var videos = $('#add-s-video .form-control');
                                                    var showId = ++id;
                                                    if(videos.length <= 9){
                                                        $('#add-s-video').append('<lable class="vid-'+showId+' has-float-label mt-3"> <input name="videourl[]" class="form-control" placeholder="@lang("service_category.dashbpoard_admin_video_URL") '+showId+'" type="text"><span>Video URL '+showId+'</span><p><a class="text-danger" style="cursor:pointer;position:absolute;top:-25px;right:5px;" onclick="$(\'.vid-'+showId+'\').remove();$(\'#add_morevideo\').removeClass(\'d-none\');showId = --id;console.log(showId)" title="">X</a></p></label>');
                                                        if(videos.length == 9){
                                                            $('#add_morevideo').addClass('d-none');
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                        <small><a href="#" id="add_morevideo">@lang('service_category.dashboard_admin_video_URL_add')</a></small>
                                    </label>
                                    <?php $assignuserdata = $userdata; ?>
                                    @include('admin.parts.assign')
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-default">@lang('general.button_cancel')</button>
                                    <button type="submit" class="btn btn-primary" id="sendbtn" >@lang('general.button_save')<i class="d-none fas fa-spinner fa-pulse ml-2"></i> </button>
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
    $(document).ready(function() { 
        $('#add-service').ajaxForm( {
            beforeSend: function(){
                $('#sendbtn').prop('disabled',true);
                $('#sendbtn i').removeClass('d-none');
            },
            success: function (message) {
                swal("Saved!", "this page will be refresh", "success").then(function () {
                    location.reload();
                });
            },
            error: function (message) {
                $('#sendbtn').prop("disabled", false);
                $('#sendbtn>i').addClass('d-none');
                addserviceErrors = message.responseJSON.message;
                if (addserviceErrors.name) {
                    $('.addname').addClass('has-error');
                    $('.addname .help-block').removeClass('d-none').text(addserviceErrors.name);
                }
                if (addserviceErrors.days_to_delever) {
                    $('.adddays_to_delever').addClass('has-error');
                    $('.adddays_to_delever .help-block').removeClass('d-none').text(addserviceErrors.days_to_delever);
                }
                if (addserviceErrors.price_per_unit) {
                    $('.addprice').addClass('has-error');
                    $('.addprice .help-block').removeClass('d-none').text(addserviceErrors.price_per_unit);
                }
                if (addserviceErrors.category) {
                    $('.addcategory.help-block').removeClass('d-none').text(addserviceErrors.category);
                }
                if (addserviceErrors.price_unit) {
                    $('.addunit').addClass('has-error');
                    $('.addunit .help-block').removeClass('d-none').text(addserviceErrors.price_unit);
                }
                if (addserviceErrors.description) {
                    $('.adddescription').addClass('has-error');
                    $('.adddescription .help-block').removeClass('d-none').text(addserviceErrors.description);
                }
                if (addserviceErrors.terms) {
                    $('.addterms').addClass('has-error');
                    $('.addterms .help-block').removeClass('d-none').text(addserviceErrors.terms);
                }
                if (addserviceErrors.question1) {
                    $('.addquestion1').addClass('has-error');
                    $('.addquestion1 .help-block').removeClass('d-none').text(addserviceErrors.question1);
                }
            }
        });
    });
</script>