@extends('layouts.app')

@section('content')

    <input type="hidden" value="{{csrf_token()}}" id="token"/>
    <div class="page-header">
        <h1 class="page-title">{{_t('My Commissions')}}:  {{$user->name}}</h1>
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

   {{-- <div class="panel">

        <header class="panel-heading">
            <div class="panel-actions"></div>
            <h3 class="panel-title">
                My Commissions
            </h3>
        </header>
        <div class="panel-body">
            <div class="col-xxl-3 col-xl-6 col-md-12">
                <!-- Panel Pie -->
                <div class="card card-shadow" id="chartPie">
                    <div class="card-block p-0 p-30 h-full">
                        <div class="font-size-20 text-center" style="height:calc(100% - 350px);">
                            Summary of
                            <div class="dropdown vertical-align-bottom font-size-20">
                                <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"
                                     style="cursor: pointer;"
                                     role="complementary">
                                    Last month
                                </div>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">The month before
                                        last</a>
                                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem">Three months
                                        ago</a>
                                </div>
                            </div>
                        </div>
                        <div class="ct-chart h-250"></div>
                        <div class="row no-space mt-40">
                            <div class="col-4">
                                <div class="counter">
                                    <div class="counter-number-group font-size-14">
                                      <span class="counter-number-related">
                                        <span class="icon wb-medium-point purple-600"></span>
                                      </span>
                                        <span class="counter-number font-size-24">35%</span>
                                        <span class="counter-number-related font-size-14">42</span>
                                    </div>
                                    <div class="counter-label text-uppercase">TYPE A</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="counter">
                                    <div class="counter-number-group font-size-14">
                                          <span class="counter-number-related">
                                            <span class="icon wb-medium-point red-600"></span>
                                          </span>
                                        <span class="counter-number font-size-24">20%</span>
                                        <span class="counter-number-related font-size-14">24</span>
                                    </div>
                                    <div class="counter-label text-uppercase">TYPE B</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="counter text-center">
                                    <div class="counter-number-group font-size-14">
                                      <span class="counter-number-related">
                                        <span class="icon wb-medium-point blue-600"></span>
                                      </span>
                                        <span class="counter-number font-size-24">45%</span>
                                        <span class="counter-number-related font-size-14">54</span>
                                    </div>
                                    <div class="counter-label text-uppercase">TYPE C</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Panel Pie -->
            </div>
        </div>
    </div>--}}

    <div class="panel">
        <header class="panel-heading">
            <div class="panel-actions"></div>
            <h3 class="panel-title">
                My Commissions history
            </h3>
        </header>
        <div class="panel-body">
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Project Name</th>
                    <th>Project Amount</th>
                    <th>Project Status</th>
                    <th>Project Project Status</th>
                    <th>My Commission</th>
                    <th>Payment Status</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Client Name</th>
                    <th>Project Name</th>
                    <th>Project Amount</th>
                    <th>Project Status</th>
                    <th>Project Project Status</th>
                    <th>My Commission</th>
                    <th>Payment Status</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($commissions as $staff_commission)
                    <tr>
                        <td>{{$staff_commission->opportunity->client_id}}</td>
                        <td>{{$staff_commission->opportunity->project_name}}</td>
                        <td>{{number_format($staff_commission->opportunity->project_amount,2)}}</td>
                        <td>{{$staff_commission->opportunity->project_status}}</td>
                        <td>{{$staff_commission->opportunity->payment_status}}</td>
                        <td>{{number_format($staff_commission->commission,2)}}</td>
                        <td>{{$staff_commission->payment_status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(function () {
            setInterval(function () {
                $('#time').html(new Date(new Date().getTime()).toLocaleTimeString());
            }, 1000);
        });
    </script>
@endsection

@section('script')
    <script src="{{asset('global/vendor/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-tabletools/dataTables.tableTools.js')}}"></script>
@endsection
