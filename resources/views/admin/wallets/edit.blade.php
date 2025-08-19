@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.wallet.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallets.update", [$wallet->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="wallet">{{ trans('cruds.wallet.fields.wallet') }}</label>
                <input class="form-control {{ $errors->has('wallet') ? 'is-invalid' : '' }}" type="number" name="wallet" id="wallet" value="{{ old('wallet', $wallet->wallet) }}" step="1">
                @if($errors->has('wallet'))
                    <div class="invalid-feedback">
                        {{ $errors->first('wallet') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.wallet.fields.wallet_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection