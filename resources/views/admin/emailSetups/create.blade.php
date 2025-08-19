@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.emailSetup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.email-setups.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.emailSetup.fields.provider_name') }}</label>
                <select class="form-control {{ $errors->has('provider_name') ? 'is-invalid' : '' }}" name="provider_name" id="provider_name" required>
                    <option value disabled {{ old('provider_name', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\EmailSetup::PROVIDER_NAME_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('provider_name', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('provider_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('provider_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.provider_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="from_name">{{ trans('cruds.emailSetup.fields.from_name') }}</label>
                <input class="form-control {{ $errors->has('from_name') ? 'is-invalid' : '' }}" type="text" name="from_name" id="from_name" value="{{ old('from_name', '') }}">
                @if($errors->has('from_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.from_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="from_email">{{ trans('cruds.emailSetup.fields.from_email') }}</label>
                <input class="form-control {{ $errors->has('from_email') ? 'is-invalid' : '' }}" type="text" name="from_email" id="from_email" value="{{ old('from_email', '') }}" required>
                @if($errors->has('from_email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from_email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.from_email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="host">{{ trans('cruds.emailSetup.fields.host') }}</label>
                <input class="form-control {{ $errors->has('host') ? 'is-invalid' : '' }}" type="text" name="host" id="host" value="{{ old('host', '') }}">
                @if($errors->has('host'))
                    <div class="invalid-feedback">
                        {{ $errors->first('host') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.host_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="port">{{ trans('cruds.emailSetup.fields.port') }}</label>
                <input class="form-control {{ $errors->has('port') ? 'is-invalid' : '' }}" type="text" name="port" id="port" value="{{ old('port', '') }}">
                @if($errors->has('port'))
                    <div class="invalid-feedback">
                        {{ $errors->first('port') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.port_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="username">{{ trans('cruds.emailSetup.fields.username') }}</label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', '') }}">
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.emailSetup.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', '') }}">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="encryption">{{ trans('cruds.emailSetup.fields.encryption') }}</label>
                <input class="form-control {{ $errors->has('encryption') ? 'is-invalid' : '' }}" type="text" name="encryption" id="encryption" value="{{ old('encryption', '') }}">
                @if($errors->has('encryption'))
                    <div class="invalid-feedback">
                        {{ $errors->first('encryption') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.encryption_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ip_address">{{ trans('cruds.emailSetup.fields.ip_address') }}</label>
                <input class="form-control {{ $errors->has('ip_address') ? 'is-invalid' : '' }}" type="text" name="ip_address" id="ip_address" value="{{ old('ip_address', '') }}">
                @if($errors->has('ip_address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ip_address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.ip_address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.emailSetup.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', '') }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.emailSetup.fields.status_helper') }}</span>
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