<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <title>View Cakes - Sweet Bliss Admin</title>
  </head>
  <body>
    <div class="container mt-4">
      <h2>All Cakes - Sweet Bliss Admin</h2>

      <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <a class="navbar-brand" href="#">Sweet Bliss Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Add Cake</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="view_cakes.php">View Cakes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Orders</a>
            </li>
          </ul>
        </div>
      </nav>

      <?php
      $conn = new mysqli("localhost", "root", "", "sweet_bliss");
      if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

      // Handle delete action
      if (isset($_GET['delete'])) {
          $delete_id = $_GET['delete'];
          $conn->query("DELETE FROM cakes WHERE cake_id='$delete_id'");
          echo "<script>alert('Cake deleted successfully!'); window.location='view_cakes.php';</script>";
      }

      $result = $conn->query("SELECT * FROM cakes");
      if ($result->num_rows > 0) {
          echo "<table class='table table-bordered'>";
          echo "<thead class='thead-dark'><tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr></thead><tbody>";
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>".$row['cake_id']."</td>
                      <td>".$row['cake_name']."</td>
                      <td>".$row['description']."</td>
                      <td>₹".$row['price']."</td>
                      <td><img src='".$row['image']."' width='80'></td>
                      <td>
                        <a href='edit_cake.php?id=".$row['cake_id']."' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='view_cakes.php?delete=".$row['cake_id']."' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure?');\">Delete</a>
                      </td>
                    </tr>";
          }
          echo "</tbody></table>";
      } else {
          echo "<div class='alert alert-info'>No cakes found.</div>";
      }

      $conn->close();
      ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
