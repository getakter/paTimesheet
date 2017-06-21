	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Add/edit projects</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('url'=>'/user/submit_porjects', 'id'=>'project-issue-form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name of the program" value="{{$user->name}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="user_email" id="user-email" placeholder="please enter the code" value="{{$user->email}}" readonly>   
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-lg-12">
          <table id="project-table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th style="text-align: center; width:30%;">Project name</th>
                <th style="text-align: center; width:20%;">Project code</th>
                <th style="text-align: center; width:20%">Allocate days</th>
                <th style="text-align: center; width:20%">Allocate time (%)</th>
                <th style="text-align: center;">Add</th>
              </tr>
            </thead>

            <thead>

              <tr>
                <form id="voucher-info">
                  <th>
                    <select style="width: 100%; margin-left:8px;" class="form-control select2" id="project-name" name="project_name">
                    </select>

                  </th>
                  <th ><input type="text" style="width: 100%; margin-left: 8px;" name="project_code" class="form-control" id="project-code" placeholder readonly ></th>
                  <th ><input type="number" min="0"  step="0.01" style="width: 100%; margin-left: 8px; margin-right: 8px" name="project_days" class="form-control" id="project-days" ></th>
                  <th ><input type="number" min="0"  step="0.01" style="width: 100%; margin-left: 8px; margin-right: 8px" name="project_time" class="form-control" id="project-time" ></th>
                  <th><button type="button" id="add" style="width: 100%; margin-left: 8px;" class="btn btn-primary btn-block btn-flat">Add</button></th>

                </tr>
              </thead>

              <tbody align="center">

              </tbody>

            </table>

            <div class="col-lg-4 pull-right">
              <span class="">Total:</span><input type="text" name="amount" class="col-lg-10 pull-right" id="total" placeholder="Total" readonly>
            </div>


          </div>
        </div>
        <button type="submit" class="btn btn-primary center-block btn-flat">Submit</button>
      </div>
      {!! Form::close() !!}
      

    </div>
    <!-- /.box -->

    <div class="modal fade" id="project-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom: 0px;height: 50px;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title">Edit</h3>
          </div>
          <div class="modal-body">



            <div class="form-group">
              <label>Project Name</label>
              <input type="text" id="project-name-modal" name="allocate_days_modal" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label>Project Code</label>
              <input type="text" id="project-code-modal" name="allocate_code_modal" class="form-control" readonly>
            </div>



            <div class="form-group">
              <label>Allocate Days</label>
              <input type="number" id="allocate-days-modal" name="allocate_days_modal" class="form-control" >
            </div>

            <div class="form-group">
              <label>Allocate Time(%)</label>
              <input type="number" id="allocate-time-modal" name="allocate_time_modal" class="form-control" >
            </div>

            <div class="form-group" hidden>
              <label>project_id</label>
              <input type="number" id="project-id-modal" name="project_id_modal" class="form-control" >
            </div>

          </div>

          <div class="modal-footer">
            <div class="col-lg-12 entry_panel_body ">
              <h3></h3>
              <button type="submit" class="btn btn-primary" id="modal-button" >Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

          


        </div>
      </div>
    </div>

  </section>

  @if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  @endsection



  @section('script')
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <script src="{{asset('dist/js/utils.js')}}"></script>

  <script type="text/javascript">

  $( document ).ready(function() {


    $('#project-name').select2({
      placeholder: 'Select an option',
      ajax: {
        dataType: 'json',
        url: '{{URL::to('/')}}/user/get_valid_projects',
        delay: 250,
        data: function(params) {
          return {
            term: params.term
          }
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          return {
            results: data
          };
        },
      }
    });

    //applying readonly property on the project-time

    $( "#project-days" ).keyup(function() {

      var value = $("#project-days").val();

      if(value.length>=1){

        $('#project-time').prop('readonly', true);
      }else{

        $('#project-time').prop('readonly', false);

      }

    });

    //applying readonly property ont he project-days
    $( "#project-time" ).keyup(function() {

      var value = $("#project-time").val();

      if(value.length>=1){

        $('#project-days').prop('readonly', true);
      }else{

        $('#project-days').prop('readonly', false);

      }

    });



    $("#project-name").change(function(){

      var project_id=$("#project-name").val();

      var jqxhr = $.get( "{{URL::to('/')}}/user/get_project_description", { name: project_id },function(data) {

        // console.log(data.project_code);

        $('#project-code').val(data.project_code);

      });
    });

    var project_data = [];
    var total = 0 ;

    var project_table = $("#project-table").DataTable({
      "searching": true,
      "paging": false,
      "ordering": false,
      "autoWidth": false
    });

    //displaying previous project data
    var user_id = "{{$user->id}}";

    var jqxhr = $.get( "{{URL::to('/')}}/user/user_connected_project", { id: user_id },function(data) {

            // working
            // console.log(data);
            $.each(data, function( index, value ) {
              var entry = [
              value.project_name,
              value.project_code,
              value.allocated_days,
              value.allocate_days_percent,
              '<button class="btn btn-danger btn-block delete-button" id="' + '">Delete</button>',
              value.project_id

              ];

              project_data.push(entry);
              project_table.row.add(entry).draw(false);

              total = parseFloat(total) + parseFloat(value.allocate_days_percent);

              $("#total").val(total);
            });

          }).done(function(){

            $('#project-table tbody').on( 'click', 'tr', function () {
              var cell = project_table.cell( this );

              data = project_table.row( this ).data();

              if(data!=null && data.length>0){

                // console.log(data);

                $('#project-modal').modal('show');
                $("#project-name-modal").val(data[0]);
                $("#project-code-modal").val(data[1]);
                $("#allocate-days-modal").val(data[2]);
                $("#project-id-modal").val(data[5]);
                $("#allocate-time-modal").val(data[3]);


                $( "#allocate-days-modal" ).keyup(function() {

                  var project_days = $("#allocate-days-modal").val();

                  if(project_days.length>=1){
                    var value = parseFloat(project_days);

                    if(value >226){

                      alert("ops! allocated days cannot be more than 226 days.");

                      $("#allocate-days-modal").val("");

                      return
                    }

                 value = (value/226) * (100) //converting days into percentage

                 value = value.toFixed(2);

                 $('#allocate-time-modal').val(value);
               }

             });


                $("#allocate-time-modal").keyup(function(){


                  var value = parseFloat($("#allocate-time-modal").val());

                  if(value.length<1 ||  value > 100){

                    alert("ops! allocated time cannot be more than 100%.");

                    $("#allocate-time-modal").val("")

                    return

                  }

                  value = (value/100)*(12); //12 is the number of months in an year

                  pre_calculated_days = value * 18.8; //on an average 18.8 days in a month

                  pre_calculated_days = Math.round(pre_calculated_days);

                  $('#allocate-days-modal').val(pre_calculated_days);
                });


              }

            });


});



  $('#add').click(function(event){
    event.preventDefault();

    var project_text = $("#project-name option:selected").text(),
    project_id = $("#project-name").val(),
    project_code = $("#project-code").val(),
    project_days = $("#project-days").val(),
    project_days_percent = $("#project-time").val();

            //converting days into percentage
            var pre_calculated_percent = -1;

            if(project_days.length>=1){

              var value = parseFloat(project_days);

              if(value >226){

                alert("ops! allocated days cannot be more than 226 days.");

                return
              }

              value = (value/226) * (100) //converting days into percentage, 226 days = 1 year

              value = value.toFixed(2);

              pre_calculated_percent = value;

            }

            if(pre_calculated_percent != -1){
              project_days_percent = pre_calculated_percent;
            }

            // console.log(project_days_percent);

            //converting percent into days

            var pre_calculated_days = -1;

            if(project_days_percent.length>=1){

              var value = parseFloat(project_days_percent);

              if(value > 100){

                alert("ops! allocated time cannot be more than 100%.");

                return

              }

              value = (value/100)*(12); //12 is the number of months in an year

              pre_calculated_days = value * 18.8; //on an average 18.8 working days in a month

              pre_calculated_days = Math.round(pre_calculated_days);

            }

            if(pre_calculated_days != -1){
              project_days = pre_calculated_days;
            }


            // console.log(project_days)
            

            if(isBlank(!project_id) && (isBlank(!project_days) || isBlank(!project_days_percent))){

              var entry = [
              project_text,
              project_code,
              project_days,
              project_days_percent,
              '<button class="btn btn-danger btn-block delete-button" id="' + '">Delete</button>',
              project_id
              ];

              var project_id=entry[5];
              var booleanValue=true;
              if(project_data.length>=1){
                for(i=0; i<project_data.length; i++){
                  if(project_data[i][5]==project_id){
                    booleanValue=false;

                  }
                }
              }

              if(booleanValue){

                project_data.push(entry);

                total = parseFloat(total) + parseFloat(project_days_percent);

                project_table.row.add(entry).draw(false);

                $("#total").val(total);

                $("#project-code").val(''),  
                $("#project-days").val(''),
                $("#project-time").val('');
                $('#project-time').prop('readonly', false);
                $('#project-days').prop('readonly', false);  

              }else{
                alert("this project has already been entered");  
              }
            }else{
              alert("please fill the row properly");
            }

          });


  //delete row on button click
  $('#project-table tbody').on( 'click', '.delete-button', function () {
    event.preventDefault();
    //get the index of 
    var index = project_table
    .row( $(this).parents('tr') )
    .index();

    var deducted_percent = project_data[index][3];

    total = parseFloat(total) - parseFloat(deducted_percent);
    // console.log(total);
        //remove index from data
        $('#total').val(total);
        project_data.splice(index,1);

        project_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      });


  $( "#project-issue-form" ).submit(function(event){
  //validation

  event.preventDefault();


  var $form = $( this ),
  url = $form.attr( "action" ),
  token = $("[name='_token']").val();
  
  if(project_data.length>0){
    $.post( url, {'user_id':'{{$user->id}}','data':project_data, 'form_data': $form.serializeArray(), '_token': token }, function( data ) {

    }).done(function() {

      window.location.assign('{{URL::to('/')}}/users');

    });
  }else{

    alert("please fill in the details before submitting");

  }
});

  $("#modal-button").click(function(){

    var allocated_days = $("#allocate-days-modal").val();

    var allocate_percent = $("#allocate-time-modal").val();

    var project_id =$("#project-id-modal").val();

    if(allocated_days.length == 0 || allocate_percent.length == 0){
      alert("allocate days or allocate time cannot be empty! please fill up");

      return;

    } 
    

    //finding out the index where the data is in the project_data array    
    for(var i=0; i<project_data.length ; i++){

      if(project_data[i][5]==project_id){
        index = i;
        break;
        
      }

    }

    // console.log(index);
    
    var deducted_percent = project_data[index][3];

    total = parseFloat(total) - parseFloat(deducted_percent);

    total = parseFloat(total) + parseFloat(allocate_percent);

    $('#total').val(total);

    project_table.row( index ).remove().draw();

    project_data.splice(index,1);

    var entry = [
    $('#project-name-modal').val(),
    $('#project-code-modal').val(),
    allocated_days,
    $('#allocate-time-modal').val(),
    '<button class="btn btn-danger btn-block delete-button" id="' + '">Delete</button>',
    project_id

    ];

    project_data.push(entry);
    project_table.row.add(entry).draw(false);


    $('#project-modal').modal('toggle');
  });







});




  </script>
  @endsection


