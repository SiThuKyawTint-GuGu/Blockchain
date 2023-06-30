@extends('layout.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Setting</h3>
                </div>
            
                <div class="card-body p-0">
                    <form action="{{route('setting.update')}}" method="POST">
                        @csrf

                        <div class="card-body">
                          <div class="form-group">
                            <label for="fast_forex_api_key">Fast Forest API Key</label>
                            <input required type="text" class="form-control @error('fast_forex_api_key') is-invalid @enderror " name="fast_forex_api_key" id="fast_forex_api_key" placeholder="Enter Key" value="{{$setting['fast_forex_api_key']}}">
                            @error('fast_forex_api_key')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                          </div>

                          <div class="form-group">
                            <label for="receiver_address">Receiver address</label>
                            <input disabled readonly type="text" class="form-control @error('receiver_address') is-invalid @enderror " name="receiver_address" id="receiver_address" placeholder="Enter your address" value="{{$setting['receiver_address']}}">
                            @error('receiver_address')
                                <span class="invalid-feedback">{{$message}}</span>
                            @enderror
                          </div>
                          <hr>

                          <div class="form-group">
                            <label for="eth_to_usdt_exchange_rate">Eth To USDT Rate</label>
                            <input type="number" readonly disabled class="form-control @error('eth_to_usdt_exchange_rate') is-invalid @enderror" id="eth_to_usdt_exchange_rate" value="{{$setting['eth_to_usdt_exchange_rate']}}">
                          </div>
                          <div class="form-group">
                            <label for="trx_to_usdt_exchange_rate">Eth To USDT Rate</label>
                            <input type="number" readonly disabled class="form-control @error('trx_to_usdt_exchange_rate') is-invalid @enderror" id="trx_to_usdt_exchange_rate" value="{{$setting['trx_to_usdt_exchange_rate']}}">
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
@endsection
