@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <b>Chatbot Test</b>
    </div>

    <div class="card-body">

        {{-- Dynamic Help / Keywords --}}
        @if(isset($rules) && $rules->count())
            <div class="alert alert-info">
                👋 <b>Welcome!</b><br>
                Neeche diye gaye keywords try karein:
                <br><br>

                @foreach($rules as $rule)
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary mb-1 quick-btn"
                        data-msg="{{ $rule->trigger_value }}">
                        {{ ucfirst($rule->trigger_value) }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Chat Form --}}
        <form id="chatTest">
            @csrf
            <input
                type="text"
                name="message"
                class="form-control"
                placeholder="Type your message here..."
                required
            >
            <br>
            <button class="btn btn-primary">
                Send
            </button>
        </form>

        <hr>

        {{-- Bot Reply --}}
        <div id="reply" class="p-3 border rounded bg-light" style="font-weight:bold;"></div>

    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // Submit chat form
    $('#chatTest').on('submit', function(e){
        e.preventDefault();

        $('#reply').html('⏳ Bot is typing...');

        $.post('{{ route("admin.chatbot.rules.test") }}', $(this).serialize(), function(res){
            $('#reply').html(res.reply);
        });
    });

    // Quick keyword buttons
    $('.quick-btn').click(function(){
        let msg = $(this).data('msg');
        $('input[name="message"]').val(msg);
        $('#chatTest').submit();
    });

});
</script>
@endsection
