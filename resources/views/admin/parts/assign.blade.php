<input type="hidden" name="supplier_id" class="supplier_id-{{$assignuserdata->id}}" value="{{$assignuserdata->id}}">
<div class="form-group mt-5 assignToSupplier-{{$assignuserdata->id}}" id="assignToSupplier">
    <label class="mb-0 text-capitalize">@lang('service_category.dashboard_admin_assign_to_user')</label>
    <input type="text" class="form-control  pl-0 userassign" value="{{$assignuserdata->username}}" onkeyup="finduser_{{$assignuserdata->id}}($(this).val())" placeholder="Search By User Name">
    <i class="icon-search"></i>
    <div class="search-result d-none">
        <button type="button" onclick="hiddenSearch()" class="btn lead"> x </button>
        <ul class="searchusers"></ul>
        <ul class="searchloader d-none">
            <li class="text-center">
                <img src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
            </li>
        </ul>
        <ul class="noresult d-none">
            <li class='cat_title'>@lang('general.search_no_result')</li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function hiddenSearch(){
        $('.search-result').addClass('d-none');
        $('#assignToSupplier .form-control').val('');
    }
    function finduser_{{$assignuserdata->id}}(search){
        var content = "";
        if (search.length < 3) {
            if (search.length == 0) {
                $('.search-result').addClass('d-none');
            }
        }else{
            // search in result
            $.ajax({type: 'GET', url: "{{ url('api/getusers') }}?free_text="+search, 
                    dataType: "html",
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    beforeSend: function(){
                        $('.searchloader').removeClass('d-none');
                        $('.searchusers').addClass('d-none');
                    },
                    // contentType: false,
                    processData:false,
                    success: function (message) {
                        $('.search-result').removeClass('d-none');
                        $('.searchusers').removeClass('d-none');
                        $('.searchloader').addClass('d-none');
                        var users = JSON.parse(message).user_pagination.data;
                        if (users) {
                            for (var i = users.length - 1; i >= 0; i--) {
                                    content = content+"<li><button type='button' onclick=\"$('.supplier_id-{{$assignuserdata->id}}').val("+users[i].id+");hiddenSearch();$('.assignToSupplier-{{$assignuserdata->id}}>.userassign').val('"+users[i].username+"')\">"+users[i].username+"</button></li>";
                            }
                            $('.assignToSupplier-{{$assignuserdata->id}} .searchusers').empty().append(content);
                            $('.assignToSupplier-{{$assignuserdata->id}} .noresult').addClass('d-none');
                        }else{
                            $('.assignToSupplier-{{$assignuserdata->id}} .searchusers').addClass('d-none').empty();
                            $('.assignToSupplier-{{$assignuserdata->id}} .noresult').removeClass('d-none');
                        }
                    },
                    error: function (message) {
                        $('.search-result').removeClass('d-none');
                        $('.searchusers').addClass('d-none').empty();
                        $('.searchloader').addClass('d-none');
                        $('.assignToSupplier-{{$assignuserdata->id}}> .noresult').removeClass('d-none');
                    }
            });

        }
    }
</script>
