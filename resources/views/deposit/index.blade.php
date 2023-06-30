@extends('layout.app')
@section('title')
    Deposits
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4 class="fw-bold">Deposits</h4>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposits as $key=>$deposit)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                @if ($customer = $deposit->customer)
                                    <a href="">{{$customer->user_id}}</a>
                                @endif
                            </td>
                            <td>{{number_format($deposit->amount,2)}}</td>
                            <td>
                                @if($deposit->status == App\Models\Deposit::SUCCESS)
                                    <span class="badge badge-success">Success</span>
                                @elseif($deposit->status == App\Models\Deposit::REJECT)
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-warning ">Pending</span>
                                @endif
                            </td>

                            <td>{{$deposit->created_at->format('d-m-Y H:i A')}}</td>
                            {{-- <td>
                                <a href="{{route('deposit.edit',$deposit->id)}}">
                                    <i class="fas fa-edit text-success"></i>
                                </a>
                            </td> --}}
                            <td>
                                @if ($deposit->status == App\Models\Deposit::PENDING)
                                    <div class="d-flex">
                                        <form action="{{route('deposit.approve',$deposit->id)}}" method="POST" class="mr-2">
                                            @csrf
                                            <button class="btn btn-primary">Approve</button>
                                        </form>
                                        <form action="{{route('deposit.reject',$deposit->id)}}" method="POST">
                                            @csrf
                                            <button class="btn btn-danger">Reject</button>
                                        </form>
                                    </div>
                                @endif
                                
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        {{$deposits->links()}}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endpush