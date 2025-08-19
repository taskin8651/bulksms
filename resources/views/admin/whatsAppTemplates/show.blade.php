@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whatsAppTemplate.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whats-app-templates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsAppTemplate.fields.id') }}
                        </th>
                        <td>
                            {{ $whatsAppTemplate->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsAppTemplate.fields.template_name') }}
                        </th>
                        <td>
                            {{ $whatsAppTemplate->template_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsAppTemplate.fields.subject') }}
                        </th>
                        <td>
                            {{ $whatsAppTemplate->subject }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsAppTemplate.fields.body') }}
                        </th>
                        <td>
                            {!! $whatsAppTemplate->body !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whats-app-templates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection