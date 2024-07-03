<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
            font-size: 16px;
            line-height: 24px;
            color: #333;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 8px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #f35525;
            color: #fff;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #f2f2f2;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #f35525;
            font-weight: bold;
        }
        .invoice-box .logo {
            height: 70px;
            width: auto;
        }
        .invoice-box .company-info {
            text-align: right;
        }
        .invoice-box .company-info h2 {
            margin: 0;
            font-size: 28px;
            color: #f35525;
        }
        .invoice-box .company-info p {
            margin: 0;
            font-size: 16px;
            color: #777;
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

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Invoice To:</strong><br>
                                {{ $pemesanan->Nama_Lengkap }}<br>
                                {{ $pemesanan->Email }}<br>
                                {{ $pemesanan->NoHP }}
                            </td>
                            <td>
                                <strong>Invoice #{{ $pemesanan->Order_Id }}</strong><br>
                                {{ $pemesanan->Tgl_Pemesanan }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Booking</td>
                <td>Harga Sewa</td>
            </tr>

            <tr class="item">
                <td>Kamar <strong>{{ $pemesanan->kamar->pemilik->Nama_Kost }}</strong><br>
                    ({{ $pemesanan->Durasi_sewa }} Bulan, {{ $pemesanan->Tgl_mulai_sewa }} hingga {{ $pemesanan->Tgl_habis_sewa }})
                </td>
                <td>{{ 'Rp ' . number_format($pemesanan->kamar->Harga, 0, ',', '.') }}</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total: {{ 'Rp ' . number_format($pemesanan->Total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
