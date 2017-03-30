@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-2 sidenav">
                @include('includes.sidebar')
            </div>

            <div class="col-sm-10">
                <h4><small>Select a Term</small></h4>
                <hr>
                <div class="row" id="term_selector">
                    <div class="container">


                        <div class="row">
                            {!! Form::open(['url' => '', 'class' => 'form-inline', 'id' => 'select_term']) !!}
                            <div class="col-sm-4" id="assign_select_from">
                                <select name="selected_term_id" id="selected_term_id">
                                    @foreach ($terms as $term)
                                        <option value={{$term->term_id}}>Term Number:{{$term->term_no}},
                                            Intake Number:{{$term->intake_id}}, Start Date:{{$term->term_start_date}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::submit('Choose Term',['class'=> 'btn btn-primary form-inline']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="assignCoursesToInstructor" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 id="modalCourseNameUnassigned" class="modal-title"></h4>
                            </div>
                            <div class="modal-body">
                                <!-- TODO need to pull instructors correctly -->
{{--                                @foreach ($instructors as $instructor)
                                    <div class='panel panel-default'>
                                        <div class='panel-body'>
                                            {!! Form::open(['url' => '', 'class' => 'form-inline', 'id' => $instructor]) !!}
                                            Instructor Id: {{$instructor->instructor_id}} <br>
                                            First Name: {{$instructor->first_name}} <br>
                                            Email: {{$instructor->email}} <br>
                                            {!! Form::submit('Assign',['class'=> 'btn btn-primary form-inline']) !!}
                                        </div>
                                    </div>

                                @endforeach--}}
                                <!-- made dropdown instead of another modal -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="availableInstructors">
                                            <h3>Instructor</h3>
                                            {!! Form::open(['url' => 'assignCourse', 'class' => 'form-inline', 'id' => 'select_instructor']) !!}
                                                <p id="noInstructorsMsg"></p>
                                                <select class="form-control" name='selected_instructor_id' id='selected_instructor_id'>
                                                    <!-- inserting options here through ajax request -->
                                                </select>
                                                <br><br>
                                                <div id="assignInstructBtn">
                                                    {!! Form::submit('Assign instructor',['class'=> 'btn btn-primary form-inline']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="availableTAs">
                                            <h3>TA</h3>
                                            {!! Form::open(['url' => 'assignCourse', 'class' => 'form-inline', 'id' => 'select_ta']) !!}
                                                <p id="noTasMsg"></p>
                                                <select class="form-control" name='selected_ta_id' id='selected_ta_id'>
                                                    <!-- inserting options here through ajax request -->
                                                </select>
                                                <br><br>
                                                <div id="assignTaBtn">
                                                    {!! Form::submit('Assign TA',['class'=> 'btn btn-primary form-inline']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $(document).on('submit', '#select_term', function (e) {
                            e.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            var term_id = $('#selected_term_id').val();
                            $.ajax({
                                type: 'POST',
                                url: '/getCourseOfferingsByTerm',
                                data: {"term_id": term_id},
                                dataType: 'json',
                                success: function (data) {
                                    //TODO: make this pretty
                                    $('#assigned').empty();
                                    for (let i = 0; i < data['assignedcourses'].length; i++) {
                                        var panel = "<div class='panel panel-default' id='" + data['assignedcourses'][i]['course_id'] + "-assigned'><div class='panel-heading'>" + data['assignedcourses'][i]['course_id']
                                            + "</div> <div class='panel-body'>" + "Instructor ID: " + data['assignedcourses'][i]['instructor_id']
                                            + " Instructor Name: " + data['assignedcourses'][i]['first_name']
                                            // + "<br><button class='btn btn-danger'>Unassign " + data['assignedcourses'][i]['first_name'] + "</button>"
                                            + "<br><br><form action='unassignCourse'><input type='submit' class='btn btn-danger' value='Unassign " + data['assignedcourses'][i]['first_name'] + "'></form>"
                                            + "</div></div>";
                                        $('#assigned').append(panel);
                                    }
                                    $('#unassigned').empty();
                                    for (let i = 0; i < data['unassignedcourses'].length; i++) {
                                        var panel = "<div class='panel panel-default' id='" + data['unassignedcourses'][i]['course_id'] + "'><div class='panel-heading'>" + data['unassignedcourses'][i]['course_id']
                                            + "</div> <div class='panel-body'>"
                                            + "</div></div>";
                                        $('#unassigned').append(panel);
                                    }
                                    // show modal for unassigned courses
                                    for (let i = 0; i < data['unassignedcourses'].length; i++) {
                                        var course = data['unassignedcourses'][i]['course_id'];
                                        var courseStr = course.toString();
                                        var courseid = document.getElementById(courseStr);

                                        courseid.onclick=function() {
                                            var courseToPass = $(this).attr('id');
                                            $('#assignCoursesToInstructor').modal('show');
                                            $('#modalCourseNameUnassigned').html('Available Instructors and TAs for ' + courseToPass);
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                type: 'POST',
                                                url: '/getInstructorsForACourse',
                                                data: {"course_id": courseToPass},
                                                dataType: 'json',
                                                success: function (data) {
                                                    $('#selected_instructor_id').css('visibility', 'visible').empty();
                                                    $('#selected_ta_id').css('visibility', 'visible').empty();
                                                    $('#assignInstructBtn').css('visibility', 'visible');
                                                    $('#assignTaBtn').css('visibility', 'visible');
                                                    $('#noInstructorsMsg').empty();
                                                    $('#noTasMsg').empty();

                                                    for (let i = 0; i < data['instructorsbycourse'].length; i++) {
                                                        var instructorDropdown = "<option value='" + data['instructorsbycourse'][i]['instructor_id'] + "'>" + data['instructorsbycourse'][i]['first_name'] + "</option>";
                                                        $('#selected_instructor_id').append(instructorDropdown);
                                                    }
                                                    for (let i = 0; i < data['tasbycourse'].length; i++) {
                                                        var taDropdown = "<option value='" + data['tasbycourse'][i]['instructor_id'] + "'>" + data['tasbycourse'][i]['first_name'] + "</option>";
                                                        $('#selected_ta_id').append(taDropdown);
                                                    }
                                                    if ($('#selected_instructor_id').is(':empty')){
                                                        var msg = "No available instructors for this course.";
                                                        $('#selected_instructor_id').css('visibility', 'hidden');
                                                        $('#assignInstructBtn').css('visibility', 'hidden');
                                                        $('#noInstructorsMsg').append(msg);
                                                    }
                                                    if ($('#selected_ta_id').is(':empty')){
                                                        var msg = "No available TAs for this course.";
                                                        $('#selected_ta_id').css('visibility', 'hidden');
                                                        $('#assignTaBtn').css('visibility', 'hidden');
                                                        $('#noTasMsg').append(msg);
                                                    }
                                                }
                                            });
                                        };
                                    }
                                }
                            });
                        });
                    });
                </script>
                <div class="row">
                    <div class="col-sm-6">
                        <h4><small>Assign Courses to Instructors for the Term</small></h4>
                        <hr>
                        <div id="unassigned"></div>
                    </div>
                    <div class="col-sm-6">
                        <h4><small>Edit Assigned Instructors by Course</small></h4>
                        <hr>
                        <div id="assigned"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection