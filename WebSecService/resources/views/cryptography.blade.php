@extends('layouts.master')
@section('title', 'Cryptography')
@section('content')
  <div class="card m-4">
    <div class="card-body">
      <form action="{{route('cryptography')}}" method="get">
        {{ csrf_field() }}
        <div class="row mb-2">
          <div class="col">
              <label for="name" class="form-label">Data:</label>
              <textarea type="text" class="form-control" placeholder="Data" name="data" required>{{$data}}</textarea>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col">
              <label for="name" class="form-label">Operation:</label>
              <select class="form-control" name="action" required>
                <option {{($action=="Encrypt")?"selected":""}}>Encrypt</option>
                <option {{($action=="Decrypt")?"selected":""}}>Decrypt</option>
                <option {{($action=="Hash")?"selected":""}}>Hash</option>
                <option {{($action=="Sign")?"selected":""}}>Sign</option>
                <option {{($action=="Verify")?"selected":""}}>Verify</option>
                <option {{($action=="KeySend")?"selected":""}}>KeySend</option>
                <option {{($action=="KeyRecive")?"selected":""}}>KeyRecive</option>
              </select>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col">
              <label for="name" class="form-label">Result:</label>
              <textarea type="text" class="form-control" placeholder="Data" name="result">{{$result}}</textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button> 
      </form>
    </div>
  </div>
  <div class="card m-4"><div class="card-body"><strong>Result Status:</strong> {{$status}}</div></div>
@endsection
