@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.organizer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.organizers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.organizer.fields.id') }}
                        </th>
                        <td>
                            {{ $organizer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.organizer.fields.title') }}
                        </th>
                        <td>
                            {{ $organizer->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.organizer.fields.description') }}
                        </th>
                        <td>
                            {!! $organizer->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.organizers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection