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
  <title>About festaura — Prototype</title>
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
    
    nav a.active {
      color: var(--purple);
      font-weight: 700;
    }

    .cta{display:flex;gap:10px;align-items:center}
    .btn{padding:10px 16px;border-radius:10px;border:none;cursor:pointer;font-weight:600;text-decoration:none;display:inline-block;text-align:center}
    .btn.secondary{background:#fff;border:1px solid #eee;color:inherit}
    .btn.primary{background:var(--purple);color:#fff;box-shadow:0 6px 18px rgba(123,75,255,0.18)}

    .hero{max-width:1200px;margin:40px auto 80px;padding:40px 20px;text-align:center}
    .hero h2{font-size:64px;margin:0;line-height:1.02;letter-spacing:-1px}
    .hero p{color:var(--muted);margin:18px 0 30px;font-size:18px}

    .section{max-width:1200px;margin:40px auto;padding:20px}
    .section h3{text-align:center;font-size:40px;margin:20px 0}
    .section p{subtle;margin:0 auto 18px;display:block;color:var(--muted);text-align:center}
    .small{color:var(--muted);font-size:14px}

    /* * STYLES FOR ABOUT PAGE 
     */
    .about-hero { 
      text-align: center; 
      max-width: 960px; 
      margin: 60px auto 80px; 
      padding: 20px;
    }
    .about-hero h2 {
      font-size: 56px;
      margin: 0;
      line-height: 1.1;
      letter-spacing: -0.5px;
      color: #111;
    }
    .about-hero p.lead {
      font-size: 20px;
      color: var(--muted);
      max-width: 720px;
      margin: 20px auto 0;
      line-height: 1.6;
    }
    
    .features-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      max-width: 1200px;
      margin: 40px auto;
    }
    .feature-item {
      background: var(--card);
      padding: 28px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      text-align: center;
    }
    .feature-item .icon {
      font-size: 32px;
      line-height: 1;
      margin-bottom: 12px;
      color: var(--purple);
      font-style: normal;
    }
    .feature-item h4 {
      font-size: 20px;
      margin: 10px 0 8px;
    }
    
    .team-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 26px;
    }
    .team-card {
      text-align: center;
      background: var(--card); /* ✅ Added card background */
      padding: 20px; /* ✅ Added padding */
      border-radius: var(--radius); /* ✅ Added radius */
      box-shadow: var(--shadow); /* ✅ Added shadow */
      display: flex; /* ✅ Added flex for alignment */
      flex-direction: column; /* ✅ Added flex direction */
      justify-content: center; /* Vertically center content */
    }
    /* This style is no longer needed */
    /* .team-card img { ... } */ 

    .team-card .name {
      font-size: 18px;
      font-weight: 700;
      margin: 0;
    }
    .team-card .title {
      font-size: 15px;
      color: var(--purple);
      font-weight: 600;
      margin-bottom: 8px; /* ✅ Added margin */
    }
    /* ✅ Added style for contribution text */
    .team-card p.small {
      font-size: 13px;
      line-height: 1.5;
      margin-top: auto; /* ✅ Pushes text to bottom */
    }

    .cta-section {
      text-align:center;
      padding:60px 20px;
      background:linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(245,240,249,1) 100%);
      margin-top: 60px;
      border-radius: 20px;
    }
    .cta-section h3 {
      font-size:36px;
      margin: 0 auto 12px;
    }
    /* * END OF NEW STYLES
     */

    /* footer */
    footer{margin-top:60px;background:linear-gradient(180deg, rgba(250,248,252,1) 0%, rgba(244,241,247,1) 100%);padding:40px}
    .footer-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:30px}
    .footer-grid h4{margin:0 0 10px 0}

    /* responsive */
    @media(max-width:980px){ 
      .hero h2, .about-hero h2 {font-size:44px}
      .features-grid { grid-template-columns: 1fr; }
      .team-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media(max-width:640px){ 
      .nav{padding:12px} 
      .hero{padding:20px} 
      .hero h2, .about-hero h2 {font-size:38px}
      .about-hero p.lead { font-size: 18px; }
      .footer-grid{grid-template-columns:1fr 1fr} 
      .team-grid { grid-template-columns: 1fr; }
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
          <li style="display:inline-block"><a href="index.php">Home</a></li>
          <li style="display:inline-block"><a href="events.php">Events</a></li>
          <li style="display:inline-block"><a href="#">Clubs</a></li>
          <li style="display:inline-block"><a href="about.php" class="active">About</a></li>
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
    <section class="about-hero">
      <h2>Our Mission: To Bring Your Campus to Life.</h2>
      <p class="lead">
        We believe campus life is more than just lectures and labs. It's about connection, discovery, and growth. 
        But we saw students missing out on amazing opportunities and clubs struggling to reach an audience. 
        <br><strong>We knew there had to be a better way.</strong>
      </p>
    </section>

    <section class="section">
      <div class="features-grid">
        <div class="feature-item">
          <i class="icon">🔍</i>
          <h4>For Students</h4>
          <p class="small">No more hunting through posters and stray emails. Discover all your campus workshops, fests, and hackathons in one place. Register in seconds.</p>
        </div>
        <div class="feature-item">
          <i class="icon">📣</i>
          <h4>For Organizers</h4>
          <p class="small">Stop shouting into the void. Promote your event directly to the entire campus, manage registrations, and see your community grow.</p>
        </div>
        <div class="feature-item">
          <i class="icon">🤝</i>
          <h4>For Everyone</h4>
          <p class="small">festaura is the central hub that connects passionate students with the clubs and events that match their interests. Find your community.</p>
        </div>
      </div>
    </section>

    <section class="section" id="team">
      <h3>Meet the Team</h3>
      <p>We're students, just like you, passionate about building a better campus community.</p>

      <div class="team-grid" style="margin-top: 40px;">
        
        <div class="team-card">
          <div class="name">Muskan</div>
          <div class="title">Frontend Developer</div>
          <p class="small">Developed static HTML/CSS/JS pages and UI layouts.</p>
        </div>
        
        <div class="team-card">
          <div class="name">Astha Gautam</div>
          <div class="title">Frontend Developer</div>
          <p class="small">Designed mockups, contributed to UI flow, and created visual assets.</p>
        </div>
        
        <div class="team-card">
          <div class="name">Yatharth Chaudhary</div>
          <div class="title">Frontend Developer</div>
          <p class="small">Built frontend pages, handled testing, and fixed UI bugs.</p>
        </div>
        
        <div class="team-card">
          <div class="name">Akshat Meena</div>
          <div class="title">Full-Stack Developer</div>
          <p class="small">Developed backend (PHP/MySQL), integrated frontend, and ensured full system functionality.</p>
        </div>

      </div>
    </section>

    <section class="cta-section">
      <h3>Join the Community</h3>
      <p class="small" style="max-width:720px;margin:0 auto 24px;color:var(--muted)">Ready to find your next event or host your own? Dive in.</p>
      <div style="display:flex; justify-content:center; gap: 12px;">
        <a href="events.php" class="btn primary" style="padding: 12px 24px; font-size: 16px;">Explore Events</a>
        <a href="create_event.php" class="btn secondary" style="padding: 12px 24px; font-size: 16px;">Host an Event</a>
      </div>
    </section>
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
        <div classs="small">Terms of Service<br/>Privacy Policy<br/>Contact Us</div>
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

 
