<?php include '../config/config.php';
checkLogin();
checkRole(['admin']);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Menu Management</title>
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/menu_management.css">
  <link rel="stylesheet" href="<?= $base_url ?>assets/css/sidebar.css">
  <link rel="stylesheet" href="<?= $base_url ?>assets/icon/css/all.min.css">

  <style>
    /* TOPBAR */
    .topbar {
      position: sticky;
      top: 0;
      left: 250px;

      right: 0;
      z-index: 1000;

      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 15px;

      margin-top: -40px;
      margin-bottom: 30px;

      padding-left: 20px;
      padding-right: 20px;
      padding-top: 25px;
      padding-bottom: 0px;
      backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);

      transition: all 0.3s ease;
    }

    i {
      font-size: 25px;
    }
  </style>
</head>

<body>
  <?php include '../include/sidebar.php'; ?>
  <div class="content">

    <!-- TOPBAR -->
    <div class="topbar">
      <h1>Custom Menu</h1>
      <p style="margin-top: -20px;">
        Welcome, <?= $_SESSION['users'] ?? 'Guest' ?>
        (<?= $_SESSION['role'] ?? 'Unknown' ?>)
        <i class="fas fa-user-circle"></i>
      </p>
    </div>

    <!-- ADD MENU -->
    <div class="add-box">
      <h3>Add New Menu</h3>

      <form action="add_menu.php" method="POST">

        <input type="text" name="menu" placeholder="Menu Name" required>

        <input type="number" name="price_medium" placeholder="Medium Price" required>

        <input type="number" name="price_large" placeholder="Large Price" required>

        <button type="submit">Add Menu</button>

      </form>
    </div>


    <!-- MENU TABLE -->
    <div class="orders-container">
      <table Class="orders-table">

        <tr>
          <th>Menu</th>
          <th>Medium</th>
          <th>Large</th>
          <th>Actions</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM menu");

        while ($row = $result->fetch_assoc()) {
        ?>

          <form action="update_menu.php" method="POST">

            <tr>

              <td>
                <input type="hidden" name="menuID" value="<?= $row['menuID'] ?>">
                <input type="text" name="menu" value="<?= $row['menu'] ?>">
              </td>

              <td>
                <input type="number" name="price_medium" value="<?= $row['price_medium'] ?>">
              </td>

              <td>
                <input type="number" name="price_large" value="<?= $row['price_large'] ?>">
              </td>

              <td>

                <button class="update">Update</button>

                <a class="delete"
                  href="delete_menu.php?id=<?= $row['menuID'] ?>"
                  onclick="return confirm('Delete this menu?')">
                  Delete
                </a>

              </td>

            </tr>

          </form>
    </div>
  <?php } ?>

  </table>

  </div>

</body>

</html>