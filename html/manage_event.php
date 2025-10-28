<?php
session_start();
if (!isset($_SESSION['user_id'])) {
     header("Location: index.php");
     exit;
}


 
$u_id= $_SESSION['user_id'];
$u_name=$_SESSION['username'];
$role=$_SESSION['role'];

if($role==="admin" || $role==="organizer");
else { header("Location: index.php"); exit;}

?>

<?php
include 'db_connect.php';  

$event_id = $_GET['id']; 

$stmt = $pdo->prepare("SELECT organizer_id FROM events WHERE id = ?");
$stmt->execute([$event_id]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event && $role==="organizer")  exit;


?>

<?php 

 

if (!isset($_GET['cmd']) || !isset($_GET['id']) || !isset($_GET['type'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

try {
    if ($_GET['cmd'] === 'del') {

    if($_GET['type']==='neve')   $table_name="new_events";
   else if($_GET['type']==='eve')   $table_name="events";
   
        $stmt = $pdo->prepare("DELETE FROM $table_name WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
    } 
    else if ($_GET['cmd'] === 'accept') {
       
        
$sql = "INSERT INTO events SELECT * FROM new_events WHERE id = ?";

 
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

  $stmt = $pdo->prepare("DELETE FROM new_events WHERE id = :id");
        $stmt->execute([':id' => $id]);

    } 
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


if($role==="admin")  header("Location: admin_dashboard.php");
else if($role==="organizer")  header("Location: organizer_dashboard.php");
?>

