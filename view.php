<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Users</title>
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
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      padding: 40px 24px;
      position: relative;
      overflow-x: hidden;
    }

    body::before, body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.12;
      pointer-events: none;
    }
    body::before {
      width: 500px; height: 500px;
      background: var(--accent2);
      top: -150px; left: -150px;
    }
    body::after {
      width: 400px; height: 400px;
      background: var(--accent);
      bottom: -100px; right: -100px;
    }

    .wrapper {
      max-width: 1000px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 32px;
      animation: fadeDown 0.5s ease both;
    }
    .header-left h1 {
      font-family: 'Syne', sans-serif;
      font-size: 26px;
      font-weight: 800;
      letter-spacing: -0.5px;
    }
    .header-left p {
      color: var(--muted);
      font-size: 13px;
      margin-top: 3px;
    }
    .btn-add {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 20px;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      border: none;
      border-radius: 10px;
      color: #fff;
      font-family: 'Syne', sans-serif;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      text-decoration: none;
      transition: opacity 0.2s, transform 0.15s;
    }
    .btn-add:hover { opacity: 0.88; transform: translateY(-1px); }

    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 24px 80px rgba(0,0,0,0.4);
      animation: fadeUp 0.5s ease 0.1s both;
    }

    table { width: 100%; border-collapse: collapse; }

    thead tr {
      background: rgba(255,255,255,0.03);
      border-bottom: 1px solid var(--border);
    }
    thead th {
      padding: 14px 18px;
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--muted);
    }

    tbody tr {
      border-bottom: 1px solid rgba(30,45,69,0.5);
      transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(255,255,255,0.02); }

    tbody td {
      padding: 14px 18px;
      font-size: 14px;
      color: var(--text);
      vertical-align: middle;
    }

    .id-badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 28px; height: 28px;
      border-radius: 8px;
      background: rgba(0,229,255,0.08);
      color: var(--accent);
      font-size: 12px;
      font-weight: 600;
    }

    .pass-mask {
      font-family: monospace;
      font-size: 13px;
      color: var(--muted);
      letter-spacing: 2px;
    }

    .actions { display: flex; gap: 8px; }

    .btn-edit, .btn-delete {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 6px 12px;
      border-radius: 7px;
      font-size: 12px;
      font-weight: 500;
      text-decoration: none;
      transition: opacity 0.2s, transform 0.15s;
      font-family: 'DM Sans', sans-serif;
    }
    .btn-edit {
      background: rgba(0,229,255,0.1);
      color: var(--accent);
      border: 1px solid rgba(0,229,255,0.2);
    }
    .btn-delete {
      background: var(--danger-bg);
      color: var(--danger);
      border: 1px solid rgba(255,77,109,0.2);
    }
    .btn-edit:hover, .btn-delete:hover { opacity: 0.75; transform: translateY(-1px); }

    .empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
    }
    .empty-icon { font-size: 40px; margin-bottom: 12px; }
    .empty p { font-size: 14px; }

    .count-badge {
      display: inline-flex;
      align-items: center;
      padding: 3px 10px;
      border-radius: 20px;
      background: rgba(0,229,255,0.08);
      color: var(--accent);
      font-size: 12px;
      font-weight: 600;
      margin-left: 10px;
      vertical-align: middle;
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-14px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

<?php
  $conn = mysqli_connect("localhost", "root", "", "userdetailsDB");
?>

<div class="wrapper">

  <div class="header">
    <div class="header-left">
      <h1>Users
        <?php
          $count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM userstable"));
          echo "<span class='count-badge'>$count</span>";
        ?>
      </h1>
      <p>All registered accounts in the system</p>
    </div>
    <a href="index.php" class="btn-add">＋ Add User</a>
  </div>

  <div class="card">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Password</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $allUsers = "SELECT * FROM userstable";
          $run = mysqli_query($conn, $allUsers);

          if (mysqli_num_rows($run) > 0) {
            while ($row = mysqli_fetch_array($run)) {
              echo "<tr>";
              echo "<td><span class='id-badge'>" . $row['id'] . "</span></td>";
              echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td><span class='pass-mask'>••••••••</span></td>";
              echo "<td>
                      <div class='actions'>
                        <a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>✎ Edit</a>
                        <a href='delete.php?id=" . $row['id'] . "' class='btn-delete' onclick=\"return confirm('Delete this user?')\">✕ Delete</a>
                      </div>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='7'>
                    <div class='empty'>
                      <div class='empty-icon'>👤</div>
                      <p>No users found. Add one to get started.</p>
                    </div>
                  </td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>

</div>

</body>
</html>