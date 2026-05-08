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

    /* ── Header ── */
    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 28px;
      animation: fadeDown 0.5s ease both;
    }
    .header-left h1 {
      font-family: 'Syne', sans-serif;
      font-size: 24px;
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
      gap: 6px;
      padding: 10px 18px;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      border-radius: 10px;
      color: #fff;
      font-family: 'Syne', sans-serif;
      font-size: 13px;
      font-weight: 700;
      text-decoration: none;
      white-space: nowrap;
      transition: opacity 0.2s, transform 0.15s;
    }
    .btn-add:hover { opacity: 0.88; transform: translateY(-1px); }

    .count-badge {
      display: inline-flex;
      align-items: center;
      padding: 3px 10px;
      border-radius: 20px;
      background: rgba(0,229,255,0.08);
      color: var(--accent);
      font-size: 12px;
      font-weight: 600;
      margin-left: 8px;
      vertical-align: middle;
    }

    /* ── Desktop Table ── */
    .card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 24px 80px rgba(0,0,0,0.4);
      animation: fadeUp 0.5s ease 0.1s both;
    }

    .table-wrap {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 600px; /* prevents table from squishing too small */
    }

    thead tr {
      background: rgba(255,255,255,0.03);
      border-bottom: 1px solid var(--border);
    }
    thead th {
      padding: 14px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--muted);
      white-space: nowrap;
    }

    tbody tr {
      border-bottom: 1px solid rgba(30,45,69,0.5);
      transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(255,255,255,0.02); }

    tbody td {
      padding: 13px 16px;
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

    .actions { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn-edit, .btn-delete {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 6px 12px;
      border-radius: 7px;
      font-size: 12px;
      font-weight: 500;
      text-decoration: none;
      white-space: nowrap;
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

    /* ── Mobile Cards (hidden on desktop) ── */
    .mobile-cards { display: none; }

    .user-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 18px;
      margin-bottom: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      animation: fadeUp 0.4s ease both;
    }

    .user-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 14px;
    }
    .user-card-name {
      font-family: 'Syne', sans-serif;
      font-size: 16px;
      font-weight: 700;
    }

    .user-card-body {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 14px;
    }

    .user-card-field .field-label {
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: var(--muted);
      margin-bottom: 2px;
    }
    .user-card-field .field-value {
      font-size: 13px;
      color: var(--text);
      word-break: break-all;
    }

    .user-card-actions {
      display: flex;
      gap: 10px;
      padding-top: 12px;
      border-top: 1px solid var(--border);
    }
    .user-card-actions .btn-edit,
    .user-card-actions .btn-delete {
      flex: 1;
      justify-content: center;
      padding: 9px;
      font-size: 13px;
    }

    /* ── Empty state ── */
    .empty {
      text-align: center;
      padding: 60px 20px;
      color: var(--muted);
    }
    .empty-icon { font-size: 40px; margin-bottom: 12px; }
    .empty p { font-size: 14px; }

    /* ── Responsive breakpoints ── */
    @media (max-width: 640px) {
      body { padding: 24px 16px; }

      .header-left h1 { font-size: 20px; }

      /* Hide desktop table, show mobile cards */
      .card { display: none; }
      .mobile-cards { display: block; }
    }

    @media (max-width: 400px) {
      .user-card-body { grid-template-columns: 1fr; }
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
  $allUsers = "SELECT * FROM userstable";
  $run = mysqli_query($conn, $allUsers);
  $count = mysqli_num_rows($run);
?>

<div class="wrapper">

  <!-- Header -->
  <div class="header">
    <div class="header-left">
      <h1>Users <span class="count-badge"><?php echo $count; ?></span></h1>
      <p>All registered accounts in the system</p>
    </div>
    <a href="index.php" class="btn-add">＋ Add User</a>
  </div>

  <?php if ($count > 0):
    // Re-run query since we used num_rows above
    $run = mysqli_query($conn, $allUsers);
    $rows = [];
    while ($row = mysqli_fetch_array($run)) {
      $rows[] = $row;
    }
  ?>

  <!-- Desktop Table -->
  <div class="card">
    <div class="table-wrap">
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
          <?php foreach ($rows as $row): ?>
          <tr>
            <td><span class="id-badge"><?php echo $row['id']; ?></span></td>
            <td><?php echo htmlspecialchars($row['firstname']); ?></td>
            <td><?php echo htmlspecialchars($row['lastname']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><span class="pass-mask">••••••••</span></td>
            <td>
              <div class="actions">
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">✎ Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this user?')">✕ Delete</a>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Mobile Cards -->
  <div class="mobile-cards">
    <?php foreach ($rows as $row): ?>
    <div class="user-card">
      <div class="user-card-header">
        <div class="user-card-name"><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?></div>
        <span class="id-badge"><?php echo $row['id']; ?></span>
      </div>
      <div class="user-card-body">
        <div class="user-card-field">
          <div class="field-label">Username</div>
          <div class="field-value"><?php echo htmlspecialchars($row['username']); ?></div>
        </div>
        <div class="user-card-field">
          <div class="field-label">Password</div>
          <div class="field-value"><span class="pass-mask">••••••••</span></div>
        </div>
        <div class="user-card-field" style="grid-column: 1 / -1;">
          <div class="field-label">Email</div>
          <div class="field-value"><?php echo htmlspecialchars($row['email']); ?></div>
        </div>
      </div>
      <div class="user-card-actions">
        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">✎ Edit</a>
        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Delete this user?')">✕ Delete</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <?php else: ?>
  <!-- Empty state -->
  <div class="card">
    <div class="empty">
      <div class="empty-icon">👤</div>
      <p>No users found. Add one to get started.</p>
    </div>
  </div>
  <?php endif; ?>

</div>

</body>
</html>