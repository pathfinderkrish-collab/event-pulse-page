<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>


<?php 

include 'db_connect.php';

if (!isset($_GET['cmd']) || !isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

try {
    if ($_GET['cmd'] === 'del') {
        $stmt = $pdo->prepare("DELETE FROM events_list WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
    } 
    else if ($_GET['cmd'] === 'accept') {
        $stmt = $pdo->prepare("UPDATE events_list SET is_showing = :val WHERE id = :id");
        $stmt->execute([
            ':val' => 1,
            ':id' => $id
        ]);
        
    } 
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


 header("Location: dashboard.php");
?>

