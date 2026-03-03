<?php

require 'insert.php';

require 'update.php';

require 'delete.php';

require 'select.php';

?>







<?php

// CHECK IF EDIT MODE

$editUser = null;



if (isset($_GET['edit'])) {

  $users_id = $_GET['edit'];

  // grab both user and order data so form fields can be pre-filled
  $stmt = $pdo->prepare("SELECT users.*, orders.product, orders.amount\n                         FROM users\n                         LEFT JOIN orders ON users.users_id = orders.users_id\n                         WHERE users.users_id = ?");

  $stmt->execute([$users_id]);

  $editUser = $stmt->fetch(PDO::FETCH_ASSOC);

}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <style>
      :root {
        --primary-color: #4f46e5;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
      }
      
      body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 30px 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      
      .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        color: white !important;
      }
      
      .page-header {
        background: rgba(255, 255, 255, 0.95);
        padding: 25px 0;
        margin-bottom: 30px;
        border-bottom: 4px solid var(--primary-color);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
      
      .page-title {
        color: var(--primary-color);
        font-weight: 700;
        margin: 0;
      }
      
      .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
      }
      
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      }
      
      .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
        color: white;
        border: none;
        padding: 20px;
        font-weight: 600;
      }
      
      .card-body {
        padding: 30px;
      }
      
      .form-label {
        font-weight: 600;
        color: #374151;
        margin-top: 15px;
        margin-bottom: 8px;
      }
      
      .form-control {
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        padding: 10px 15px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
      }
      
      .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
      }
      
      .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: none;
      }
      
      .btn-success {
        background: var(--success-color);
      }
      
      .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      }
      
      .btn-warning {
        background: var(--warning-color);
        color: white;
      }
      
      .btn-warning:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
      }
      
      .btn-danger {
        background: var(--danger-color);
      }
      
      .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
      }
      
      .btn a {
        color: inherit;
        text-decoration: none;
      }
      
      .table {
        margin-bottom: 0;
      }
      
      .table-hover tbody tr:hover {
        background-color: #f3f4f6;
        transform: scale(1.01);
      }
      
      .table thead {
        background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
        color: white;
      }
      
      .table th {
        border: none;
        font-weight: 600;
        padding: 15px;
      }
      
      .table td {
        padding: 15px;
        vertical-align: middle;
        color: #374151;
      }
      
      .btn-group-sm {
        display: flex;
        gap: 5px;
      }
      
      h3 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
      }
      
      .form-section {
        margin-bottom: 15px;
      }
      
      .btn-wrapper {
        display: flex;
        gap: 10px;
        margin-top: 25px;
      }
      
      .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
      }
    </style>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar bg-dark">
      <div class="container">
        <span class="navbar-brand">👥 User Management</span>
      </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
      <div class="container">
        <h1 class="page-title">📊 Manage Users & Orders</h1>
        <p class="text-muted mb-0">Create, edit, and manage user information</p>
      </div>
    </div>

    <div class="container">  
      <div class="row">
        <div class="col-lg-5 col-md-12 mb-4">
    <div class="card">
      <div class="card-header">
        <?= $editUser ? '✏️ Update User Information' : '➕ Add New User' ?>
      </div>
      <div class="card-body">
        <form method="POST">
          <?php if (!empty($editUser)): ?>
            <input type="hidden" name="users_id" value="<?= $editUser['users_id'] ?>">
          <?php endif; ?>

          <div class="form-section">
            <label for="Name" class="form-label">👤 Full Name</label>
            <input type="text" name="name" value="<?= !empty($editUser) ? htmlspecialchars($editUser['name']) : '' ?>" class="form-control" placeholder="Enter full name" required>
          </div>

          <div class="form-section">
            <label for="Email" class="form-label">✉️ Email Address</label>
            <input type="email" name="email" value="<?= !empty($editUser) ? htmlspecialchars($editUser['email']) : '' ?>" class="form-control" placeholder="Enter email address" required>
          </div>

          <div class="form-section">
            <label for="Product" class="form-label">📦 Product</label>
            <input type="text" name="product" value="<?= !empty($editUser) ? htmlspecialchars($editUser['product']) : '' ?>" placeholder="Enter product name" class="form-control" required>
          </div>

          <div class="form-section">
            <label for="Amount" class="form-label">💵 Amount</label>
            <input type="number" step="0.01" name="amount" value="<?= !empty($editUser) ? htmlspecialchars($editUser['amount']) : '' ?>" placeholder="Enter amount" class="form-control" required>
          </div>

          <div class="btn-wrapper">
            <?php if (!empty($editUser)): ?>
              <button type="submit" name="update" class="btn btn-success flex-grow-1">
                ✅ Update
              </button>
              <a href="landing.php" class="btn btn-secondary flex-grow-1">
                ❌ Cancel
              </a>
            <?php else: ?>
              <button type="submit" name="add" class="btn btn-success w-100">
                ➕ Add User
              </button>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-7 col-md-12">


    <div class="card">
      <div class="card-header">
        📋 User List & Orders
      </div>
      <div class="card-body">
        <?php if (!empty($users)): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th># ID</th>
                  <th>👤 Name</th>
                  <th>✉️ Email</th>
                  <th>📦 Product</th>
                  <th>💵 Amount</th>
                  <th>⚙️ Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($user['users_id']) ?></strong></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></a></td>
                    <td><?= htmlspecialchars($user['product']) ?></td>
                    <td><strong class="text-success">$<?= number_format($user['amount'], 2) ?></strong></td>
                    <td>
                      <a href="?edit=<?= htmlspecialchars($user['users_id']) ?>" class="btn btn-warning btn-sm" title="Edit User">
                        ✏️ Edit
                      </a>
                      <a href="?delete=<?= htmlspecialchars($user['users_id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');" title="Delete User">
                        🗑️ Delete
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="empty-state">
            <div style="font-size: 2.5rem; margin-bottom: 15px; color: #d1d5db;">📭</div>
            <p style="font-size: 1.1rem;">No users found. Add your first user to get started!</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
  </body>
</html>