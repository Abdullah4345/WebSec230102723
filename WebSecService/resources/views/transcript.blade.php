<?php
$courses = [
    ['name' => 'Mathematics', 'credits' => 3, 'grade' => 4.0],
    ['name' => 'Physics', 'credits' => 4, 'grade' => 3.5],
    ['name' => 'Chemistry', 'credits' => 3, 'grade' => 3.7],
    ['name' => 'Computer Science', 'credits' => 3, 'grade' => 4.0]
];

function calculateGPA($courses) {
    $totalCredits = 0;
    $totalPoints = 0;
    
    foreach ($courses as $course) {
        $totalCredits += $course['credits'];
        $totalPoints += $course['credits'] * $course['grade'];
    }
    
    return $totalCredits > 0 ? $totalPoints / $totalCredits : 0;
}

$gpa = calculateGPA($courses);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Student Transcript</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Course</th>
                    <th>Credits</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['name']); ?></td>
                        <td><?php echo $course['credits']; ?></td>
                        <td><?php echo number_format($course['grade'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-dark">
                    <th colspan="2" class="text-end">GPA</th>
                    <th><?php echo number_format($gpa, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
