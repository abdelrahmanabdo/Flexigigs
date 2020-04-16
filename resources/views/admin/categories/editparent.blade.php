<!-- add service modal -->
<div class="modal fade edit-category add-service" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">@lang('service_category.dashboard_admin_edit_category')</h5>
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
                <form onSubmit="return false" onreset="$('.edit-category').modal('hide');" method="post" id="edit-category" action="{{ route('edit_category') }}">
                    <div class="container">
                        {{ csrf_field() }}      
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="cat-id" class="form-control counted" required>
                                <label class="form-group has-float-label mt-5 editname">
                                    <input type="text" maxlength="200" name="name" id="cat-name" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/35</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editname_ar">
                                    <input type="text" maxlength="200" name="name_ar" id="cat-name_ar" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name_ar')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/35</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editslug">
                                    <input type="text" maxlength="200" name="slug" id="cat-slug" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_slug')" required>
                                    <span>@lang('service_category.dashboard_admin_category_slug')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/35</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editdescription">
                                    <textarea name="intro" maxlength="1000" id="cat-intro" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editdescription_ar">
                                    <textarea name="intro_ar" maxlength="1000" id="cat-intro_ar" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description_ar')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
                                </label>
                                <label class="form-group has-float-label editicon mt-5">
                                    <input type="text" maxlength="200" name="icon" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_icon')" id="cat-icon">
                                    <span>@lang('service_category.dashboard_admin_category_icon')</span>
                                    <p class="help-block"></p>
                                </label>
                                <label class="form-group pl-4">
                                    <input type="checkbox" value="1" class="form-check-input" name="featured" id="cat-featured">
                                    <label class="form-check-label" for="cat-featured">@lang('service_category.dashboard_admin_category_featured')</label>
                                    <p class="help-block"></p>
                                </label>
                                <label class="form-group has-float-label editicon">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img id="cat-image" class="img-fluid">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input">
                                                <span class="custom-file-control"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <span>@lang('service_category.dashboard_admin_category_bg_image')</span>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-default col-md-6">@lang('general.button_cancel')</button>
                                    <button type="submit" class="btn btn-primary col-md-6" id="sendbtn"> @lang('general.button_save') <i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
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
    $('.editCat').click(function() {
        var cat = $(this);
        $('#cat-id').val(cat.data('id'));
        $('#cat-name').val(cat.data('name')).siblings('.char').text(cat.data('name').length + '/200');
        $('#cat-name_ar').val(cat.data('name_ar')).siblings('.char').text(cat.data('name_ar').length + '/200');
        $('#cat-slug').val(cat.data('slug')).siblings('.char').text(cat.data('slug').length + '/200');
        $('#cat-intro').val(cat.data('intro')).siblings('.char').text(cat.data('intro').length + '/1000');
        $('#cat-intro_ar').val(cat.data('intro_ar')).siblings('.char').text(cat.data('intro_ar').length + '/1000');
        $('#cat-keywords').val(cat.data('keywords'));
        $('#cat-icon').val(cat.data('icon'));
        if (cat.data('featured') == 1) {
            $('#cat-featured').attr('checked','checked');
        }else{
            $('#cat-featured').removeAttr('checked');
        }
         if (cat.data('image')) {
            $('#cat-image').attr('src',cat.data('image'));
        }else{
            $('#cat-image').removeAttr('src');
        }
        $('.edit-category').modal('show');
    });
    
    $('#edit-category').on('submit', function (e) {
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
                // console.log(message);
                // alert('true');
                swal("@lang('service_category.dashboard_admin_category_save_title')", "@lang('service_category.dashboard_admin_category_save_msg')", "success").then(function (value) {
                    window.location = "{{ url(app()->getLocale().'/admin/categories') }}";
                });
            },
            error: function (message) {
                $('#sendbtn').prop("disabled", false);
                $('#sendbtn>i').addClass('d-none');
                // console.log(message);
                // alert('false');
                addcategoryErrors = message.responseJSON;
                    if (addcategoryErrors.name) {
                        $('.editname').addClass('has-error');
                        $('.editname .help-block').removeClass('d-none').text(addcategoryErrors.name);
                    }
                    if (addcategoryErrors.name_ar) {
                        $('.editname_ar').addClass('has-error');
                        $('.editname_ar .help-block').removeClass('d-none').text(addcategoryErrors.name_ar);
                    }
                    if (addcategoryErrors.slug) {
                        $('.editslug').addClass('has-error');
                        $('.editslug .help-block').removeClass('d-none').text(addcategoryErrors.slug);
                    }
                    if (addcategoryErrors.intro) {
                        $('.editdescription').addClass('has-error');
                        $('.editdescription .help-block').removeClass('d-none').text(addcategoryErrors.intro);
                    }
                    if (addcategoryErrors.intro_ar) {
                        $('.editdescription_ar').addClass('has-error');
                        $('.editdescription_ar .help-block').removeClass('d-none').text(addcategoryErrors.intro_ar);
                    }
                   if (addcategoryErrors.keywords) {
                        $('.editkeywords').addClass('has-error');
                        $('.editkeywords .help-block').removeClass('d-none').text(addcategoryErrors.keywords);
                    }

                }
                // $('.LoginErrors').removeClass('d-none').text("Wrong E-Mail or password");
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