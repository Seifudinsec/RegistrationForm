<?php
// ── ALL PHP LOGIC FIRST (before any HTML output) ─────────────────
$conn = mysqli_connect("localhost", "root", "", "userdetailsDB");

$successMsg = "";
$errorMsg   = "";

if (isset($_POST['save'])) {
    $firstName = $_POST['fname'];
    $lastName  = $_POST['lname'];
    $UserName  = $_POST['uname'];
    $email     = $_POST['email'];
    $password  = md5($_POST['pword']);

    $addUser = "INSERT INTO userstable(firstname, lastname, username, email, password)
                VALUES ('$firstName', '$lastName', '$UserName', '$email', '$password')";

    $run = mysqli_query($conn, $addUser);

    if ($run) {
        header("Location: view.php");
        exit();
    } else {
        $errorMsg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add User</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #0b0f1a;
      --card: #111827;
      --border: #1e2d45;
      --accent: #00e5ff;
      --accent2: #7c3aed;
      --text: #e8eaf0;
      --muted: #6b7a99;
      --input-bg: #0d1526;
      --error: #ff4d6d;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    body::before, body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.18;
      pointer-events: none;
      animation: drift 10s ease-in-out infinite alternate;
    }
    body::before {
      width: 600px; height: 600px;
      background: var(--accent2);
      top: -200px; left: -200px;
    }
    body::after {
      width: 500px; height: 500px;
      background: var(--accent);
      bottom: -150px; right: -150px;
      animation-delay: -5s;
    }
    @keyframes drift {
      from { transform: translate(0, 0) scale(1); }
      to   { transform: translate(40px, 30px) scale(1.08); }
    }

    .wrapper {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 480px;
      padding: 24px;
    }

    .brand {
      text-align: center;
      margin-bottom: 32px;
      animation: fadeDown 0.6s ease both;
    }
    .brand-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 52px; height: 52px;
      border-radius: 14px;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      margin-bottom: 14px;
      font-size: 22px;
    }
    .brand h1 {
      font-family: 'Syne', sans-serif;
      font-size: 26px;
      font-weight: 800;
      letter-spacing: -0.5px;
    }
    .brand p {
      color: var(--muted);
      font-size: 14px;
      margin-top: 4px;
    }

    .alert {
      padding: 12px 16px;
      border-radius: 10px;
      font-size: 14px;
      margin-bottom: 20px;
      border-left: 3px solid;
    }
    .alert-error {
      background: rgba(255,77,109,0.08);
      border-color: var(--error);
      color: var(--error);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 36px 32px;
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
      animation: fadeUp 0.6s ease 0.1s both;
    }

    .row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    .field {
      display: flex;
      flex-direction: column;
      gap: 7px;
      margin-bottom: 16px;
    }
    .field:last-of-type { margin-bottom: 0; }

    label {
      font-size: 12px;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--muted);
    }

    .input-wrap { position: relative; }
    .input-wrap svg {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px; height: 16px;
      color: var(--muted);
      pointer-events: none;
      transition: color 0.2s;
    }

    input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 13px 14px 13px 40px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input::placeholder { color: #3a4a65; }
    input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(0,229,255,0.1);
    }

    .divider {
      height: 1px;
      background: var(--border);
      margin: 22px 0;
    }

    .btn-row {
      display: flex;
      gap: 12px;
      margin-top: 24px;
    }

    .btn {
      padding: 14px;
      border-radius: 10px;
      font-family: 'Syne', sans-serif;
      font-size: 14px;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      transition: opacity 0.2s, transform 0.15s;
      border: none;
    }
    .btn:hover { opacity: 0.88; transform: translateY(-1px); }
    .btn-cancel {
      background: rgba(255,255,255,0.05);
      color: var(--muted);
      border: 1px solid var(--border);
      padding: 14px 20px;
    }
    .btn-save {
      flex: 1;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      color: #fff;
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<div class="wrapper">

  <div class="brand">
    <div class="brand-icon">👤</div>
    <h1>Add New User</h1>
    <p>Fill in the details to add a new record</p>
  </div>

  <?php if ($errorMsg): ?>
    <div class="alert alert-error"><?php echo $errorMsg; ?></div>
  <?php endif; ?>

  <div class="card">
    <form method="POST" action="">

      <div class="row">
        <div class="field">
          <label for="fname">First Name</label>
          <div class="input-wrap">
            <input type="text" id="fname" name="fname" placeholder="John" required />
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
        </div>

        <div class="field">
          <label for="lname">Last Name</label>
          <div class="input-wrap">
            <input type="text" id="lname" name="lname" placeholder="Doe" required />
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
        </div>
      </div>

      <div class="field">
        <label for="uname">Username</label>
        <div class="input-wrap">
          <input type="text" id="uname" name="uname" placeholder="johndoe123" required />
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.88 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
      </div>

      <div class="field">
        <label for="email">Email Address</label>
        <div class="input-wrap">
          <input type="email" id="email" name="email" placeholder="john@example.com" required />
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
      </div>

      <div class="divider"></div>

      <div class="field">
        <label for="pword">Password</label>
        <div class="input-wrap">
          <input type="password" id="pword" name="pword" placeholder="••••••••" required />
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
      </div>

      <div class="btn-row">
        <a href="view.php" class="btn btn-cancel">← Back</a>
        <button type="submit" name="save" class="btn btn-save">＋ Add User</button>
      </div>

    </form>
  </div>

</div>

</body>
</html>