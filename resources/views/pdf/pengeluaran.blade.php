<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran</title>
</head>
<body>
    <h1>Laporan Pengeluaran</h1>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $item)
                <tr>
                    <td>{{ $item->barang->nama }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total Pengeluaran: </strong>{{ $total }}</p>
</body>
</html>
