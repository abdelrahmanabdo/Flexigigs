<!-- add service modal -->
<div class="modal fade add-categorychild add-service" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">@lang('service_category.dashboard_admin_add_subCategory')</h5>
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
                <form onSubmit="return false" onreset="$('.add-categorychild').modal('hide');" method="post" id="add-subcategory" action="{{ route('add_category') }}">
                    <div class="container">
                        {{ csrf_field() }}      
                        <input type="hidden" name="parent_id" class="form-control " id="parent_id" required>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-group has-float-label mt-5 addname">
                                    <input type="text" maxlength="200" name="name" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_name')" required>
                                    <span>@lang('service_category.dashboard_admin_category_name')</span>
                                    <p class="help-block"></p>
                                    <p class="char">0/200</p>
                                </label>
                                <label class="form-group has-float-label mt-5 addname_ar">
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
                                <label class="form-group has-float-label mt-5 addclass">
                                    <input type="text" maxlength="200" name="class" class="form-control counted" placeholder="@lang('service_category.dashboard_admin_category_icon')">
                                    <span>@lang('service_category.dashboard_admin_category_icon')</span>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-default col-md-6">@lang('general.button_cancel')</button>
                                    <button type="submit" class="btn btn-primary col-md-6">@lang('general.button_save')</button>
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
    $('.addsub').click(function () {
        var item = $(this);
        parent_id = item.data('parent_id');
        $('#parent_id').val(parent_id);
        $('.add-categorychild').modal('show');
    });
    
    $('#add-subcategory').on('submit', function (e) {
        e.preventDefault();
        var Data = $(this).serialize();
        console.log(Data);
        var action = $(this).attr('action');
        $.ajax({
            type: 'POST', url: action, 
            data: Data,
            beforeSend: function(){$("#body-overlay").show();},
            success: function (message) {
                swal("@lang('service_category.dashboard_admin_category_save_title')", "@lang('service_category.dashboard_admin_category_save_msg')", "success").then(function(value) {
                    window.location = "{{ url(app()->getLocale().'/admin/categories') }}";
                });
            },
            error: function (message) {
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
            }
        });
    });
</script>