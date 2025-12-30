@extends('layouts.admin')
@section('content')

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.chatbot.rules.create') }}">
                Add Chatbot Rule
            </a>
        </div>
    </div>


<div class="card">
    <div class="card-header">
        Chatbot Rules List
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Trigger Type</th>
                    <th>Trigger Value</th>
                    <th>Reply Message</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules as $rule)
                    <tr>
                        <td>{{ $rule->id }}</td>
                        <td>{{ $rule->trigger_type }}</td>
                        <td>{{ $rule->trigger_value ?? '-' }}</td>
                        <td>{{ $rule->reply_message }}</td>
                        <td>{{ $rule->priority }}</td>
                        <td>
                            @if($rule->is_active)
                                <span class="text-success font-semibold">Active</span>
                            @else
                                <span class="text-danger font-semibold">Inactive</span>
                            @endif
                        </td>
                        <td>
                           
                                <a class="btn btn-sm btn-warning" href="{{ route('admin.chatbot.rules.edit', $rule->id) }}">Edit</a>
                           
                          
                                <form action="{{ route('admin.chatbot.rules.destroy', $rule->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                           
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
