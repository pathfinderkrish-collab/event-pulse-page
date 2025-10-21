<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<?php include 'db_connect.php'; 

if (  !isset($_GET['id'])) {
    die("Invalid request");
}
 $id = $_GET['id'] ?? 0;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Rhythm Fest 2025 - festaura</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#fbf7ff;
      --muted:#6a6a78;
      --purple:#7b4bff;
      --soft:#efe9f9;
      --card:#ffffff;
      --shadow: 0 8px 18px rgba(25,20,50,0.06);
      --radius: 10px;
    }
    *{box-sizing:border-box}
    html,body{min-height:100%;margin:0;font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;color:#17141a;background:linear-gradient(180deg,#fbf7ff 0%, #f6eff9 100%)}

    header{position:sticky;top:0;background:rgba(255,255,255,0.9);backdrop-filter: blur(4px);box-shadow:0 1px 0 rgba(0,0,0,0.04);z-index:30}
    .nav{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:18px}
    .brand{display:flex;align-items:center;gap:12px}
    .brand .logo{width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--purple),#c28bff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
    .brand h1{font-size:18px;margin:0}
    nav ul{list-style:none;display:flex;gap:18px;margin:0;padding:0;color:var(--muted)}
    nav a{color:var(--muted);text-decoration:none;font-weight:500}
    .cta{display:flex;gap:10px;align-items:center}
    .btn{padding:10px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;text-align:center;font-family:inherit}
    .btn.secondary{background:#fff;border:1px solid #eee;color:inherit}
    .btn.primary{background:var(--purple);color:#fff;box-shadow:0 6px 18px rgba(123,75,255,0.18)}
    .btn.success{background:#10b981;color:#fff;box-shadow:0 6px 18px rgba(16,185,129,0.18)}

    .hero{height:350px;display:flex;flex-direction:column;justify-content:flex-end;padding:32px;background:linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=1600&q=80') center/cover;color:#fff}
    .hero .tag{background:rgba(255,255,255,0.15);padding:6px 12px;border-radius:8px;font-size:13px;font-weight:700;display:inline-block;align-self:flex-start;margin-top:10px}
    .hero .title{font-size:44px;font-weight:800;margin:10px 0}

    main{max-width:1200px;margin:-80px auto 40px;display:grid;grid-template-columns:2.5fr 1fr;gap:30px;padding:20px;position:relative;z-index:10}
    .content{background:var(--card);border-radius:12px;padding:28px;box-shadow:var(--shadow)}

    .sidebar{display:flex;flex-direction:column;gap:20px}
    .sidebar-card{background:var(--card);border-radius:12px;padding:20px;box-shadow:var(--shadow)}
    .sidebar-card h3{margin:0 0 12px 0;font-size:18px}
    .info-row{display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid #f0f0f0}
    .info-row:last-child{border:0}
    .info-row .label{color:var(--muted);font-weight:500;font-size:14px}
    .info-row .value, .org{font-weight:600;color:#111}

    .organizer-card{display:flex;gap:12px;align-items:center}
    .organizer-logo{width:44px;height:44px;min-width:44px;border-radius:8px;background:var(--soft);color:var(--purple);font-weight:700;display:flex;align-items:center;justify-content:center}
    .organizer-info{flex:1}
    .organizer-info h4{margin:0 0 4px 0;font-size:18px}
    .organizer-info p{margin:0;font-size:14px;color:var(--muted)}

    .section-title{font-weight:700;font-size:20px;margin:0 0 16px 0}
    .description{line-height:1.7;color:#444}
    
    .highlights{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-top:20px}
    .highlight-item{display:flex;align-items:flex-start;gap:12px;padding:16px;background:var(--soft);border-radius:10px}
    .highlight-icon{width:32px;height:32px;border-radius:8px;background:var(--purple);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0}
    .highlight-text{flex:1}
    .highlight-text strong{display:block;margin-bottom:4px}
    .highlight-text span{color:var(--muted);font-size:14px}

    .event-section{margin-top:28px}
    .section-title{font-weight:700;font-size:20px;margin:0 0 16px 0}
    .description{line-height:1.7;color:#444}
    
    /* ✅ Popup styling */
    .popup-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .popup-box {
      background: #efe9f9;
      width: 200px;
      height: 200px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
  .btn.danger {
        background: #ffebee;
        color: #d32f2f;
        border: 1px solid #ffcdd2;
    }
  </style>
</head>
<body>
  <header>
    <div class="nav">
      <div class="brand">
        <div class="logo">F</div>
        <h1>festaura</h1>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="events.php">Events</a></li>
          <li><a href="#">Clubs</a></li>
        </ul>
      </nav>
      <div class="cta">
        <a class="btn primary" href="logout.php">Logout</a>
<a class="btn secondary" href="dashboard.php">Admin Panel</a>
      </div>
    </div>
  </header>
<?php 
 
    $stmt = $pdo->prepare("SELECT * FROM events_list WHERE id = :id");
    $stmt->execute([':id' => $id]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

 
  <div class="hero" style="background-image:linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7)), url('/show_image.php?type=poster&id=<?php echo $id;?>');">
    <h1 class="title"><?php echo $row['event_name'];?></h1>
    <div class="tag"><?php echo $row['event_category'];?></div>
  </div>

  <main>
    <div class="content">
      <h2 class="section-title">About this Event</h2>
      <p class="description">
        <?php echo $row['about_event'];?>
      </p>
    
      
      <section class="event-section">
        <h2 class="section-title">What to Expect</h2>
        <div class="highlights">
<?php echo $row['what_to_expect'];?>
        </div>
      </section>

 <section class="event-section">
        <h2 class="section-title">Contact Information</h2>
 

    
            <div class="info-row">
              <span class="label">Email</span>
              <span class="value"><?php echo $row['public_contact'];?></span>
            </div>
      

        </div>
      </section>

    </div>

    <aside class="sidebar">
      <div class="sidebar-card" id="actionButtons">
        <button class="btn danger" style="width:100%" id="registerBtn" onclick="window.location.href='manage_event.php?cmd=del&id=<?php echo $row['id'];?>'" >Delete Event</button>
      </div>

      <div class="sidebar-card">
        <h3>Event Details</h3>
        <div class="info-row">
          <span class="label">Date & Time</span>
          <span class="value"><?php echo date("F j, Y", strtotime($row['event_date']));?> | <?php echo date("g:i A", strtotime($row['event_start_time']));?> to  <?php echo date("g:i A", strtotime($row['event_end_time']));?></span>
        </div>
        <div class="info-row">
          <span class="label">Location</span>
          <span class="value"><?php echo $row['event_location'];?></span>
        </div>
        <div class="info-row">
          <span class="label">Price</span>
          <span class="value"><?php echo $row['event_type'];?></span>
        </div>
      </div>

      <div class="sidebar-card">
        <h3>Organized By</h3>
        <div class="organizer-card">
       
          <div class="org">
        <span class="value"><?php echo $row['event_organiser'];?></span>
          </div>
        </div>
      </div>
    </aside>
  </main>

 
</body>
</html>


