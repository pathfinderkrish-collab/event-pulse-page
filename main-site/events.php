<?php
session_start();
$admin=false;
if (isset($_SESSION['username'])) {
 $admin=true;
}
?>
<?php include 'db_connect.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Browse Events — Campus Event Connect</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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

    .section{max-width:1200px;margin:40px auto;padding:20px}

    .category-tabs{
      display:flex;
      gap:20px;
      margin-bottom:30px;
    }
    .category-tabs button{
      background:rgba(20,15,30,0.04);
      border:none;
      border-radius:8px;
      padding:10px 16px;
      font-weight:600;
      cursor:pointer;
      transition:0.3s;
    }
    .category-tabs button.active{
      background:linear-gradient(90deg,var(--purple),#b07bff);
      color:#fff;
      box-shadow:0 4px 12px rgba(123,75,255,0.12);
    }

    .cards{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;}
    .card{background:var(--card);border-radius:12px;overflow:hidden;box-shadow:var(--shadow);display:flex;flex-direction:column}
    .card .media{height:180px;background-size:cover;background-position:center}
    .card .body{padding:18px;flex:1;display:flex;flex-direction:column;gap:12px}
    .pill{background:#fff;padding:6px 10px;border-radius:8px;font-weight:700;color:var(--muted);box-shadow:0 4px 12px rgba(10,10,20,0.03);font-size:13px;}
    .tag{background:rgba(20,15,30,0.08);padding:6px 8px;border-radius:8px;font-size:13px; font-weight: 600; color: var(--muted);}
    .title{font-weight:800;font-size:18px;color:#111}
    .card-desc{font-size:14px;color:var(--muted)}
    .btn-row{margin-top:auto}
    .btn-row .btn{width:100%}

    @media(max-width:1100px){ .cards{grid-template-columns:repeat(2,1fr)} }
    @media(max-width:980px){ .cards{grid-template-columns:1fr} }
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
          <li><a href="#">About</a></li>
        </ul>
      </nav>
      <div class="cta">
    <?php if($admin) echo '<a class="btn primary" href="logout.php">Logout</a><a class="btn secondary" href="dashboard.php">Admin Panel</a>';

else echo '<a class="btn primary" href="login.php">Login</a>';

?>
   
      </div>
    </div>
  </header>

 
  <main>
    <section class="section">
      <div class="category-tabs">
        <button class="tab-btn active" data-category="Tech">Tech</button>
        <button class="tab-btn" data-category="Cultural">Cultural</button>
        <button class="tab-btn" data-category="Sports">Sports</button>
        <button class="tab-btn" data-category="Workshop">Workshops</button>
      </div>

      <div class="cards" id="event-cards">

<?php 
 
$stmt = $pdo->query("SELECT * FROM events_list  ORDER BY id DESC");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 if (!$row['is_showing'])  continue;  
 ?>

           <article class="card" data-category="<?php echo $row['event_category'];?>">
          <div class="media" style="background-image:url('/show_image.php?type=poster&id=<?php echo $row['id'];?>');"></div>
          <div class="body">
            <div style="display:flex;gap:10px;align-items:center">
             <div class="pill"><?php echo date("F j, Y", strtotime($row['event_date']));?></div>
              <div class="tag"><?php echo $row['event_category'];?></div>
            </div>
            <div class="title"><?php echo $row['event_name']; ?></div>
            <div class="card-desc"><?php echo $row['short_details']; ?></div>
           <div class="btn-row"><button class="btn primary" onclick="window.location.href='show_event.php?id=<?php echo $row['id'];?>'">View Details</button></div>
          </div>
        </article>
<?php }?> 
       

      </div>
    </section>
  </main>

  <footer>
    <div style="max-width:1200px;margin:30px auto 0;color:var(--muted);text-align:center;font-size:14px">© 2025 Campus Event Connect. All rights reserved.</div>
  </footer>

  <script>
    const tabs = document.querySelectorAll('.tab-btn');
    const cards = document.querySelectorAll('.card');

    function showCategory(category){
 
      cards.forEach(card=>{
        card.style.display = (card.dataset.category === category) ? 'flex' : 'none';
      });
    }

    tabs.forEach(tab=>{
      tab.addEventListener('click',()=>{
        tabs.forEach(t=>t.classList.remove('active'));
        tab.classList.add('active');
        showCategory(tab.dataset.category);
      });
    });

    // Show Tech by default
    showCategory('Tech');
  </script>
</body>
</html>

