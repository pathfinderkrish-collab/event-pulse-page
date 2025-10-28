<?php
session_start();
 $u_id= $_SESSION['user_id'];
$u_name=$_SESSION['username'];
$role=$_SESSION['role'];

?>
<?php include 'db_connect.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>festaura — Prototype</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <style>
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

    header{position:sticky;top:0;background:rgba(255,255,255,0.9);backdrop-filter: blur(4px);box-shadow:0 1px 0 rgba(0,0,0,0.04);z-index:30}
    .nav{max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;padding:18px}
    .brand{display:flex;align-items:center;gap:12px}
    .brand .logo{width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--purple),#c28bff);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700}
    .brand h1{font-size:18px;margin:0}
    nav ul{list-style:none;display:flex;gap:18px;margin:0;padding:0;color:var(--muted)}
    nav a{color:var(--muted);text-decoration:none;font-weight:500}
    .cta{display:flex;gap:10px;align-items:center}
    .btn{padding:10px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;text-align:center}
    .btn.secondary{background:#fff;border:1px solid #eee;color:inherit}
    .btn.primary{background:var(--purple);color:#fff;box-shadow:0 6px 18px rgba(123,75,255,0.18)}

    /* Hero */
    .hero{max-width:1200px;margin:40px auto 80px;padding:40px 20px;text-align:center}
    .hero h2{font-size:64px;margin:0;line-height:1.02;letter-spacing:-1px}
    .hero p{color:var(--muted);margin:18px 0 30px;font-size:18px}

    .search{max-width:640px;margin:0 auto;display:flex;align-items:center;background:var(--card);padding:14px 18px;border-radius:40px;box-shadow: 0 10px 30px rgba(25,20,50,0.04);border:1px solid rgba(20,15,30,0.02)}
    .search input{border:0;outline:0;font-size:16px;width:100%;padding:6px; background: transparent;}
    .search .icon{margin-right:12px;opacity:0.6}

    /* Featured section */
    .section{max-width:1200px;margin:40px auto;padding:20px}
    .section h3{text-align:center;font-size:40px;margin:20px 0}
    .section p{subtle;margin:0 auto 18px;display:block;color:var(--muted);text-align:center}

    .cards{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:28px}
    .card{background:var(--card);border-radius:12px;overflow:hidden;box-shadow:var(--shadow);display:flex;flex-direction:column}
    .card .media{height:180px;background-size:cover;background-position:center}
    .card .body{padding:18px;flex:1;display:flex;flex-direction:column;gap:12px}
    .meta{display:flex;gap:8px;align-items:center;color:#fff;font-weight:700}
    .tag{background:rgba(255,255,255,0.15);padding:6px 8px;border-radius:8px;font-size:13px}
    .title{font-weight:800;font-size:18px;color:#111}
    .card .btn-row{margin-top:auto}
    .card .btn-row .btn{width:100%}

    /* footer */
    footer{margin-top:60px;background:linear-gradient(180deg, rgba(250,248,252,1) 0%, rgba(244,241,247,1) 100%);padding:40px}
    .footer-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:30px}
    .footer-grid h4{margin:0 0 10px 0}
    .small{color:var(--muted);font-size:14px}

    /* responsive */
    @media(max-width:980px){ .cards{grid-template-columns:repeat(2,1fr)} .hero h2{font-size:44px} }
    @media(max-width:640px){ .nav{padding:12px} .cards{grid-template-columns:1fr} .hero{padding:20px} .hero h2{font-size:34px} .footer-grid{grid-template-columns:1fr 1fr} }

    /* small helpers to match look */
    .pill{background:#fff;padding:6px 10px;border-radius:8px;font-weight:700;color:var(--muted);box-shadow:0 4px 12px rgba(10,10,20,0.03);font-size:13px}
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
          <li style="display:inline-block"><a href="index.php">Home</a></li>
          <li style="display:inline-block"><a href="events.php">Events</a></li>
          <li style="display:inline-block"><a href="#clubs">Clubs</a></li>
          <li style="display:inline-block"><a href="about.php">About</a></li>
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
    <section class="hero">
      <h2>Discover &amp; Register for<br><span style="display:inline-block">Campus Events Instantly</span></h2>
      <p>Workshops, Hackathons, Cultural Nights, and more!</p>

      <form class="search" role="search" aria-label="Find events" action="events.html">
        <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 21l-4.35-4.35" stroke="#666" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="11" cy="11" r="6" stroke="#666" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <input placeholder="Find events by name, date, or club" name="q" />
      </form>
    </section>

    <section class="section" id="events">
      <h3>Featured Events</h3>
      <p>Check out the most popular upcoming events on campus.</p>

      <div style="text-align:center; margin-bottom: 20px;">
        <a href="events.php" class="btn secondary">View All Events</a>
      </div>

      <div class="cards" id="cards">
 

<?php 
 
$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
$x=1;
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
 

if($x>3) break;
$x++;
?>

        <article class="card">
          <div class="media" style="background-image:url('/show_image.php?type=poster&id=<?php echo $row['id'];?>');"></div>
          <div class="body">
            <div style="display:flex;justify-content:space-between;align-items:center">
              <div style="display:flex;gap:10px;align-items:center">
                <div class="pill"><?php echo date("F j, Y", strtotime($row['event_date']));?></div>
                <div class="tag"><?php echo $row['event_category'];?></div>
              </div>
            </div>
            <div class="title"><?php echo $row['event_name']; ?></div>
            <div class="card-desc small"><?php echo $row['short_details']; ?></div>
            <div class="btn-row"><button class="btn primary" onclick="window.location.href='show_event.php?id=<?php echo $row['id'];?>'">View Details</button></div>
          </div>
        </article>
<?php }?> 
      </div>
    </section>

 
    <?php  if ($role === 'organizer' || !$logged_in ): ?>
   <section style="text-align:center;padding:60px 20px;background:linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(245,240,249,1) 100%)">
      <h3 style="font-size:36px;margin-bottom:8px">Ready to Host Your Own Event?</h3>
      <p class="small" style="max-width:720px;margin:0 auto 20px;color:var(--muted)">Become an organizer and showcase your club's activities. It's easy to get started.</p>
 <?php if(!$logged_in) $link="login.php"; else $link="create_event.php";?>      
<a href="<?php echo $link; ?>" class="btn primary">Create Your Event</a>
    </section>  
<?php endif; ?>

  </main>

  <footer>
    <div class="footer-grid">
      <div>
        <div style="display:flex;gap:12px;align-items:center;margin-bottom:12px">
          <div style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,var(--purple),#b07bff);display:flex;align-items:center;justify-content:center;color:#fff">F</div>
          <strong>festaura</strong>
        </div>
        <div class="small">Your one-stop platform for all campus happenings.</div>
      </div>

      <div>
        <h4>Quick Links</h4>
        <div class="small">Home<br/>Events<br/>Clubs</div>
      </div>

      <div>
        <h4>Legal</h4>
        <div class="small">Terms of Service<br/>Privacy Policy<br/>Contact Us</div>
      </div>

      <div>
        <h4>Follow Us</h4>
        <div style="display:flex;gap:12px;margin-top:12px;opacity:0.9">FB · TW · IG · IN</div>
      </div>
    </div>
    <div style="max-width:1200px;margin:30px auto 0;color:var(--muted);text-align:center;font-size:14px">© 2025 festaura. All rights reserved.</div>
  </footer>

</body>
</html>


