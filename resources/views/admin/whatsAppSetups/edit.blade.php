@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.whatsAppSetup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.whats-app-setups.update', [$whatsAppSetup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            {{-- PROVIDER --}}
            <div class="form-group">
                <label class="required" for="provider_name">{{ trans('cruds.whatsAppSetup.fields.provider_name') }}</label>
                <select class="form-control" name="provider_name" id="provider_name" required>
                    @foreach(App\Models\WhatsAppSetup::PROVIDER_NAME_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ $whatsAppSetup->provider_name == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- WHATSAPP BUSINESS ACCOUNT ID --}}
            <div class="form-group">
                <label class="required" for="whatsapp_business_account_id">{{ trans('cruds.whatsAppSetup.fields.whatsapp_business_account_id') }}</label>
                <input class="form-control" type="text" name="whatsapp_business_account_id"
                       id="whatsapp_business_account_id" value="{{ old('whatsapp_business_account_id', $whatsAppSetup->whatsapp_business_account_id) }}" required>
            </div>

            {{-- PHONE NUMBER ID --}}
            <div class="form-group">
                <label class="required" for="phone_number_id">{{ trans('cruds.whatsAppSetup.fields.phone_number_id') }}</label>
                <input class="form-control" type="text" name="phone_number_id"
                       id="phone_number_id" value="{{ old('phone_number_id', $whatsAppSetup->phone_number_id) }}" required>
            </div>

            {{-- ACCESS TOKEN --}}
            <div class="form-group">
                <label class="required" for="access_token">{{ trans('cruds.whatsAppSetup.fields.access_token') }}</label>
                <textarea class="form-control" name="access_token" id="access_token" required>{{ old('access_token', $whatsAppSetup->access_token) }}</textarea>
            </div>

            {{-- VERIFY TOKEN --}}
            <div class="form-group">
                <label class="required" for="verify_token">{{ trans('cruds.whatsAppSetup.fields.verify_token') }}</label>
                <input class="form-control" type="text" name="verify_token"
                       id="verify_token" value="{{ old('verify_token', $whatsAppSetup->verify_token) }}" required>
            </div>

            {{-- WEBHOOK URL --}}
            <div class="form-group">
                <label for="webhook_url">{{ trans('cruds.whatsAppSetup.fields.webhook_url') }}</label>
                <input class="form-control" type="text" name="webhook_url"
                       id="webhook_url" value="{{ old('webhook_url', $whatsAppSetup->webhook_url) }}">
            </div>

            {{-- SENDER NAME --}}
            <div class="form-group">
                <label for="sender_name">{{ trans('cruds.whatsAppSetup.fields.sender_name') }}</label>
                <input class="form-control" type="text" name="sender_name"
                       id="sender_name" value="{{ old('sender_name', $whatsAppSetup->sender_name) }}">
            </div>

            {{-- API VERSION --}}
            <div class="form-group">
                <label for="api_version">{{ trans('cruds.whatsAppSetup.fields.api_version') }}</label>
                <input class="form-control" type="text" name="api_version"
                       id="api_version" value="{{ old('api_version', $whatsAppSetup->api_version) }}">
            </div>

            {{-- DESCRIPTION --}}
            <div class="form-group">
                <label for="description">{{ trans('cruds.whatsAppSetup.fields.description') }}</label>
                <textarea class="form-control" name="description" id="description">{{ old('description', $whatsAppSetup->description) }}</textarea>
            </div>

            {{-- STATUS --}}
            <div class="form-group">
                <label class="required" for="status">{{ trans('cruds.whatsAppSetup.fields.status') }}</label>
                <select class="form-control" name="status" id="status" required>
                    <option value="1" {{ old('status', $whatsAppSetup->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $whatsAppSetup->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
            </div>

        </form>
    </div>
</div>

@endsection
