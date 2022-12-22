<html>
<head>
    <title>Home</title>
</head>
<body>
    
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengguna as $p)
                
                <tr>
                    <td>{{ $p["nama"] }}</td>
                    <td>{{ $p["email"] }}</td>
                </tr>

            @endforeach
        </tbody>
    </table>

</body>
</html>