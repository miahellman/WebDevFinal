<?php include('../header.php'); ?> 
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        //go to database folder path
        $path = "/home/jsl10027/databases";
        $db = new SQLite3($path . '/orders.db');
    } catch (Exception $e) {
        die("Error connecting to database: " . $e->getMessage());
    }

    //CREATES TABLE HERE IF IT DOESN'T EXIST
    $sqlCreateTable = "
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        orderDate TEXT,
        customerName TEXT,
        email TEXT,
        address TEXT,
        phone TEXT,
        zipCode TEXT,
        creditCardMasked TEXT,
        qty1 INTEGER,
        qty2 INTEGER,
        qty3 INTEGER,
        qty4 INTEGER,
        qty5 INTEGER,
        qty6 INTEGER,
        shippingMethod TEXT,
        subtotal REAL,
        shippingCost REAL,
        grandTotal REAL
    );
    ";

    try {
        $db->exec($sqlCreateTable);
    } catch (Exception $e) {
        die("Error creating table: " . $e->getMessage());
    }

    //getting form values
    $customerName = trim($_POST['customerName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $zipCode = trim($_POST['zipCode'] ?? '');
    $creditCard = trim($_POST['creditCard'] ?? '');
    $qty1 = intval($_POST['qty1'] ?? 0);
    $qty2 = intval($_POST['qty2'] ?? 0);
    $qty3 = intval($_POST['qty3'] ?? 0);
    $qty4 = intval($_POST['qty4'] ?? 0);
    $qty5 = intval($_POST['qty5'] ?? 0);
    $qty6 = intval($_POST['qty6'] ?? 0);
    $shipping = $_POST['shipping'] ?? 'pickup';

    //make sure everything is filled out
    if (
        empty($customerName) || empty($email) || empty($address) ||
        empty($phone) || empty($zipCode) || empty($creditCard)
    ) {
        $success = false;
        $message = "Please fill in all required fields.";
    } elseif ($qty1 == 0 && $qty2 == 0 && $qty3 == 0 && $qty4 == 0 && $qty5 == 0 && $qty6 == 0) {
        $success = false;
        $message = "Please select at least one item.";
    } else {
        
        $product1Price = 25.00;
        $product2Price = 20.00;
        $product3Price = 8.00;
        $product4Price = 15.00;
        $product5Price = 30.00;
        $product6Price = 250.00;

        $subtotal1 = $qty1 * $product1Price;
        $subtotal2 = $qty2 * $product2Price;
        $subtotal3 = $qty3 * $product3Price;
        $subtotal4 = $qty4 * $product4Price;
        $subtotal5 = $qty5 * $product5Price;
        $subtotal6 = $qty6 * $product6Price;

        $cartSubtotal = $subtotal1 + $subtotal2 + $subtotal3 + $subtotal4 + $subtotal5 + $subtotal6;
        $shippingCost = ($shipping === 'shipping') ? 10.00 : 0.00;
        $grandTotal = $cartSubtotal + $shippingCost;

        $orderDate = date('Y-m-d H:i:s');
        $maskedCreditCard = str_repeat('*', strlen($creditCard) - 4) . substr($creditCard, -4);

        $sqlInsert = "
        INSERT INTO orders (
            orderDate, customerName, email, address, phone, zipCode,
            creditCardMasked, qty1, qty2, qty3, qty4, qty5, qty6,
            shippingMethod, subtotal, shippingCost, grandTotal
        )
        VALUES (
            :orderDate, :customerName, :email, :address, :phone, :zipCode,
            :creditCardMasked, :qty1, :qty2, :qty3, :qty4, :qty5, :qty6,
            :shippingMethod, :subtotal, :shippingCost, :grandTotal
        )
        ";

        try {
            $stmt = $db->prepare($sqlInsert);
            $stmt->bindValue(':orderDate', $orderDate, SQLITE3_TEXT);
            $stmt->bindValue(':customerName', $customerName, SQLITE3_TEXT);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':address', $address, SQLITE3_TEXT);
            $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
            $stmt->bindValue(':zipCode', $zipCode, SQLITE3_TEXT);
            $stmt->bindValue(':creditCardMasked', $maskedCreditCard, SQLITE3_TEXT);
            $stmt->bindValue(':qty1', $qty1, SQLITE3_INTEGER);
            $stmt->bindValue(':qty2', $qty2, SQLITE3_INTEGER);
            $stmt->bindValue(':qty3', $qty3, SQLITE3_INTEGER);
            $stmt->bindValue(':qty4', $qty4, SQLITE3_INTEGER);
            $stmt->bindValue(':qty5', $qty5, SQLITE3_INTEGER);
            $stmt->bindValue(':qty6', $qty6, SQLITE3_INTEGER);
            $stmt->bindValue(':shippingMethod', $shipping, SQLITE3_TEXT);
            $stmt->bindValue(':subtotal', $cartSubtotal, SQLITE3_FLOAT);
            $stmt->bindValue(':shippingCost', $shippingCost, SQLITE3_FLOAT);
            $stmt->bindValue(':grandTotal', $grandTotal, SQLITE3_FLOAT);

            $stmt->execute();

            $success = true;
            $message = "ORDER SUBMITTED!";

        } catch (Exception $e) {
            $success = false;
            $message = "Database insert error: " . $e->getMessage();
        }

        $db->close();
        unset($db);
    }

} else {
    $success = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THANK YOU!</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>

    <div class="confirmation-container" style="max-width: 700px; margin: 60px auto; text-align: center;">

        <h1 style="margin-bottom: 30px;">Order Confirmation</h1>

        <?php if ($success): ?>
            <div class="success" style="margin-bottom: 30px;">
                <h2 style="margin-bottom: 10px;"><?php echo htmlspecialchars($message); ?></h2>
            </div>

            <div class="order-summary" style="font-size: 18px; line-height: 1.6; text-align: center;">
                <p><strong>Order Date:</strong> <?= $orderDate ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($customerName) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($address) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
                <p><strong>ZIP:</strong> <?= htmlspecialchars($zipCode) ?></p>
                <p><strong>Card:</strong> <?= htmlspecialchars($maskedCreditCard) ?></p>

                <hr style="margin: 30px auto; width: 60%;">

                <p><strong>Subtotal:</strong> $<?= number_format($cartSubtotal, 2) ?></p>
                <p><strong>Shipping:</strong> $<?= number_format($shippingCost, 2) ?></p>
                <p><strong>Total:</strong> $<?= number_format($grandTotal, 2) ?></p>
            </div>

        <?php else: ?>
            <div class="error" style="margin-bottom: 30px;">
                <h2 style="margin-bottom: 10px;">✗ <?php echo htmlspecialchars($message); ?></h2>
            </div>
        <?php endif; ?>

        <a href="merch.html" class="back-button"
           style="display: inline-block; margin-top: 40px; background: #0300BF; color: white; padding: 12px 28px; border-radius: 4px; font-size: 18px;">
           BACK TO SHOP
        </a>

    </div>
</body>
</html>
