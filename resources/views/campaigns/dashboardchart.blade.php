@extends('master')
<style>
    .container-fluid {
        margin-top: 20px;
    }

    .form-group {
        text-align: center;
    }
    #heading {
        margin-top: 15px;
        background-color: #d8dde2;
        font-family: serif;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('main-content')
    <main>
        <form action="{{route('dashboardchart')}}" method="get" id="myForm">
        <div class="container" style="margin-left: 344px;">
            <div class="row">
                <div class='col-sm-6'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type="hidden" id="startDate" name="startDate" value="" />
                            <input type="hidden" id="endDate" name="endDate"  value="" />
                            <h4><span class="badge bg-secondary" style="margin-top: 10;margin-right: 15;">Choose Date</span>
                            </h4><input type='date' name="selectdate"  id="selectdate" class="form-control" style="margin-top: 8px;" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

        <table class="table">
            <thead class="table">
                <tr>
                    <h2><th scope="col" id="heading" style="text-align: center;font-size: 22px;">Campaign's Details</th></h2>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="container-fluid px-4">
                            <div class="row">
                                @foreach ($camp as $key => $values)
                                    <div class="col-xl-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class='fas fa-bullhorn' style='font-size:17px'></i>
                                                {{ $values['campaign_name'] }}'s Details
                                            </div>
                                            <div class="card-body"><canvas id="myBarChart_{{ $key }}" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            {{ $camp->appends(request()->query())->links() }}
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </main>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var start = moment().subtract(29, 'days');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('input[name="selectdate"]').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $("#selectdate").on('change', function(e) {

                $('#startDate').val($('#selectdate').data('daterangepicker').startDate.format('YYYY-MM-DD'));
                $('#endDate').val($('#selectdate').data('daterangepicker').endDate.format('YYYY-MM-DD'));
                document.getElementById("myForm").submit();
            });

        });
        var leadsData = JSON.parse('{!! json_encode($leadsData) !!}');
    </script>
@endsection
