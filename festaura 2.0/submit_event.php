<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


 

 
 
  

$u_id= $_SESSION['user_id'];
$u_name=$_SESSION['username'];
$role=$_SESSION['role'];

 

 if($role!=="organizer") { header("Location: index.php"); exit;}

?>

<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $event_name = $_POST['event-name'];
    $short_details = $_POST['short-details'];
    $about_event = $_POST['about-event'];
    $event_date = $_POST['event-date'];
    $event_start_time = $_POST['event-start-time'];
    $event_end_time = $_POST['event-end-time'];
    $event_location = $_POST['event-location'];
    $event_category = $_POST['event-category'];
    $event_organiser = $_POST['event-organiser'];
    $admin_contact = $_POST['admin-contact'];
    $public_contact = $_POST['public-contact'];
    $event_type = $_POST['event-type'];
    $what_to_expect = $_POST['what-to-expect'];
    $reg_type = $_POST['registration-method'];
    $organizer_id=$u_id;

    // For now, static poster & QR code filenames
 
 
 
if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
 
    $pfile = $_FILES['poster'];
    $poster_name = $pfile['name'];
    $poster_type = $pfile['type'];
    $poster_size = $pfile['size'];
    $poster_data = file_get_contents($pfile['tmp_name']);

}

 
if (isset($_FILES['qrcode']) && $_FILES['qrcode']['error'] === UPLOAD_ERR_OK) {
    $qrcode = file_get_contents($_FILES['qrcode']['tmp_name']);

    $qfile = $_FILES['qrcode'];
    $qrcode_name = $qfile['name'];
    $qrcode_type = $qfile['type'];
    $qrcode_size = $qfile['size'];
    $qrcode_data = file_get_contents($qfile['tmp_name']);
}

 


    try {
        $stmt = $pdo->prepare("INSERT INTO new_events (
           poster_name, poster_type, poster_size, poster_data, qrcode_name, qrcode_type, qrcode_size, qrcode_data, event_name, short_details, about_event,
            event_date, event_start_time, event_end_time, event_location,
            event_category, event_organiser, admin_contact, public_contact,
            event_type, what_to_expect, reg_type, organizer_id
        ) VALUES (
            :poster_name, :poster_type, :poster_size, :poster_data, :qrcode_name, :qrcode_type, :qrcode_size, :qrcode_data, :event_name, :short_details, :about_event,
            :event_date, :event_start_time, :event_end_time, :event_location,
            :event_category, :event_organiser, :admin_contact, :public_contact,
            :event_type, :what_to_expect, :reg_type, :organizer_id
        )");

        $stmt->execute([
            ':poster_name' => $poster_name,
            ':poster_type' => $poster_type,
            ':poster_size' => $poster_size,
            ':poster_data' => $poster_data,
            ':qrcode_name' => $qrcode_name,
            ':qrcode_type' => $qrcode_type,
            ':qrcode_size' => $qrcode_size,
            ':qrcode_data' => $qrcode_data,
           
            ':event_name' => $event_name,
            ':short_details' => $short_details,
            ':about_event' => $about_event,
            ':event_date' => $event_date,
            ':event_start_time' => $event_start_time,
            ':event_end_time' => $event_end_time,
            ':event_location' => $event_location,
            ':event_category' => $event_category,
            ':event_organiser' => $event_organiser,
            ':admin_contact' => $admin_contact,
            ':public_contact' => $public_contact,
            ':event_type' => $event_type,
            ':what_to_expect' => $what_to_expect,
            ':reg_type' => $reg_type,
            ':organizer_id' => $organizer_id
        ]);

      header("Location: msg.php");
    } catch (PDOException $e) {
        echo "Error inserting event: " . $e->getMessage();
    }
}
?>

