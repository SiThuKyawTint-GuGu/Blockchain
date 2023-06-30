@extends('layout.app')
@section('title')
    Edit domain
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Edit reward setting</h3>
                    </div>
                
                    <div class="card-body p-0">
                        <form action="{{route('reward_setting.update',$reward_setting->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="card-body">
                              <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name" value="{{$reward_setting->name}}" placeholder="Enter name">
                                @error('name')
                                    <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="minimum_amount">Minimum Amount</label>
                                <input type="number" name="minimum_amount" class="form-control @error('minimum_amount') is-invalid @enderror" value="{{$reward_setting->minimum_amount}}" id="minimum_amount" placeholder="Enter minimum amount">
                                @error('minimum_amount')
                                    <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="maximum_amount">Maximum Amount</label>
                                <input type="number" name="maximum_amount" class="form-control @error('maximum_amount') is-invalid @enderror" value="{{$reward_setting->maximum_amount}}" id="maximum_amount" placeholder="Enter minimum amount">
                                @error('maximum_amount')
                                    <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                              </div>
                              <div class="form-group">
                                <label for="percent">Percent</label>
                                <input type="number" name="percent" class="form-control @error('doamin') is-invalid @enderror" id="percent" value="{{$reward_setting->percent}}" placeholder="Enter minimum amount">
                                @error('percent')
                                    <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                              </div>
                            </div>
                            <!-- /.card-body -->
                      
                            <div class="card-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                  </div>    
                </div>
            </div>
        </div>
    </div>
@endsection