<?php
include 'db_connect.php';


if (!isset($_GET['type']) || !isset($_GET['id'])) {
    die("Invalid request");
}
$type = isset($_GET['type']) ? trim($_GET['type']) : '';
 $id = $_GET['id'] ?? 0;
 $tab = $_GET['tab'] ?? '';

if ($type === 'poster') {
    $col_data = 'poster_data';
    $col_type = 'poster_type';
} elseif ($type === 'qrcode') {
    $col_data = 'qrcode_data';
    $col_type = 'qrcode_type';
} else {
    die("Invalid type: '$type'");
}


// Decide which column to fetch
if ($type === 'poster') {
    $col_data = 'poster_data';
    $col_type = 'poster_type';
} elseif ($type === 'qrcode') {
    $col_data = 'qrcode_data';
    $col_type = 'qrcode_type';
} else {
    die("Invalid type");
}

if($tab==='new') $tab_n='new_events';

else $tab_n='events';

$stmt = $pdo->prepare("SELECT $col_type, $col_data FROM $tab_n WHERE id = :id");
$stmt->execute([':id' => $id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if ($image) {
    // Disable all output buffering & compression
    if (ob_get_length()) ob_end_clean();
    header("Content-Type: " . $image[$col_type]);
    header("Content-Length: " . strlen($image[$col_data]));
    echo $image[$col_data];
    exit;
} else {
    http_response_code(404);
    echo "Image not found.";
}

