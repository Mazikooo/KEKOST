<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di KEKOST!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #f35525;
            color: #ffffff;
            padding: 10px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 20px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            color: #666666;
            line-height: 1.5;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            text-align: center;
            font-size: 14px;
            color: #999999;
        }
        /* Ensure all elements are displayed */
        * {
            display: block !important;
            visibility: visible !important;
        }

        /* Media query for mobile */
        @media only screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
            }
            .header h1 {
                font-size: 20px;
            }
            .content h1 {
                font-size: 18px;
            }
            .content p {
                font-size: 14px;
            }
            .footer {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KEKOST</h1>
        </div>
        <div class="content">
            <h1>Selamat Datang, {{ $validated['Nama_Lengkap'] }}!</h1>
            <p>Terima kasih telah mendaftar di KEKOST. Kami sangat senang menyambut Anda!</p>
            <p>Silakan login ke akun Anda dan mulai mencari kamar kost yang sesuai dengan kebutuhan Anda.</p>
            <p>Salam hangat,</p>
            <p>Tim KEKOST</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 KEKOST. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
