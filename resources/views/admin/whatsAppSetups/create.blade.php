@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.whatsAppSetup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.whats-app-setups.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Provider Name --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.whatsAppSetup.fields.provider_name') }}</label>
                <select name="provider_name" id="provider_name"
                        class="form-control {{ $errors->has('provider_name') ? 'is-invalid' : '' }}" required>
                    <option value="" disabled selected>-- Select Provider --</option>
                    @foreach(App\Models\WhatsAppSetup::PROVIDER_NAME_SELECT as $key => $val)
                        <option value="{{ $key }}" {{ old('provider_name') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
                @if($errors->has('provider_name'))
                    <span class="text-danger">{{ $errors->first('provider_name') }}</span>
                @endif
            </div>

            {{-- Business Account ID --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.whatsAppSetup.fields.whatsapp_business_account_id') }}</label>
                <input type="text" name="whatsapp_business_account_id" id="whatsapp_business_account_id"
                       class="form-control {{ $errors->has('whatsapp_business_account_id') ? 'is-invalid' : '' }}"
                       value="{{ old('whatsapp_business_account_id') }}" required>
                @if($errors->has('whatsapp_business_account_id'))
                    <span class="text-danger">{{ $errors->first('whatsapp_business_account_id') }}</span>
                @endif
            </div>

            {{-- Phone Number ID --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.whatsAppSetup.fields.phone_number_id') }}</label>
                <input type="text" name="phone_number_id" id="phone_number_id"
                       class="form-control {{ $errors->has('phone_number_id') ? 'is-invalid' : '' }}"
                       value="{{ old('phone_number_id') }}" required>
                @if($errors->has('phone_number_id'))
                    <span class="text-danger">{{ $errors->first('phone_number_id') }}</span>
                @endif
            </div>

            {{-- Access Token --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.whatsAppSetup.fields.access_token') }}</label>
                <input type="text" name="access_token" id="access_token"
                       class="form-control {{ $errors->has('access_token') ? 'is-invalid' : '' }}"
                       value="{{ old('access_token') }}" required>
                @if($errors->has('access_token'))
                    <span class="text-danger">{{ $errors->first('access_token') }}</span>
                @endif
            </div>

            {{-- Verify Token --}}
            <div class="form-group">
                <label>{{ trans('cruds.whatsAppSetup.fields.verify_token') }}</label>
                <input type="text" name="verify_token" id="verify_token"
                       class="form-control {{ $errors->has('verify_token') ? 'is-invalid' : '' }}"
                       value="{{ old('verify_token') }}">
                @if($errors->has('verify_token'))
                    <span class="text-danger">{{ $errors->first('verify_token') }}</span>
                @endif
            </div>

            {{-- Webhook URL --}}
            <div class="form-group">
                <label>{{ trans('cruds.whatsAppSetup.fields.webhook_url') }}</label>
                <input type="text" name="webhook_url" id="webhook_url"
                       class="form-control {{ $errors->has('webhook_url') ? 'is-invalid' : '' }}"
                       value="{{ old('webhook_url') }}">
                @if($errors->has('webhook_url'))
                    <span class="text-danger">{{ $errors->first('webhook_url') }}</span>
                @endif
            </div>

            {{-- Sender Name --}}
            <div class="form-group">
                <label>{{ trans('cruds.whatsAppSetup.fields.sender_name') }}</label>
                <input type="text" name="sender_name" id="sender_name"
                       class="form-control {{ $errors->has('sender_name') ? 'is-invalid' : '' }}"
                       value="{{ old('sender_name') }}">
                @if($errors->has('sender_name'))
                    <span class="text-danger">{{ $errors->first('sender_name') }}</span>
                @endif
            </div>

            {{-- API Version --}}
            <div class="form-group">
                <label>{{ trans('cruds.whatsAppSetup.fields.api_version') }}</label>
                <input type="text" name="api_version" id="api_version"
                       placeholder="e.g., v20.0"
                       class="form-control {{ $errors->has('api_version') ? 'is-invalid' : '' }}"
                       value="{{ old('api_version') }}">
                @if($errors->has('api_version'))
                    <span class="text-danger">{{ $errors->first('api_version') }}</span>
                @endif
            </div>

            {{-- Description --}}
            <div class="form-group">
                <label>{{ trans('cruds.whatsAppSetup.fields.description') }}</label>
                <textarea name="description" id="description"
                          class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label class="required">{{ trans('cruds.whatsAppSetup.fields.status') }}</label>
                <select name="status" id="status"
                        class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" required>
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
            </div>

            {{-- Submit Button --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
