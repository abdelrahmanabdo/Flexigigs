<div class="row">
    <div class="col-md-12">
        <a class="btn btn-success" href="<?=base_url('creator/query')?>"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> add module
                                    </a>
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet">
            <div class="portlet-body" style="display: block;">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fa fa-database"></i> Table</th>
                                <th class="hidden-xs">
                                    <i class="fa fa-link"></i> URL</th>
                                <th><i class="fa fa-shopping-cart"></i> Name</th>
                                <th><i class="fa fa-info"></i> Icons</th>
                                <th><i class="fa fa-star"></i> Actions</th></th>
                            </tr>
                        </thead>
                        <tbody><?php foreach ($tables as $table) : ?>
                            <tr>
                                <td class="highlight">
                                    <div class="success"></div>
                                    <a href="javascript:;"> <?=$table->table_name?> </a>
                                </td>
                                <td class="hidden-xs"><a onclick='window.open("<?=base_url()?>admin/<?=$table->url?>");return false;' href="<?=base_url()?>admin/<?=$table->url?>"><?=$table->url?></a> </td>
                                <td><?=$table->the_name?></td>
                                <td><?=$table->icon_name?></td>
                                <td>
                                <a class="btn blue" href="<?=base_url()?>creator/columns/<?=$table->id?>">
                                                                        <i class="fa fa-columns"></i> Columns </a>
                                    <a href="<?=base_url()?>creator/edit_query/<?=$table->id?>" class="btn default"> Edit
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                    <a href="<?=base_url()?>creator/delete_query/<?=$table->id?>" class="btn red"> Delete <i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>