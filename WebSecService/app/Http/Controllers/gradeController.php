<?php

namespace App\Http\Controllers;

use App\Models\Grade; // Import the Grade model
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the grades.
     */
    public function index()
    {
        // Group grades by term
        $grades = Grade::all()->groupBy('term');
    
        // Calculate Term GPA, CGPA, and CCH
        $termGPA = [];
        $cgpa = Grade::calculateCGPA();
        $cch = Grade::calculateCCH();
    
        foreach ($grades as $term => $termGrades) {
            $termGPA[$term] = Grade::calculateTermGPA($term);
        }
    
        return view('grades.index', compact('grades', 'termGPA', 'cgpa', 'cch'));
    }

    /**
     * Show the form for creating a new grade.
     */
    public function create()
    {
        return view('grades.create'); // Load the grades create form
    }
    
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'course_name' => 'required|string',
            'grade' => 'required|string',
            'credit_hours' => 'required|integer',
            'term' => 'required|string',
        ]);
    
        // Create a new grade
        Grade::create($request->all());
    
        // Redirect to the grades index page
        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    /**
     * Display the specified grade.
     */
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified grade.
     */
    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        // Validate the request
        $request->validate([
            'course_name' => 'required|string|max:255',
            'grade' => 'required|string|max:2', // Assuming grades are like A, B, C, etc.
            'credit_hours' => 'required|integer|min:1',
            'term' => 'required|string|max:255',
        ]);
    
        // Debugging: Display submitted data
        // dd($request->all());
    
        // Update the grade with the new data
        $grade->update([
            'course_name' => $request->course_name,
            'grade' => $request->grade,
            'credit_hours' => $request->credit_hours,
            'term' => $request->term,
        ]);
    
        // Redirect to the grades index page with a success message
        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    /**
     * Remove the specified grade from the database.
     */
    public function destroy(Grade $grade)
    {
        // Delete the grade
        $grade->delete();
    
        // Redirect to the grades index page with a success message
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}