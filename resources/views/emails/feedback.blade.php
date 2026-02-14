<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Feedback Baru</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px;">

    <div style="background: #ffffff; padding: 20px; border-radius: 8px;">
        <h3 style="margin-top: 0;">Feedback Baru Masuk</h3>

        <p><strong>Nama:</strong> {{ $feedback->name }}</p>
        <p><strong>Email:</strong> {{ $feedback->email }}</p>

        <hr>

        <p><strong>Pesan:</strong></p>
        <p style="white-space: pre-line;">
            {{ $feedback->message }}
        </p>

        <hr>

        <small>
            Email ini dikirim otomatis oleh sistem FinTrack.
        </small>
    </div>

</body>

</html>