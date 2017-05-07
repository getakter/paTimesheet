	@extends('layout.main')
	@section('content')

	<section class="content">
		<!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Create New Project</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
      </div>

      {!! Form::open(array('route'=>'projects.store', 'files'=>true, 'id'=>'customer_form')) !!}

      <div class="box-body">
        <div class="row">
          <div class="col-md-6">

           <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="program_name" id="program-name" placeholder="Name of the program" value="{{old('program_name')}}" required>   
          </div>

        </div>
        <!-- /.col -->
        <div class="col-md-6">
            <div class="form-group">
            <label>Swif Code</label>
            <input type="number" class="form-control" name="swif_code" id="swif-code" placeholder="please enter the code" value="{{old('swif_code')}}" required>   
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="form-group">

        <button type="submit" class="btn btn-primary">Submit</button>

      </div>
    </div>
    {!! Form::close() !!}
    <!-- /.box-body -->

  </div>
  <!-- /.box -->
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

<script type="text/javascript">
$( document ).ready(function() {

  





});




  </script>
  @endsection


