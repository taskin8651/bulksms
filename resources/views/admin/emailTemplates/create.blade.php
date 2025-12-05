@extends('layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <h4>Create Email Template</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.email-templates.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Template Name</label>
                            <input type="text" name="template_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Body</label>
                            <textarea name="body" rows="8" class="form-control" placeholder="Write email content here..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Template</button>
                        <a href="{{ route('admin.email-templates.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
