<?php include 'db_connect.php'; ?>
<?php 
 //echo password_hash("pass123", PASSWORD_DEFAULT);

$hashed='$2y$12$dJ1YmdhWXfdwr4XxiVb5ROgTVkWjtGyc9uBsHqs7tFgmW/VMr1VMe';
 try {
        $stmt = $pdo->prepare("INSERT INTO users 
            (role, fullname, email, rollno, branch, year, contact, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(["admin", "sanjay", "sanjay@gmail.com", null, null, null, null, $hashed]);
        $user_id = $pdo->lastInsertId();

       

      $token = bin2hex(random_bytes(16));
    try {
        $stmt = $pdo->prepare("INSERT INTO email_verification (user_id, token, is_verified) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $token, 1]);

       echo "✅ Admin added successfully";
        
    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error sending verification: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

?>
