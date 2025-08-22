@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        Transactions List
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance After</th>
                    <th>Description</th>
                    <th>Reference</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->balance_after }}</td>
                        <td>{{ $transaction->description }}</td>

                        {{-- Reference Model aur ID --}}
                        <td>
                            @if($transaction->reference)
                                {{ class_basename($transaction->reference_type) }} #{{ $transaction->reference_id }}
                            @else
                                -
                            @endif
                        </td>

                        {{-- Created By User --}}
                        <td>{{ $transaction->createdBy ? $transaction->createdBy->name : 'System' }}</td>

                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>

                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-xs btn-primary">
                                View
                            </a>
                            <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-xs btn-info">
                                Edit
                            </a>
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No transactions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
