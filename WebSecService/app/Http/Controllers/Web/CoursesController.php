<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CoursesController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
    }

	public function list(Request $request) {

		$query = Course::select("courses.*");

		$query->when($request->keywords, 
		fn($q)=> $q->where("name", "like", "%$request->keywords%"));

		$query->when($request->order_by, 
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$courses = $query->get();

		return view('courses.list', compact('courses'));
	}

	public function edit(Request $request, Course $course = null) {

		$course = $course??new Course();

		return view('courses.edit', compact('course'));
	}

	public function save(Request $request, Course $course = null) {

		$this->validate($request, [
	        'code' => ['required', 'string', 'max:32'],
	        'name' => ['required', 'string', 'max:256'],
	        'max_degree' => ['required', 'numeric']
	    ]);

		$course = $course??new Course();
		$course->fill($request->all());
		$course->save();

		return redirect()->route('courses_list');
	}

	public function delete(Request $request, Course $course) {

		$course->delete();

		return redirect()->route('courses_list');
	}
} 