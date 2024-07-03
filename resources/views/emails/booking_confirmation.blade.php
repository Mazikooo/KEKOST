
<!DOCTYPE html>
<html>
<head>
    <title>Booking Anda Sukses</title>
</head>
<body>
    <h1>Booking Anda Sukses!</h1>
    <p>Detail Pemesanan:</p>
    <ul>
        <li>Nama Lengkap: {{ $pemesanan->Nama_Lengkap }}</li>
        <li>Email: {{ $pemesanan->Email }}</li>
        <li>Nomor HP: {{ $pemesanan->NoHP }}</li>
        <li>Durasi Sewa: {{ $pemesanan->Durasi_sewa }}</li>
        <li>Tanggal Mulai Sewa: {{ $pemesanan->Tgl_mulai_sewa }}</li>
        <li>Tanggal Habis Sewa: {{ $pemesanan->Tgl_habis_sewa }}</li>
        <li>Total Harga: Rp {{ number_format($pemesanan->Total_harga, 0, ',', '.') }}</li>
        <li>ID Order: {{ $pemesanan->Order_Id }}</li>
    </ul>
    <p>Terima kasih telah melakukan pemesanan!</p>
</body>
</html>
