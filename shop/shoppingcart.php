<?php include('../header.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form values submitted by the user
    $customerName = isset($_POST['customerName']) ? trim($_POST['customerName']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $zipCode = isset($_POST['zipCode']) ? trim($_POST['zipCode']) : '';
    $creditCard = isset($_POST['creditCard']) ? trim($_POST['creditCard']) : '';
    $qty1 = isset($_POST['qty1']) ? intval($_POST['qty1']) : 0;
    $qty2 = isset($_POST['qty2']) ? intval($_POST['qty2']) : 0;
    $qty3 = isset($_POST['qty3']) ? intval($_POST['qty3']) : 0;
    $qty4 = isset($_POST['qty4']) ? intval($_POST['qty4']) : 0;
    $qty5 = isset($_POST['qty5']) ? intval($_POST['qty5']) : 0;
    $qty6 = isset($_POST['qty6']) ? intval($_POST['qty6']) : 0;
    $shipping = isset($_POST['shipping']) ? $_POST['shipping'] : 'pickup';
    
    // Basic validation
    if (empty($customerName) || empty($email) || empty($address) || empty($phone) || empty($zipCode) || empty($creditCard)) {
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
        
        $orderData = array(
            $orderDate,
            $customerName,
            $email,
            $address,
            $phone,
            $zipCode,
            $maskedCreditCard,
            $qty1,
            $qty2,
            $qty3,
            $qty4,
            $qty5,
            $qty6,
            $shipping,
            number_format($cartSubtotal, 2),
            number_format($shippingCost, 2),
            number_format($grandTotal, 2)
        );

        $dataLine = implode('|', $orderData) . "\n";
        
        $filename = 'orders.txt';
        $writeResult = file_put_contents($filename, $dataLine, FILE_APPEND | LOCK_EX);
        
        if ($writeResult !== false) {
            $success = true;
            $message = "Order successfully submitted!";
        } else {
            $success = false;
            $message = "Error saving order. Please try again.";
        }
    }
    
} else {
    $success = false;
    $message = "Invalid access method.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Space Network</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: white;
            color: #000;
        }
        
        .confirmation-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 40px;
            text-align: center;
        }
        
        .confirmation-container h1 {
            color: #000;
            margin-bottom: 30px;
            font-size: 2em;
            font-weight: bold;
        }
        
        .success {
            color: #28a745;
            font-size: 1.3em;
            margin-bottom: 20px;
        }
        
        .error {
            color: #dc3545;
            font-size: 1.3em;
            margin-bottom: 20px;
        }
        
        .order-summary {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 0;
            padding: 30px;
            margin: 20px 0;
            text-align: left;
        }
        
        .order-summary h3 {
            color: #000;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .order-summary p {
            color: #000;
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .order-summary hr {
            border: none;
            border-top: 2px solid #000;
            margin: 15px 0;
        }
        
        .back-button {
            display: inline-block;
            background: #000;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            background: #333;
        }
    </style>
</head>
<body>

    <div class="confirmation-container">
        <h1>Order Confirmation</h1>
        
        <?php if (isset($success) && $success): ?>
            <div class="success">
                <h2>✓ <?php echo htmlspecialchars($message); ?></h2>
            </div>
            
            <?php if (isset($orderData)): ?>
            <div class="order-summary">
                <h3>Order Summary</h3>
                <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDate); ?></p>
                <p><strong>Customer:</strong> <?php echo htmlspecialchars($customerName); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>ZIP Code:</strong> <?php echo htmlspecialchars($zipCode); ?></p>
                <p><strong>Credit Card:</strong> <?php echo htmlspecialchars($maskedCreditCard); ?></p>
                <hr>
                <?php if ($qty1 > 0): ?>
                <p><strong>Space Network T-Shirt:</strong> <?php echo $qty1; ?> × $25.00 = $<?php echo number_format($subtotal1, 2); ?></p>
                <?php endif; ?>
                <?php if ($qty2 > 0): ?>
                <p><strong>Astronaut Baseball Cap:</strong> <?php echo $qty2; ?> × $20.00 = $<?php echo number_format($subtotal2, 2); ?></p>
                <?php endif; ?>
                <?php if ($qty3 > 0): ?>
                <p><strong>Astronaut Ice Cream:</strong> <?php echo $qty3; ?> × $8.00 = $<?php echo number_format($subtotal3, 2); ?></p>
                <?php endif; ?>
                <?php if ($qty4 > 0): ?>
                <p><strong>Solar System Coffee Mug:</strong> <?php echo $qty4; ?> × $15.00 = $<?php echo number_format($subtotal4, 2); ?></p>
                <?php endif; ?>
                <?php if ($qty5 > 0): ?>
                <p><strong>Galaxy Poster Set:</strong> <?php echo $qty5; ?> × $30.00 = $<?php echo number_format($subtotal5, 2); ?></p>
                <?php endif; ?>
                <?php if ($qty6 > 0): ?>
                <p><strong>Astronaut Helmet Replica:</strong> <?php echo $qty6; ?> × $250.00 = $<?php echo number_format($subtotal6, 2); ?></p>
                <?php endif; ?>
                <p><strong>Shipping Method:</strong> <?php echo ($shipping === 'shipping') ? 'Standard Shipping ($10.00)' : 'Store Pickup (Free)'; ?></p>
                <hr>
                <p><strong>Subtotal:</strong> $<?php echo number_format($cartSubtotal, 2); ?></p>
                <p><strong>Shipping:</strong> $<?php echo number_format($shippingCost, 2); ?></p>
                <p style="font-size: 1.3em;"><strong>Grand Total:</strong> $<?php echo number_format($grandTotal, 2); ?></p>
            </div>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="error">
                <h2>✗ Error: <?php echo htmlspecialchars($message); ?></h2>
            </div>
        <?php endif; ?>
        
        <a href="merch.html" class="back-button">Back to Shop</a>
    </div>
</body>
</html>