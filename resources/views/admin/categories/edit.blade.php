<!-- add service modal -->
<div class="modal fade edit-categorychild add-service" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('service_category.dashboard_admin_edit_subCategory')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="floating-label-form"onSubmit="return false" onreset="$('.edit-categorychild').modal('hide');" method="post" id="edit-subcategory" action="{{ route('edit_category') }}">
                    <div class="container">
                        {{ csrf_field() }}      
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="subcat-id" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name')" required>
                                <label class="form-group has-float-label mt-5 editsubname">
                                    <input type="text" maxlength="200" class="form-control counted" name="name" id="subcat-name" placeholder="@lang('service_category.dashboard_admin_category_name')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editsubname_ar">
                                    <input type="text" maxlength="200" class="form-control counted" name="name_ar" id="subcat-name_ar" placeholder="@lang('service_category.dashboard_admin_category_name_ar')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                <label class="form-group has-float-label mt-5 editsubslug">
                                    <input type="text" maxlength="200" class="form-control counted" name="slug" id="subcat-slug" placeholder="@lang('service_category.dashboard_admin_category_slug')" required>
                                    <span>@lang('service_category.dashboard_admin_category_slug')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                
                                <label class="form-group has-float-label mt-5 editsubdescription">
                                    <textarea name="intro" maxlength="1000" id="subcat-intro" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
                                </label>

                                <label class="form-group has-float-label mt-5 editsubdescription_ar">
                                    <textarea name="intro_ar" maxlength="1000" id="subcat-intro_ar" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_description_ar')" rows="6"></textarea>
                                    <span>@lang('service_category.dashboard_admin_category_description_ar')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/1000</p>
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
    $('.editsubCat').click(function() {
        var subcat = $(this);
        $('#subcat-id').val(subcat.data('id'));
        $('#subcat-name').val(subcat.data('name')).siblings('.char').text(subcat.data('name').length + '/200');
        $('#subcat-name_ar').val(subcat.data('name_ar')).siblings('.char').text(subcat.data('name_ar').length + '/200');
        $('#subcat-slug').val(subcat.data('slug')).siblings('.char').text(subcat.data('slug').length + '/200');
        $('#subcat-intro').val(subcat.data('intro')).siblings('.char').text(subcat.data('intro').length + '/1000');
        $('#subcat-intro_ar').val(subcat.data('intro_ar')).siblings('.char').text(subcat.data('intro_ar').length + '/1000');
        $('#subcat-keywords').val(subcat.data('keywords'));
        $('.edit-categorychild').modal('show');
    });
    
    $('#edit-subcategory').on('submit', function (e) {
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
                swal("@lang('service_category.dashboard_admin_category_save_title')", "@lang('service_category.dashboard_admin_category_save_msg')", "success").then(function (value) {
                    window.location = "{{ url(app()->getLocale().'/admin/categories') }}";
                });
            },
            error: function (message) {
                $('#sendbtn').prop("disabled", false);
                $('#sendbtn>i').addClass('d-none');
                addcategoryErrors = message.responseJSON;
                if (addcategoryErrors.name) {
                    $('.editsubname').addClass('has-error');
                    $('.editsubname .help-block').removeClass('d-none').text(addcategoryErrors.name);
                }
                if (addcategoryErrors.name_ar) {
                    $('.editsubname_ar').addClass('has-error');
                    $('.editsubname_ar .help-block').removeClass('d-none').text(addcategoryErrors.name_ar);
                }
                if (addcategoryErrors.slug) {
                    $('.editsubslug').addClass('has-error');
                    $('.editsubslug .help-block').removeClass('d-none').text(addcategoryErrors.slug);
                }
                if (addcategoryErrors.intro) {
                    $('.editsubdescription').addClass('has-error');
                    $('.editsubdescription .help-block').removeClass('d-none').text(addcategoryErrors.intro);
                }
                if (addcategoryErrors.intro_ar) {
                    $('.editsubdescription_ar').addClass('has-error');
                    $('.editsubdescription_ar .help-block').removeClass('d-none').text(addcategoryErrors.intro_ar);
                }
               if (addcategoryErrors.keywords) {
                    $('.editsubkeywords').addClass('has-error');
                    $('.editsubkeywords .help-block').removeClass('d-none').text(addcategoryErrors.keywords);
                }
            }
        });
    });

</script>