@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whatsApp.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whats-apps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.id') }}
                        </th>
                        <td>
                            {{ $whatsApp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.campaign_name') }}
                        </th>
                        <td>
                            {{ $whatsApp->campaign_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.template') }}
                        </th>
                        <td>
                            {{ $whatsApp->template->template_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.contacts') }}
                        </th>
                        <td>
                            @foreach($whatsApp->contacts as $key => $contacts)
                                <span class="label label-info">{{ $contacts->whatsapp_number }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.coins_used') }}
                        </th>
                        <td>
                            {{ $whatsApp->coins_used }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsApp.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\WhatsApp::STATUS_SELECT[$whatsApp->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whats-apps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection