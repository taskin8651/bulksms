@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card shadow-sm">
        
        <div class="card-header">
            <h3 class="card-title">Create WhatsApp Template</h3>
        </div>

        <div class="card-body">

            <form method="POST" 
                  action="{{ route('admin.whats-app-templates.store') }}" 
                  enctype="multipart/form-data">
                @csrf

                {{-- Template Name --}}
                <div class="mb-3">
                    <label for="template_name" class="form-label">
                        Template Name <span class="text-danger">*</span>
                    </label>

                    <input type="text" 
                           id="template_name" 
                           name="template_name"
                           value="{{ old('template_name') }}"
                           class="form-control @error('template_name') is-invalid @enderror"
                           required>

                    @error('template_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Subject --}}
                <div class="mb-3">
                    <label for="subject" class="form-label">
                        Subject <span class="text-danger">*</span>
                    </label>

                    <input type="text" 
                           id="subject" 
                           name="subject"
                           value="{{ old('subject') }}"
                           class="form-control @error('subject') is-invalid @enderror"
                           required>

                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Body --}}
                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>

                    <textarea id="body" 
                              name="body"
                              class="form-control ckeditor @error('body') is-invalid @enderror">{{ old('body') }}</textarea>

                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Save Template
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $(function () {

        function SimpleUploadAdapter(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                return {
                    upload: function () {
                        return loader.file.then(function (file) {
                            return new Promise(function (resolve, reject) {

                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '{{ route('admin.whats-app-templates.storeCKEditorImages') }}', true);
                                xhr.setRequestHeader('x-csrf-token', window._token);
                                xhr.responseType = 'json';

                                xhr.onload = function () {
                                    var response = xhr.response;

                                    if (xhr.status !== 201) {
                                        return reject(response && response.message ? response.message : "Upload error");
                                    }

                                    $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
                                    resolve({ default: response.url });
                                };

                                xhr.onerror = function () { reject("Upload error"); };
                                xhr.onabort = function () { reject(); };

                                var data = new FormData();
                                data.append('upload', file);
                                data.append('crud_id', 0);
                                xhr.send(data);

                            });
                        });
                    }
                };
            }
        }

        document.querySelectorAll('.ckeditor').forEach((el) => {
            ClassicEditor.create(el, {
                extraPlugins: [SimpleUploadAdapter],
            });
        });

    });
</script>
@endsection
