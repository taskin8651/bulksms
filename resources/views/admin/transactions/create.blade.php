@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.transaction.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.transactions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="wallet">{{ trans('cruds.transaction.fields.wallet') }}</label>
                <input class="form-control {{ $errors->has('wallet') ? 'is-invalid' : '' }}" type="text" name="wallet" id="wallet" value="{{ old('wallet', '') }}">
                @if($errors->has('wallet'))
                    <div class="invalid-feedback">
                        {{ $errors->first('wallet') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.transaction.fields.wallet_helper') }}</span>
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