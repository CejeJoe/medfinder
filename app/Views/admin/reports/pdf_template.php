<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MedFinder Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>MedFinder Report</h1>
    
    <h2>Summary</h2>
    <p>Total Sales: UGX <?= number_format($totalSales, 2) ?></p>
    <p>Total Orders: <?= number_format($totalOrders) ?></p>

    <h2>Top Selling Drugs</h2>
    <table>
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topSellingDrugs as $drug): ?>
            <tr>
                <td><?= esc($drug['name']) ?></td>
                <td><?= number_format($drug['total_sales']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Revenue by Pharmacy</h2>
    <table>
        <thead>
            <tr>
                <th>Pharmacy Name</th>
                <th>Total Sales</th>
                <th>Total Orders</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($revenueByPharmacy as $pharmacy): ?>
            <tr>
                <td><?= esc($pharmacy['name']) ?></td>
                <td>UGX <?= number_format($pharmacy['total_sales'], 2) ?></td>
                <td><?= number_format($pharmacy['total_orders']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

