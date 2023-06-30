@extends('layout.app')
@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add new domain</h3>
            </div>
        
            <div class="card-body p-0">
                <form action="{{route('domain.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name" placeholder="Enter name">
                        @error('name')
                            <span class="invalid-feedback">{{$message}}</span>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="domain">Domain</label>
                        <input type="text" name="domain" class="form-control @error('doamin') is-invalid @enderror" id="domain" placeholder="Enter domain">
                        @error('domain')
                            <span class="invalid-feedback">{{$message}}</span>
                        @enderror
                      </div>
                    </div>
                    <!-- /.card-body -->
              
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
       
        
    </div>
</div>
@endsection