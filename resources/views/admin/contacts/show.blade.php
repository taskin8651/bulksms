@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.contact.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.id') }}
                        </th>
                        <td>
                            {{ $contact->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.name') }}
                        </th>
                        <td>
                            {{ $contact->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.email') }}
                        </th>
                        <td>
                            {{ $contact->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.phone_number') }}
                        </th>
                        <td>
                            {{ $contact->phone_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.whatsapp_number') }}
                        </th>
                        <td>
                            {{ $contact->whatsapp_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Contact::STATUS_SELECT[$contact->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.contact.fields.organization') }}
                        </th>
                        <td>
                            {{ App\Models\Contact::ORGANIZATION_SELECT[$contact->organization] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection