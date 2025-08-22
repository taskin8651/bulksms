@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.transaction.title') }}
    </div>

    <div class="card-body">
        <div class="mb-3">
            <a class="btn btn-default" href="{{ route('admin.transactions.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.id') }}</th>
                    <td>{{ $transaction->id }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.wallet') }}</th>
                    <td>{{ $transaction->wallet }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.amount') }}</th>
                    <td>{{ $transaction->amount ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.type') }}</th>
                    <td>{{ $transaction->type ?? '-' }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.created_at') }}</th>
                    <td>{{ $transaction->created_at ? $transaction->created_at->format('d-m-Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>{{ trans('cruds.transaction.fields.updated_at') }}</th>
                    <td>{{ $transaction->updated_at ? $transaction->updated_at->format('d-m-Y H:i') : '-' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-3">
            <a class="btn btn-default" href="{{ route('admin.transactions.index') }}">
                {{ trans('global.back_to_list') }}
            </a>
        </div>
    </div>
</div>

@endsection
