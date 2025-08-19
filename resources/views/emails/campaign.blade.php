<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $template->subject ?? '' }}</title>
</head>
<body>
    <p>Dear {{ $contact->name }},</p>

    {{-- ⚠️ change $content → $body --}}
    {!! $body !!}

    <p>Regards,<br>Team Scroll2Earn</p>
</body>
</html>
