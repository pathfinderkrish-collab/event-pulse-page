<?php include 'db_connect.php'; ?>
<?php
 

 

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM email_verification WHERE token=?");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && !$row['is_verified']) {
        // Update verification
        $stmt2 = $pdo->prepare("UPDATE email_verification SET is_verified=1 WHERE id=?");
        $stmt2->execute([$row['id']]);
        echo "✅ Your email has been verified! <a href='http://localhost'>click here</a> to login.";
    } else {
        echo "❌ Invalid or already verified token.";
    }
} else {
    echo "❌ Token not provided.";
}
  
?>

