<?php
$products = 
[
    "Chickenjoy" => 130,
    "Yumburger" => 140,
    "Jolly Spaghetti" => 75,
    "Palabok" => 130,
    "Burger Steak" => 150,
    "Big Burger Steak Supreme" => 200,
    "Classic Jolly Hotdog" => 80,
    "Peach Mango Pie" => 45,
    "Sundae" => 55,
    "Iced Tea" => 20,
];

$orderSummary = "";
$totalAmount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order'])) {
    foreach ($products as $product => $price) {
        $qty = isset($_POST['qty'][$product]) ? (int)$_POST['qty'][$product] : 0;
        if ($qty > 0) {
            $cost = $qty * $price;
            $orderSummary .= "$qty PC of $product. P$cost<br>";
            $totalAmount += $cost;
        }
    }

    if ($orderSummary) {
        $orderSummary = "You ordered:<br>" . $orderSummary . "<strong>Total: P$totalAmount</strong>";
    } else {
        $orderSummary = "No items selected.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Q4_WebDesign_04292025</title>
    <style>
        .product { margin-bottom: 10px; }
        .qty { display: inline-block; width: 30px; text-align: center; }
        button { margin: 0 5px; }
    </style>
    <script>
        function increaseQty(id) {
            let checkbox = document.getElementById("cb_" + id);
            let qty = document.getElementById("qty_" + id);
            qty.value = parseInt(qty.value) + 1;
            checkbox.checked = true;
        }

        function decreaseQty(id) {
            let checkbox = document.getElementById("cb_" + id);
            let qty = document.getElementById("qty_" + id);
            let newQty = parseInt(qty.value) - 1;
            if (newQty <= 0) {
                qty.value = 0;
                checkbox.checked = false;
            } else {
                qty.value = newQty;
            }
        }

        function toggleCheck(id) {
            let checkbox = document.getElementById("cb_" + id);
            let qty = document.getElementById("qty_" + id);
            if (checkbox.checked) {
                qty.value = 1;
            } else {
                qty.value = 0;
            }
        }
    </script>
</head>
<body>
    <h2>Ordering System</h2>
    <form method="POST">
        <?php foreach ($products as $product => $price): ?>
            <div class="product">
                <label>
                    <input type="checkbox" id="cb_<?= $product ?>" name="selected[]" onclick="toggleCheck('<?= $product ?>')">
                    <?= $product ?> - P<?= $price ?>
                </label>
                <button type="button" onclick="decreaseQty('<?= $product ?>')">−</button>
                <input class="qty" type="text" id="qty_<?= $product ?>" name="qty[<?= $product ?>]" value="0" readonly>
                <button type="button" onclick="increaseQty('<?= $product ?>')">+</button>
            </div>
        <?php endforeach; ?>
        <br>
        <button type="submit" name="order">Add to basket</button>
    </form>

    <?php if (!empty($orderSummary)): ?>
        <div style="margin-top: 20px; padding: 10px; background: #f0f0f0;">
            <?= $orderSummary ?>
        </div>
    <?php endif; ?>
</body>
</html>
