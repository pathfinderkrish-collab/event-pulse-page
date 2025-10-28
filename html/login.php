<?php
 require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();  
  
?>


<?php

$error = "";  
 $success=false;

 
include 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['form_type'])) {
        $formType = $_POST['form_type'];
 
        if ($formType === 'login') {



            
            $email = $_POST['email'];
            $password = $_POST['password'];
          

            $stmt = $pdo->prepare("SELECT * FROM  users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
 

            if ($user && password_verify($password, $user['password'])) {
           
               


                  

    $stmt2 = $pdo->prepare("SELECT * FROM email_verification WHERE user_id=?");
    $stmt2->execute([$user['id']]);
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

       

       if(!$row['is_verified']) $error="Email not verified!";
       else {


 $_SESSION['user_id'] = $user['id'];
 $_SESSION['username'] = $user['fullname'];
$_SESSION['role'] = $user['role'];
 
header("Location: index.php");
    
 exit();
}
                 
            } else {
                $error = "Invalid email or password!";
         

               
            }

        } elseif ($formType === 'signup') {


 
    
    $role = $_POST['signup-role'] ?? 'user';
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $rollno = $_POST['rollno'] ?? null;
    $branch = $_POST['branch'] ?? null;
    $year = $_POST['year'] ?? null;
    $contact = $_POST['contact'] ?? null;
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];  
    $user_id=0;
 $domain_name="http://localhost/";


    function match_password($password, $confirm_password) {
    if ($password !== $confirm_password) return "Passwords do not match.";
    return '';
}
function check_mail($pdo, $email) {
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) return "Email already registered.";
    return '';
}

 
 function insert_data($pdo, $role, $fullname, $email, $rollno, $branch, $year, $contact, $password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Set fields to null based on role
    if ($role === 'organizer') {
        $rollno = null;
        $branch = null;
        $year = null;
    } elseif ($role === 'student') {
        $contact = null;
    }

elseif ($role === 'admin') {
       exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users 
            (role, fullname, email, rollno, branch, year, contact, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$role, $fullname, $email, $rollno, $branch, $year, $contact, $hashed]);
        $user_id = $pdo->lastInsertId();

        
        send_mail($pdo, $user_id, $fullname, $email, "http://localhost/");

       // echo "<div style='color:green;'>Account created successfully! A verification link has been sent to $email.</div>";

    } catch (PDOException $e) {
        echo "<div style='color:red;'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

 
function send_mail($pdo, $user_id, $fullname, $email, $domain_name) {
    $token = bin2hex(random_bytes(16));

    // Save token in DB
 

    // Send email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'festaura.team@gmail.com';
        $mail->Password   = 'fzbetzheskpsqowb ';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('festaura.team@gmail.com', 'festaura');
        $mail->addAddress($email, $fullname);
        
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email - festaura';

        $verify_link = $domain_name . "verify.php?token=$token";

        // Load template
        $mailBody = file_exists('mail.html') ? file_get_contents('mail.html') : "
            <p>Hi $fullname,</p>
            <p>Click below to verify your email:</p>
            <a href='$verify_link'>$verify_link</a>
        ";
        $mailBody = str_replace(['[Username]', '[VerifyLink]'], [$fullname, $verify_link], $mailBody);

        $mail->Body    = $mailBody;
        $mail->AltBody = "Hi $fullname, please verify your email by visiting: $verify_link";

        $mail->send();
       $stmt = $pdo->prepare("INSERT INTO email_verification (user_id, token) VALUES (?, ?)");
    $stmt->execute([$user_id, $token]);
        return true;
    } catch (Exception $e) {
        echo "<div style='color:red;'>Mailer Error: " . htmlspecialchars($mail->ErrorInfo) . "</div>";
        return false;
    }
}



    $error = match_password($password, $confirm_password);
 


 if(!$error) $error= check_mail($pdo, $email);

 
if (!$error) {
    if ($role === 'student') {
        // Student must use @nitkkr.ac.in email
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@nitkkr\.ac\.in$/", $email)) {
            $error = "Students must register using their @nitkkr.ac.in email address.";
        }
    } elseif ($role === 'organizer') {
        // Organizer must NOT use @nitkkr.ac.in email
        if (preg_match("/@nitkkr\.ac\.in$/", $email)) {
            $error = "Organizers must register using their personal (non-NITKKR) email address.";
        }
    }
}
 if(!$error)  { 

  $user_id=insert_data($pdo, $role, $fullname, $email, $rollno, $branch, $year, $contact, $password);
  

 
$success=true; 
}







 
}





 




    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>festaura — Welcome</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

<style>
  :root{
    --bg:#f6f0f8;
    --card:#ffffff;
    --muted:#9b8fa9;
    --accent:#7b4bff; /* primary purple */
    --accent-2:#7e52f7;
    --input-bg:#f3eefe;
    --pill-border:#efe9f6;
    --shadow: 0 10px 30px rgba(120,80,170,0.08);
    --radius:12px;
  }
  html,body{height:100%}
  body{
    margin:0;
    font-family:"Poppins",system-ui,Segoe UI,Roboto,"Helvetica Neue",Arial;
    background:linear-gradient(180deg, rgba(250,246,252,1) 0%, rgba(245,240,248,1) 100%);
    background-color:var(--bg);
    color:#222;
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:48px 24px;
  }

  .wrap{
    width:420px;
    max-width:92vw;
    text-align:center;
  }

  .brand{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    margin-bottom:18px;
  }
  .logo{
    width:48px;height:48px;
    border-radius:12px;
    background:linear-gradient(135deg,var(--accent),var(--accent-2));
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 6px 18px rgba(125,80,200,0.12), inset 0 -6px 10px rgba(255,255,255,0.06);
  }
  .logo svg{filter:drop-shadow(0 2px 6px rgba(120,60,200,0.12));}
  .brand h1{
    margin:0;
    font-size:20px;
    font-weight:700;
    letter-spacing:0.2px;
  }

  .card{
    background:var(--card);
    border-radius:16px;
    box-shadow:var(--shadow);
    padding:18px;
    overflow:hidden;
    border:1px solid rgba(130,100,180,0.04);
  }
  
  /* --- Tab Styles --- */
  .tab-nav{
    display:flex;
    background:var(--input-bg);
    padding:6px;
    border-radius:var(--radius);
    margin-bottom:18px;
  }
  .tab-btn{
    flex:1;
    padding:10px;
    border:none;
    background:transparent;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    color:var(--muted);
    font-size:14px;
    font-family:inherit;
    transition: all 0.2s ease;
  }
  .tab-btn.active{
    background:var(--card);
    color:var(--accent);
    box-shadow: 0 4px 10px rgba(120,80,170,0.06);
  }
  /* ---------------------- */

  .content{
    text-align:left;
    padding:8px 6px 18px;
  }
  
  /* Hide non-active panels */
  .content[role="tabpanel"]:not(.active){
    display:none;
  }

  .title{
    font-size:22px;
    font-weight:700;
    margin:6px 6px 6px 6px;
  }
  .subtitle{
    margin:0 6px 18px 6px;
    color:#85739b;
    font-size:13px;
  }

  label.field{
    display:block;
    margin:12px 6px 6px 6px;
    font-size:13px;
    color:#4b3f5e;
    font-weight:600;
  }
  
  /* --- Role Selector Styles --- */
  .role-selector{
    display:flex;
    border:1px solid var(--pill-border);
    border-radius:10px;
    overflow:hidden;
    margin-top:8px;
  }
  .role-selector input[type="radio"]{
    display:none; /* Hide the actual radio button */
  }
  .role-selector label{
    flex:1;
    text-align:center;
    padding:10px 8px;
    font-size:13px;
    font-weight:600;
    color:var(--muted);
    background:var(--bg);
    cursor:pointer;
    transition: all 0.2s ease;
    margin:0;
  }
  .role-selector label:not(:last-child){
    border-right:1px solid var(--pill-border);
  }
  .role-selector input[type="radio"]:checked + label{
    background:var(--card);
    color:var(--accent);
    box-shadow: 0 2px 8px rgba(120,80,170,0.08);
  }
  /* ------------------------------- */

  .input{
    width:100%;
    display:flex;
    align-items:center;
    gap:8px;
    margin-top:8px;
  }

  input[type="text"], input[type="email"], input[type="password"]{
    width:100%;
    padding:12px 14px;
    border-radius:10px;
    border:1px solid rgba(120,90,160,0.08);
    background:var(--input-bg);
    font-size:14px;
    color:#2f2540;
    box-shadow: 0 2px 0 rgba(255,255,255,0.6) inset;
  }

  .small-link{
    display:block;
    text-align:right;
    margin-top:8px;
    font-size:13px;
    color:var(--accent-2);
    text-decoration:none;
    font-weight:600;
  }

  .btn{
    display:inline-block;
    width:100%;
    padding:12px 16px;
    border-radius:10px;
    background:linear-gradient(90deg,var(--accent),var(--accent-2));
    color:white;
    border:none;
    font-weight:700;
    cursor:pointer;
    margin-top:14px;
    box-shadow: 0 6px 18px rgba(124,80,240,0.18);
  }

  .pw-wrap{position:relative}
  .eye-btn{
    position:absolute;
    right:8px;
    top:50%;
    transform:translateY(-50%);
    width:34px;height:34px;
    border-radius:8px;
    border:1px solid rgba(120,90,160,0.08);
    background:transparent;
    display:flex;
    align-items:center;justify-content:center;
    cursor:pointer;
  }

  /* Role-specific field containers */
  #user-specific-fields {
    display: block; /* Show by default as 'User' is checked */
  }
  #organizer-specific-fields {
    display: none; /* Hide by default */
  }

  @media (max-width:520px){ 
    .wrap{width:94vw} 
    .brand h1{font-size:18px} 
    .tab-btn{font-size:13px;}
    .role-selector label{font-size:12px;}
  }
</style>
</head>
<body>

<div class="wrap" role="main" aria-labelledby="brandTitle">
  <div class="brand">
    <div class="logo" aria-hidden="true">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 21h18" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M6 10v11" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M10 7v14" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M14 4v17" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M18 12v9" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h1 id="brandTitle">festaura</h1>
  </div>

  <div class="card" aria-live="polite">

    <div class="tab-nav" role="tablist" aria-label="Login or Signup">
      <button class="tab-btn active" id="login-tab" data-target="panel-login" type="button" role="tab" aria-selected="true" aria-controls="panel-login">Login</button>
      <button class="tab-btn" id="signup-tab" data-target="panel-signup" type="button" role="tab" aria-selected="false" aria-controls="panel-signup">Sign Up</button>
    </div>




<form id="loginForm" action="" method="POST">
<input type="hidden" name="form_type" value="login">
  <section id="panel-login" class="content active" role="tabpanel" aria-labelledby="login-tab">
    
    <div class="title">Welcome Back</div>
    <div class="subtitle">Please enter your credentials to log in.</div>

    <label class="field" id="login-role-label">Log in as</label>
    <div class="role-selector" role="radiogroup" aria-labelledby="login-role-label">
      <input type="radio" id="login-role-user" name="role" value="student" checked>
      <label for="login-role-user">User</label>
      
      <input type="radio" id="login-role-org" name="role" value="organizer">
      <label for="login-role-org">organizer</label>
      
      <input type="radio" id="login-role-admin" name="role" value="admin">
      <label for="login-role-admin">Admin</label>
    </div>

    <label class="field">Email</label>
    <div class="input">
      <input type="email" id="login-email" name="email" placeholder="you@college.edu" autocomplete="username" required>
    </div>

    <label class="field">Password</label>
    <div class="input pw-wrap">
      <input type="password" id="login-password" name="password" placeholder="••••••••" autocomplete="current-password" required >
      <button class="eye-btn" type="button" aria-label="Toggle password visibility" data-target="login-password">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
          <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="12" cy="12" r="2.5" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>

    <a href="#" class="small-link">Forgot Password?</a>

    <button class="btn" id="loginBtn" type="submit">Login</button>
 
 
    <?php if (!empty($error)): ?>
      <label class="field" style='color:#f44336'><?= htmlspecialchars($error) ?></label>
    <?php endif; ?>


  
 <div style="text-align:center;">
        <?php if ($success): ?>

       <label class="field"  style='color:#198754;'>
                Account created successfully! 
                A verification link has been sent to <strong><?php echo $email;?></strong></label>
              <?php endif; ?>
            </div>
  </section>
</form>

<form id="signupForm" action="" method="POST">
<input type="hidden" name="form_type" value="signup">  

 <section id="panel-signup" class="content" role="tabpanel" aria-labelledby="signup-tab">
      <div class="title">Create Account</div>
      <div class="subtitle">Join festaura to discover and manage events.</div>

      <label class="field" id="signup-role-label">Sign up as</label>
      <div class="role-selector" role="radiogroup" aria-labelledby="signup-role-label">
        <input type="radio" id="signup-role-user" name="signup-role" value="student"   checked>
        <label for="signup-role-user">User</label>
        
        <input type="radio" id="signup-role-org" name="signup-role"   value="organizer">
        <label for="signup-role-org">organizer</label>
      </div>

      <label class="field">Full Name</label>
      <div class="input">
        <input type="text" id="signup-name" placeholder="Your Name" name="fullname" autocomplete="name" required>
      </div>
      
      <label class="field">Email</label>
      <div class="input">
        <input type="email" id="signup-email" placeholder="you@college.edu" autocomplete="email" name="email" required>
      </div>

      <div id="user-specific-fields">
        <label class="field">Roll No.</label>
        <div class="input">
          <input type="text" id="signup-rollno"  name="rollno" placeholder="e.g., 20BCS1234" required>
        </div>

        <label class="field">Branch</label>
        <div class="input">
          <input type="text" id="signup-branch" name="branch" placeholder="e.g., Computer Science" required>
        </div>
        
        <label class="field">Year of Passing</label>
        <div class="input">
          <input type="text" id="signup-year" name="year" placeholder="e.g., 2024" inputmode="numeric" maxlength="4" required>
        </div>
      </div>
      <div id="organizer-specific-fields">
        <label class="field">Contact No.</label>
        <div class="input">
          <input type="text" id="signup-contact" name="contact" placeholder="Your 10-digit number" autocomplete="tel" inputmode="numeric" maxlength="10" required>
        </div>
      </div>
      <label class="field">Password</label>
      <div class="input pw-wrap">
        <input type="password" id="signup-password" name="password" placeholder="••••••••" autocomplete="new-password" value='pass123' required>
        <button class="eye-btn" type="button" aria-label="Toggle password visibility" data-target="signup-password">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="2.5" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
      
      <label class="field">Confirm Password</label>
      <div class="input pw-wrap">
        <input type="password" id="signup-password-confirm" name="confirm_password" placeholder="••••••••" autocomplete="new-password" value='pass123' required>
        <button class="eye-btn" type="button" aria-label="Toggle password visibility" data-target="signup-password-confirm">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="12" cy="12" r="2.5" stroke="#6b577f" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>

      <button class="btn" id="signupBtn" type="submit">Create Account</button>
    </section>
</form>


  </div>
</div>

<script>
  // --- Tab Switching Logic ---
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabPanels = document.querySelectorAll('.content[role="tabpanel"]');
    document.getElementById('signup-role-user').checked= true;

  tabButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-target');
      
      // Update buttons
      tabButtons.forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');
      
      // Update panels

      tabPanels.forEach(panel => {
        if (panel.id === targetId) {
          panel.classList.add('active');
          panel.style.display = 'block';
        } else {
          panel.classList.remove('active');
          panel.style.display = 'none';
        }
      });
    });
  });

  // --- Role-Specific Field Logic for Sign Up ---
  document.querySelectorAll('input[name="signup-role"]').forEach(radio => {
    radio.addEventListener('change', (event) => {
      const userFields = document.getElementById('user-specific-fields');
      const organizerFields = document.getElementById('organizer-specific-fields');
      
      if (event.target.value === 'student') {
        userFields.style.display = 'block';
        organizerFields.style.display = 'none';
      } else {
        userFields.style.display = 'none';
        organizerFields.style.display = 'block';
      }
    });
  });

  // --- Dynamic Placeholder Logic for Login ---
  document.querySelectorAll('input[name="login-role"]').forEach(radio => {
    radio.addEventListener('change', (event) => {
      const loginEmailInput = document.getElementById('login-email');
      if (event.target.value === 'student') {

     
        loginEmailInput.placeholder = 'you@college.edu';
      } else {
        loginEmailInput.placeholder = 'your-email@example.com';
        
      }
    });
  });
  
    
 
  document.querySelectorAll('input[name="signup-role"]').forEach(radio => {
    radio.addEventListener('change', (event) => {
      const signupEmailInput = document.getElementById('signup-email');
      if (event.target.value === 'student') {
        signupEmailInput.placeholder = 'you@college.edu';
       
      set_student_field();
        
      } else {
        signupEmailInput.placeholder = 'your-email@example.com';
      set_org_field();
         
      }
    });
  });

  // --- Eye Toggle Handlers ---
  document.querySelectorAll('.eye-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-target');
      const input = document.getElementById(targetId);
      if (!input) return;
      if (input.type === 'password') {
        input.type = 'text';
        btn.style.opacity = 0.85;
      } else {
        input.type = 'password';
        btn.style.opacity = 1;
      }
    });
  });

  // --- Fake Submit Buttons ---
 

function set_org_field(){
 document.getElementById('signup-rollno').required = false;
  document.getElementById('signup-branch').required = false;
   document.getElementById('signup-year').required = false;
   document.getElementById('signup-contact').required = true;
}

function set_student_field(){
 document.getElementById('signup-contact').required = false;
  document.getElementById('signup-rollno').required = true;
  document.getElementById('signup-branch').required = true;
   document.getElementById('signup-year').required = true;

}
set_student_field();
</script>
</body>
</html>
