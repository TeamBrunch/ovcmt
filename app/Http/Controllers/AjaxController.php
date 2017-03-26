<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseInstructor;
use App\InstructAvail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function instructorDetails(Request $req) {
        if ($req->ajax() && isset($req->instructor_id)) {
            $courses = CourseInstructor::where('instructor_id', $req->instructor_id)->get();
            $avail = InstructAvail::where('instructor_id', $req->instructor_id)->get();
        }
        return response()->json(array("courses" => $courses, "avail" => $avail), 200);
    }

    public function getInstructorsForACourse(Request $req) {
        if($req->ajax() && isset($req->course_id)) {
            $instructorsbycourse = CourseInstructor::where('course_id', $req->course_id)->get();
        }
        return response()->json(array("coursesbyinstructor" => $instructorsbycourse), 200);
    }

    public function getWeeklySchedule(Request $req) {
        if($req->ajax() && isset($req->week_monday)) {
            $weekstart = date_create($req->week_monday);
            $weekend = date_add($weekstart, date_interval_create_from_date_string('5 days'));
            $roomsbyday = DB::table('rooms_by_day')
                ->where('cdate', '>=' , $weekstart)
                ->where('cdate', '<=' , $weekend)
                ->orderBy('cdate')
                ->get();
            return response()->json(array("roomsbyday" => $roomsbyday), 200);
        }
    }

    public function getCourseOfferingsByTerm(Request $req) {
        if($req->ajax() && isset($req->term_id)) {
            $term_id = $req->term_id;
            $assignedcourses = DB::table('courses AS c')
                ->join('course_offerings AS co', 'c.course_id', '=', 'co.course_id')
                ->join('instructors AS i', 'co.instructor_id', '=', 'i.instructor_id')
                ->where("co.term_id", $req->term_id)
                ->select('c.course_id AS course_id', 'co.instructor_id as instructor_id', 'i.first_name as first_name',
                'i.email as email')
                ->get();
            $query = DB::table('course_offerings')
                ->where('term_id', $req->term_id)
                ->select("course_id");
            $unassignedcourses = Course::whereNotIn("course_id", $query)->get();
            return response()->json(array("assignedcourses" => $assignedcourses, "unassignedcourses" => $unassignedcourses), 200);
        }
    }
}
