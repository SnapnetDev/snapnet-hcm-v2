@extends('layouts.master')
@section('stylesheets')
 <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/css/bootstrap-select.min.css">
@endsection
@section('content')
<!-- Page -->
  <div class="page ">
  	<div class="page-header">
  		<h1 class="page-title">{{__('Leave Graph Report')}}</h1>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
		    <li class="breadcrumb-item active">{{__('Leave Graph Report')}}</li>
		  </ol>
		  <div class="page-header-actions">
		    <div class="row no-space w-250 hidden-sm-down">

		      <div class="col-sm-6 col-xs-12">
		        <div class="counter">
		          <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

		        </div>
		      </div>
		      <div class="col-sm-6 col-xs-12">
		        <div class="counter">
		          <span class="counter-number font-weight-medium" id="time"></span>
		        </div>
		      </div>
		    </div>
		  </div>
	</div>
    
      <div class="page-content container-fluid">
      	<div class="row" data-plugin="matchHeight" data-by-row="true">
  <!-- First Row -->
  
  
  <!-- End First Row -->
  {{-- second row --}}
  <div class="col-ms-6 col-xs-6 col-md-6">
    <div class="panel panel-info panel-line">
		            <div class="panel-heading">
		              <h3 class="panel-title">Graph Report for All Leave Requests</h3>
		              <div class="panel-actions">
                      
                      <a class="btn btn-info" href="{{ url('leave/excel_report?year='.currentYear()) }}">Excel Report</a>
                  
                    </div>
		            	</div>
		            <div class="panel-body">
		            	
		      <canvas id="canvas" height="280" width="600"></canvas>
         
      </div>
  </div>

    </div>

    <div class="col-ms-6 col-xs-6 col-md-6">
    <div class="panel panel-info panel-line">
                <div class="panel-heading">
                  <h3 class="panel-title">Graph Report for Approved Leave Requests</h3>
                  <div class="panel-actions">
                      
                      <a class="btn btn-info" href="{{ url('leave/excel_report?year='.currentYear().'&type=approved') }}">Excel Report</a>
                  
                    </div>
                  </div>
                <div class="panel-body">
                  
          <canvas id="canvas_approved" height="280" width="600"></canvas>
         
      </div>
  </div>

    </div>

    <div class="col-ms-6 col-xs-6 col-md-6">
    <div class="panel panel-info panel-line">
                <div class="panel-heading">
                  <h3 class="panel-title">Graph Report for Pending Leave Requests</h3>
                  <div class="panel-actions">
                      
                      <a class="btn btn-info" href="{{ url('leave/excel_report?year='.currentYear().'&type=pending') }}">Excel Report</a>
                  
                    </div>
                  </div>
                <div class="panel-body">
                  
          <canvas id="canvas_pending" height="280" width="600"></canvas>
         
      </div>
  </div>

    </div>

    <div class="col-ms-6 col-xs-6 col-md-6">
    <div class="panel panel-info panel-line">
                <div class="panel-heading">
                  <h3 class="panel-title">Graph Report for Rejected Leave Requests</h3>
                  <div class="panel-actions">
                      
                      <a class="btn btn-info" href="{{ url('leave/excel_report?year='.currentYear().'&type=rejected') }}">Excel Report</a>
                  
                    </div>
                  </div>
                <div class="panel-body">
                  
          <canvas id="canvas_rejected" height="280" width="600"></canvas>
         
      </div>
  </div>

    </div>
  	
	</div>
</div>
</div>
  <!-- End Page -->
   @include('leave.modals.approve_request')
   {{-- Leave Request Details Modal --}}
   <div class="modal fade in modal-3d-flip-horizontal modal-info" id="leaveDetailsModal" aria-hidden="true" aria-labelledby="leaveDetailsModal" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg" >
        <div class="modal-content">        
          <div class="modal-header" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="training_title">Leave Request Details</h4>
          </div>
            <div class="modal-body">         
                <div class="row row-lg col-xs-12">            
                  <div class="col-xs-12" id="detailLoader"> 
                    
                  </div>
                  <div class="clearfix hidden-sm-down hidden-lg-up"></div>            
                </div>        
            </div>
            <div class="modal-footer">
              <div class="col-xs-12">
                
                  
                  <!-- End Example Textarea -->
                </div>
             </div>
         </div>
      </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script type="text/javascript" src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('global/vendor/chart-js/Chart.js')}}"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script> --}}
  <script type="text/javascript">
  	  $(document).ready(function() {
    $('.input-daterange').datepicker({
    autoclose: true,
    format:'yyyy-mm-dd'
});
   
    });
      
      function approve(leave_approval_id)
      {
         $(document).ready(function() {
             $('#approval_id').val(leave_approval_id);
          $('#approveLeaveRequestModal').modal();
        });
        
      }
      function getRandomColor() {
      var letters = '0123456789ABCDEF';
      var color = '#';
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    }

  </script>
  <script>
        var url = "{{url('leave/get_year_report?year=2019')}}";
        
        $(document).ready(function(){
          $.get(url, {year:{{currentYear()}}},function(response){


            console.log(response.datasets);
            let dt = [];
             $.each(response.datasets,function(k,v){
                  let rcolor = getRandomColor();
                dt.push({
                  label:v.label,
                  data:v.data,
                  backgroundColor: rcolor,
                  borderColor: rcolor,
                  hoverBackgroundColor: rcolor,
                  borderWidth: 2,
                });

             });

            // var barChartData = response;
            var barChartData = {
            labels: response.labels,
            datasets:dt
          };

          var myBar = new Chart(document.getElementById("canvas").getContext("2d"), {
            type: 'bar',
            data: barChartData,
            options: {
              responsive: true,
              scales: {
                xAxes: [{
                  display: true
                }],
                yAxes: [{
                  display: true,
                  ticks: {
                          beginAtZero:true
                              }
                }]
              }
            }
          });
            
          });
        });
        </script>
        <script>
        var url = "{{url('leave/get_year_report')}}";
        
        $(document).ready(function(){
          $.get(url,{year:{{currentYear()}},type:'approved'}, function(response){


            console.log(response.datasets);
            let dt = [];
             $.each(response.datasets,function(k,v){
                  
                dt.push({
                  label:v.label,
                  data:v.data,
                  backgroundColor: getRandomColor(),
                  borderColor: getRandomColor(),
                  hoverBackgroundColor: getRandomColor(),
                  borderWidth: 2,
                });

             });

            // var barChartData = response;
            var abarChartData = {
            labels: response.labels,
            datasets:dt
          };

          var amyBar = new Chart(document.getElementById("canvas_approved").getContext("2d"), {
            type: 'bar',
            data: abarChartData,
            options: {
              responsive: true,
              scales: {
                xAxes: [{
                  display: true
                }],
                yAxes: [{
                  display: true,
                  ticks: {
                          beginAtZero:true
                              }
                }]
              }
            }
          });
            
          });
        });
        </script>
        <script>
        var url = "{{url('leave/get_year_report')}}";
        
        $(document).ready(function(){
          $.get(url,{year:{{currentYear()}},type:'pending'}, function(response){


            console.log(response.datasets);
            let dt = [];
             $.each(response.datasets,function(k,v){
                  
                dt.push({
                  label:v.label,
                  data:v.data,
                  backgroundColor: getRandomColor(),
                  borderColor: getRandomColor(),
                  hoverBackgroundColor: getRandomColor(),
                  borderWidth: 2,
                });

             });

            // var barChartData = response;
            var pbarChartData = {
            labels: response.labels,
            datasets:dt
          };

          var pmyBar = new Chart(document.getElementById("canvas_pending").getContext("2d"), {
            type: 'bar',
            data: pbarChartData,
            options: {
              responsive: true,
              scales: {
                xAxes: [{
                  display: true
                }],
                yAxes: [{
                  display: true,
                  ticks: {
                          beginAtZero:true
                              }
                }]
              }
            }
          });
            
          });
        });
        </script>
       <script>
        var url = "{{url('leave/get_year_report')}}";
        
        $(document).ready(function(){
          $.get(url,{year:{{currentYear()}},type:'rejected'}, function(response){


            console.log(response.datasets);
            let dt = [];
             $.each(response.datasets,function(k,v){
                  
                dt.push({
                  label:v.label,
                  data:v.data,
                  backgroundColor: getRandomColor(),
                  borderColor: getRandomColor(),
                  hoverBackgroundColor: getRandomColor(),
                  borderWidth: 2,
                });

             });

            // var barChartData = response;
            var rbarChartData = {
            labels: response.labels,
            datasets:dt
          };

          var rmyBar = new Chart(document.getElementById("canvas_rejected").getContext("2d"), {
            type: 'bar',
            data: rbarChartData,
            options: {
              responsive: true,
              scales: {
                xAxes: [{
                  display: true
                }],
                yAxes: [{
                  display: true,
                  ticks: {
                          beginAtZero:true
                              }
                }]
              }
            }
          });
            
          });
        });
        </script>
@endsection