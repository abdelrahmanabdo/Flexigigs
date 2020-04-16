<div class="search input-group col-sm-12" id="autocompleteSearch">
    <input type="text" onkeyup="search($(this).val())" class="text-white form-control" placeholder="@lang('general.search_placeholder')" aria-label="@lang('general.search_placeholder')">
    <a href="#" class="resultslink search-inner-btn btn d-md-flex">
		<span class="d-none d-sm-inline-block">@lang('general.search')</span>
		<span class="fas fa-search d-sm-none d-inline-block"></span>
	</a>
	<div class="search-result d-none">
        <button onclick="hiddenSearch()" class="btn lead"> x </button>
        <ul class="searchcats"></ul>
        <ul class="searchservices"></ul>
        <ul class="searchgigs"></ul>
        <ul class="searchloader d-none">
            <li class="text-center">
                <img src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
            </li>
        </ul>
        <ul class="noResult">
            <li class='cat_title'>@lang('general.search_no_result')</li>
        </ul>
        <ul class="allResult">
            <li class="allResult-link"> <a href="#" class="text-primary text-uppercase font-weight-bold resultslink" id="results">@lang('general.search_show_all')</a> </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function hiddenSearch(){
        $('.form-control').val('');
        $('.search-result').addClass('d-none');
    }
    function search(text){
        if (text.length < 3) {
            $('.search-result').addClass('d-none');
        }else{
            $('.search-result').removeClass('d-none');
            $('.searchloader').removeClass('d-none');
            $.when(
                // search in category
                $.ajax({type: 'GET', url: "{{ url(app()->getLocale().'/categories/filterCategory') }}", 
                        data: "name{{(app()->getLocale()=='ar')?'_ar':''}}="+text+"&limit=4&_token="+$('meta[name="csrf-token"]').attr('content'),
                        beforeSend: function(){$('.searchcats').addClass('d-none'); },
                        contentType: false,
                        processData:false,
                        success: function (request) {
                        $('.searchcats').removeClass('d-none');
                       category_status = request.status;
                        if (request.category) {
                            var content = "<li class='cat_title'>@lang('general.search_categories')</li>";
                            for (var i = request.category.length - 1; i >= 0; i--) {
                                if(!request.category[i].parent && !request.category[i].sub){
                                    content = content+"<li class='pl-3 pr-3'><a href='{{url('/'.app()->getLocale())}}"+"/"+request.category[i].slug+"'><p>"+request.category[i].name+"</p></a></li>";
                                }else if(request.category[i].sub){
                                    content = content+"<li class='pl-3 pr-3'><a href='{{url('/'.app()->getLocale())}}"+"/"+request.category[i].parent+"/"+request.category[i].sub+"/"+request.category[i].slug+"'><p>"+request.category[i].name+"</p></a></li>";
                                }else if(!request.category[i].sub && request.category[i].parent){
                                    content = content+"<li class='pl-3 pr-3'><a href='{{url('/'.app()->getLocale())}}"+"/"+request.category[i].parent+"/"+request.category[i].slug+"'><p>"+request.category[i].name+"</p></a></li>";
                                }
                            }
                            $('.searchcats').empty().append(content);
                        }else{
                            $('.searchcats').addClass('d-none').empty();
                        }
                    },
                    error: function (message) {
                        $('.searchcats').addClass('d-none').empty();
                    }
            }),
            // search in services
            $.ajax({type: 'GET', url: "{{ url('api/filterservices') }}", 
                    data: "free_text="+text+"&limit=4",
                    headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                    beforeSend: function(){
                        $('.searchservices').addClass('d-none');
                    },
                    contentType: false,
                    processData:false,
                    success: function (results) {
                        $('.searchservices').removeClass('d-none');
                        service_status = results.status;
                        if (results.result) {
                            var servicecontent = "<li class='cat_title'>@lang('general.search_services')</li>";
                            for (var i = results.result.length - 1; i >= 0; i--) {
                                    servicecontent = servicecontent+"<li class='pl-3 pr-3'><a href='{{url('/'.app()->getLocale())}}"+"/service/details/"+results.result[i].id+"'><p>"+results.result[i].name+"</p></a></li>";
                            }
                            $('.searchservices').empty().append(servicecontent);
                        }else{
                            $('.searchservices').addClass('d-none').empty();
                        }
                    },
                    error: function (results) {
                        $('.searchservices').addClass('d-none').empty();
                    }
            }),
            // search in gigs
            $.ajax({type: 'GET', url: "{{ url('api/gigs/filter') }}", 
                data: "free_text="+text+"&limit=4&page=1",
                beforeSend: function(){
                    $('.searchgigs').addClass('d-none');
                },
                headers: {"authorization": "Bearer {{Flexihelp::auth()}}"},
                contentType: false,
                processData:false,
                success: function (gigsresults) {
                    $('.searchgigs').removeClass('d-none');
                    if (gigsresults.result) {
                        gig_status = gigsresults.status;
                        $('.noResult').addClass('d-none');
                        var gigcontent = "<li class='cat_title'>Gigs</li>";
                        for (var i = gigsresults.result.length - 1; i >= 0; i--) {
                            gigcontent = gigcontent+"<li class='pl-3 pr-3'><a href='{{url('/'.app()->getLocale())}}"+"/gig/details/"+gigsresults.result[i].id+"'><p>"+gigsresults.result[i].title+"</p></a></li>";
                        }
                        $('.searchgigs').empty().append(gigcontent);
                    }else{
                        $('.searchgigs').addClass('d-none').empty();
                    }
                },
                error: function (gigsresults) {
                    $('.searchgigs').addClass('d-none').empty();
                }
            })

            ).then(function(category,service,gig){
                $('.resultslink').attr('href',"{{url(app()->getLocale().'/search/services')}}?free_text="+text);
                $('.searchloader').addClass('d-none');
                if ( category[0].status||service[0].status||gig[0].status) {
                    $('.noResult').addClass('d-none');
                    $('.allResult').removeClass('d-none');
                }else{
                    $('.noResult').removeClass('d-none');
                    $('.allResult').addClass('d-none');
                }
            },function(error){
                $('.searchloader').addClass('d-none');
                if ( $('#searchcats li').length > 1||$('#searchservices li').length > 1||$('#searchgigsul li').length > 1) {
                    $('.noResult').addClass('d-none');
                    $('.allResult').removeClass('d-none');
                }else{
                    $('.noResult').removeClass('d-none');
                    $('.allResult').addClass('d-none');
                }
                console.log('error',error);
            });
        }
    }
</script>
