<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
            background-color: #fff;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.heading td {
            background: #f35525;
            color: #fff;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box .company-info {
            text-align: right;
        }

        .invoice-box .company-info h2 {
            margin: 0;
            text-align: right;
            font-size: 28px;
            color: #f35525;
        }

        .invoice-box .company-info p {
            margin: 0;
            font-size: 16px;
            color: #777;
        }

        .invoice-box h2 {
            color: #f35525;
            text-align: center;
        }

        .invoice-box h3 {
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .invoice-box .logo {
            height: 50px;
            width: auto;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/images/home-title.png') }}" alt="KEKOST" class="logo">
                            </td>
                            <td class="company-info">
                                <h2>KEKOST</h2>
                                <p>Jl. Ring Road Utara, Condongcatur<br>Sleman, Indonesia</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <h3>Laporan Transaksi</h3>
        <table>
            <thead>
                <tr class="heading">
                    <td>Booking</td>
                    <td>Harga Sewa</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanans as $pms)
                <tr class="item">
                    <td> Oleh <strong>{{ $pms->penyewa->Nama_Lengkap }}</strong> <br>
                        ({{ $pms->Durasi_sewa }} Bulan, {{ $pms->Tgl_mulai_sewa }} hingga {{ $pms->Tgl_habis_sewa }})</td>
                    <td>{{ 'Rp ' . number_format($pms->kamar->Harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
