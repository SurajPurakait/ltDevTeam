var base_url = document.getElementById('base_url').value;

/* royalty report */
function loadRoyaltyReportsData(office = '',date_range = '') {
    $('#reports-tab').DataTable().destroy();

    $('#reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'scrollX':true,
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'RoyaltyReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ],
        'columnDefs': [
            { width: '100px', targets: 0 }
        ],
        'serverMethod': 'post',
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_royalty_reports_data',
            'type': 'POST',
            'data': {'ofc': office,'daterange':date_range},
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {
                data: 'date',
                render: function ( data, type, row ) {
                    return data.split('-')[1]+'-'+data.split('-')[2]+'-'+data.split('-')[0];
                }
            },
            {data: 'client_id'},
            {data: 'invoice_id'},
            {data: 'service_id'},
            {data: 'office_id_name'},
            {data: 'service_name'},
            {data: 'retail_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'override_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'payment_status'},
            {data: 'collected',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'payment_type'},
            {data: 'authorization_id'},
            {data: 'reference'},
            {data: 'total_net',render: $.fn.dataTable.render.number(',', '.', 2, '$')},
            {data: 'office_fee',render: $.fn.dataTable.render.number(',', '.', 0,'','%')},
            {data: 'fee_with_cost',render: $.fn.dataTable.render.number(',', '.', 2,'$')},
            {data: 'fee_without_cost',render: $.fn.dataTable.render.number(',', '.', 2,'$')}
        ],
        'columnDefs': [
            { width: '100px', targets: 0 }
        ],
    });
}
/* royalty report total calculation */
function get_total_royalty_report(office = '',date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/royalty_reports_totals',
        data: {'ofc': office,'daterange':date_range},
        success: function (result) {
            $("#total").html(result);
        },
    });
}

/* weekly sales report */
function loadSalesReportsData(office = '',date_range = '') {
    $('#sales-reports-tab').DataTable().destroy();

    $('#sales-reports-tab').DataTable({
        'processing': false,
        'serverSide': true,
        'scrollX':true,
        'dom': '<"html5buttons"B>lTfgitp',
        'buttons': [ 
            {extend: 'excel', title: 'SalesReport'},
            {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
            }
            }
        ],
        'columnDefs': [
            { width: '100px', targets: 0 }
        ],
        'serverMethod': 'post',
        'serverMethod': 'post',
        'ajax': {
            'url': base_url + 'reports/get_weekly_sales_report_data',
            'type': 'POST',
            'data': {'ofc': office,'daterange':date_range},
            beforeSend: function () {
                openLoading();
            },
            complete: function (msg) {
                closeLoading();
            }
        },
        'columns': [
            {
                data: 'date',
                render: function ( data, type, row ) {
                    return data.split('-')[1]+'-'+data.split('-')[2]+'-'+data.split('-')[0];
                }
            },
            {data: 'client_id'},
            {data: 'service_id'},
            {data: 'service_name'},
            {data: 'status'},
            {data: 'retail_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'override_price',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'cost',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'collected',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'total_net',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'franchisee_fee',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'gross_profit',render: $.fn.dataTable.render.number( ',', '.', 2, '$' )},
            {data: 'notes'}
        ]
    });
}

/* sales report total calculation */
function get_total_sales_report(office = '',date_range = '') {
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/weekly_sales_reports_totals',
        data: {'ofc': office,'daterange':date_range},
        success: function (result) {
            $("#total_sales_data").html(result);
        },
    });
}

// report service section js
function show_service_franchise_result(category='',date_range = '') {
    // alert(date_range);return false;
    if (category == 'franchise') {
        $("#service_by_franchise").toggle();
    } else if(category == 'department') {
        $("#service_by_department").toggle();
    } else if (category == 'service_category') {
        $("#service_by_category").toggle();
    }  
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_service_by_franchise_data',
        data: {'category': category,'date_range':date_range},
        success: function (result) {
            // console.log(result);
            if (category == 'franchise') {
                $("#service_by_franchise").html(result);
            } else if(category == 'department') {
                $("#service_by_department").html(result);
            } else if (category == 'service_category') {
                $("#service_by_category").html(result);
            }
        },
    });
}

// report billing section js
function show_billing_data(date_range = '') {
    $("#billing_invoice_payments").toggle();
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_show_billing_data',
        data: {'date_range':date_range},
        success: function (result) {
            $("#billing_invoice_payments").html(result);
        },
    });
}

// report billing section js
function show_action_data(category,date_range = '') {
    if (category == 'action_by_office') {
        $("#action_by_office").toggle();
    } else if(category == 'action_to_office') {
        $("#action_to_office").toggle();
    } else if (category == 'action_by_department') {
        $("#action_by_department").toggle();
    } else if (category == 'action_to_department') {
        $("#action_to_department").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_action_data',
        data: {'category': category,'date_range':date_range},
        success: function (result) {
            if (category == 'action_by_office') {
                $("#action_by_office").html(result);
            } else if(category == 'action_to_office') {
                $("#action_to_office").html(result);
            } else if (category == 'action_by_department') {
                $("#action_by_department").html(result);
            } else if (category == 'action_to_department') {
                $("#action_to_department").html(result);
            }
        },
    });
}

// report project section js
function show_project_data(category,date_range = '') {
    if (category == 'projects_by_office') {
        $("#projects_by_office").toggle();
    } else if(category == 'tasks_by_office') {
        $("#tasks_by_office").toggle();
    } else if (category == 'projects_to_department') {
        $("#projects_to_department").toggle();
    } else if (category == 'tasks_to_department') {
        $("#tasks_to_department").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_project_data',
        data: {'category': category,'date_range':date_range},
        success: function (result) {
            if (category == 'projects_by_office') {
                $("#projects_by_office").html(result);
            } else if(category == 'tasks_by_office') {
                $("#tasks_by_office").html(result);
            } else if (category == 'projects_to_department') {
                $("#projects_to_department").html(result);
            } else if (category == 'tasks_to_department') {
                $("#tasks_to_department").html(result);
            }
        },
    });    
}

// report lead section js
function show_lead_data(category,date_range = '') {   
    if (category == 'status') {
        $("#leads_by_status").toggle();
    } else if(category == 'type') {
        $("#leads_by_type").toggle();
    } else if (category == 'mail_campaign') {
        $("#leads_email_campaign").toggle();
    }
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_leads_data',
        data: {'category': category,'date_range':date_range},
        success: function (result) {
            if (category == 'status') {
                $("#leads_by_status").html(result);
            } else if(category == 'type') {
                $("#leads_by_type").html(result);
            } else if (category == 'mail_campaign') {
                $("#leads_email_campaign").html(result);
            }
        },
    });
}

// report partner section js
function show_partner_data(date_range = '') {  
    $("#partners_by_type").toggle();
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_partner_data',
        data: {'date_range':date_range},
        success: function (result) {
            $("#partners_by_type").html(result);
        },
    });    
}

// report service section js
function show_clients_data(category) {
    if (category == 'clients_by_office') {
        $("#total_clients_by_office").toggle();
    } else if(category == 'business_clients_by_office') {
        $("#business_clients_by_office").toggle();
    } else if (category == 'individual_clients_by_office') {
        $("#individual_clients_by_office").toggle();
    }  
    $.ajax({
        type: 'POST',
        url: base_url + 'reports/get_clients_data',
        data: {'category': category},
        success: function (result) {
            // console.log(result);
            if (category == 'clients_by_office') {
                $("#total_clients_by_office").html(result);
            } else if(category == 'business_clients_by_office') {
                $("#business_clients_by_office").html(result);
            } else if (category == 'individual_clients_by_office') {
                $("#individual_clients_by_office").html(result);
            }
        },
    });
}

function pieChart(className) {
    $('.' + className).each(function () {
        var element = '#' + $(this).attr('id');
        var size = $(this).attr('data-size');
        if (parseInt(size) > 1) {
            // Basic setup
            // ------------------------------
            var dataVariable = $(this).attr('data-json');

            // Add data set
            var data = window[dataVariable];

            // Main variables
            var d3Container = d3.select(element),
                    distance = 2, // reserve 2px space for mouseover arc moving
                    radius = (size / 2) - distance,
                    sum = d3.sum(data, function (d) {
                        return d.value;
                    });
            // Tooltip
            // ------------------------------
            var tip = d3.tip()
                    .attr('class', 'd3-tip')
                    .offset([-10, 0])
                    .direction('e')
                    .html(function (d) {
                        return "<ul class='list-unstyled mb-5'>" +
                                "<li>" + "<span class='text-semibold pull-right'>" + d.data.section_label + ' : ' + d.value + "</span>" + "</li>" +
                                "</ul>";
                    });
            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg").call(tip);

            // Add SVG group
            var svg = container
                    .attr("width", size)
                    .attr("height", size)
                    .append("g")
                    .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");
            // Construct chart layout
            // ------------------------------

            // Pie
            var pie = d3.layout.pie()
                    .sort(null)
                    .startAngle(Math.PI)
                    .endAngle(3 * Math.PI)
                    .value(function (d) {
                        return d.value;
                    });

            // Arc
            var arc = d3.svg.arc()
                    .outerRadius(radius)
                    .innerRadius(radius / 2);
            //
            // Append chart elements
            //
            // Group chart elements
            var arcGroup = svg.selectAll(".d3-arc")
                    .data(pie(data))
                    .enter()
                    .append("g")
                    .attr("class", "d3-arc")
                    .style('stroke', '#fff')
                    .style('cursor', 'pointer');

            // Append path
            var arcPath = arcGroup
                    .append("path")
                    .style("fill", function (d) {
                        return d.data.color;
                    });
            // Add tooltip
            arcPath
                    .on('mouseover', function (d, i) {

                        // Transition on mouseover
                        d3.select(this)
                                .transition()
                                .duration(500)
                                .ease('elastic')
                                .attr('transform', function (d) {
                                    d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                                    var x = Math.sin(d.midAngle) * distance;
                                    var y = -Math.cos(d.midAngle) * distance;
                                    return 'translate(' + x + ',' + y + ')';
                                });
                    })
                    .on("mousemove", function (d) {

                        // Show tooltip on mousemove
                        tip.show(d)
                                .style("top", (d3.event.pageY - 40) + "px")
                                .style("left", (d3.event.pageX + 30) + "px");
                    })

                    .on('mouseout', function (d, i) {

                        // Mouseout transition
                        d3.select(this)
                                .transition()
                                .duration(500)
                                .ease('bounce')
                                .attr('transform', 'translate(0,0)');

                        // Hide tooltip
                        tip.hide(d);
                    });

            // Animate chart on load
            arcPath
                    .transition()
                    .delay(function (d, i) {
                        return i * 500;
                    })
                    .duration(500)
                    .attrTween("d", function (d) {
                        var interpolate = d3.interpolate(d.startAngle, d.endAngle);
                        return function (t) {
                            d.endAngle = interpolate(t);
                            return arc(d);
                        };
                    });
        }
    });
}
