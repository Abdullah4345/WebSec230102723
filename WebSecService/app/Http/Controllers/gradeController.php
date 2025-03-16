<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GradeController extends Controller
{
    private $jsonFile = 'grades.json';
    private $studentsFile = 'students.json';

    private function getGrades()
    {
        if (Storage::exists($this->jsonFile)) {
            return json_decode(Storage::get($this->jsonFile), true) ?? [];
        }
        return [];
    }

    private function getStudents()
    {
        if (Storage::exists($this->studentsFile)) {
            return json_decode(Storage::get($this->studentsFile), true) ?? [];
        }
        return [];
    }

    public function index()
    {
        $students = $this->getStudents();
        $grades = $this->getGrades();
        
        // Group grades by student
        $studentGrades = [];
        foreach ($grades as $grade) {
            $studentId = $grade['student_id'];
            if (!isset($studentGrades[$studentId])) {
                $studentGrades[$studentId] = [];
            }
            $studentGrades[$studentId][] = $grade;
        }
        
        return view('grades.index', compact('students', 'studentGrades'));
    }

    public function create($studentId = null)
    {
        $students = $this->getStudents();
        $gradeOptions = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'];
        
        if ($studentId && !isset($students[$studentId])) {
            return redirect()->route('grades.index')->with('error', 'Student not found');
        }
        
        $student = $studentId ? $students[$studentId] : null;
        return view('grades.create', compact('students', 'student', 'studentId', 'gradeOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer',
            'course_name' => 'required|string|max:255',
            'grade' => 'required|string|max:2',
            'credit_hours' => 'required|integer|min:1',
            'term' => 'required|string|max:255',
        ]);

        $grades = $this->getGrades();
        $id = count($grades) + 1;
        
        $grades[] = [
            'id' => $id,
            'student_id' => $validated['student_id'],
            'course_name' => $validated['course_name'],
            'grade' => $validated['grade'],
            'credit_hours' => $validated['credit_hours'],
            'term' => $validated['term']
        ];

        Storage::put($this->jsonFile, json_encode($grades));
        return redirect()->route('grades.index')->with('success', 'Grade added successfully');
    }

    public function edit($id)
    {
        $grades = $this->getGrades();
        $grade = collect($grades)->firstWhere('id', (int)$id);
        
        if (!$grade) {
            return redirect()->route('grades.index')->with('error', 'Grade not found');
        }

        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'grade' => 'required|string|max:2',
            'credit_hours' => 'required|integer|min:1',
            'term' => 'required|string|max:255',
        ]);

        $grades = $this->getGrades();
        
        $index = collect($grades)->search(fn($grade) => $grade['id'] == (int)$id);
        
        if ($index === false) {
            return redirect()->route('grades.index')->with('error', 'Grade not found');
        }

        $grades[$index] = array_merge($grades[$index], $validated);
        
        Storage::put($this->jsonFile, json_encode($grades));
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully');
    }

    public function destroy($id)
    {
        $grades = $this->getGrades();
        $grades = array_filter($grades, fn($grade) => $grade['id'] != (int)$id);
        Storage::put($this->jsonFile, json_encode(array_values($grades)));
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully');
    }
}