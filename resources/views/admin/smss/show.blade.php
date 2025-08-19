@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sms.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.smss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.id') }}
                        </th>
                        <td>
                            {{ $sms->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.campaign_name') }}
                        </th>
                        <td>
                            {{ $sms->campaign_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.template') }}
                        </th>
                        <td>
                            {{ $sms->template->template_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.contacts') }}
                        </th>
                        <td>
                            @foreach($sms->contacts as $key => $contacts)
                                <span class="label label-info">{{ $contacts->phone_number }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.coins_used') }}
                        </th>
                        <td>
                            {{ $sms->coins_used }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sms.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Sms::STATUS_SELECT[$sms->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.smss.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection