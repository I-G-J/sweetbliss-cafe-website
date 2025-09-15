<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Bakery Admin Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container mt-4">
    <h2>Welcome Admin - Sweet Bliss</h2>
    <!-- Bootstrap Nav Tabs -->
    <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="addcake-tab" data-toggle="tab" href="#addcake" role="tab">Add Items</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab">Orders</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="messages-tab" data-toggle="tab" href="#messages" role="tab">Contact Messages</a>
      </li>

    </ul>

    <div class="tab-content" id="adminTabContent">
      <!-- Add Cake Tab -->
      <div class="tab-pane fade show active" id="addcake" role="tabpanel">
        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Item Name</label>
              <input type="text" class="form-control" name="cake_name" placeholder="Item name" required>
            </div>
          </div>
          <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control" name="description" placeholder="Short description">
          </div>
          <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" required>
          </div>
          <div class="form-group">
            <label>Upload Item Image</label>
            <input type="file" class="form-control" name="image" accept="image/*" required>
          </div>
          <input type="submit" class="btn btn-primary" name="save" value="Save Item">
        </form>
        <?php
        include "db.php";
        // Handle Cake Upload
        if (isset($_POST["save"])) {

          $cake_name = $conn->real_escape_string($_POST['cake_name']);
          $desc = $conn->real_escape_string($_POST['description']);
          $price = $conn->real_escape_string($_POST['price']);

          // upload image
          $uploadDir = "uploads/cakes/";
          if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
          }
          $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            $sql = "INSERT INTO cakes (cake_name, description, price, image)
                VALUES ('$cake_name', '$desc', '$price', '$imagePath')";
            if ($conn->query($sql) === TRUE) {
              echo "<div class='alert alert-success mt-3'>Item saved successfully!</div>";
            } else {
              echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
            }
          } else {
            echo "<div class='alert alert-danger mt-3'>Image upload failed.</div>";
          }
        }
        ?>
      </div>
      <!-- Orders Tab -->
      <div class="tab-pane fade" id="orders" role="tabpanel">
        <?php
        // Fetch orders
        $result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        ?>
        <h2>Orders</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Items</th>
              <th>Payment</th>
              <th>Customer</th>
              <th>Address</th>
              <th>Phone Number</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $order['order_id'] ?></td>
                <td>
                  <?php
                  $items = json_decode($order['items'], true);
                  if (is_array($items)) {
                    foreach ($items as $item) {
                      $quantity = isset($item['qty']) ? $item['qty'] : 1;
                      echo htmlspecialchars($item['title']) . " x " . $quantity . "<br>";
                    }
                  } else {
                    echo "<span class='text-danger'>Invalid or empty order items.</span>";
                  }
                  ?>
                </td>
                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                <td>
                  <?= isset($order['customer_name']) ? htmlspecialchars($order['customer_name']) : '' ?><br>
                  <?= isset($order['customer_email']) ? htmlspecialchars($order['customer_email']) : '' ?>
                </td>
                <td><?= isset($order['customer_address']) ? htmlspecialchars($order['customer_address']) : '' ?></td>
                <td><?= isset($order['customer_phonenumber']) ? htmlspecialchars($order['customer_phonenumber']) : '' ?>
                </td>

                <td><?= $order['created_at'] ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>


        <!-- Check UPI Payments Button -->
        <div class="text-center mb-4">
          <a href="https://docs.google.com/forms/d/1CctjmnqwNQ08teX9yDWZcoWUp2HG5pfLrJQrilkCTBM/edit#responses"
            target="_blank" class="btn btn-success btn-lg">Check UPI Payments</a>
        </div>
        <?php $conn->close(); ?>
      </div>

      <!-- Contact Messages Tab -->
<div class="tab-pane fade" id="messages" role="tabpanel">
  <?php
  include "db.php"; // reconnect because you closed it after orders
  $result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
  ?>
  <h2>Contact Messages</h2>
  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($msg = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $msg['id'] ?></td>
          <td><?= htmlspecialchars($msg['name']) ?></td>
          <td><?= htmlspecialchars($msg['email']) ?></td>
          <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
          <td><?= $msg['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php $conn->close(); ?>
</div>

    </div>
  </div>
  <script>
    // Enable Bootstrap tabs
    $(function () {
      $('#adminTab a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
      });
    });
  </script>
</body>

</html>