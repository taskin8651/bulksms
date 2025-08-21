@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Add Wallet Amount
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallets.store") }}" enctype="multipart/form-data">
            @csrf

            {{-- Amount --}}
            <div class="form-group">
                <label for="balance">Enter Amount</label>
                <input 
                    class="form-control {{ $errors->has('balance') ? 'is-invalid' : '' }}" 
                    type="number" 
                    name="balance" 
                    id="balance" 
                    value="{{ old('balance') }}" 
                    step="0.01"
                    required
                >
                @if($errors->has('balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('balance') }}
                    </div>
                @endif
            </div>

            {{-- Hidden fields (auto handled in controller) --}}
            {{-- created_by_id = auth user --}}
            {{-- status = pending --}}

            {{-- Submit --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
