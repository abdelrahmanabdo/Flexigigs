<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase">Columns</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
            <div class="form-body">
                <?php if ($columns = get_table('columns',['module_id'=>$this->uri->segment('3')])): ?>
                    <?php foreach ($columns as $column): ?>
                        <div class="row removeclass<?=$column->id?>">
                        <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Show List</label>
                                    <div class="form-group">
                                        <select class="form-control check-<?=$column->id?>" name="check" tabindex="1">
                                            <option <?php if( $column->list == 0 ) echo "selected";?> value="0">No</option>
                                            <option <?php if( $column->list == 1 ) echo "selected";?> value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Required</label>
                                    <div class="form-group">
                                        <select class="form-control is_required-<?=$column->id?>" name="is_required" tabindex="1">
                                            <option <?php if( $column->is_required == 0 ) echo "selected";?> value="0">No</option>
                                            <option <?php if( $column->is_required == 1 ) echo "selected";?> value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Type</label>
                                    <div class="form-group">
                                        <select class="form-control type-<?=$column->id?>" name="type[<?=$column->id?>]" tabindex="1" required="required">
                                            <option <?php if( $column->type == 1 ) echo "selected";?> value="1">Input</option>
                                            <option <?php if( $column->type == 2 ) echo "selected";?> value="2">Textarea</option>
                                            <option <?php if( $column->type == 3 ) echo "selected";?> value="3">Checkbox</option>
                                            <option <?php if( $column->type == 4 ) echo "selected";?> value="4">CKEditor</option>
                                            <option <?php if( $column->type == 5 ) echo "selected";?> value="5">Radio</option>
                                            <option <?php if( $column->type == 6 ) echo "selected";?> value="6">Dropdown</option>
                                            <option <?php if( $column->type == 7 ) echo "selected";?> value="7">File</option>
                                            <option value="8">Date</option>
                                            <option <?php if( $column->type == 9 ) echo "selected";?> value="9">Date Time</option>
                                            <option <?php if( $column->type == 10 ) echo "selected";?> value="10">Integer</option>
                                            <option <?php if( $column->type == 11 ) echo "selected";?> value="11">Readonly</option>
                                            <option <?php if( $column->type == 12 ) echo "selected";?> value="12">Password</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input type="text"  name="name[<?=$column->id?>]" value="<?=$column->name?>" class="form-control name-<?=$column->id?>" placeholder="Name" required="required">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Rename</label>
                                    <input type="text" name="rename[<?=$column->id?>]" value="<?=$column->is_rename?>" class="rename-<?=$column->id?> form-control" placeholder="Rename" required="required">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Options</label>
                                    <div class="col-md-12">
                                        <input type="text" name="options<?=$column->id?>" class="form-control input-large options-<?=$column->id?>" value="<?=$column->options?>" data-role="tagsinput"> 
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group-btn add-where">
                                        <button class="btn btn-success" type="button" title="Append" name="update" onclick="update_row(<?=$column->id?>);"> <span class="glyphicon glyphicon-save" aria-hidden="true"></span> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-1">
                                <div class="form-group">
                                    <div class="input-group-btn add-where">
                                      <button class="btn btn-danger" title="Delete" id="delete" onclick="remove_row(<?=$column->id?>);" type="button">  
                                         <span class="fa fa-minus" aria-hidden="true"></span> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
                <div class="row removeclass1">
                    <div class="col-md-1">
                         <div class="form-group">
                            <label class="control-label">Show List</label>
                            <div class="form-group">
                                <select class="form-control check-0" name="check" tabindex="1">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="control-label">Required</label>
                            <div class="form-group">
                                <select class="form-control is_required-0" name="is_required" tabindex="1">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Type</label>
                            <div class="form-group">
                                <select class="form-control type-0" name="type" tabindex="1" required="required">
                                    <option value="1">Input</option>
                                    <option value="2">Textarea</option>
                                    <option value="3">Checkbox</option>
                                    <option value="4">CKEditor</option>
                                    <option value="5">Radio</option>
                                    <option value="6">Dropdown</option>
                                    <option value="7">File</option>
                                    <option value="8">Date</option>
                                    <option value="9">Date Time</option>
                                    <option value="10">Integer</option>
                                    <option value="11">Readonly</option>
                                    <option value="12">Password</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control name-0" placeholder="Name" required="required">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Rename</label>
                            <input type="text" name="rename" class="form-control rename-0" placeholder="Rename" required="required">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Options</label>
                            <div class="col-md-12">
                                <input type="text" name="options" class="form-control input-large options-0" data-role="tagsinput"> 
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-1">
                        <div class="form-group">
                            <div class="input-group-btn add-where">
                                <button class="btn btn-success" type="button" title="save" name="save" onclick="save_row(0,<?=$this->uri->segment(3)?>);">
                                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span> 
                                </button>
                            </div>
                        </div>
                    </div>
                   <div class="col-md-1">
                        <div class="form-group">
                            <div class="input-group-btn add-where">
                                <button class="btn btn-danger delete-0" onclick="remove_append_more(0);" title="Delete" type="button"> 
                                 <span class="fa fa-minus" aria-hidden="true"></span> 
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="append_more"> </div>
                <div class="col-md-12">
                    <div class="form-group text-center"><br>
                        <div class="input-group-btn add-where">
                            <button class="btn btn-success" type="button" onclick="append_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add More 
                            </button>
                        </div>
                    </div>
                </div>
                <!--/row-->
            </div>
            <div class="form-actions left">
                    <button class="btn default" onclick="location.href='<?=base_url()?>creator/modules'">Cancel</button>
            </div>
            <!-- END FORM-->
    </div>
</div>

<script type="text/javascript">
var theId = 1;
function append_more() {
        theId++;
        var objTo = document.getElementById('append_more')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + theId);
        var rdiv = 'removeclass' + theId;
        divtest.innerHTML = '<div class="row"><div class="col-md-1"><div class="form-group"><label class="control-label">Show List</label><div class="form-group"><select class="form-control check-'+theId+'" name="check" tabindex="1"><option value="1">Yes</option><option value="0">No</option></select></div></div></div><div class="col-md-1"><div class="form-group"><label class="control-label">Required</label><div class="form-group"><select class="form-control is_required-'+theId+'" name="is_required" tabindex="1"><option value="0">No</option><option value="1">Yes</option></select></div></div></div><div class="col-md-2"><div class="form-group"> <label class="control-label">Type</label><div class="form-group"> <select class="form-control type-'+theId+'" name="type" tabindex="1" required="required"> <option value="1">Input</option> <option value="2">Textarea</option> <option value="3">Checkbox</option> <option value="4">CKEditor</option> <option value="5">Radio</option> <option value="6">Dropdown</option> <option value="7">File</option><option value="8">Date</option><option value="9">Date Time</option><option value="10">Integer</option><option value="11">Readonly</option><option value="12">Password</option></select></div></div></div><div class="col-md-2"><div class="form-group"> <label class="control-label">Name</label> <input type="text" id="name" name="name" class="form-control name-'+theId+'"placeholder="Name" required="required"> </div></div><div class="col-md-2"><div class="form-group"> <label class="control-label">Rename</label> <input type="text" id="rename" name="rename" class="form-control rename-'+theId+'"placeholder="Rename" required="required"> </div></div><div class="col-md-2"><div class="form-group"><label class="control-label">Options</label><div class="col-md-12"><input type="text" name="options" class="form-control input-large options-'+theId+'" value="" data-role="tagsinput"> </div></div></div><div class="col-md-1"><div class="form-group"><div class="input-group-btn add-where"> <button class="btn btn-success" type="button" title="save" onclick="save_row('+theId+',<?=$this->uri->segment(3)?>);"> <span class="glyphicon glyphicon-save" aria-hidden="true"></span> </button></div></div></div><div class="col-md-1"><div class="form-group"><div class="input-group-btn add-where"> <button class="btn btn-danger" onclick="remove_append_more('+theId +');" title="Delete" id="delete" type="button"> <span class="fa fa-minus" aria-hidden="true"></span> </button></div></div></div></div>';
        objTo.appendChild(divtest);
        $.getScript("<?= base_url() ?>assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js");
    }
function remove_append_more(rid) {
        $('.removeclass' + rid).remove();
    }
function save_row(theId,module_id){
        var check = $(".check-"+theId).val();
        var req = $(".is_required-"+theId).val();
        var type = $(".type-"+theId).val();
        var name= $(".name-"+theId).val();
        var rename= $(".rename-"+theId).val();
        var options= $(".options-"+theId).val();
        $.ajax({
            url: "<?=base_url()?>creator/add_column/",
            type: "POST",
            data: {name:name,rename:rename,type:type,check:check,id:module_id,req:req,options:options},
            success: function(data) {
               alert("Sucess");
            },
            error: function(data){
               alert("Shit");
            }
        });
    }
function update_row(theId){
        var check = $(".check-"+theId).val();
        var req = $(".is_required-"+theId).val();
        var type = $(".type-"+theId).val();
        var name= $(".name-"+theId).val();
        var rename= $(".rename-"+theId).val();
        var options= $(".options-"+theId).val();
        var id= theId;
        $.ajax({
            url: "<?=base_url()?>creator/update_column",
            type: "POST",
            data: {name:name,rename:rename,type:type,check:check,id:theId,req:req,options:options},
            success: function(data) {
               alert("Sucess");
            },
            error: function(data){
               alert("Shit");
            }
        });
    }
function remove_row(rid) {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, delete it!',
            closeOnConfirm: false
        },
        function(){
            swal("Deleted!", "Your imaginary file has been deleted!", "success");
            $('.removeclass' + rid).remove();
                $.ajax({
                url: "<?=base_url()?>creator/delete_column/",
                type: "POST",
                data: {id:rid},
            success: function(data) {
            //    alert("sucess");
            },
            error: function(data){
            //    alert("Shit");
            }
            });
        });
        
    }
</script>