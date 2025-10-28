<?php
session_start();
if (!isset($_SESSION['user_id'])) {
     header("Location: index.php");
     exit;
}


 // $_SESSION['user_id'] = $user['id'];
 // $_SESSION['username'] = $user['username'];
 // $_SESSION['role'] = $user['role'];

$u_id= $_SESSION['user_id'];
$u_name=$_SESSION['username'];
$role=$_SESSION['role'];
 
 

if($role!=="student") { header("Location: index.php"); exit;}

?>

<?php include 'db_connect.php'; ?>
<?php
 

 

if (isset($_GET['event_id'])) {


$event_id = $_GET['event_id'];
$student_id = $u_id;
 
try{
$stmt = $pdo->prepare("INSERT INTO registrations (event_id, student_id) VALUES (?, ?)");
$stmt->execute([$event_id, $student_id]);

echo "✅ You are registered for this event!"; 
}
 catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }

} else {
    echo "❌ ERROR";
}
  
?>

