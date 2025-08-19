@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sms.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.smss.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="campaign_name">{{ trans('cruds.sms.fields.campaign_name') }}</label>
                <input class="form-control {{ $errors->has('campaign_name') ? 'is-invalid' : '' }}" type="text" name="campaign_name" id="campaign_name" value="{{ old('campaign_name', '') }}" required>
                @if($errors->has('campaign_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('campaign_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.campaign_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="template_id">{{ trans('cruds.sms.fields.template') }}</label>
                <select class="form-control select2 {{ $errors->has('template') ? 'is-invalid' : '' }}" name="template_id" id="template_id" required>
                    @foreach($templates as $id => $entry)
                        <option value="{{ $id }}" {{ old('template_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('template'))
                    <div class="invalid-feedback">
                        {{ $errors->first('template') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.template_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="contacts">{{ trans('cruds.sms.fields.contacts') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('contacts') ? 'is-invalid' : '' }}" name="contacts[]" id="contacts" multiple required>
                    @foreach($contacts as $id => $contact)
                        <option value="{{ $id }}" {{ in_array($id, old('contacts', [])) ? 'selected' : '' }}>{{ $contact }}</option>
                    @endforeach
                </select>
                @if($errors->has('contacts'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contacts') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.contacts_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coins_used">{{ trans('cruds.sms.fields.coins_used') }}</label>
                <input class="form-control {{ $errors->has('coins_used') ? 'is-invalid' : '' }}" type="text" name="coins_used" id="coins_used" value="{{ old('coins_used', '') }}">
                @if($errors->has('coins_used'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coins_used') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.coins_used_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sms.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sms::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'running') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sms.fields.status_helper') }}</span>
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