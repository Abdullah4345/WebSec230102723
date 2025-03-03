<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'grade',
        'credit_hours',
        'term',
    ];

    /**
     * Calculate GPA for a specific term.
     */
    public static function calculateTermGPA($term)
    {
        $grades = self::where('term', $term)->get();
        $totalPoints = 0;
        $totalCreditHours = 0;

        foreach ($grades as $grade) {
            $gradePoint = self::gradeToPoint($grade->grade);
            $totalPoints += $gradePoint * $grade->credit_hours;
            $totalCreditHours += $grade->credit_hours;
        }

        return $totalCreditHours > 0 ? $totalPoints / $totalCreditHours : 0;
    }

    /**
     * Calculate Cumulative GPA (CGPA).
     */
    public static function calculateCGPA()
    {
        $grades = self::all();
        $totalPoints = 0;
        $totalCreditHours = 0;

        foreach ($grades as $grade) {
            $gradePoint = self::gradeToPoint($grade->grade);
            $totalPoints += $gradePoint * $grade->credit_hours;
            $totalCreditHours += $grade->credit_hours;
        }

        return $totalCreditHours > 0 ? $totalPoints / $totalCreditHours : 0;
    }

    /**
     * Calculate Cumulative Credit Hours (CCH).
     */
    public static function calculateCCH()
    {
        return self::sum('credit_hours');
    }

    /**
     * Convert letter grade to grade points.
     */
    private static function gradeToPoint($grade)
    {
        switch ($grade) {
            case 'A': return 4.0;
            case 'B': return 3.0;
            case 'C': return 2.0;
            case 'D': return 1.0;
            case 'F': return 0.0;
            default: return 0.0;
        }
    }
}