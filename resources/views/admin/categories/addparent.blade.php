<!-- add service modal -->
<div class="modal fade add-category add-service" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">@lang('service_category.dashboard_admin_add_category')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- 
                    - added has-float-label class to the each form-group div
                    - just add .has-float-label class to .form-group
                    - <input> should be inside <label> and <span> should go after <input>
                 -->
                <form role="form" onSubmit="return false" onreset="$('.add-category').modal('hide');" method="post" id="add-category" action="{{ route('add_category') }}">
                    <div class="container">
                        {{ csrf_field() }}      
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-group has-float-label addname">
                                    <input type="text" maxlength="200" name="name" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                <label class="form-group has-float-label addname_ar">
                                    <input type="text" maxlength="200" name="name_ar" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name_ar')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                
                                <label class="form-group has-float-label mt-5 addslug">
                                    <input type="text" maxlength="200" name="slug" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_slug')" required>
                                    <span>@lang('service_category.dashboard_admin_category_slug')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                <label class="form-group has-float-label mt-5 adddescription">
                                    <textarea name="intro" maxlength="1000" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
                                </label>
                                <label class="form-group has-float-label mt-5 adddescription_ar">
                                    <textarea name="intro_ar" maxlength="1000" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description_ar')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
                                </label>

                                <label class="form-group has-float-label addicon mt-5">
                                    <input type="text" maxlength="200" name="class" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_icon')">
                                    <span>@lang('service_category.dashboard_admin_category_icon')</span>
                                    <p class="help-block"></p>
                                </label>
                                <label class="form-group pl-4">
                                    <input type="checkbox" value="1" class="form-check-input" name="featured" id="featured">
                                    <label  for="featured">@lang('service_category.dashboard_admin_category_featured')</label>
                                    <p class="help-block"></p>
                                </label>
                                <label class="form-group has-float-label">
                                    <label >@lang('service_category.dashboard_admin_category_bg_image')</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input">
                                        <!-- <span>backgound image</span> -->
                                        <span class="custom-file-control"></span>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-default col-md-6">@lang('general.button_cancel')</button>
                                    <button type="submit" class="btn btn-primary col-md-6" id="sendbtn">@lang('general.button_save')<i class="d-none fas fa-spinner fa-pulse ml-2"></i> </button>
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
    $('#add-category').on('submit', function (e) {
        e.preventDefault();
        var Data = $(this).serialize();
        var action = $(this).attr('action');
        $.ajax({
            type: 'POST', url: action, 
            data: Data,
            beforeSend: function(){
                $('#sendbtn').prop('disabled',true);
                $('#sendbtn i').removeClass('d-none');
            },
            success: function (message) {
                swal("@lang('service_category.dashboard_admin_category_save_title')", "@lang('service_category.dashboard_admin_category_save_msg')", "success").then(function(value){
                    location.reload();
                });
            },
            error: function (message) {
                $('#sendbtn').prop("disabled", false);
                $('#sendbtn>i').addClass('d-none');
                addcategoryErrors = message.responseJSON;
                if (addcategoryErrors.name) {
                    $('.addname').addClass('has-error');
                    $('.addname .help-block').removeClass('d-none').text(addcategoryErrors.name);
                }
                if (addcategoryErrors.name_ar) {
                    $('.addname_ar').addClass('has-error');
                    $('.addname_ar .help-block').removeClass('d-none').text(addcategoryErrors.name_ar);
                }
                if (addcategoryErrors.slug) {
                    $('.addslug').addClass('has-error');
                    $('.addslug .help-block').removeClass('d-none').text(addcategoryErrors.slug);
                }
                if (addcategoryErrors.intro) {
                    $('.adddescription').addClass('has-error');
                    $('.adddescription .help-block').removeClass('d-none').text(addcategoryErrors.intro);
                }
                if (addcategoryErrors.intro_ar) {
                    $('.adddescription_ar').addClass('has-error');
                    $('.adddescription_ar .help-block').removeClass('d-none').text(addcategoryErrors.intro_ar);
                }
               if (addcategoryErrors.keywords) {
                    $('.addkeywords').addClass('has-error');
                    $('.addkeywords .help-block').removeClass('d-none').text(addcategoryErrors.keywords);
                }
            }
        });
    });
    
    // change image name
    $(document).on('change', 'input[type="file"]', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    $('input[type="file"]').on('fileselect', function(
        event,
        numFiles,
        label
    ) {
        $(this).siblings('.custom-file-control').text(label);
    });


</script>