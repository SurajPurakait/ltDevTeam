function loadTaskDashboard(status, request, priority, officeID, departmentID, filter_assign, filter_data, sos_value, sort_criteria, sort_type, client_type, client_id, clients, pageNumber = 0) {
//   alert("hi");return false;
    $.ajax({
        type: "POST",
        data: {
            status: status,
            request: request,
            priority: priority,
            office_id: officeID,
            department_id: departmentID,
            filter_assign: filter_assign,
            filter_data: filter_data,
            sos_value: sos_value,
            sort_criteria: sort_criteria,
            sort_type: sort_type,
            client_type: client_type,
            client_id: client_id,
            page_number: pageNumber
        },
        url: base_url + 'task/task_dashboard_ajax',
        success: function (task_result) {
            if (task_result.trim() != '') {
                if (pageNumber == 1 || pageNumber == 0) {
                     $("#task_dashboard_div").html(task_result);
                    //$("a.filter-button span:contains('-')").html(0);
                } else {
                    $("#task_dashboard_div").append(task_result);
                    $('.result-header').not(':first').remove();
                }
                if (pageNumber != 0) {
                    $('.load-more-btn').not(':last').remove();
                }
                $(".status-dropdown").val(status);
                $(".request-dropdown").val(request);
                $("[data-toggle=popover]").popover();
            }
            // var filter_result = '';
            // if (filter_result != '') {
            //     $("#clear_filter").html(filter_result + ' &nbsp; ');
            //     $("#clear_filter").show();
            //     $('#btn_clear_filter').show();
            // } else {
            //     $("#clear_filter").html('');
            //     $("#clear_filter").hide();
            //     $('#btn_clear_filter').hide();
            // }
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
            jumpDiv();
            if(clients=='clients'){
                $("#task_dashboard_div").find(".clearfix").remove();
            }
        }
    });
}
function taskFilter() {
    var form_data = new FormData(document.getElementById('filter-form'));
    $.ajax({
        type: "POST",
        data: form_data,
        url: base_url + 'task/task_filter',
        dataType: "html",
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        cache: false,
        success: function (result) {
            //console.log("Result: " + result); return false;
            $("#task_dashboard_div").html(result);
            $("[data-toggle=popover]").popover();
            $("#clear_filter").show();
            $('#btn_clear_filter').show();
        },
        beforeSend: function () {
            openLoading();
        },
        complete: function (msg) {
            closeLoading();
        }
    });
}
function sort_task_dashboard(sort_criteria='',sort_type=''){
    var form_data = new FormData(document.getElementById('filter-form'));
//    alert(form_data.value);return false;
    if(sort_criteria==''){
      var sc = $('.dropdown-menu li.active').find('a').attr('id'); 
      var ex = sc.split('-');
        if(ex[0]=='project_template'){
            var sort_criteria = ex[0];
        }else{
            var sort_criteria = 'pt.'+ex[0];
        }      
    }
    if(sort_type==''){
      var sort_type = 'ASC';  
    }
    
    if (sort_criteria.indexOf('.') > -1)
    {
      var sp = sort_criteria.split(".");
      var activehyperlink = sp[1]+'-val';  
    }else{
        var activehyperlink = sort_criteria+'-val';
    }
    form_data.append('sort_criteria',sort_criteria);
    form_data.append('sort_type',sort_type);
    $.ajax({
                type: "POST",
                data: form_data,
                url: base_url + 'task/sort_task_dashboard',
                dataType: "html",
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                cache: false,
                success: function (action_result) {
//                    alert(action_result);return false;
                    var data = JSON.parse(action_result);   
                    $("#task_dashboard_div").html(data.result);
                   $(".dropdown-menu li").removeClass('active');
                   $("#"+activehyperlink).parent('li').addClass('active');
                   if(sort_type=='ASC'){
                    $(".sort_type_div #sort-desc").hide();
                    $(".sort_type_div #sort-asc").css({display: 'inline-block'});
                   }else{
                    $(".sort_type_div #sort-asc").hide();
                    $(".sort_type_div #sort-desc").css({display: 'inline-block'});
                   }
                   $(".sort_type_div").css({display: 'inline-block'});
                   var text = $('.dropdown-menu li.active').find('a').text();
//                   alert(text);return false;
                   var textval = 'Sort By : '+text+' <span class="caret"></span>'; 
                   $("#sort-by-dropdown").html(textval);
                    $("[data-toggle=popover]").popover();
                    // $("#clear_filter").html('');
                    // $("#clear_filter").hide();
                    //$('#btn_clear_filter').hide();
                    },
                    beforeSend: function () {
                        openLoading();
                    },
                    complete: function (msg) {
                        closeLoading();
                    }
                });
}