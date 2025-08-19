@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.email.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.id') }}
                        </th>
                        <td>
                            {{ $email->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.campaign_name') }}
                        </th>
                        <td>
                            {{ $email->campaign_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.template') }}
                        </th>
                        <td>
                            {{ $email->template->template_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.contacts') }}
                        </th>
                        <td>
                            @foreach($email->contacts as $key => $contacts)
                                <span class="label label-info">{{ $contacts->email }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.coins_used') }}
                        </th>
                        <td>
                            {{ $email->coins_used }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.email.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Email::STATUS_SELECT[$email->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.emails.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection