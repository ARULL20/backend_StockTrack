<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemasukan</title>
</head>
<body>
    <h1>Laporan Pemasukan</h1>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasukan as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total Pemasukan: </strong>{{ $total }}</p>
</body>
</html>
