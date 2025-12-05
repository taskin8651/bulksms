@extends('layouts.admin')
@section('content')

@can('whats_app_setup_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.whats-app-setups.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.whatsAppSetup.title_singular') }}
            </a>

            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'WhatsAppSetup', 'route' => 'admin.whats-app-setups.parseCsvImport'])
        </div>
    </div>
@endcan


<div class="card">
    <div class="card-header">
        {{ trans('cruds.whatsAppSetup.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">

        <table id="whatsappTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Provider Name</th>
                    <th>WABA ID</th>
                    <th>Phone Number ID</th>
                    <th>Sender Name</th>
                    <th>API Version</th>
                    <th>Webhook URL</th>
                    <th>Verify Token</th>
                    <th>Access Token</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($setups as $setup)
                    <tr>
                        <td></td>

                        <td>{{ $setup->id }}</td>

                        <td>{{ $setup->provider_name }}</td>

                        <td>{{ $setup->whatsapp_business_account_id }}</td>

                        <td>{{ $setup->phone_number_id }}</td>

                        <td>{{ $setup->sender_name }}</td>

                        <td>{{ $setup->api_version }}</td>

                        <td>{{ $setup->webhook_url }}</td>

                        <td>{{ $setup->verify_token }}</td>

                        <td>
                            <span class="badge badge-info">
                                ******{{ substr($setup->access_token, -6) }}
                            </span>
                        </td>

                        <td>{{ $setup->description }}</td>

                        <td>
                            @if($setup->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>

                        <td>{{ $setup->createdBy->name ?? '—' }}</td>

                        <td>{{ $setup->created_at }}</td>

                        <td>
                            @can('whats_app_setup_show')
                                <a class="btn btn-xs btn-primary"
                                   href="{{ route('admin.whats-app-setups.show', $setup->id) }}">
                                    View
                                </a>
                            @endcan

                            @can('whats_app_setup_edit')
                                <a class="btn btn-xs btn-info"
                                   href="{{ route('admin.whats-app-setups.edit', $setup->id) }}">
                                    Edit
                                </a>
                            @endcan

                            @can('whats_app_setup_delete')
                                <form action="{{ route('admin.whats-app-setups.destroy', $setup->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure?');"
                                      style="display: inline-block;">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $('#whatsappTable').DataTable({
            pageLength: 25,
            ordering: true
        });
    });
</script>
@endsection
