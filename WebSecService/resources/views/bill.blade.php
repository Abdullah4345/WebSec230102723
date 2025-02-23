<?php
$items = [
    ['name' => 'Apples', 'quantity' => 5, 'price' => 2.00],
    ['name' => 'Bananas', 'quantity' => 3, 'price' => 1.50],
    ['name' => 'Oranges', 'quantity' => 4, 'price' => 2.50],
    ['name' => 'Milk', 'quantity' => 2, 'price' => 3.00]
];

function calculateTotal($quantity, $price) {
    return $quantity * $price;
}

$totalBill = 0;
foreach ($items as $item) {
    $totalBill += calculateTotal($item['quantity'], $item['price']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Supermarket Items</h2>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price ($)</th>
                    <th>Total ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo number_format(calculateTotal($item['quantity'], $item['price']), 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-dark">
                    <th colspan="3" class="text-end">Total Bill ($)</th>
                    <th><?php echo number_format($totalBill, 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
