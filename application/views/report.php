  <!--Load the AJAX API-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Sec1', 3],
          ['Sec2', 1],
          ['Sec3', 1],
        
        ]);

        // Set chart options
        var options = {
                       'width':200,
                       'height':150};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        var options = {
                       'width':250,
                       'height':150};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div_new'));
        chart.draw(data, options);

        
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        var options = {
                       'width':250,
                       'height':150};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div_new_one'));
        chart.draw(data, options);

        
      }

      
    </script>

    <style>



    </style>

<div class="wrapper wrapper-content">
<div class="row">
        <div class="col-lg-12">
            <div class="float-e-margins">
                <div class="ibox-content">
                
                <h2 class="text-primary">Action by Departments (2 Options here: To departments and from department)</h2>     
                
              <div class="row">

              <div class="col-lg-9 m-t-20">
               
              <div class="form-group">
                            <label class="col-lg-2 m-t-5 control-label">Select Period :</label>
                            <div class="col-lg-5">

                            <input type="text" class="form-control" id="reportrange" placeholder="Select Period">
                                       
                            </div>
                        </div>

                        
                
 <table width="100%"  class="table table-bordered m-t-70" >
  <tr>
  <td></td>
    <td><b>Totals</b> </td>
    <td> <b>Not Started (%)  </b> </td>
    <td><b>Started(%)</b> </td>
    <td><b>Completed (%) </b></td>
    <td><b>From Creative  Date</b> </td>
    <td><b>SOS</b></td>
    
  </tr>
  <tr>
    <td><b>Data</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td><b>Bookkeeping </b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td><b>Government</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td><b>Billing</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td><b>IT</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td><b>LeafNet</b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                </div>

                <div class="col-md-3">

                         <div id="chart_div"></div> 
                         
                         <div id="chart_div_new"></div>

                         <div id="chart_div_new_one"></div>    

                 </div>

                </div>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});
</script>
