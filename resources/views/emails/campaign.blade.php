<!DOCTYPE html>
<html>
<head>
    <title>{{ $template->subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $template->subject }}</h1>
    </div>
    
    <div class="content">
        {!! $content !!}
    </div>
    
    <div class="footer">
        <p>This email was sent to {{ $contact->email }}</p>
        <p>If you no longer wish to receive these emails, please unsubscribe.</p>
    </div>
</body>
</html>