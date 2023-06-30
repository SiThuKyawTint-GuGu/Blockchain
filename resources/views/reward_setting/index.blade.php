@extends('layout.app')
@section('title')
    Reward Settings
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h3 class="card-title">    Reward Settings
</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Minimum Amount</th>
                        <th>Maximum Amount</th>
                        <th>Percent</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($reward_settings as $key=>$reward_setting)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$reward_setting->name}}</td>
                            <td>{{$reward_setting->minimum_amount}}</td>
                            <td>{{$reward_setting->maximum_amount}}</td>
                            <td>{{$reward_setting->percent}}%</td>


                            <td>
                              <a href="{{route('reward_setting.edit',$reward_setting->id)}}">
                                <i class="fas fa-edit text-success"></i>
                              </a>
                              <a style="cursor: pointer" onclick="if(confirm('Are you sure to delete?')){
                                document.getElementById('delete-{{$reward_setting->id}}').submit();
                              }">
                                <i class="fas fa-trash text-danger"></i>

                              </a>
                              <form method="POST" id="delete-{{$reward_setting->id}}" action="{{route('reward_setting.destroy',$reward_setting->id)}}">
                                @csrf
                                @method('DELETE')
                              </form>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        {{$reward_settings->links()}}
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add new reward setting</h3>
                </div>
            
                <div class="card-body p-0">
                    <form action="{{route('reward_setting.store')}}" method="POST">
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
                            <label for="minimum_amount">Minimum Amount</label>
                            <input type="number" name="minimum_amount" class="form-control @error('doamin') is-invalid @enderror" id="minimum_amount" placeholder="Enter minimum amount">
                            @error('minimum_amount')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                          </div>
                          <div class="form-group">
                            <label for="maximum_amount">Maximum Amount</label>
                            <input type="number" name="maximum_amount" class="form-control @error('doamin') is-invalid @enderror" id="maximum_amount" placeholder="Enter minimum amount">
                            @error('maximum_amount')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                          </div>
                           <div class="form-group">
                            <label for="percent">Percent</label>
                            <input type="number" name="percent" class="form-control @error('doamin') is-invalid @enderror" id="percent" placeholder="Enter minimum amount">
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