<?php
namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use DB;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Grade;
use App\Models\User;

class GradesController extends Controller {

	use ValidatesRequests;

	public function __construct()
    {
    }

	public function list(Request $request) {

		$query = Grade::select("grades.*");
		$query->join('users', 'users.id', 'grades.user_id');
		$query->join('courses', 'courses.id', 'grades.course_id');

		$query->when($request->keywords, 
		fn($q)=> $q->where(function($subQuery) use($request){
			$subQuery->orWhere("users.name", "like", "%$request->keywords%");
			$subQuery->orWhere("courses.name", "like", "%$request->keywords%");
		}));

		$query->when($request->order_by, 
		fn($q)=> $q->orderBy($request->order_by, $request->order_direction??"ASC"));

		$grades = $query->get();

		return view('grades.list', compact('grades'));
	}

	public function edit(Request $request, Grade $grade = null) {

		$grade = $grade??new Grade();

		$users = User::select('id', 'name')->get();
		$courses = Course::select('id', 'name')->get();

		return view('grades.edit', compact('grade', 'courses', 'users'));
	}

	public function save(Request $request, Grade $grade = null) {

		$this->validate($request, [
	        'user_id' => ['required', 'numeric', 'exists:users,id'],
	        'course_id' => ['required', 'numeric', 'exists:courses,id'],
	        'degree' => ['required', 'numeric', 'max:100']
	    ]);

		$grade = $grade??new Grade();
		$grade->fill($request->all());
		$grade->save();

		return redirect()->route('grades_list');
	}

	public function freeze(Request $request, Grade $grade) {

		$grade->freezed = 1;
		$grade->save();

		return redirect()->route('grades_list');
	}

	public function unfreeze(Request $request, Grade $grade) {

		$grade->freezed = 0;
		$grade->save();

		return redirect()->route('grades_list');
	}

	public function delete(Request $request, Grade $grade) {

		$grade->delete();

		return redirect()->route('grades_list');
	}
} 