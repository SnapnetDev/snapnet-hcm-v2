@extends('layouts.app')

@section('content')

    <input type="hidden" value="{{csrf_token()}}" id="token"/>
    <div class="page-header">
        <h1 class="page-title">{{_t('Shares Allocations')}} {{ isset($search_title) ? $search_title : ' ' }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{_t('Home')}}</a></li>
            <li class="breadcrumb-item active">{{_t('You are Here')}}</li>
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
                        <span class="counter-number font-weight-medium" id="time">08:32:56 am</span>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="card card-block p-30 bg-success">
                <div class="counter counter-md text-xs-left">
                    <div class="counter-label text-uppercase m-b-5"><b>{{_t('Total Shares Vested')}}</b>
                    </div>
                    <div class="counter-number-group m-b-10">
                        <span class="counter-number" style="color: white">{{ number_format($vested) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="card card-block p-30 bg-info">
                <div class="counter counter-md text-xs-left">
                    <div class="counter-label text-uppercase m-b-5"><b>{{_t('Total Shares Pending')}}</b>
                    </div>
                    <div class="counter-number-group m-b-10">
                        <span class="counter-number" style="color: white">{{ number_format($pending) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div class="card card-block p-30 bg-primary">
                <div class="counter counter-md text-xs-left">
                    <div class="counter-label text-uppercase m-b-5"><b>{{_t('Total Shares')}}</b>
                    </div>
                    <div class="counter-number-group m-b-10">
                        <span class="counter-number" style="color: white">{{ number_format($total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <header class="panel-heading">
            <div class="panel-actions"></div>
            <h3 class="panel-title">
                <div class="row">
                    <div class="col-lg-7">
                        <button class="btn btn-primary" data-target="#exampleNiftyFadeScale"
                                data-toggle="modal" type="button">Allocate Shares
                        </button>
                    </div>
                    <div class="col-lg-5">
                        <form method="GET" action="{{url("/shares-allocations")}}" style="margin-right:-50px">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="icon fa fa-calendar" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control datepair-date datepair-start" id="startdate2" data-plugin="datepicker" name="date" autocomplete="off" value="{{ isset($date) ? $date : '' }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

            </h3>
        </header>
        <div class="panel-body">
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th>Staff</th>
                    <th>Number of SHARES</th>
                    <th>Start Date</th>
                    <th>Years Vested</th>
                    <th>Years Shares Vested</th>
                    <th>Shares Vested</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Staff</th>
                    <th>Number of Shares</th>
                    <th>Start Date</th>
                    <th>Years Vested</th>
                    <th>Years Shares Vested</th>
                    <th>Shares Vested</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($shares as $share)
                    <tr>
                        <td><a style="text-decoration: none;"
                               href="{{ url('/user-shares',$share->user->id) }}">{{$share->user->name}}</a></td>
                        <td>{{number_format($share->no_of_shares)}}</td>
                        <td>{{$share->start_date}}</td>
                        <td>{{$share->years_vested}}</td>
                        <td>{{$share->shares_vested->where('status','vested')->count()}}</td>
                        <td>{{number_format($share->shares_vested->where('status','vested')->sum('no_of_shares'))}}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1"
                                        data-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu"
                                     x-placement="bottom-start"
                                     style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" style="cursor:pointer;" id="{{$share->id}}"
                                       onclick="viewMore(this.id)">
                                        <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View Details</a>

                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Dropdown link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade modal-fade-in-scale-up" id="exampleNiftyFadeScale" aria-hidden="true"
         aria-labelledby="exampleModalTitle" role="dialog" >
        <div class="modal-dialog modal-simple">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Allocate New Share</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/shares-allocations') }}" method="Post">
                        {{ csrf_field() }}

                        <div class="example"  style="margin-bottom: 0px; margin-top: 0px">
                            <h4 class="example-title">Select Staff</h4>
                            <div class="form-group">
                                <select class="form-control select2-hidden-accessible" data-plugin="select2" data-select2-id="1" tabindex="-1" aria-hidden="true"
                                        name="user_id" id="user_id" required>
                                    @foreach($users as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="example"  style="margin-bottom: 0px  margin-top: 0px">
                                    <h4 class="example-title">Number of Shares</h4>
                                    <input type="number" class="form-control focus" id="inputFocus" name="no_of_shares"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="example"  style="margin-bottom: 0px;  margin-top: 0px">
                                    <h4 class="example-title">Years Vested</h4>
                                    <input type="number" class="form-control focus" id="inputFocus" name="years_vested"
                                           required>
                                </div>
                            </div>
                        </div>




                        <div class="example">
                            <h4 class="example-title">Share Start Date</h4>
                            <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="icon wb-calendar" aria-hidden="true"></i>
                                </span>
                                <input type="text" class="form-control" data-plugin="datepicker" name="date" required
                                       autocomplete="off">
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in modal-3d-flip-horizontal modal-info" id="viewMoreModal" aria-hidden="true"
         aria-labelledby="attendanceDetailsModal" role="dialog" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="training_title">Shares Breakdown</h4>
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

    <script>
        function viewMore(id) {
            $("#detailLoader").load('{{ url('/shares-getdetails') }}/' + id);
            $('#viewMoreModal').modal();
        }
    </script>

@endsection
@section('scripts')
    <script src="{{asset('global/vendor/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-tabletools/dataTables.tableTools.js')}}"></script>
    <script>
        $("#startdate2").datepicker({
            format: " yyyy", // Notice the Extra space at the beginning
            viewMode: "years",
            minViewMode: "years"
        });

        $(function (){
            setInterval(function(){
                $('#time').html(new Date(new Date().getTime()).toLocaleTimeString());
            },1000);
        });
    </script>
@endsection