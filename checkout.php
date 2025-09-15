<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Checkout - Sweet Bliss</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Sweet Bliss theme style for UPI button */
    #upiPayBtn {
      display: none;
      margin-bottom: 15px;
      background: linear-gradient(135deg, #ff7eb3, #ff758c); /* Sweet Bliss pinkish theme */
      border: none;
      color: white;
      font-weight: bold;
      padding: 10px 20px;
      border-radius: 8px;
      transition: 0.3s ease;
      text-decoration: none;
    }
    #upiPayBtn:hover {
      background: linear-gradient(135deg, #ff4e8b, #ff2e63);
      transform: scale(1.05);
      color: #fff;
    }
  </style>
</head>
<body class="container py-5">
  <h2>Checkout</h2>
  <?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Cake</th>
          <th>Quantity</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; foreach ($cart as $item): 
          $quantity = isset($item['qty']) ? $item['qty'] : 1;
        ?>
          <tr>
            <td><?= htmlspecialchars($item['title']) ?></td>
            <td><?= $quantity ?></td>
            <td>₹<?= number_format($item['price'] * $quantity, 2) ?></td>
          </tr>
          <?php $total += $item['price'] * $quantity; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
    <h4>Total: ₹<?= number_format($total, 2) ?></h4>
    <form action="place_order.php" method="POST">
      <div class="mb-3">
        <label for="customerphonenumber" class="form-label">Phone Number</label>
        <input type="number" class="form-control" id="customerphonenumber" name="customerphonenumber" required>
      </div>
      <div class="mb-3">
        <label for="customeraddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="customeraddress" name="customeraddress" required>
      </div>
      <label>Payment Method:</label>
      <select name="payment_method" id="payment_method" class="form-select mb-3" required>
        <option value="cod">Cash on Delivery</option>
        <option value="upi">UPI</option>
        <!-- Future payment methods can be added here -->
      </select>

      <!-- UPI Pay Button (Google Form link opens in new tab) -->
      <a href="https://docs.google.com/forms/d/e/1FAIpQLScNQD9BsIZTY6y0JmHuIPEGaiW-Fn5F86CmXy8im6WopbjdvQ/viewform?usp=header" target="_blank" id="upiPayBtn">Click here to Pay</a>
      <p1 style="text: size 10px;">(For UPI payments, please click the button above to complete your payment via our secure Google Form. After submitting the form, return here to finalize your order.)</p>
      <button type="submit" class="btn btn-success">Place Order</button>
    </form>
  <?php endif; ?>

  <script>
    const paymentSelect = document.getElementById('payment_method');
    const upiBtn = document.getElementById('upiPayBtn');

    paymentSelect.addEventListener('change', function() {
      if (this.value === 'upi') {
        upiBtn.style.display = 'inline-block';
      } else {
        upiBtn.style.display = 'none';
      }
    });
  </script>
</body>
</html>
