@extends('layout.main')
@section('styles')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">

@endsection
@section('content')


<div class="box-body">

  <div class="row">

    {!! Form::open(array('id'=>'search_form', )) !!}
    <div class="col-md-3">

     <div class="form-group">
      <label>Please select one of the projects</label>
      <select id="sub-user" name="sub_user"  style="width: 100%;" class="col-lg-8 form-control" >

        @if(isset($sub_users))
        @foreach($sub_users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
        <option value="all">All</option>
        @else
        <option value="-1">No projecs has been assigned for you yet</option>
        @endif

      </select>
    </div>

  </div>

  <div class="col-md-2">
    <div class="form-group">
      <label>Start Date</label>

      <div class="input-group date">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right onchange" name="start_date" data-date-format="dd-mm-yyyy" id="start-date" placeholder="Start Date">
      </div>
      <!-- /.input group -->
    </div>
  </div>

  <div class="col-md-2">
    <div class="form-group">
      <label>End Date</label>

      <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right onchange" name="end_date" data-date-format="dd-mm-yyyy" id="end-date" placeholder="End Date">
      </div>
      <!-- /.input group -->
    </div>
  </div>

  <div class="col-md-2"style="padding-top:24px;" >
   <div class="form-group">
    <button type="submit" class="btn  btn-success" id="search-query">Search</button>
  </div>
</div>
{!! Form::close() !!}

</div>


<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Previous Time Log</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="time-log" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Project Name</th>
              <th>Date</th>
              <th>Time</th>
              <th>Activity</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>

            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>






</div>





@endsection
@section('script')


<script src="{{asset('dist/js/utils.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('dist/js/utils.js')}}"></script>
<script >


$('#start-date').datepicker({

  autoclose: true

});

$('#end-date').datepicker({

  autoclose: true

});



$('#search_form').submit(function( event ){

  event.preventDefault();

  var not_empty = true;

  var user_id = $("#sub-user").val();


  var start_date=  $("#start-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

  var end_date=$("#end-date").datepicker({ dateFormat: 'dd-mm-yy' }).val();

  if(start_date!="" && end_date!=""){
    not_empty = true;
  }else{
    not_empty = false;
  }

  if(user_id == -1){
    alert("You do not have any subordinates yet!");
    return;
  }

  

  if(not_empty){

    var startDate=  $("#start-date").datepicker('getDate');
    var endDate=$("#end-date").datepicker('getDate');

    //
    if(calcDaysBetween(startDate, endDate) < 0){
      alert("dates are not properly set please check!");
      return;
    };




    var table = $('#time-log').DataTable( {
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "ajax": "{{URL::to('/')}}/timesheet/lineManager_to_accountManager/old_records/"+user_id+"/"+start_date+"/"+end_date,
      "columns": [
      { "data": "project_name" },
      { "data": "date" },
      { "data": "time_spent" },
      { "data": "activity" },
      { "data": "action", name: 'action', orderable: false, searchable: false}
      ],
      "order": [[1, 'asc']]
    } );

  }else{
    alert("please set the dates!");
    return;
  } 


});

</script>
@endsection


























