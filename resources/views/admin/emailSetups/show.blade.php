@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.emailSetup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.email-setups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.id') }}
                        </th>
                        <td>
                            {{ $emailSetup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.provider_name') }}
                        </th>
                        <td>
                            {{ App\Models\EmailSetup::PROVIDER_NAME_SELECT[$emailSetup->provider_name] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.from_name') }}
                        </th>
                        <td>
                            {{ $emailSetup->from_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.from_email') }}
                        </th>
                        <td>
                            {{ $emailSetup->from_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.host') }}
                        </th>
                        <td>
                            {{ $emailSetup->host }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.port') }}
                        </th>
                        <td>
                            {{ $emailSetup->port }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.username') }}
                        </th>
                        <td>
                            {{ $emailSetup->username }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.password') }}
                        </th>
                        <td>
                            {{ $emailSetup->password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.encryption') }}
                        </th>
                        <td>
                            {{ $emailSetup->encryption }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.ip_address') }}
                        </th>
                        <td>
                            {{ $emailSetup->ip_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.emailSetup.fields.status') }}
                        </th>
                        <td>
                            {{ $emailSetup->status }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.email-setups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection