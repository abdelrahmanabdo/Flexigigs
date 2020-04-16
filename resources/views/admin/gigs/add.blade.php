<div class="d-flex justify-content-end pb-4">
    <a id="postBtn" class="btn btn-primary text-white">@lang('gigs.dashboard_admin_gigs_post_new')</a>
</div>
<div id="gigPost" class="d-none mb-4" data-children=".item">
    <div class="item">
        <div class="item-trigger" data-toggle="collapse" data-parent="#gigPost" data-target="#post" aria-expanded="true">
            <div class="item-info-collapsed">
                <h2>@lang('gigs.dashboard_admin_gigs_post_new')</h2>
                <i class="icon-angle-down"></i>
            </div>
            <div class="item-info">
                <h2>@lang('gigs.dashboard_admin_gigs_post_new')</h2>
                <i class="icon-angle-down"></i>
            </div>
        </div>
        <div id="post" class="item-content show active" role="tabpanel">
            <form id="add_gig" action="{{ route('add_gig') }}" method="post" onreset="$('#gigPost').addClass('d-none').removeClass('d-block')">
                {{ csrf_field() }}
                <input type="hidden" name="repost">
                
                <div class="row pt-2">
                    <div class="col-md-6">
                        <label class="form-group has-float-label mt-5 gigTitle">
                            <input type="text" name="title" class="form-control pl-0" placeholder="@lang('gigs.dashboard_admin_gigs_project.title')" required>
                            <span >@lang('gigs.dashboard_admin_gigs_project.title')</span>
                            <p class="help-block d-none"> <strong></strong> </p>
                        </label>
                        <label class="form-group has-float-label mt-5 adddeadline">
                            <input type="text" name="deadline" id="deadlineDatePicker" class="form-control datepicker" placeholder="@lang('gigs.dashboard_admin_gigs_project.deadline')" required>
                            <span>@lang('gigs.dashboard_admin_gigs_project.deadline')</span>
                            <p class="help-block d-none"> <strong></strong> </p>
                        </label>
                        <label class="form-group has-float-label mt-5 addskills">
                            <select id="keySkills" data-placeholder="@lang('gigs.dashboard_admin_gigs_project.required_skills')" multiple>
                                <?=Flexihelp::getSkills('id','null',Request::segment(1))?>
                            </select>
                            <input type="hidden" name="skills" id="skills">
                            <script type="text/javascript">
                                $("#keySkills").chosen({max_selected_options: 4, width: '100%'}).change(function() {
                                    $("#skills").val($(this).val());
                                });
                            </script>
                            <span>@lang('gigs.dashboard_admin_gigs_project.required_skills')</span>
                            <p class="help-block d-none"> <strong></strong> </p>
                        </label>
                        <label class="form-group has-float-label d-flex justify-content-between addprice mt-5">
                            <input type="number" min="0" name="price" class="form-control" placeholder="@lang('gigs.dashboard_admin_gigs_project.add_price')" required>
                            <span>@lang('gigs.dashboard_admin_gigs_project.add_price')</span>
                            <p class="help-block d-none addprice"> <strong></strong> </p>
                        </label>
                        <label class="sec-title">@lang('user.gh_type')</label>
                        <div class="custom-controls-stacked">
                            @foreach(Flexihelp::supplier_type('','all') as $type=>$value)
                            <label class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="supplier_type[]" value="{{$type}}">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{$value}}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group has-float-label adddescription">
                            <textarea name="description" class="form-control" rows="4" placeholder="@lang('gigs.dashboard_admin_gigs_project.description')" required></textarea>
                            <span>@lang('gigs.dashboard_admin_gigs_project.description')</span>
                            <p class="help-block d-none" style="margin-top: 6rem;"> <strong></strong> </p>
                        </label>
                        <?php $assignuserdata = $userdata; ?>
                        @include('admin.parts.assigntocustomer')
                        <!-- <div class="form-group">
                            <label class="custom-file" style="z-index: 0 !important;">
                                <input type="file" name="attach[]" class="custom-file-input" multiple>
                                <span class="custom-file-control">{{__('Up to 5 files Max. 5MB')}}</span>
                            </label>
                        </div> -->

                        <div id="add-s-img" class="addattach">
                            <label class="mb-0"></label>
                            <label class="custom-file img-1">
                                <input type="file" name="attach[]" class="custom-file-input">
                                <p class="custom-file-control"></p>
                                <p class="help-block d-none" style="margin-top: 6rem;"> <strong></strong> </p>
                            </label>
                        </div>
                        <small><a class="mt-0 text-primary float-right" id="add_moreimg" style="font-size:14px;font-weight: 600;cursor: pointer;">@lang('gigs.dashboard_admin_gigs_project.add_attachment')</a></small>
                        <p class="mb-4">@lang('gigs.dashboard_admin_gigs_project.max_size_msg')</p>
                        <p class="mb-4">png - jpg - gif - doc - docx - csv - pdf</p>
                        <script>
                            $(document).ready(function(){

                                var id = 1;
                                var showId = 0;
                                $("#add_moreimg").click(function(){
                                    var images = $('#add-s-img .custom-file-input');
                                    showId = ++id;
                                    if(images.length <= 4)
                                    {
                                        $('#add-s-img').append('<label class="custom-file img-'+showId+'"  style="width: 80% !important"> <input type="file" name="attach[]" class="custom-file-input"> <span class="custom-file-control"></span> <p><a class="text-danger add-s-removeimage"style="text-decoration:none;cursor:pointer;position:absolute;top:0px;right:-30px;" onclick="event.preventDefault();$(\'.img-'+showId+'\').remove();$(\'#add_moreimg\').removeClass(\'d-none\');showId = --id;" title="">X</a></p> <p class="help-block d-none" style="margin-top: 6rem;"> <strong></strong> </p></label>');
                                     if (images.length == 4) {
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


                        <div class="d-flex">
                            <button class="btn btn-default" type="reset">@lang('general.button_cancel')</button>
                            <button class="btn btn-primary" type="submit" id="sendbtn" >@lang('general.button_save')<i class="d-none fas fa-spinner fa-pulse ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() { 
        $('#add_gig').ajaxForm( {
            beforeSend: function(){
                $('#sendbtn').prop('disabled',true);
                $('#sendbtn i').removeClass('d-none');
            },
            success: function (message) {
                swal("@lang('gigs.dashboard_admin_gigs_save_title')", "@lang('gigs.dashboard_admin_gigs_save_msg')", "success").then(function(value) {
                    location.reload();
                });
            },
            error: function (message) {
                $('#sendbtn').prop("disabled", false);
                $('#sendbtn>i').addClass('d-none');
                addgigErrors = message.responseJSON;
                if (addgigErrors.title) {
                    $('#add_gig .gigTitle').addClass('has-error');
                    $('#add_gig .gigTitle .help-block').removeClass('d-none').text(addgigErrors.message.title);
                }
                if (addgigErrors.message.deadline) {
                    $('#add_gig .adddeadline').addClass('has-error');
                    $('#add_gig .adddeadline .help-block').removeClass('d-none').text(addgigErrors.message.deadline);
                }
                if (addgigErrors.message.price) {
                    $('#add_gig .addprice').addClass('has-error');
                    $('#add_gig .addprice .help-block').removeClass('d-none').text(addgigErrors.message.price);
                }
                if (addgigErrors.message.price_unit) {
                    $('#add_gig .addunit').addClass('has-error');
                    $('#add_gig .addunit .help-block').removeClass('d-none').text(addgigErrors.message.price_unit);
                }
                if (addgigErrors.message.description) {
                    $('#add_gig .adddescription').addClass('has-error');
                    $('#add_gig .adddescription .help-block').removeClass('d-none').text(addgigErrors.message.description);
                }
                if (addgigErrors.message.skills) {
                    $('#add_gig .addskills').addClass('has-error');
                    $('#add_gig .addskills .help-block').removeClass('d-none').text(addgigErrors.message.skills);
                }
                var images = $('#add-s-img .custom-file-input');
                for (var i = images.length - 1; i >= 0; i--) {
                    if (addgigErrors.message["attach."+i]) {
                        classnumber = i+1;
                       $('.custom-file.img-'+classnumber+' .help-block').removeClass('d-none').text(addgigErrors.message["attach."+i]);
                    }
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