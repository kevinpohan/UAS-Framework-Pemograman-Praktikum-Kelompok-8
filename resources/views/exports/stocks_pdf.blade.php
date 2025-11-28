<!DOCTYPE html>
<html>

<head>
    <title>Stocks Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Stocks List</h2>
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Currency</th>
                <th>Visible</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->symbol }}</td>
                <td>{{ $stock->name }}</td>
                <td>{{ $stock->currency }}</td>
                <td>{{ $stock->is_visible ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>