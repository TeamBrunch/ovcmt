@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2 sidenav" >
                @include('includes.sidebar')
            </div>

            <div class="col-sm-8">
                <h4><small>Manage Term </small></h4>
                <hr>
                <button href="#addNewCourse" class="btn btn-default" data-toggle="collapse">Add Term</button>
                <div class="collapse" id="addNewCourse">
                    <h2>Add a New Term</h2>

                    {!! Form::open(['url' => 'manageTermStore', 'id' => 'addCourseForm']) !!}

                    <div class="form-group">
                        {!! Form::label('date_start', 'Term start date:') !!}
                        {!! Form::date('term_start_date') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('intake_no', 'Intake No:') !!}
                        {!! Form::text('intake_no', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('term_no2', 'Term No:') !!}&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::radio('term_no2', 1, false, array('id'=>'modal_termNo_name1', 'required'=>'true')) }}&nbsp 1&nbsp;&nbsp;
                        {{ Form::radio('term_no2', 2, false, array('id'=>'modal_termNo_name2', 'required'=>'true')) }}&nbsp 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ Form::radio('term_no2', 3, false, array('id'=>'modal_termNo_name3', 'required'=>'true')) }}&nbsp 3&nbsp;&nbsp;&nbsp;
                        {{ Form::radio('term_no2', 4, false, array('id'=>'modal_termNo_name4', 'required'=>'true')) }}&nbsp 4
                    </div>

                    <div class="form-group">
                        {!! Form::label('date_start', 'Duration Weeks:') !!}
                        {!! Form::date('duration_weeks') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('course_weeks', 'Course Weeks:') !!}
                        {!! Form::date('course_weeks') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('exam_weeks', 'Exam Weeks:') !!}
                        {!! Form::date('exam_weeks') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('holiday', 'Holiday:') !!}
                        {!! Form::date('holiday') !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Add Term',['class'=> 'btn btn-primary form-control']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <hr/>
                <h2>Display Term</h2>
                <br>
                <!-- Search bar -->
                <div class="form-group col-md-7">
                    <div class="input-group">
                        <span class="input-group-addon">Search</span>
                        <input type="text" name="search" id ="search" placeholder="Search Term" class ="form-control">
                    </div>
                </div>
                <br><br><br>
                <hr>
                <table class="table table-striped table-bordered table-hover table-condensed text-center">
                    <thead class="thead-default">
                    <tr class = "success">
                        <th class="text-center">Term Id</th>
                        <th class="text-center">Term Start Date</th>
                        <th class="text-center">Intake Id</th>
                        <th class="text-center">Term no</th>
                        <th class="text-center">Duration week</th>
                        <th class="text-center">Course week</th>
                        <th class="text-center">Exam week</th>
                        <th class="text-center">Holiday</th>
                        <th class="text-center">Edit </th>
                        <th class="text-center">Delete</th>
                    </tr>
                    </thead>

                    <tbody class = "searchbody">

                    </tbody>
                </table>
                <script type = "text/javascript">
                    $('#search').on('keyup',function(){
                        $value = $(this).val();
                        $.ajax ({
                            type : 'GET',
                            url  : '/searchInstructor',
                            data: { 'search' : $value },
                            success: function (data) {
                                $('.searchbody').html(data);
                            }
                        });
                    })
                </script>

                </table>
            </div>
        </div>
    </div>



@endsection