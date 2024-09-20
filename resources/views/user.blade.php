<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1 style="text-align: center;">Data User</h1>

    <!-- Tabel untuk menampilkan jumlah pengguna -->
    <table border="1" cellpadding="5" cellspacing="0" align="center">
        <thead>
            <tr>
                <th>Jumlah Pengguna</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">{{ $userCount }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
