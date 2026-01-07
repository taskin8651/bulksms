@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        WhatsApp Message Logs
    </div>

    <div class="card-body">
        <div class="mb-3">
    <span class="badge badge-primary">Total: {{ $summary->total }}</span>
    <span class="badge badge-success">Sent: {{ $summary->sent }}</span>
    <span class="badge badge-danger">Failed: {{ $summary->failed }}</span>
    <span class="badge badge-warning">Pending: {{ $summary->pending }}</span>
</div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Contact</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Error</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $log->contact->name ?? 'N/A' }} <br>
                            <small>{{ $log->contact->whatsapp_number ?? '' }}</small>
                        </td>
                        <td>{!! $log->message !!}</td>
                        <td>
                            <span class="badge badge-{{ 
                                $log->status == 'sent' ? 'success' :
                                ($log->status == 'failed' ? 'danger' : 'warning')
                            }}">
                                {{ strtoupper($log->status) }}
                            </span>
                        </td>
                        <td>{{ $log->error_message ?? '-' }}</td>
                        <td>{{ $log->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
