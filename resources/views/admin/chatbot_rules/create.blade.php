@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Create Chatbot Rule
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.chatbot.rules.store') }}">
            @csrf

            <div class="form-group">
                <label class="required" for="trigger_type">Trigger Type</label>
                <select class="form-control {{ $errors->has('trigger_type') ? 'is-invalid' : '' }}" name="trigger_type" id="trigger_type" required>
                    @foreach(['exact','contains','starts_with','default'] as $type)
                        <option value="{{ $type }}" {{ old('trigger_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="trigger_value">Trigger Value</label>
                <input type="text" name="trigger_value" id="trigger_value" class="form-control" value="{{ old('trigger_value') }}">
            </div>

            <div class="form-group">
                <label class="required" for="reply_message">Reply Message</label>
                <textarea class="form-control ckeditor" name="reply_message" id="reply_message" rows="4" required>{{ old('reply_message') }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority">Priority</label>
                <input type="number" name="priority" id="priority" class="form-control" value="{{ old('priority', 1) }}">
            </div>

            <div class="form-group">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">Save Rule</button>
            </div>
        </form>
    </div>
</div>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<script>
$(document).ready(function () {

    // CKEditor SimpleUploadAdapter
    function SimpleUploadAdapter(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
            return {
                upload: function() {
                    return loader.file
                        .then(function(file) {
                            return new Promise(function(resolve, reject) {
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '{{ route('admin.chatbot.rules.storeCKEditorImages') }}', true);
                                xhr.setRequestHeader('x-csrf-token', window._token);
                                xhr.setRequestHeader('Accept', 'application/json');
                                xhr.responseType = 'json';

                                xhr.addEventListener('error', function() { reject(`Couldn't upload file: ${file.name}.`) });
                                xhr.addEventListener('abort', function() { reject() });
                                xhr.addEventListener('load', function() {
                                    var response = xhr.response;
                                    if (!response || xhr.status !== 201) {
                                        return reject(`Couldn't upload file: ${file.name}.`);
                                    }
                                    // Add hidden input to form
                                    if ($('form').length) {
                                        $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                                    }
                                    resolve({ default: response.url });
                                });

                                if (xhr.upload) {
                                    xhr.upload.addEventListener('progress', function(e) {
                                        if (e.lengthComputable) {
                                            loader.uploadTotal = e.total;
                                            loader.uploaded = e.loaded;
                                        }
                                    });
                                }

                                var data = new FormData();
                                data.append('upload', file);
                                data.append('crud_id', 0); // Create page, id = 0
                                xhr.send(data);
                            });
                        });
                }
            };
        }
    }

    // Initialize CKEditor for all textareas with class 'ckeditor'
    document.querySelectorAll('.ckeditor').forEach(editorEl => {
        ClassicEditor.create(editorEl, {
            extraPlugins: [SimpleUploadAdapter]
        })
        .then(editor => {
            // Push editor content back to textarea before form submit
            const form = editorEl.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    editor.updateSourceElement();
                });
            }
        })
        .catch(error => {
            console.error('CKEditor error:', error);
        });
    });

});
</script>

@endsection