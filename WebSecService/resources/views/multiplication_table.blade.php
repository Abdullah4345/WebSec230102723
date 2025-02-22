@foreach (range(1, 10) as $j)
<div class="card m-4 col-sm-2">
    <div class="card-header bg-primary text-white text-center">{{$j}} Multiplication Table</div>
    <div class="card-body">
        <table class="table table-bordered">
            @foreach (range(1, 10) as $i)
            <tr>
                <td>{{$i}} * {{$j}}</td>
                <td>= {{ $i * $j }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endforeach

<!-- Include Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">