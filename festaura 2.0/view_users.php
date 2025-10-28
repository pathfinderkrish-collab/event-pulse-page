<?php
session_start();
if (!isset($_SESSION['user_id'])) {
     header("Location: index.php");
    exit;
}


if (!isset($_GET['event_id']))  exit; 

include 'db_connect.php'; // your PDO connection file

$event_id = $_GET['event_id']; // example event ID (you can get this dynamically from $_GET or $_POST)

// Query: get users who registered for this event + event details
$sql = "SELECT 
            e.event_name,
            u.fullname,
            u.email,
            u.rollno,
            u.branch,
            u.year,
            u.contact,
            u.role,
            r.registered_at
        FROM registrations r
        INNER JOIN users u ON r.student_id = u.id
        INNER JOIN events e ON r.event_id = e.id
        WHERE r.event_id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get event name (if at least one registration exists)
$event_name = count($users) > 0 ? $users[0]['event_name'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registered Students</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background: #007BFF;
            color: white;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            color: #333;
        }
    </style>
</head>
<body>

<h2>Registered Students for Event: 
    <span style="color:#007BFF;">
        <?php echo htmlspecialchars($event_name ?? 'Unknown Event'); ?>
    </span>
</h2>
 
<a href="organizer_dashboard.php">Go_back</a><br><br>
<table>
    <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Roll No</th>
        <th>Branch</th>
        <th>Year</th>
 
        <th>Registered At</th>
    </tr>

    <?php if (count($users) > 0): ?>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['fullname']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['rollno']) ?></td>
            <td><?= htmlspecialchars($user['branch']) ?></td>
            <td><?= htmlspecialchars($user['year']) ?></td>
 
      
            <td><?= htmlspecialchars($user['registered_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No students registered for this event.</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>
