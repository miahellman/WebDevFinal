<?php
// submit_contact.php - Handle contact form submission

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form values
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    
    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $success = false;
        $errorMessage = "Please fill in all required fields.";
    } else {
        $success = true;
    }
    
} else {
    // If accessed directly without POST data
    $success = false;
    $errorMessage = "Invalid access method.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent - Space Network</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .message-container {
            max-width: 800px;
            margin: 80px auto;
            padding: 60px 40px;
            text-align: center;
            border: 2px solid #e0e0e0;
            background: white;
        }
        
        .success-icon {
            font-size: 80px;
            color: green;
            margin-bottom: 20px;
        }
        
        .error-icon {
            font-size: 80px;
            color: red;
            margin-bottom: 20px;
        }
        
        .message-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: black;
        }
        
        .message-container p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .back-button {
            display: inline-block;
            border: 1px solid black;
            color: black;
            padding: 15px 40px;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .back-button:hover {
            background: black;
            color: white;
        }
        
        .submission-details {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }
        
        .submission-details p {
            margin-bottom: 10px;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">SPACE NETWORK</div>
        
        <nav>
            <ul>
                <li><a href="about.html">ABOUT</a></li>
                <li><a href="shop/merch.html">MERCH</a></li>
                <li><a href="games.html">GAMES</a></li>
                <li><a href="contact.html">CONTACT</a></li>
                <li><a href="loginAndReg/login.html">LOGIN</a></li>
            </ul>
        </nav>
    </header>

    <div class="message-container">
        <?php if (isset($success) && $success): ?>
            <h1>Thank You for Reaching Out!</h1>
            <p>
                We've received your message and appreciate you taking the time to contact us. 
                Our team will review your inquiry and get back to you as soon as possible.
            </p>
            
            <div class="submission-details">
                <p><strong>Your Submission:</strong></p>
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Message:</strong></p>
                <p><?php echo nl2br($message); ?></p>
            </div>

       <?php else: ?>
            <div class="error-icon">✗</div>
            <h1>Oops! Something Went Wrong</h1>
            <p><?php echo isset($errorMessage) ? $errorMessage : 'An error occurred.'; ?></p>
        <?php endif; ?>
        
        <a href="contact.html" class="back-button">Back to Contact</a>
    </div>
</body>
</html>