<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; color: #212529; }
        .header { text-align: center; padding-bottom: 10px; border-bottom: 2px solid #242a62; }
        .row { display: flex; justify-content: space-between; margin-top: 12px; }
        .box { border: 1px solid #dee2e6; padding: 12px; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding: 8px; border-bottom: 1px solid #eee; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>ZobPot</h2>
        <p>Payment Receipt</p>
    </div>

    <div class="row">
        <div class="box" style="flex:1; margin-right:10px;">
            <strong>Bill To</strong>
            <p>{{ $user->name ?? 'N/A' }}</p>
            <p>{{ $user->email ?? '' }}</p>
        </div>
        <div class="box" style="width: 200px; text-align: right;">
            <strong>Transaction</strong>
            <p>{{ $payment->transaction_id }}</p>
            <p>{{ $payment->paid_on ? $payment->paid_on->format('d M Y H:i') : '' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Internship Enrollment Fee</td>
                <td class="right">₹{{ number_format($payment->total_amount - ($payment->gst_amount ?? 0), 2) }}</td>
            </tr>
            <tr>
                <td>GST ({{ $payment->gst_percentage }}%)</td>
                <td class="right">₹{{ number_format($payment->gst_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount Paid</strong></td>
                <td class="right"><strong>₹{{ number_format($payment->total_amount, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top:20px; font-size:12px; color:#6c757d;">This is a system generated receipt.</p>
</body>
</html>