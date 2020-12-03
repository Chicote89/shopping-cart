<?php

require_once('functions.php');

$pdo = pdo_connect_mysql();
$msg = "";
// Check to make sure the id parameter is specified in the URL
if (isset($_POST['email'])) {
    // Prepare statement and execute, prevents SQL injection
    $sql = 'SELECT * 
            FROM users 
            WHERE email = ? AND 
                  password = ?';

    $stmt = $pdo->prepare($sql);
    $params = [$_POST['email'], $_POST['password']];
    $stmt->execute($params);

    // Fetch the product from the database and return the result as an Array
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the user exists (array is not empty)
    if (!$user) {
        // Simple error to display if the id for the user doesn't exists (array is empty)
        $msg = 'Invalid username or password!';
    } else {
        $msg = 'You logged in successfully.';
    }
}
?>

<?=template_header('Login')?>

<div class="login content-wrapper">

    <div>
        <h1 class="name">User Login</h1>
        <p><?php echo $msg; ?></p>
        <form action="login.php" method="post">
            <input type="email" name="email" value=""  placeholder="email" required>
            <input type="password" name="password" value="" required>
            <input type="submit" value="Login">
        </form>
        
    </div>
</div>

<?=template_footer()?>