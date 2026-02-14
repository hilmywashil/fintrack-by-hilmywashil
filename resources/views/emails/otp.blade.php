<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kode OTP Reset Password</title>
</head>

<body style="background:#f4f4f4; padding:20px; font-family: Arial, sans-serif;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width:600px; background:#ffffff; border-radius:10px; padding:20px;">

        <tr>
            <td style="text-align:center; padding:10px;">
                <img src="https://i.ibb.co.com/PzQ6WHDz/logo-square.png" width="200" alt="FinTrack Logo">
            </td>
        </tr>

        <tr>
            <td style="padding:20px;">
                <h3 style="margin-bottom:10px;">Permintaan Reset Password</h3>

                <p>Halo,</p>

                <p>
                    Gunakan kode OTP di bawah ini untuk melanjutkan proses reset password akun FinTrack Anda:
                </p>

                <div style="
                background:#f2f2f2;
                padding:15px;
                text-align:center;
                font-size:24px;
                font-weight:bold;
                letter-spacing:5px;
                margin:20px 0;
                border-radius:8px;
            ">
                    {{ $otp ?? 'XXXXXX' }}
                </div>

                <p>
                    Kode OTP ini hanya berlaku selama <strong>10 menit</strong>.
                </p>

                <p>
                    Jika Anda tidak merasa melakukan permintaan ini,
                    abaikan saja email ini.
                </p>

                <hr style="margin:20px 0;">

                <p style="font-size:12px; color:#888;">
                    Email ini dikirim secara otomatis oleh sistem FinTrack.
                    Mohon tidak membalas email ini.
                </p>
            </td>
        </tr>

        <tr>
            <td style="text-align:center; padding:10px; font-size:12px; color:#999;">
                © {{ date('Y') }} FinTrack. All Rights Reserved.
            </td>
        </tr>

    </table>

</body>

</html>