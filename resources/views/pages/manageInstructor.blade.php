@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            @include('includes.sidebar')
        </div>
        <div class="col-sm-6">
            <h4><small>Manage Instructors </small></h4>
            <hr>
            <button href="#addNewInstructor" class="btn btn-default" data-toggle="collapse">Add Instructor</button>
            <div class="collapse" id="addNewInstructor">
                <h2>Add a New Instructor</h2>
            {!! Form::open(['url' => 'manageInstructor']) !!}
                    {{csrf_field()}}
                    <div class="form-group">
                    {!! Form::label('first_name', 'First Name:') !!}
                    {!! Form::text('first_name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>
                <p>Check all time slots for which instructor is available:</p>
                <div class="form-group">
                    {!! Form::label('date_start', 'Date effective:') !!}
                    {!! Form::date('date_start') !!}
                </div>
                <div class="form-group">
                <table>
                    <tr>
                        <th>Time</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thurs</th><th>Fri</th>
                    </tr>
                    <tr>
                        <td>Morn</td>
                        <td>{!! Form::checkbox('instructAvail[]', '0', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '1', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '2', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '3', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '4', false) !!}</td>

                    </tr>
                    <tr>
                        <td>Aft</td>
                        <td>{!! Form::checkbox('instructAvail[]', '5', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '6', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '7', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '8', false) !!}</td>
                        <td>{!! Form::checkbox('instructAvail[]', '9', false) !!}</td>
                    </tr>
                </table>
                </div>

                <div class="form-group">
                    {!! Form::submit('Add instructor',['class'=> 'btn btn-primary form-control']) !!}
                </div>

                {!! Form::close() !!}


                <hr>
                <h4>Teachable Courses</h4>
                <br>
                <h5>Assign Course </h5>

                {!! Form::open(['url' => 'courseInstructor']) !!}
                <div class="form-group">
                    {!! Form::hidden('modal_instructor_id', '', array('id'=>'modal_instructor_id')) !!}


                    <select id="course_id" name ="course_id">
                        @foreach($courses as $course)
                            <option value=course name = "$course->course_id">{{$course->course_id}}</option>
                        @endforeach
                    </select>

                     &nbsp &nbsp Option A
                    <input type="radio" id = "a" name ="intake_no" value ="A" checked="checked" />

                    &nbsp &nbsp Option B
                    <input type="radio" id = "b" name ="intake_no" value ="B" />
                    &nbsp

                    | &nbsp &nbsp Instructor
                    <input type="radio" id = "inst" name ="instructor_type" value ="Instructor" checked="checked"/>
                    &nbsp &nbsp TA
                    <input type="radio" id = "ta" name ="instructor_type" value ="TA" />
                    <br><br>

                    <div class="form-group">
                        {!! Form::submit('Assign course',['class'=> 'btn btn-primary ', 'id'=>'addbtn']) !!}
                    </div>

                    <p id="demo"></p>

                    <h5>display assigned course</h5>


                </div>

                <script>


                        $(document).ready(function() {
                            $('#addbtn').click(function(){

                                var course_id = document.getElementById("course_id");
                                course_id = course_id.options[course_id.selectedIndex].text;

                                if (document.getElementById("a").checked){
                                    intake_no = document.getElementById('a').value;
                                }else {
                                    intake_no = document.getElementById('b').value;
                                }
                                if (document.getElementById("inst").checked){
                                    instructor_type = document.getElementById('inst').value;
                                }else if (document.getElementById("ta").checked){
                                    instructor_type = document.getElementById('ta').value;
                                }
                                var myArray = [ course_id, intake_no, instructor_type];

                                document.getElementById("demo").innerHTML = myArray;

                                /*
                                $.ajax({
                                    type: 'POST',
                                    url: '/showCourseInstructorDetail',
                                    data: {"instructor_id" : instructor_id},
                                    dataType: 'json',
                                    data: {id: currentValue, _token: $('input[name="_token"]').val()},
                                    success: function(data){
                                        alert(data);
                                    },
                                    error: function(){},
                                });
                                */
                            });
                        });




                </script>

                {!! Form::close() !!}

            </div> <!-- Close the add instructor div-->

            <hr/>

            <h2>Display Instructors</h2>
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead class="thead-default">
                <tr>
                    <th>ID</th><th>Name</th><th>Date</th>
                    <th>Mon AM</th><th>Tues AM</th><th>Wed AM</th><th>Thur AM</th><th>Fri AM</th>
                    <th>Mon PM</th><th>Tues PM</th><th>Wed PM</th><th>Thur PM</th><th>Fri PM</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($instructors as $instructor)
                    <tr>
                        <th>{{$instructor->instructor_id}}</th>
                        <td>{{$instructor->first_name}}</td>
                        <td>{{$instructor->date_start}}</td>
                        <td>{{$instructor->mon_am}}</td>
                        <td>{{$instructor->tues_am}}</td>
                        <td>{{$instructor->wed_am}}</td>
                        <td>{{$instructor->thurs_am}}</td>
                        <td>{{$instructor->fri_am}}</td>
                        <td>{{$instructor->mon_pm}}</td>
                        <td>{{$instructor->tues_pm}}</td>
                        <td>{{$instructor->wed_pm}}</td>
                        <td>{{$instructor->thurs_pm}}</td>
                        <td>{{$instructor->fri_pm}}</td>
                        <td>
                            <button class="btn btn-action open-EditInstructorDialog"
                                    data-toggle="modal"
                                    data-id="{{$instructor->instructor_id}}"
                                    data-name="{{$instructor->first_name}}"
                                    data-target="#editInstructorModal"
                            >Edit</button>
                        </td>

                    </tr>


                @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="editInstructorModal" tabindex="-1" role="dialog" aria-labeleledby="editInstructorModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="editInstructorModalLabel">Edit</h4>
                        </div>
                        <div class="modal-body">
                            {!! Form::open(['url' => 'editInstructor']) !!}
                            <p>New Availability</p>
                            <div class="form-group">
                                {!! Form::hidden('modal_instructor_id', '', array('id'=>'modal_instructor_id')) !!}
                                {!! Form::label('modal_instructor_name', 'Instructor:') !!}
                                {!! Form::text('modal_instructor_name', '', array('id'=>'modal_instructor_name'))!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('modal_instruct_avail_start_date', 'Effective date:') !!}
                                {!! Form::date('modal_instruct_avail_start_date')!!}
                            </div>
                            <div class="form-group">
                                <table>
                                    <tr>
                                        <th>Time</th><th>Mon</th><th>Tues</th><th>Wed</th><th>Thurs</th><th>Fri</th>
                                    </tr>
                                    <tr>
                                        <td>Morn</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '0', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '1', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '2', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '3', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '4', false) !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Aft</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '5', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '6', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '7', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '8', false) !!}</td>
                                        <td>{!! Form::checkbox('instructEditAvail[]', '9', false) !!}</td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <h4>Courses this instructor can teach</h4>
                                <div id="courseListing"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <span class="pull-right">
                                {!! Form::submit('Edit',['class'=> 'btn btn-primary form-control']) !!}
                            </span>
                            {!! Form::close() !!}
                        </div>
                        <script>
                            $(document).on('click', '.open-EditInstructorDialog', function() {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                var instructor_id = $(this).data('id');
                                var instructor_name = $(this).data('name');
                                $('.modal-body #modal_instructor_id').attr('value',instructor_id);
                                $('.modal-body #modal_instructor_name').attr('value',instructor_name);
                                $.ajax({
                                    type: 'POST',
                                    url: '/showInstructorDetails',
                                    data: {"instructor_id" : instructor_id},
                                    dataType: 'json',
                                    success: function(data){
                                        $('#courseListing').empty();
                                        for (let i = 0; i < data['courses'].length; i++) {
                                            var panel = "<div class='panel panel-default'><div class='panel-heading'>" + data['courses'][i]['course_id']
                                                + "</div> <div class='panel-body'>" + "Intake: " + data['courses'][i]['intake_no'] + "</div></div>";
                                            $('#courseListing').append(panel);
                                        }
                                        var avail = data['avail'][0];
                                        $('input[name="modal_instruct_avail_start_date"]').val(avail['date_start']);
                                        $('input:checkbox[name="instructEditAvail[]"][value="0"]')
                                            .prop('checked', (avail['mon_am'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="1"]')
                                            .prop('checked', (avail['tues_am'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="2"]')
                                            .prop('checked', (avail['wed_am'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="3"]')
                                            .prop('checked', (avail['thurs_am'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="4"]')
                                            .prop('checked', (avail['fri_am'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="5"]')
                                            .prop('checked', (avail['mon_pm'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="6"]')
                                            .prop('checked', (avail['tues_pm'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="7"]')
                                            .prop('checked', (avail['wed_pm'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="8"]')
                                            .prop('checked', (avail['thurs_pm'] == 1) ? true : false);
                                        $('input:checkbox[name="instructEditAvail[]"][value="9"]')
                                            .prop('checked', (avail['fri_pm'] == 1) ? true : false);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection