<?php
function isPrime($number) {
    if ($number <= 1) return false;
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) return false;
    }
    return true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Numbers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .badge-primary {
            background-color: #007bff;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="card m-4">
        <div class="card-header">Prime Numbers</div>
        <div class="card-body">
            @foreach (range(1, 100) as $i)
                @if (isPrime($i))
                    <span class="badge badge-primary">{{ $i }}</span>
                @else
                    <span class="badge badge-secondary">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>
</body>
</html>