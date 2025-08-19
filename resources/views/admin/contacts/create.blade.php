@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.contact.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.contacts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.contact.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.contact.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.contact.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="number" name="phone_number" id="phone_number" value="{{ old('phone_number', '') }}" step="1">
                @if($errors->has('phone_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp_number">{{ trans('cruds.contact.fields.whatsapp_number') }}</label>
                <input class="form-control {{ $errors->has('whatsapp_number') ? 'is-invalid' : '' }}" type="number" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', '') }}" step="1">
                @if($errors->has('whatsapp_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp_number') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.whatsapp_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.contact.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Contact::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'active') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.contact.fields.organization') }}</label>
                <select class="form-control {{ $errors->has('organization') ? 'is-invalid' : '' }}" name="organization" id="organization">
                    <option value disabled {{ old('organization', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Contact::ORGANIZATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('organization', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('organization'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organization') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.contact.fields.organization_helper') }}</span>
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