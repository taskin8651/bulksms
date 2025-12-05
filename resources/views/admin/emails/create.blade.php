@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.email.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.emails.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Campaign Name --}}
            <div class="form-group">
                <label class="required" for="campaign_name">{{ trans('cruds.email.fields.campaign_name') }}</label>
                <input class="form-control {{ $errors->has('campaign_name') ? 'is-invalid' : '' }}"
                       type="text"
                       name="campaign_name"
                       id="campaign_name"
                       value="{{ old('campaign_name', '') }}"
                       required>
                @if($errors->has('campaign_name'))
                    <div class="invalid-feedback">{{ $errors->first('campaign_name') }}</div>
                @endif
            </div>

            {{-- Template --}}
            <div class="form-group">
                <label class="required" for="template_id">{{ trans('cruds.email.fields.template') }}</label>
                <select class="form-control select2 {{ $errors->has('template_id') ? 'is-invalid' : '' }}"
                        name="template_id"
                        id="template_id"
                        required>
                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                    @foreach($templates as $id => $entry)
                        <option value="{{ $id }}" {{ old('template_id') == $id ? 'selected' : '' }}>
                            {{ $entry }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('template_id'))
                    <div class="invalid-feedback">{{ $errors->first('template_id') }}</div>
                @endif
            </div>

            {{-- Contacts --}}
            <div class="form-group">
                <label class="required" for="contacts">Contacts</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                </div>

                <select class="form-control select2 {{ $errors->has('contacts') ? 'is-invalid' : '' }}"
                        name="contacts[]"
                        id="contacts"
                        multiple
                        required>

                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}"
                            {{ in_array($contact->id, old('contacts', [])) ? 'selected' : '' }}>
                            {{ $contact->name }} ({{ $contact->email }})
                        </option>
                    @endforeach

                </select>
                @if($errors->has('contacts'))
                    <div class="invalid-feedback">{{ $errors->first('contacts') }}</div>
                @endif
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>{{ trans('cruds.email.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}"
                        name="status"
                        id="status">

                    @foreach(App\Models\Email::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'draft') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach

                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">{{ $errors->first('status') }}</div>
                @endif
            </div>

            {{-- Save --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>

        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
$(document).ready(function () {
    $('#contacts').select2({ width: '100%' });
    $('#template_id').select2({ width: '100%' });

    $('.select-all').click(function () {
        $('#contacts option').prop('selected', true);
        $('#contacts').trigger('change');
    });

    $('.deselect-all').click(function () {
        $('#contacts option').prop('selected', false);
        $('#contacts').trigger('change');
    });
});
</script>
@endsection
