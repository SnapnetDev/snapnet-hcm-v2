@extends('layouts.app')

@section('content')

    <input type="hidden" value="{{csrf_token()}}" id="token"/>
    <div class="page-header">
        <h1 class="page-title">{{_t('Staff Commissions for ')}} {{ $opportunity->project_name }} with {{ $opportunity->client_id }}</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{_t('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/opportunities') }}">{{_t('Opportunities')}}</a></li>
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

   @include('commissions.modal.add_commission')
    <div class="panel">

        <header class="panel-heading">
            <div class="panel-actions"></div>
            <h3 class="panel-title">
                <button class="btn btn-outline btn-default" data-target="#exampleNiftyFadeScale"
                        data-toggle="modal" type="button">Add Commission to Staff
                </button>
            </h3>
        </header>
        <div class="panel-body">
            <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                <thead>
                <tr>
                    <th>Staff</th>
                    <th>Expected</th>
                    <th>Commission</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Staff</th>
                    <th>Expected</th>
                    <th>Commission</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($staff_commissions as $staff_commission)
                    <tr>
                        <td><a style="text-decoration: none;" href="{{ url('user/commissions',$staff_commission->user->id) }}">{{$staff_commission->user->name}}</a></td>
                        <td>{{number_format($staff_commission->expected_commission,2)}}</td>
                        <td>{{number_format($staff_commission->commission,2)}}</td>
                        <td>{{$staff_commission->payment_status}}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" id="exampleIconDropdown1" data-toggle="dropdown" aria-expanded="false">
                                   Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="exampleIconDropdown1" role="menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 36px, 0px); top: 0px; left: 0px; will-change: transform;">
                                   {{-- <a class="dropdown-item"   href="#" role="menuitem">Edit Commission</a>--}}
                                    @if($staff_commission->payment_status!='paid')
                                    <a class="dropdown-item" href="{{ url('pay-staff-commission',$staff_commission->id) }}" role="menuitem">Pay Commission</a>
                                    @endif
                                    @if($staff_commission->payment_status!='paid')
                                    <a class="dropdown-item" href="#" onclick="deleteCommission({{ $staff_commission->id }})" role="menuitem">Delete Commission</a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End Panel Basic -->

    <script>
        $(function (){
            setInterval(function(){
                $('#time').html(new Date(new Date().getTime()).toLocaleTimeString());
            },1000);
        });
    </script>
@endsection

@section('script')
    <script src="{{asset('global/vendor/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{asset('global/vendor/datatables-tabletools/dataTables.tableTools.js')}}"></script>

    <script>
        function deleteCommission(id){
            var txt;
            var r = confirm("Are you sure you want to delete this commission?");
            if (r == true) {
                deleteCom(id)
            } else {
                toastr.error('It was not approved');
            }
        }

        function deleteCom(id){
            var token = '{{csrf_token()}}';
            senddata={'_token':token,'commission_id':id,'type':'delete'};
            $.ajax({
                url: '{{url('commissions')}}',
                type: 'POST',
                data: senddata,
                success: function (data, textStatus, jqXHR) {
                    toastr.success('Successfully Deleted Commission');
                    console.log(data)
                      setTimeout(function () {
                          window.location.reload();
                      }, 2000);
                },
                error: function (data, textStatus, jqXHR) {

                }
            });
        }
        $(function () {
            $(document).on('submit', '#addCommissionForm', function (event) {
                $("#addCommissionFormSubmit").hide();
                $("#loader").show();
                var form = $(this);
                var formdata = false;
                if (window.FormData) {
                    formdata = new FormData(form[0]);
                }
                $.ajax({
                    url: '{{ url('/commissions') }}',
                    data: formdata ? formdata : form.serialize(),
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (data, textStatus, jqXHR) {
                        if (data.status==='success'){
                            toastr.success(data.details);
                            $('#addCommissionForm').trigger("reset");
                            $("#addCommissionFormSubmit").show();
                            $("#loader").hide();
                            location.reload();
                        }
                        else {
                            toastr.error(data.details);
                        }
                    },
                    error: function (data, textStatus, jqXHR) {

                    }
                });
                return event.preventDefault();
            });
        });
    </script>
@endsection
