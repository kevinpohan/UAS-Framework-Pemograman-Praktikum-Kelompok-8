<!DOCTYPE html>
<html>

<head>
    <title>Transaction History</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: sans-serif;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #0f172a;
            color: white;
        }
    </style>
</head>

<body>
    <h2>Transaction History</h2>
    <p>User: {{ Auth::user()->name }} | Date: {{ now()->format('Y-m-d') }}</p>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Symbol</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ ucfirst($t->type) }}</td>
                <td>{{ $t->stock ? $t->stock->symbol : '-' }}</td>
                <td>{{ $t->qty }}</td>
                <td>${{ number_format($t->price, 2) }}</td>
                <td>${{ number_format($t->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>