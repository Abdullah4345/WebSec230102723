<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    private $jsonFile = 'students.json';

    private function getStudents()
    {
        if (Storage::exists($this->jsonFile)) {
            return json_decode(Storage::get($this->jsonFile), true) ?? [];
        }
        return [];
    }

    public function index()
    {
        $students = $this->getStudents();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $students = $this->getStudents();
        $id = count($students) + 1;
        
        $students[$id] = [
            'id' => $id,
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        Storage::put($this->jsonFile, json_encode($students));
        return redirect()->route('students.index')->with('success', 'Student added successfully');
    }

    public function edit($id)
    {
        $students = $this->getStudents();
        if (!isset($students[$id])) {
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        $student = $students[$id];
        return view('students.edit', compact('student', 'id'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);

        $students = $this->getStudents();
        if (!isset($students[$id])) {
            return redirect()->route('students.index')->with('error', 'Student not found');
        }

        $students[$id]['name'] = $validated['name'];
        $students[$id]['email'] = $validated['email'];

        Storage::put($this->jsonFile, json_encode($students));
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    public function destroy($id)
    {
        $students = $this->getStudents();
        if (isset($students[$id])) {
            unset($students[$id]);
            Storage::put($this->jsonFile, json_encode($students));
            return redirect()->route('students.index')->with('success', 'Student deleted successfully');
        }
        return redirect()->route('students.index')->with('error', 'Student not found');
    }
}
