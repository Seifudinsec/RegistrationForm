<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delete User</title>
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
      --danger: #ff4d6d;
      --danger-bg: rgba(255,77,109,0.08);
      --success: #00e5a0;
      --success-bg: rgba(0,229,160,0.08);
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }

    body::before, body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.15;
      pointer-events: none;
    }
    body::before {
      width: 500px; height: 500px;
      background: var(--danger);
      top: -200px; left: -150px;
    }
    body::after {
      width: 400px; height: 400px;
      background: var(--accent2);
      bottom: -100px; right: -100px;
    }

    .wrapper {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      padding: 24px;
      text-align: center;
      animation: fadeUp 0.5s ease both;
    }

    /* Icon circle */
    .icon-wrap {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 72px; height: 72px;
      border-radius: 50%;
      margin-bottom: 20px;
      font-size: 30px;
      animation: pop 0.4s ease 0.1s both;
    }
    .icon-danger {
      background: var(--danger-bg);
      border: 2px solid rgba(255,77,109,0.25);
    }
    .icon-success {
      background: var(--success-bg);
      border: 2px solid rgba(0,229,160,0.25);
    }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 36px 32px;
      box-shadow: 0 24px 80px rgba(0,0,0,0.5);
    }

    h1 {
      font-family: 'Syne', sans-serif;
      font-size: 22px;
      font-weight: 800;
      margin-bottom: 8px;
    }
    p {
      color: var(--muted);
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 28px;
    }

    /* User info box */
    .user-box {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 24px;
      text-align: left;
    }
    .user-box .label {
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--muted);
      margin-bottom: 4px;
    }
    .user-box .value {
      font-size: 15px;
      font-weight: 500;
      color: var(--text);
    }

    .btn-row {
      display: flex;
      gap: 12px;
    }

    .btn {
      flex: 1;
      padding: 13px;
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
    .btn:hover { opacity: 0.85; transform: translateY(-1px); }
    .btn-cancel {
      background: rgba(255,255,255,0.05);
      color: var(--muted);
      border: 1px solid var(--border);
    }
    .btn-danger {
      background: linear-gradient(135deg, #c0392b, var(--danger));
      color: #fff;
    }

    /* Success/redirecting state */
    .status-success h1 { color: var(--success); }
    .redirect-bar {
      height: 3px;
      background: var(--border);
      border-radius: 10px;
      margin-top: 20px;
      overflow: hidden;
    }
    .redirect-bar-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--accent2), var(--accent));
      animation: fillBar 2s linear forwards;
    }
    .redirect-note {
      font-size: 12px;
      color: var(--muted);
      margin-top: 10px;
      margin-bottom: 0;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pop {
      from { opacity: 0; transform: scale(0.7); }
      to   { opacity: 1; transform: scale(1); }
    }
    @keyframes fillBar {
      from { width: 0%; }
      to   { width: 100%; }
    }
  </style>
</head>
<body>

<?php
  $conn = mysqli_connect("localhost", "root", "", "userdetailsDB");
  $deleted = false;
  $userName = "";
  $userEmail = "";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user info before deleting
    $getUser = mysqli_query($conn, "SELECT * FROM userstable WHERE id='$id'");
    $user = mysqli_fetch_array($getUser);
    $userName = $user['firstname'] . " " . $user['lastname'];
    $userEmail = $user['email'];

    // Delete if confirmed
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
      $deleteUser = "DELETE FROM userstable WHERE id='$id'";
      $run = mysqli_query($conn, $deleteUser);
      if ($run) {
        $deleted = true;
        header("refresh:2; url=view.php");
      }
    }
  }
?>

<div class="wrapper">
  <div class="card <?php echo $deleted ? 'status-success' : ''; ?>">

    <?php if ($deleted): ?>
      <!-- SUCCESS STATE -->
      <div class="icon-wrap icon-success">✓</div>
      <h1>User Deleted</h1>
      <p><strong><?php echo htmlspecialchars($userName); ?></strong> has been removed from the system.</p>
      <div class="redirect-bar"><div class="redirect-bar-fill"></div></div>
      <p class="redirect-note">Redirecting you back to users list...</p>

    <?php else: ?>
      <!-- CONFIRM STATE -->
      <div class="icon-wrap icon-danger">🗑</div>
      <h1>Delete User?</h1>
      <p>This action cannot be undone. The following user will be permanently removed.</p>

      <div class="user-box">
        <div class="label">Full Name</div>
        <div class="value"><?php echo htmlspecialchars($userName); ?></div>
      </div>
      <div class="user-box">
        <div class="label">Email</div>
        <div class="value"><?php echo htmlspecialchars($userEmail); ?></div>
      </div>

      <div class="btn-row">
        <a href="view.php" class="btn btn-cancel">← Cancel</a>
        <a href="delete.php?id=<?php echo $_GET['id']; ?>&confirm=yes" class="btn btn-danger">🗑 Delete</a>
      </div>

    <?php endif; ?>

  </div>
</div>

</body>
</html>