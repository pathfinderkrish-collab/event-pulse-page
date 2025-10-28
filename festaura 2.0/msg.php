 <?php
session_start();
 $u_id= $_SESSION['user_id'];
$u_name=$_SESSION['username'];
$role=$_SESSION['role'];
 
 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>festaura — Submission Received</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    /* --- Base Styles (from home.html) --- */
    :root{
      --bg:#fbf7ff;
      --muted:#6a6a78;
      --purple:#7b4bff;
      --soft:#efe9f9;
      --card:#ffffff;
      --glass: rgba(255,255,255,0.6);
      --shadow: 0 8px 18px rgba(25,20,50,0.06);
      --radius: 10px;
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;color:#17141a;background:linear-gradient(180deg,#fbf7ff 0%, #f6eff9 100%)}

    /* --- Header & Navigation (from home.html) --- */
    header{position:sticky;top:0;background:rgba(255,255,255,0.9);backdrop-filter: blur(4px);box-shadow:0 1px 0 rgba(0,0,0,0.04);z-index:30}
    .nav{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:18px}
    .brand{display:flex;align-items:center;gap:12px}
    .brand .logo{width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--purple),#c28bff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
    .brand h1{font-size:18px;margin:0}
    nav ul{list-style:none;display:flex;gap:18px;margin:0;padding:0;color:var(--muted)}
    nav a{color:var(--muted);text-decoration:none;font-weight:500}
    .cta{display:flex;gap:10px;align-items:center}
    .btn{padding:10px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;text-align:center;transition: all 0.2s ease-in-out;}
    .btn.secondary{background:#fff;border:1px solid #eee;color:inherit}
    .btn.primary{background:var(--purple);color:#fff;box-shadow:0 6px 18px rgba(123,75,255,0.18)}
    .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(123,75,255,0.22); }
    .btn.secondary:hover { box-shadow: 0 8px 24px rgba(25,20,50,0.08); }


    /* --- NEW: Thank You Page Styles --- */
    .thank-you-section {
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-grow: 1;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    main {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .thank-you-container {
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
        padding: 50px;
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.03);
        text-align: center;
    }
    .success-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background-color: var(--soft);
        color: var(--purple);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
    }
    .success-icon svg {
        width: 36px;
        height: 36px;
    }
    .thank-you-container h2 {
        font-size: 32px;
        margin-top: 0;
        margin-bottom: 12px;
        color: #111;
    }
    .thank-you-container p {
        color: var(--muted);
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    
    /* Responsive */
    @media(max-width: 640px){
        .thank-you-container { padding: 30px; }
        .nav{padding:12px}
    }
  </style>
</head>
<body>
  <!-- Header section from home.html -->
  <header>
    <div class="nav">
      <div class="brand">
        <div class="logo">F</div>
        <h1>festaura</h1>
      </div>
      <nav>
        <ul>
          <li style="display:inline-block"><a href="index.php">Home</a></li>
          <li style="display:inline-block"><a href="events.php">Events</a></li>
        </ul>
      </nav>
  <div class="cta">
    <?php 
$logged_in=false;
if (in_array($role, ['admin', 'organizer', 'student'])) $logged_in=true;

?>
   <?php if ($logged_in): ?>
    <a class="btn primary" href="logout.php">Logout</a>
    
    <?php if ($role === 'admin'): ?>
        <a class="btn secondary" href="admin_dashboard.php">Admin Panel</a>
    <?php elseif ($role === 'organizer'): ?>
        <a class="btn secondary" href="organizer_dashboard.php">Organizer Panel</a>
    <?php elseif ($role === 'student'): ?>
        <a class="btn secondary" href="dashboard.php">Student Panel</a>
    <?php endif; ?>

<?php else: ?>
    <a class="btn primary" href="login.php">Login</a>
<?php endif; ?>
   
      </div>
    </div>
  </header>

  <main>
    <section class="thank-you-section">
      <div class="thank-you-container">
        <div class="success-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <h2>Submission Received!</h2>
        <p>
          Thank you for submitting your event. Our admin team will review it, and if approved, it will be live within 24 hours. We'll contact you if there are any questions.
        </p>
        <a href="index.php" class="btn primary">Back to Home</a>
      </div>
    </section>
  </main>
  
</body>
</html>
