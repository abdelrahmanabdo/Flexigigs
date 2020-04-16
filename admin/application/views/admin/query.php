<div class="portlet light ">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-red-sunglo"></i>
            <span class="caption-subject font-red-sunglo bold uppercase"> Query Operations</span>
        </div>
    </div>
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
    <?php if ( $query = get_table('module',['id'=>$this->uri->segment('3')]) ): ?>
     <?php foreach ($query as $quiz ): ?>
        <?=form_open('creator/edit_query/'.$this->uri->segment('3'),array('class'=>'horizontal-form','method'=>'POST'))?>
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <input type="text" id="url" name="url" value="<?=$quiz->url?>" class="form-control" placeholder="creator/edit_one">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Table</label>
                            <input type="text" id="table" name="table_name" value="<?=$quiz->table_name?>" class="form-control" placeholder="Table name" required="required">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" id="name" name="the_name" class="form-control" value="<?=$quiz->the_name?>" placeholder="The name">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Icon</label>
                            <input type="text" id="icon" name="icon_name" class="form-control" value="<?=$quiz->icon_name?>" placeholder="Icon name">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <?php $arr=[]; $arr = json_decode($quiz->is_where);
                      $i =1; 
                       if($arr): foreach ($arr as $val ) :
                      $i++; ?>
                <div class="row where-<?=$i?>">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Where</label>
                                <div class="form-group">
                                    <input type="text" name="key[]" value='<?=$val->key?>' class="form-control" placeholder="Key">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Value</label>
                                <div class="form-group">
                                    <input type="text" name="value[]" value='<?=$val->value?>' class="form-control" placeholder="value">
                                </div>
                            </div>
                        </div>
                         <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-danger" type="button" onclick="remove_where(<?=$i?>)">  
                                           <span class="fa fa-minus" aria-hidden="true"></span>  
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div> <?php endforeach;?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Where</label>
                                <div class="form-group">
                                    <input type="text" name="key[]" value="" class="form-control" placeholder="Key">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Value</label>
                                <div class="form-group">
                                    <input type="text" name="value[]" value="" class="form-control" placeholder="value">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="append_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                      </div>
                    <div id="append_more"></div>
                    </div>
                    <!--/span-->
                <?php else: ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Where</label>
                                <div class="form-group">
                                    <input type="text" name="key[]" value="" class="form-control" placeholder="Key">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Value</label>
                                <div class="form-group">
                                    <input type="text" name="value[]" value="" class="form-control" placeholder="value">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="append_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                      <div id="append_more"></div>
                    </div>
                    <!--/span-->
                <?php endif; ?>
                <?php $unsets=[]; $unsets = json_decode($quiz->unset);
                      $u =1;
                       if($unsets): foreach ($unsets as $unset ) : 
                      $u++; ?>
                <div class="row unset-<?=$u?>">
                    <div class="form-group">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="control-label">Unset</label>
                                <div class="form-group">
                                    <input type="text" name="unset[]" value="<?=$unset?>" class="form-control" placeholder="Column unset">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-danger" type="button" onclick="remove_unset(<?=$u?>)">  
                                           <span class="fa fa-minus" aria-hidden="true"></span>  
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <?php endforeach;?>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="control-label">Unset</label>
                                <div class="form-group">
                                    <input type="text" name="unset[]" class="form-control" placeholder="Column unset">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="unset_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="unset_more"></div>
                    <!--/span-->
                </div>
                <?php else: ?>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="control-label">Unset</label>
                                <div class="form-group">
                                    <input type="text" name="unset[]" class="form-control" placeholder="Column unset">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="unset_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="unset_more"></div>
                    <!--/span-->
                </div>
                <?php endif; ?>
                       <?php $join=[]; $join = json_decode($quiz->is_join);
                             $m =1;
                             if($join): foreach ($join as $key ) : 
                             $m++;?>
                <div class="row joined-<?=$m?>">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Join Table</label>
                                <div class="form-group">
                                    <input type="text" name="join[]" value='<?=$key->table?>' class="form-control" placeholder="Table name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 1</label>
                                <div class="form-group">
                                    <input type="text" name="cond1[]" value='<?=$key->cond1?>' class="form-control" placeholder="Condition 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 2</label>
                                <div class="form-group">
                                    <input type="text" name="cond2[]" value='<?=$key->cond2?>' class="form-control" placeholder="Condition 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Specific Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="join_type[]" data-placeholder="Choose the type" tabindex="1">
                                        <option value=""></option>
                                        <option <?php if($key->type == 'left') echo "selected"; ?> value="left">Left</option>
                                        <option <?php if($key->type == 'right') echo "selected"; ?> value="right">Right</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-danger" type="button" onclick="remove_joined(<?=$m?>)">  
                                           <span class="fa fa-minus" aria-hidden="true"></span>  
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <?php endforeach; ?>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Join Table</label>
                                <div class="form-group">
                                    <input type="text" name="join[]" class="form-control" placeholder="Table name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 1</label>
                                <div class="form-group">
                                    <input type="text" name="cond1[]" class="form-control" placeholder="Condition 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 2</label>
                                <div class="form-group">
                                    <input type="text" name="cond2[]" class="form-control" placeholder="Condition 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Specific Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="join_type[]" data-placeholder="Choose the type" tabindex="1">
                                        <option value=""></option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="join_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    <div id="join_more">
                    </div>
                    </div>
                    <!--/span-->
                </div>
                <?php else: ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Join Table</label>
                                <div class="form-group">
                                    <input type="text" name="join[]" value="" class="form-control" placeholder="Table name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 1</label>
                                <div class="form-group">
                                    <input type="text" name="cond1[]" value="" class="form-control" placeholder="Condition 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 2</label>
                                <div class="form-group">
                                    <input type="text" name="cond2[]" value="" class="form-control" placeholder="Condition 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Specific Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="join_type[]" data-placeholder="Choose the type" tabindex="1">
                                        <option value=""></option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="join_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    <div id="join_more">
                    </div>
                    </div></div>
                    <!--/span-->
                    <?php endif; ?>
                <!--/row-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Sort</label>
                            <input type="text" name="is_sort" value="<?=$quiz->is_sort?>" class="form-control" placeholder="sort">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Order By</label>
                            <select class="form-control" name="order_by" data-placeholder="Choose a Category" tabindex="1">
                                <option value=""></option>
                                <option <?php if( $quiz->order_by == 'DESC' ) echo "selected";?> value="DESC">DESC</option>
                                <option <?php if( $quiz->order_by == 'ASC' ) echo "selected";?> value="ASC">ASC</option>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Limit</label>
                            <div class="form-group">
                                <input type="text" value="<?=$quiz->is_limit?>" name="is_limit" class="form-control" placeholder="Limit">
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Offset</label>
                            <div class="form-group">
                                <input type="text" value="<?=$quiz->offset?>" name="offset" class="form-control" placeholder="Offset">
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="multi-append" class="control-label">Select Hidden Buttons</label>
                            <div class="input-group select2-bootstrap-append">
                                <?php $buttons=[]; 
                                      $buttons = json_decode($quiz->buttons);
                                      $options = array('Add'      => 'Add',
                                                       'Edit'     => 'Edit',
                                                       'View'     => 'View',
                                                       'Delete'   => 'Delete',
                                                      );
                                      echo form_multiselect('buttons[]', $options, $buttons,['id'=>'multi-append','class'=>'form-control select2','multiple'=>'multiple']); 
                                      ?>
                                <span class="input-group-btn">
                                 <button class="btn btn-default" type="button" data-select2-open="multi-append">
                                 <span class="glyphicon glyphicon-search"></span>
                                </button>
                                </span>
                            </div>
                        </div>

                    </div>
                    <!--/span-->
                </div>
            </div>
            <div class="form-actions left">
                <input type="submit" name="save" class="btn blue" value="Edit - Default">
                <input type="submit" name="no_redirect" class="btn default" value="Advanced - Edit">
            </div>
        </form>
 <?php endforeach; ?>
 <?php else : ?>
                <?=form_open('creator/add_query',array('class'=>'horizontal-form','method'=>'POST'))?>
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">URL</label>
                            <input type="text" id="url" name="url" class="form-control" placeholder="creator/add_one">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Table</label>
                            <input type="text" id="table" name="table_name" class="form-control" placeholder="Table name" required="required">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" id="name" name="the_name" class="form-control" placeholder="The name">
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Icon</label>
                            <input type="text" id="icon" name="icon_name" class="form-control" placeholder="Icon name">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Where</label>
                                <div class="form-group">
                                    <input type="text" name="key[]" class="form-control" placeholder="Key">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Value</label>
                                <div class="form-group">
                                    <input type="text" name="value[]" class="form-control" placeholder="value">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="append_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="append_more">
                    </div>
                    <!--/span-->
                </div>
                 <div class="row">
                    <div class="form-group">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label class="control-label">Unset</label>
                                <div class="form-group">
                                    <input type="text" name="unset[]" class="form-control" placeholder="Column unset">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="unset_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="unset_more">
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Join Table</label>
                                <div class="form-group">
                                    <input type="text" name="join[]" class="form-control" placeholder="Table name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 1</label>
                                <div class="form-group">
                                    <input type="text" name="cond1[]" class="form-control" placeholder="Condition 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Condition 2</label>
                                <div class="form-group">
                                    <input type="text" name="cond2[]" class="form-control" placeholder="Condition 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Specific Type</label>
                                <div class="form-group">
                                    <select class="form-control" name="join_type[]" data-placeholder="Choose the type" tabindex="1">
                                        <option value=""></option>
                                        <option value="left">Left</option>
                                        <option value="right">Right</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <div class="input-group-btn add-where">
                                    <button class="btn btn-success" type="button" onclick="join_more();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    <div id="join_more">
                    </div>
                    </div>
                    <!--/span-->
                </div>
                <!--/row-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Sort</label>
                            <input type="text" name="is_sort" class="form-control" placeholder="sort">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Order By</label>
                            <select class="form-control" name="order_by" data-placeholder="Choose a Category" tabindex="1">
                                <option value=""></option>
                                <option value="DESC">DESC</option>
                                <option value="ASC">ASC</option>
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Limit</label>
                            <div class="form-group">
                                <input type="text" name="is_limit" class="form-control" placeholder="limit">
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Offset</label>
                            <div class="form-group">
                                <input type="text" name="offset" class="form-control" placeholder="Offset">
                            </div>
                        </div>
                    </div>
                    <!--/span-->
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="multi-append" class="control-label">Select Hidden Buttons</label>
                            <div class="input-group select2-bootstrap-append">
                                <select id="multi-append" class="form-control select2" name="buttons[]" multiple>
                                    <option></option>
                                    <option value="Add">Add</option>
                                    <option value="Edit">Edit</option>
                                    <option value="View">View</option>
                                    <option value="Delete">Delete</option>
                                </select>
                                <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-select2-open="multi-append">
                                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                                </span>
                            </div>
                        </div>

                    </div>
                    <!--/span-->
                </div>
            </div>
            <div class="form-actions left">
                <input type="submit" name="save" class="btn blue" value="Add - Default">
                <input type="submit" name="no_redirect" class="btn default" value="Advanced - Add">
            </div>
        </form>
 <?php endif; ?>
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
        divtest.innerHTML = '<div class="col-md-6"> <div class="form-group"> <label class="control-label">Where</label> <div class="form-group"> <input type="text" name="key[]" class="form-control" placeholder="Key"> </div></div></div><div class="col-md-5"> <div class="form-group"> <label class="control-label">Value</label> <div class="form-group"> <input type="text" name="value[]" class="form-control" placeholder="value"> </div></div></div><div class="col-md-1"> <div class="form-group"> <div class="input-group-btn add-where"> <button class="btn btn-danger" type="button" onclick="remove_append_more(' + theId + ');"> <span class="fa fa-trash" aria-hidden="true"></span> </button> </div></div></div>';

        objTo.appendChild(divtest)
    }
function remove_append_more(rid) {
        $('.removeclass' + rid).remove();
    }

function unset_more() {
        theId++;
        var objTo = document.getElementById('unset_more')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + theId);
        var rdiv = 'removeclass' + theId;
        divtest.innerHTML = '<div class="form-group"> <div class="col-md-11"> <div class="form-group"> <label class="control-label">Unset</label> <div class="form-group"> <input type="text" name="unset[]" class="form-control" placeholder="Column unset"> </div></div></div><div class="col-md-1"> <div class="form-group"> <div class="input-group-btn add-where"> <button class="btn btn-danger" type="button" onclick="remove_unset_more(' + theId + ');"> <span class="fa fa-trash" aria-hidden="true"></span> </button> </div></div></div></div>';

        objTo.appendChild(divtest)
    }
function remove_unset_more(rid) {
        $('.removeclass' + rid).remove();
    }

function join_more() {
        theId++;
        var objTo = document.getElementById('join_more')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass" + theId);
        var rdiv = 'removeclass' + theId;
        divtest.innerHTML = '<div class="form-group"> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Join Table</label> <div class="form-group"> <input type="text" name="join[]" class="form-control" placeholder="Table name"> </div></div></div><div class="col-md-3"> <div class="form-group"> <label class="control-label">Condition 1</label> <div class="form-group"> <input type="text" name="cond1[]" class="form-control" placeholder="Condition 1"> </div></div></div><div class="col-md-3"> <div class="form-group"> <label class="control-label">Condition 2</label> <div class="form-group"> <input type="text" name="cond2[]" class="form-control" placeholder="Condition 2"> </div></div></div><div class="col-md-2"> <div class="form-group"> <label class="control-label">Specific Type</label> <div class="form-group"> <select class="form-control" name="join_type[]" data-placeholder="Choose the type" tabindex="1"> <option value=""></option> <option value="left">Left</option> <option value="right">Right</option> </select> </div></div></div><div class="col-md-1"> <div class="form-group"> <div class="input-group-btn add-where"> <button class="btn btn-danger" type="button" onclick="remove_join_more(' + theId + ');"> <span class="fa fa-trash" aria-hidden="true"></span> </button> </div></div></div></div>';

        objTo.appendChild(divtest)
    }
function remove_join_more(rid) {
        $('.removeclass' + rid).remove();
    }
function remove_where(id) {
        $('.where-'+id).remove();
    }
function remove_joined(id) {
        $('.joined-'+id).remove();
    }
function remove_unset(id) {
        $('.unset-'+id).remove();
    }
</script>