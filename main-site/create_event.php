<?php
session_start();
$admin=false;
if (isset($_SESSION['username'])) {
 $admin=true;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>festaura — Create Event</title>
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


    /* --- NEW: Form Styles --- */
    .form-section {
        padding: 40px 20px;
    }
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px;
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0,0,0,0.03);
    }
    .form-container h2 {
        text-align: center;
        font-size: 32px;
        margin-top: 0;
        margin-bottom: 30px;
        color: #111;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-weight: 600;
        color: var(--muted);
        font-size: 14px;
    }
    .label-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
     .word-counter {
        font-size: 12px;
        color: var(--muted);
    }
    .word-counter.limit-exceeded {
        color: #e53e3e;
        font-weight: 600;
    }
    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="time"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        font-family: inherit;
        font-size: 15px;
        background: #fdfcff;
        transition: border-color 0.2s, box-shadow 0.2s;
        appearance: none;
    }
    .form-group select {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23333' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 16px 12px;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--purple);
        box-shadow: 0 0 0 3px var(--soft);
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    #short-details {
        min-height: 80px;
    }
    .time-range-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* File Upload Styling */
    .file-upload-wrapper {
        border: 2px dashed #dcd6e5;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background: #fbf9ff;
        transition: background-color 0.2s, border-color 0.2s;
    }
    .file-upload-wrapper:hover {
        background-color: var(--soft);
        border-color: var(--purple);
    }
    .file-upload-wrapper p {
        margin: 0;
        color: var(--muted);
        font-weight: 500;
    }
    .file-upload-wrapper span {
        font-size: 12px;
        color: var(--muted);
        opacity: 0.8;
        display: block;
        margin-top: 4px;
    }
    .upload-specs {
        font-size: 12px;
        color: var(--muted);
        opacity: 0.8;
        margin-top: 4px;
    }
     .file-name {
        font-size: 14px;
        color: var(--purple);
        margin-top: 10px;
        font-weight: 600;
    }


    /* Radio Button Styling */
    .radio-group {
        display: flex;
        gap: 16px;
        align-items: center;
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background: #fdfcff;
    }
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        color: #333;
        cursor: pointer;
        flex: 1;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background-color 0.2s;
    }
     .radio-group input[type="radio"] {
        display: none;
    }
    .radio-group input[type="radio"]:checked + span {
        background-color: var(--soft);
        color: var(--purple);
    }
    .radio-group span {
        width: 100%;
        text-align: center;
        padding: 8px 0;
        border-radius: 6px;
    }

    /* Button Group */
    .btn-group {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
        border-top: 1px solid #f0f0f0;
        padding-top: 24px;
    }
    
    /* Responsive */
    @media(max-width: 640px){
        .form-grid { grid-template-columns: 1fr; }
        .form-container { padding: 20px; }
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
 <?php if($admin) echo '<a class="btn primary" href="logout.php">Logout</a><a class="btn secondary" href="dashboard.php">Admin Panel</a>';

else echo '<a class="btn primary" href="login.php">Login</a>';

?>
      </div>
    </div>
  </header>

  <main>
    <section class="form-section">
      <div class="form-container">
        <h2>Create a New Event</h2>
<form action="submit_event.php" method="POST" id="create-event-form" enctype="multipart/form-data">

          <div class="form-grid">
            
            <!-- Event Poster Upload -->
            <div class="form-group">
              <label for="event-poster">Event Poster</label>
              <div class="file-upload-wrapper" id="poster-dropzone">
                <p>Click or drag & drop to upload</p>
                <div class="upload-specs">
                    <strong>Orientation:</strong> Landscape &bull;
                    <strong>Aspect Ratio:</strong> 16:9 &bull;
                    <strong>Ideal Size:</strong> 1920×1080px
                </div>
                <div class="file-name" id="poster-file-name"></div>
              </div>
              <input type="file" id="event-poster" name="poster" accept="image/*" hidden>
            </div>
            
            <!-- QR Code Upload -->
            <div class="form-group">
              <label for="event-qrcode">Registration QR Code</label>
              <div class="file-upload-wrapper" id="qrcode-dropzone">
                <p>Click or drag & drop to upload</p>
                <span>Students will scan this to register</span>
                 <div class="file-name" id="qrcode-file-name"></div>
              </div>
              <input type="file" id="event-qrcode" name="qrcode" accept="image/*" hidden>
            </div>
            
            <!-- Event Name -->
            <div class="form-group full-width">
              <label for="event-name">Event Name</label>
              <input type="text" id="event-name" name="event-name" placeholder="e.g., Annual Tech Summit 2025" required>
            </div>

            <!-- Short Details -->
            <div class="form-group full-width">
              <div class="label-group">
                  <label for="short-details">Short Details</label>
                  <span class="word-counter" id="word-counter">0 / 20 words</span>
              </div>
              <textarea id="short-details" name="short-details" placeholder="A brief, catchy summary for the event listing page." required></textarea>
            </div>
            
            <!-- About This Event -->
            <div class="form-group full-width">
              <label for="about-event">About this Event</label>
              <textarea id="about-event" name="about-event" placeholder="Provide a detailed description of the event. What is it about? Who should attend? This will appear on the main event page." required></textarea>
            </div>
            
            <!-- Date -->
            <div class="form-group">
              <label for="event-date">Date</label>
              <input type="date" id="event-date" name="event-date" required>
            </div>

            <!-- Time -->
            <div class="form-group">
                <label for="event-time">Time</label>
                <div class="time-range-container">
                    <input type="time" id="event-start-time" name="event-start-time" required>
                    <span style="color: var(--muted);">to</span>
                    <input type="time" id="event-end-time" name="event-end-time" required>
                </div>
            </div>
            
            <!-- Location -->
            <div class="form-group">
              <label for="event-location">Location</label>
              <input type="text" id="event-location" name="event-location" placeholder="e.g., University Auditorium" required>
            </div>

            <!-- Category -->
            <div class="form-group">
              <label for="event-category">Category</label>
              <select id="event-category" name="event-category" required>
                <option value="" disabled selected>Select a category</option>
                <option value="Tech">Tech</option>
                <option value="Cultural">Cultural</option>
                <option value="Sports">Sports</option>
                <option value="Workshop">Workshop</option>
              </select>
            </div>
            
            <!-- Organiser -->
            <div class="form-group">
              <label for="event-organiser">Organiser</label>
              <input type="text" id="event-organiser" name="event-organiser" placeholder="e.g., Computer Science Club" required>
            </div>
            
            <!-- Admin Contact (Private) -->
            <div class="form-group">
              <label for="admin-contact">Admin Contact (Private)</label>
              <input type="text" id="admin-contact" name="admin-contact" placeholder="Your Email or Phone for Admin" required>
            </div>

            <!-- Public Contact (for Students) -->
            <div class="form-group">
              <label for="public-contact">Public Contact (for Students)</label>
              <input type="text" id="public-contact" name="public-contact" placeholder="e.g., event.support@email.com" required>
            </div>

            <!-- Free or Paid -->
            <div class="form-group">
              <label>Event Fee</label>
              <div class="radio-group">
                <label>
                  <input type="radio" name="event-type" value="Free" checked>
                  <span>Free</span>
                </label>
                <label>
                  <input type="radio" name="event-type" value="Paid">
                  <span>Paid</span>
                </label>
              </div>
            </div>
            
            <!-- What to Expect -->
            <div class="form-group full-width">
              <label for="what-to-expect">What to Expect</label>
              <textarea id="what-to-expect" name="what-to-expect" placeholder="List key takeaways, activities, or guest speakers. Use bullet points for clarity if needed." required></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group">
              <a href="index.php" class="btn secondary">Cancel</a>
              <button type="submit" class="btn primary">Submit Event</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
  
  <script>
    // --- Script for File Upload UI ---

function save_event(){

 
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'insert_post.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Handle response
    xhr.onreadystatechange = function() {
        if(xhr.readyState === 4) {
            if(xhr.status === 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
                
            } else {
                document.getElementById('result').innerText = "❌ Error: " + xhr.statusText;
            }
        }
    };

    // Send data
    xhr.send('content=' + encodeURIComponent(content)); 

}

    function setupFileUpload(inputId, dropzoneId, fileNameId) {
        const inputElement = document.getElementById(inputId);
        const dropzoneElement = document.getElementById(dropzoneId);
        const fileNameElement = document.getElementById(fileNameId);

        dropzoneElement.addEventListener('click', () => {
            inputElement.click();
        });

        inputElement.addEventListener('change', () => {
            if (inputElement.files.length > 0) {
                fileNameElement.textContent = inputElement.files[0].name;
            } else {
                fileNameElement.textContent = '';
            }
        });

        // Drag and Drop functionality
        dropzoneElement.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzoneElement.style.backgroundColor = 'var(--soft)';
            dropzoneElement.style.borderColor = 'var(--purple)';
        });

        dropzoneElement.addEventListener('dragleave', () => {
            dropzoneElement.style.backgroundColor = '#fbf9ff';
            dropzoneElement.style.borderColor = '#dcd6e5';
        });

        dropzoneElement.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzoneElement.style.backgroundColor = '#fbf9ff';
            dropzoneElement.style.borderColor = '#dcd6e5';
            
            if (e.dataTransfer.files.length > 0) {
                inputElement.files = e.dataTransfer.files;
                fileNameElement.textContent = inputElement.files[0].name;
            }
        });
    }

    setupFileUpload('event-poster', 'poster-dropzone', 'poster-file-name');
    setupFileUpload('event-qrcode', 'qrcode-dropzone', 'qrcode-file-name');

    // --- Script for Word Counter ---
    const shortDetailsTextarea = document.getElementById('short-details');
    const wordCounterElement = document.getElementById('word-counter');
    const wordLimit = 20;

    shortDetailsTextarea.addEventListener('input', () => {
        const text = shortDetailsTextarea.value.trim();
        // Split by whitespace characters
        const words = text.split(/\s+/).filter(word => word.length > 0);
        const wordCount = words.length;

        wordCounterElement.textContent = `${wordCount} / ${wordLimit} words`;

        if (wordCount > wordLimit) {
            wordCounterElement.classList.add('limit-exceeded');
        } else {
            wordCounterElement.classList.remove('limit-exceeded');
        }
    });

 
  </script>

</body>
</html>



