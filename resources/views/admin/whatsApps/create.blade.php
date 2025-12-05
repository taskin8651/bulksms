@extends('layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Create WhatsApp Campaign</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.whats-apps.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Campaign Name --}}
                <div class="form-group mb-3">
                    <label for="campaign_name" class="form-label required">Campaign Name</label>
                    <input type="text" name="campaign_name" id="campaign_name" 
                           value="{{ old('campaign_name') }}" class="form-control @error('campaign_name') is-invalid @enderror" required>
                    @error('campaign_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Template --}}
                <div class="form-group mb-3">
                    <label for="template_id" class="form-label required">Template</label>
                    <select name="template_id" id="template_id" class="form-control @error('template_id') is-invalid @enderror" required>
                        <option value="">-- Select Template --</option>
                        @foreach($templates as $id => $template)
                            <option value="{{ $id }}" {{ old('template_id') == $id ? 'selected' : '' }}>{{ $template }}</option>
                        @endforeach
                    </select>
                    @error('template_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Contacts Checkboxes --}}
                <div class="form-group mb-3">
                    <label class="form-label required">Contacts</label>
                    <div class="mb-2">
                        <button type="button" class="btn btn-info btn-sm select-all me-2">Select All</button>
                        <button type="button" class="btn btn-secondary btn-sm deselect-all">Deselect All</button>
                    </div>
                    <div class="row border p-3 rounded" style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa;">
                        @foreach($contacts as $id => $number)
                            <div class="col-md-3 col-sm-4 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input contact-checkbox" type="checkbox" name="contacts[]" value="{{ $id }}" 
                                        id="contact-{{ $id }}"
                                        {{ in_array($id, old('contacts', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="contact-{{ $id }}">
                                        {{ $number }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('contacts')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="form-group mt-3 text-end">
                    <button type="submit" class="btn btn-success btn-lg">Send Campaign</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllBtn = document.querySelector('.select-all');
        const deselectAllBtn = document.querySelector('.deselect-all');
        const checkboxes = document.querySelectorAll('.contact-checkbox');

        selectAllBtn.addEventListener('click', () => {
            checkboxes.forEach(cb => cb.checked = true);
        });

        deselectAllBtn.addEventListener('click', () => {
            checkboxes.forEach(cb => cb.checked = false);
        });
    });
</script>
@endsection
