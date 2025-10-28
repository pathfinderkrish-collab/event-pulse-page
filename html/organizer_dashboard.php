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

<?php include 'db_connect.php'; ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Events — festaura</title>
  
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <style>
    /* --- Base Theme Styles --- */
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
    html,body{
      height:100%;
      margin:0;
      font-family:Poppins,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
      color:#171a1a;
      background:linear-gradient(180deg,var(--bg) 0%, #f6eff9 100%);
    }
    
    /* --- Header & Nav Styles --- */
    header{
      position:sticky;
      top:0;
      background:rgba(255,255,255,0.9);
      backdrop-filter: blur(4px);
      box-shadow:0 1px 0 rgba(0,0,0,0.04);
      z-index:30;
    }
    .nav{
      max-width:1200px;
      margin:0 auto;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:18px;
    }
    .brand{display:flex;align-items:center;gap:12px}
    .brand .logo{
      width:36px;
      height:36px;
      border-radius:8px;
      background:linear-gradient(135deg,var(--purple),#c28bff);
      display:flex;
      align-items:center;
      justify-content:center;
      color:#fff;
      font-weight:700;
    }
    .brand h1{font-size:18px;margin:0}
    .cta{display:flex;gap:10px;align-items:center}
    .btn{
      padding:10px 16px;
      border-radius:10px;
      border:none;
      cursor:pointer;
      font-weight:600;
      text-decoration:none;
      display:inline-block;
      text-align:center;
      font-size: 14px; 
    }
    .btn.secondary{background:#fff;border:1px solid #eee;color:inherit}
    .btn.primary{
      background:var(--purple);
      color:#fff;
      box-shadow:0 6px 18px rgba(123,75,255,0.18);
    }
    .btn.danger {
        background: #ffebee;
        color: #d32f2f;
        border: 1px solid #ffcdd2;
    }

    /* --- Base Layout & Card Styles --- */
    .section{
      max-width:1200px;
      margin:40px auto;
      padding:20px;
    }
    .pill{
      background:#fff;
      padding:6px 10px;
      border-radius:8px;
      font-weight:700;
      color:var(--muted);
      box-shadow:0 4px 12px rgba(10,10,20,0.03);
      font-size:13px;
    }
    .tag{
      background:rgba(20,15,30,0.08);
      padding:6px 8px;
      border-radius:8px;
      font-size:13px; 
      font-weight: 600; 
      color: var(--muted);
    }
    .title{font-weight:800;font-size:18px;color:#111; margin: 0;}
    .card-desc{font-size:14px;color:var(--muted); margin: 0;}

    /* --- Admin Page Styles --- */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .page-title {
      font-weight: 800;
      font-size: 24px;
      margin: 0;
    }
    
    /* --- TAB STYLES (Main and Filter) --- */
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
    .category-tabs.main-tabs button.active{
      background:linear-gradient(90deg,var(--purple),#b07bff);
      color:#fff;
      box-shadow:0 4px 12px rgba(123,75,255,0.12);
    }
    
    .category-tabs.filter-tabs {
        margin-bottom: 20px;
        gap: 15px; 
    }
    .category-tabs.filter-tabs button {
        padding: 8px 14px;
        font-size: 14px;
    }
    .category-tabs.filter-tabs button.active {
      background: var(--soft);
      color: var(--purple);
    }
    /* ------------------------------------- */

    .event-list {
      display: flex;
      flex-direction: column;
      gap: 20px; 
    }

    .h-card {
      background: var(--card);
      border-radius: 12px;
      box-shadow: var(--shadow);
      display: flex; 
      flex-direction: row;
      overflow: hidden;
    }
    
    .h-card .media {
      width: 280px; 
      flex-shrink: 0;
      background-color: #eee; 
      font-size: 0;
    }
    .h-card .media img {
      width: 100%;
      height: 100%; 
      object-fit: cover;
      display: block; 
      vertical-align: top;
    }

    .h-card .body {
      padding: 24px 30px;
      flex: 1; 
      display: flex;
      flex-direction: column;
      gap: 12px;
      justify-content: center; 
    }

    .h-card .info {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    
    .h-card .actions {
      margin-top: auto; 
      padding-top: 10px;
      display: flex;
      gap: 12px;
    }

  </style>
</head>
<body>

  <header>
    <div class="nav">
      <div class="brand">
        <div class="logo">F</div>
        <h1>festaura — Organizer</h1>
      </div>
      <div class="cta">
        <a class="btn secondary" href="index.php">View Site</a>
        <a class="btn primary" href="logout.php">Logout</a>
      </div>
    </div>
  </header>

  <main>
    <section class="section">

      <div class="page-header">
        <h2 class="page-title">Hi, <?php echo $u_name;?></h2>
        </div>

      <div class="category-tabs main-tabs">
        <button class="tab-btn active" data-tab="manage">All Events</button>
        <button class="tab-btn" data-tab="requests">My Events</button>
      </div>
      <div class="content-panel panel-manage" data-panel="manage">
        
        <div class="category-tabs filter-tabs manage-filters">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="Tech">Tech</button>
          <button class="filter-btn" data-filter="Cultural">Cultural</button>
          <button class="filter-btn" data-filter="Sports">Sports</button>
          <button class="filter-btn" data-filter="Workshop">Workshop</button>
        </div>

        <div class="event-list">

 
<?php 
 
$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

 
 

 ?>

           <article class="h-card" data-category="<?php echo $row['event_category'];?>">
            <div class="media">
             <img src="/show_image.php?type=poster&id=<?php echo $row['id'];?>"  >
             </div>
          <div class="body">
             <div class="info">
             <div class="pill"><?php echo date("F j, Y", strtotime($row['event_date']));?></div>
              <div class="tag"><?php echo $row['event_category'];?></div>
            </div>
            <div class="title"><?php echo $row['event_name']; ?></div>
            <div class="card-desc"><?php echo $row['short_details']; ?></div>
            <div class="actions">
           
                    <a href="show_event.php?id=<?php echo $row['id'];?>" class="btn primary">View Details</a> 

                
          </div>
         </div>
        </article>
<?php }?> 




        </div>
      </div>
      
      <div class="content-panel panel-requests" data-panel="requests" style="display:none;">
        
        <div class="category-tabs filter-tabs requests-filters">
          <button class="filter-btn active" data-filter="all">All</button>
          <button class="filter-btn" data-filter="Tech">Tech</button>
          <button class="filter-btn" data-filter="Cultural">Cultural</button>
          <button class="filter-btn" data-filter="Sports">Sports</button>
          <button class="filter-btn" data-filter="Workshop">Workshop</button>
        </div>
        
        <div class="event-list">
 

<?php 
 
$stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
if($row['organizer_id']!==$u_id) continue; 


 

$event_id = $row['id']; // example event id

$sql = "SELECT COUNT(*) AS total_registered 
        FROM registrations 
        WHERE event_id = ?";

$stmt3 = $pdo->prepare($sql);
$stmt3->execute([$event_id]);
$row2 = $stmt3->fetch(PDO::FETCH_ASSOC);

$total_registered = $row2['total_registered'];

 
?>


           <article class="h-card" data-category="<?php echo $row['event_category'];?>">
            <div class="media">
             <img src="/show_image.php?type=poster&id=<?php echo $row['id'];?>"  >
             </div>
          <div class="body">
             <div class="info">
             <div class="pill"><?php echo date("F j, Y", strtotime($row['event_date']));?></div>
              <div class="tag"><?php echo $row['event_category'];?></div>
            </div>
            <div class="title"><?php echo $row['event_name']; ?></div>
            <div class="card-desc"><?php echo $row['short_details']; ?></div>
            <div class="actions">
           
                    <a href="show_event.php?id=<?php echo $row['id'];?>" class="btn primary">View Details</a> 
 
   <a href="manage_event.php?cmd=del&type=eve&id=<?php echo $row['id'];?>" class="btn danger">Delete</a>
             
          </div>
 <div class="card-desc" style="font-size:14px">Registerd user: <strong><?php echo $total_registered;?></strong> <a href="view_users.php?event_id=<?php echo $row['id'];?> ">View</a></div>
         </div>
        </article>
<?php }?> 

       

        </div>

      </div>

    </section>
  </main>

  <script>
    // --- Logic for MAIN TABS (Manage vs Requests) ---
    const mainTabs = document.querySelectorAll('.main-tabs .tab-btn');
    const mainPanels = document.querySelectorAll('.content-panel'); 

    function showMainPanel(panelName){
      mainPanels.forEach(panel => { 
        panel.style.display = (panel.dataset.panel === panelName) ? 'block' : 'none'; 
      });
    }

    mainTabs.forEach(tab=>{
      tab.addEventListener('click',()=>{
        mainTabs.forEach(t=>t.classList.remove('active'));
        tab.classList.add('active');
        showMainPanel(tab.dataset.tab);
      });
    });

    // --- Reusable Logic for FILTER TABS ---
    function setupFilterLogic(filterButtonsSelector, cardsSelector) {
      const filterBtns = document.querySelectorAll(filterButtonsSelector);
      const cards = document.querySelectorAll(cardsSelector);

      filterBtns.forEach(filterBtn => {
        filterBtn.addEventListener('click', () => {
          // Set active state for filter button
          filterBtns.forEach(f => f.classList.remove('active'));
          filterBtn.classList.add('active');

          const filter = filterBtn.dataset.filter;

          // Show/Hide cards based on filter
          cards.forEach(card => {
            if (filter === 'all' || card.dataset.category === filter) {
              card.style.display = 'flex';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });
    }

    // Initialize filters for both panels
    setupFilterLogic('.manage-filters .filter-btn', '.panel-manage .h-card');
    setupFilterLogic('.requests-filters .filter-btn', '.panel-requests .h-card');

    // Show "Manage Events" panel by default
    showMainPanel('manage');
  </script>

</body>
</html>

