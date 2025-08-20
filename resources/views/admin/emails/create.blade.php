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
                    <div class="invalid-feedback">
                        {{ $errors->first('campaign_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.campaign_name_helper') }}</span>
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
                    <div class="invalid-feedback">
                        {{ $errors->first('template_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.template_helper') }}</span>
            </div>

            {{-- Organizer / Business Type --}}
            <div class="form-group">
                <label class="required" for="organizer_id">Business Type</label>
                <select class="form-control select2 {{ $errors->has('organizer_id') ? 'is-invalid' : '' }}" 
                        name="organizer_id" 
                        id="organizer_id" 
                        required>
                    <option value="all">-- All Business Types --</option>
                    @foreach($organizers as $id => $entry)
                        <option value="{{ $id }}" {{ old('organizer_id') == $id ? 'selected' : '' }}>
                            {{ $entry }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('organizer_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('organizer_id') }}
                    </div>
                @endif
                <span class="help-block">Select a business type to filter contacts</span>
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
                    {{-- Options will be loaded by AJAX --}}
                </select>
                @if($errors->has('contacts'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contacts') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.contacts_helper') }}</span>
            </div>

            {{-- Coins Used --}}
            <div class="form-group">
                <label for="coins_used">{{ trans('cruds.email.fields.coins_used') }}</label>
                <input class="form-control {{ $errors->has('coins_used') ? 'is-invalid' : '' }}" 
                       type="number" 
                       name="coins_used" 
                       id="coins_used" 
                       value="{{ old('coins_used', '0') }}" 
                       min="0">
                @if($errors->has('coins_used'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coins_used') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.coins_used_helper') }}</span>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>{{ trans('cruds.email.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" 
                        name="status" 
                        id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Email::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', 'draft') === (string) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.email.fields.status_helper') }}</span>
            </div>

            {{-- Save Button --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Section --}}
@section('scripts')
<script>
$(document).ready(function () {
    $('#contacts').select2({ width: '100%', placeholder: "Select contacts" });
    $('#organizer_id').select2({ width: '100%' });

    // Laravel से old values
    let oldContacts = @json(old('contacts', []));

    function loadContacts(organizerId) {
        console.log("➡ Sending request for organizer:", organizerId);

        $.ajax({
            url: "/get-contacts-by-organizer/" + organizerId,
            type: "GET",
            success: function (data) {
                console.log("✅ Response received:", data);

                $('#contacts').empty();

                if (data.length === 0) {
                    console.warn("⚠ No contacts found for this organizer");
                }

                $.each(data, function (i, contact) {
                    let organizerTitle = contact.organizer ? contact.organizer.title : "No Organizer";

                    // अगर old selected contacts हैं तो उन्हें दुबारा select करो
                    let selected = oldContacts.includes(contact.id) ? true : false;

                    $('#contacts').append(
                        $('<option>', {
                            value: contact.id,
                            text: contact.name + " (" + contact.email + ") - " + organizerTitle,
                            selected: selected
                        })
                    );
                });

                $('#contacts').trigger('change'); // refresh select2
            },
            error: function (xhr, status, error) {
                console.error("❌ AJAX Error:", error);
                console.error("📄 Full Response:", xhr.responseText);
            }
        });
    }

    // Page load पर organizer select हुआ है या नहीं
    let initialOrganizer = $('#organizer_id').val() || "all";
    console.log("🔄 Initial load with organizer:", initialOrganizer);
    loadContacts(initialOrganizer);

    // जब organizer बदले
    $('#organizer_id').on('change', function () {
        let organizerId = $(this).val();
        console.log("🔄 Organizer changed:", organizerId);
        oldContacts = []; // change पर पुरानी selection clear कर दो
        loadContacts(organizerId);
    });

    $('.select-all').click(function () {
        console.log("✔ Select all clicked");
        $('#contacts option').prop('selected', true);
        $('#contacts').trigger('change');
        return false;
    });

    $('.deselect-all').click(function () {
        console.log("✖ Deselect all clicked");
        $('#contacts option').prop('selected', false);
        $('#contacts').trigger('change');
        return false;
    });
});
</script>
@endsection

@endsection
