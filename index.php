<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sweet Bliss - Bakery & Desserts</title>
  <meta name="description" content="Sweet Bliss Bakery - Freshly baked cakes, cupcakes, pastries & desserts. Order online now!" />

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    html { scroll-behavior: smooth; }
    body { font-family: 'Segoe UI', sans-serif; transition: background 0.3s, color 0.3s; }

    /* Hero */
    .hero {
      background-image: url('background.png');
      background-size: cover; background-position: center;
      height: 90vh; display: flex; align-items: center; justify-content: center;
      color: white; text-align: center; position: relative;
    }
    .hero::after { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.45); }
    .hero > div { position: relative; z-index: 1; animation: fadeInUp 1.1s ease-out; }
    @keyframes fadeInUp { from {opacity:0; transform: translateY(30px);} to {opacity:1; transform: translateY(0);} }
    .hero h1 { font-size: clamp(2.2rem, 5vw, 4rem); text-shadow: 2px 2px 10px rgba(0,0,0,0.6); }
    .hero .btn { animation: pulse 2s infinite; background-color: rgba(255,193,7,0.9); }
    @keyframes pulse { 0%{box-shadow:0 0 0 0 rgba(255,193,7,0.6);} 70%{box-shadow:0 0 0 12px rgba(255,193,7,0);} 100%{box-shadow:0 0 0 0 rgba(255,193,7,0);} }

    /* Menu */
    .section-title { margin: 60px 0 30px; text-align: center; font-weight: bold; }
    .card img { height: 200px; object-fit: cover; }
    .card:hover { transform: translateY(-3px); transition: transform 0.25s ease; }

    /* Footer */
    footer { background-color: #f8f9fa; padding: 30px 0; text-align: center; margin-top: 60px; }
    footer a { margin: 0 10px; color: inherit; }

    /* Dark Mode */
    .dark-mode { background: #121212; color: #f1f1f1; }
    .dark-mode .navbar { background: #1a1a1a !important; }
    .dark-mode footer { background: #1f1f1f; }
    .dark-mode .card { background: #1a1a1a; color: #eaeaea; }

    /* Utility */
    .pointer { cursor: pointer; }
    .cart-img { width: 60px; height: 60px; object-fit: cover; border-radius: .5rem; }
  </style>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="70">


<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!--navbar -->


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">🍰 Sweet Bliss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">About</a></li>

        <?php if(isset($_SESSION['username'])): ?>
          <!-- Display user initial with logout dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-bold text-uppercase" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
              <?php echo $_SESSION['username'][0]; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Show Signup & Login buttons when not logged in -->
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a></li>
          <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link position-relative pointer" data-bs-toggle="modal" data-bs-target="#cartModal" aria-label="Open cart">
            <i class="bi bi-cart3"></i>
            <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
          </a>
        </li>
        <li class="nav-item"><button id="toggleDark" class="btn btn-sm btn-outline-secondary ms-lg-2" aria-label="Toggle dark mode">🌙</button></li>
      </ul>
    </div>
  </div>
</nav>





<!-- Hero -->
<div class="hero">
  <div>
    <h1>Delight in Every Bite</h1>
    <p class="lead">Great food warm bevrages and Drinks </p>
    <a href="#menu" class="btn btn-warning btn-lg mt-3">Explore Menu</a>
    <a href="#" class="btn btn-light btn-lg mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#signupModal">Join Us</a>
  </div>
</div>
<!--yaha add akr rahe hai -->




<!-- Menu Section -->
<section id="menu" class="container">
  <h2 class="section-title">Our Menu</h2>
  
  <!-- Search & Categories -->
  <div class="row g-2 align-items-center mb-3">
    <div class="col-12 col-lg-6">
      <input type="text" id="search" class="form-control" placeholder="Search cakes, cupcakes, pastries...">
    </div>
    <div class="col-12 col-lg-6 d-flex justify-content-lg-end">
      <ul class="nav nav-pills" id="categoryPills">
        <li class="nav-item"><button class="nav-link active" data-category="all"></button></li>
        <li class="nav-item"><button class="nav-link" data-category="cake"></button></li>
        <li class="nav-item"><button class="nav-link" data-category="cupcake"></button></li>
        <li class="nav-item"><button class="nav-link" data-category="pastry"></button></li>
      </ul>
    </div>
  </div>

  <!-- Menu Items -->
  <div class="row row-cols-1 row-cols-md-3 g-4" id="menu-items"></div>
</section>




<!-- Contact Section -->
<section id="contact" class="container mt-5">
  <div class="container">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p class="text-center mb-5">We’d love to hear from you! Send us your queries, feedback, or suggestions.</p>

    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-lg">
          <div class="card-body p-4">
            <form action="contact.php" method="POST">
              <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
              </div>

              <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
              </div>

              <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Footer -->
<footer>
  <p class="mb-2">&copy; 2025 Sweet Bliss Bakery. All rights reserved.</p>
  <div>
    <a href="https://www.instagram.com/its_gj_1/" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
    <a href="https://www.instagram.com/its_gj_1/" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
  </div>
</footer>

<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">About Sweet Bliss</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row g-3">
        <div class="col-md-6">
          <p>Welcome to "Sweet Bliss", your cozy escape at Lalpur Chowk, Ranchi. We're more than just a café. we're a community built on a passion for great food, warm beverages, and creating unforgettable moments.

Our journey began with a simple idea: to create a space where you can unwind with a perfect cup of coffee, indulge in a delicious meal, and enjoy the company of friends and family. From our aromatic Kulhad Chai to our classic Margherita Pizza and comforting Grilled Cheese Sandwich, every item on our menu is crafted with care and the freshest ingredients.

At Sweet Bliss, we believe in quality and a touch of homegrown love. We source our ingredients locally whenever possible to bring you authentic flavors. Whether you're looking for a quick bite, a leisurely lunch, or a sweet treat like our Vanilla Chocolate Ice Cream, you'll find something to make you smile.

Thank you for letting us be a part of your day. Come in, relax, and find your own moment of sweet bliss.</p>
        </div>
        <div class="col-md-6">
          <img src="about.webp" class="img-fluid rounded" alt="Baker decorating a cake">
        </div>
      </div>
    </div>
  </div>
</div>




<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      
      <!-- Header -->
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title fw-bold" id="loginModalLabel">
          <i class="bi bi-person-circle me-2"></i> Login to Sweet Bliss
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body p-4">
        <form action="login.php" method="POST" id="loginForm" novalidate>
          
          <!-- Email -->
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email Address</label>
            <input 
              type="email" 
              class="form-control" 
              id="loginEmail" 
              name="email" 
              placeholder="Enter your email"
              required>
            <div class="invalid-feedback">Please enter a valid email address.</div>
          </div>
          
          <!-- Password -->
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Password</label>
            <input 
              type="password" 
              class="form-control" 
              id="loginPassword" 
              name="password" 
              placeholder="Enter your password"
              minlength="6"
              required>
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
          </div>

          <!-- Remember Me + Forgot Password -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            <a href="#" class="text-decoration-none text-warning fw-semibold">Forgot Password?</a>
          </div>
          
          <!-- Button -->
          <button type="submit" class="btn btn-warning w-100 fw-bold">Login</button>
          
        </form>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-center">
        <p class="mb-0">Don't have an account? 
          <a href="#" class="text-warning fw-bold" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Sign Up</a>
        </p>
      </div>
    </div>
  </div>
</div>

         <!-- Small Script for Bootstrap validation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("loginForm");
  form.addEventListener("submit", function (event) {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add("was-validated");
  });
});
</script>
  





<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-3">
      
      <!-- Header -->
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title fw-bold">Create Account</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4">
        <form action="signup.php" method="POST" id="signupForm">
          
          <!-- Full Name -->
          <div class="mb-3">
            <label for="signupName" class="form-label fw-semibold">Full Name</label>
            <input type="text" id="signupName" name="name" class="form-control" placeholder="Enter your full name" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="signupEmail" class="form-label fw-semibold">Email Address</label>
            <input type="email" id="signupEmail" name="email" class="form-control" placeholder="you@example.com" required>
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label for="signupPassword" class="form-label fw-semibold">Password</label>
            <input type="password" id="signupPassword" name="password" class="form-control" placeholder="Enter password" minlength="6" required>
            <small class="text-muted">At least 6 characters</small>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label for="signupConfirm" class="form-label fw-semibold">Confirm Password</label>
            <input type="password" id="signupConfirm" name="confirm_password" class="form-control" placeholder="Re-enter password" required>
          </div>

          <!-- Terms -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="termsCheck" required>
            <label class="form-check-label" for="termsCheck">
              I agree to the <a href="terms.php" target="_blank">Terms & Conditions</a>
            </label>
          </div>

          <!-- Submit -->
          <button class="btn btn-warning w-100 fw-bold" type="submit">Sign Up</button>
        </form>
      </div>

      <!-- Footer -->
      <div class="modal-footer text-center justify-content-center">
        <p class="mb-0">Already have an account? 
          <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login here</a>
        </p>
      </div>

    </div>
  </div>
</div>


<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Item</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <img id="orderImg" class="cart-img" alt="Selected item preview"/>
          <div>
            <p class="mb-0 fw-semibold" id="orderItem"></p>
            <small class="text-muted" id="orderPrice"></small>
          </div>
        </div>
        <label for="orderQty" class="form-label">Quantity</label>
        <input type="number" id="orderQty" class="form-control" min="1" value="1">
        <button class="btn btn-warning mt-3 w-100" id="addToCart">Add to Cart</button>
      </div>
    </div>
  </div>
</div>

<!-- Cart Modal -->



<div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Your Cart</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="cartEmpty" class="text-center text-muted py-4">Your cart is empty.</div>
        <div id="cartFilled" class="d-none">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Price</th>
                  <th style="width: 120px;">Qty</th>
                  <th>Subtotal</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="cartTable"></tbody>
            </table>
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <button id="clearCart" class="btn btn-outline-secondary">Clear Cart</button>
            <div class="h5 mb-0">Total: <span id="cartTotal"></span></div>
          </div>
          
          <button class="btn btn-warning w-100 mt-3" id="checkoutBtn">Checkout</button>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ====== Data ======
  let cakes = [];

function fetchCakes() {
  fetch('get_cakes.php')
    .then(res => res.json())
    .then(data => {
      cakes = data;
      renderMenu();
    });
}

  // ====== Helpers ======
  const fmt = (v) => new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(v);
  const el = (sel) => document.querySelector(sel);

// ====== Render Menu ======
const menuContainer = document.getElementById('menu-items');
function renderMenu(filter = 'all', search = '') {
  menuContainer.innerHTML = '';
  cakes
    .filter(c => (filter === 'all' || c.cat === filter) && (c.title + ' ' + c.desc).toLowerCase().includes(search.toLowerCase()))
    .forEach(c => {
      const card = document.createElement('div');
      card.className = 'col';
      card.innerHTML = `
        <div class="card shadow-sm h-100">
          <img src="${c.img}" class="card-img-top" alt="${c.title}" loading="lazy">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">${c.title}</h5>
            <p class="card-text">${c.desc}</p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <span class="fw-semibold">${fmt(c.price)}</span>
              <button class="btn btn-warning order-btn" data-id="${c.id}">Order Now</button>
            </div>
          </div>
        </div>`;
      menuContainer.appendChild(card);
    });
}

// Initial AJAX fetch
fetchCakes();

  // Category filter
  document.querySelectorAll('[data-category]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('[data-category]').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      renderMenu(btn.dataset.category, el('#search').value);
    });
  });

  // Search filter
  document.getElementById('search').addEventListener('input', (e) => {
    const currentCat = document.querySelector('#categoryPills .active').dataset.category;
    renderMenu(currentCat, e.target.value);
  });

  // ====== Cart System (localStorage) ======
  const CART_KEY = 'sb_cart_v1';
  let cart = loadCart();

  function loadCart(){
    try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; } catch { return []; }
  }
  function saveCart(){ localStorage.setItem(CART_KEY, JSON.stringify(cart)); }
  function cartTotalCount(){ return cart.reduce((s,i)=> s + i.qty, 0); }
  function cartTotalAmount(){ return cart.reduce((s,i)=> s + i.qty * i.price, 0); }

  function updateCartBadge(){ el('#cart-count').innerText = cartTotalCount(); }

  function addToCart(id, qty){
    const item = cakes.find(c => c.id === id);
    if(!item) return;
    const found = cart.find(i => i.id === id);
    if(found) found.qty += qty; else cart.push({ id, title: item.title, price: item.price, img: item.img, qty });
    saveCart();
    updateCartBadge();
  }

  function removeFromCart(id){ cart = cart.filter(i => i.id !== id); saveCart(); updateCartBadge(); }

  function setQty(id, qty){
    const it = cart.find(i => i.id === id);
    if(!it) return;
    it.qty = Math.max(1, qty|0);
    saveCart();
  }

  function renderCart(){
    const empty = el('#cartEmpty');
    const filled = el('#cartFilled');
    const tbody = el('#cartTable');
    tbody.innerHTML = '';

    if(cart.length === 0){
      empty.classList.remove('d-none');
      filled.classList.add('d-none');
      updateCartBadge();
      return;
    }

    empty.classList.add('d-none');
    filled.classList.remove('d-none');

    cart.forEach(i => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>
          <div class="d-flex align-items-center gap-2">
            <img src="${i.img}" alt="${i.title}" class="cart-img" loading="lazy">
            <div class="fw-semibold">${i.title}</div>
          </div>
        </td>
        <td>${fmt(i.price)}</td>
        <td>
          <input type="number" min="1" value="${i.qty}" class="form-control form-control-sm qty-input" data-id="${i.id}">
        </td>
        <td>${fmt(i.qty * i.price)}</td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-danger remove-item" data-id="${i.id}"><i class="bi bi-trash"></i></button>
        </td>`;
      tbody.appendChild(tr);
    });

    el('#cartTotal').innerText = fmt(cartTotalAmount());
    updateCartBadge();
  }

  // Open cart modal -> render
  document.getElementById('cartModal').addEventListener('shown.bs.modal', renderCart);

  // Cart actions
  document.getElementById('cartTable').addEventListener('input', (e) => {
    if(e.target.classList.contains('qty-input')){
      const id = e.target.dataset.id; const q = parseInt(e.target.value)||1; setQty(id, q); renderCart();
    }
  });
  document.getElementById('cartTable').addEventListener('click', (e) => {
    if(e.target.closest('.remove-item')){
      const id = e.target.closest('.remove-item').dataset.id; removeFromCart(id); renderCart();
    }
  });
  document.getElementById('clearCart').addEventListener('click', () => { cart = []; saveCart(); renderCart(); });
   document.getElementById('checkoutBtn').addEventListener('click', () => {
  fetch('save_cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(cart)
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      window.location.href = 'checkout.php';
    } else {
      alert('Could not proceed to checkout.');
    }
  });
});

  // ====== Order flow ======
  let currentOrderId = null;
  document.addEventListener('click', (e) => {
    if(e.target.classList.contains('order-btn')){
      currentOrderId = e.target.dataset.id;
      const item = cakes.find(c => c.id === currentOrderId);
      if(!item) return;
      el('#orderItem').innerText = item.title;
      el('#orderPrice').innerText = fmt(item.price);
      el('#orderQty').value = 1;
      el('#orderImg').src = item.img;
      el('#orderImg').alt = item.title;
      const om = bootstrap.Modal.getOrCreateInstance(document.getElementById('orderModal'));
      om.show();
    }
  });

  document.getElementById('addToCart').addEventListener('click', () => {
    const qty = parseInt(el('#orderQty').value) || 1;
    if(currentOrderId) addToCart(currentOrderId, qty);
    const om = bootstrap.Modal.getOrCreateInstance(document.getElementById('orderModal'));
    om.hide();
  });

  // ====== Dark Mode toggle ======
  document.getElementById('toggleDark').addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
  });

  // ====== Contact form alert ======
  document.getElementById('contactForm').addEventListener('submit', e => {
    e.preventDefault();
    alert('Message sent! We will reply soon.');
    e.target.reset();
  });

  // On load, ensure badge matches saved cart
  updateCartBadge();

  // redirecting to a checkout page  



// When adding a cake to the cart
// When user clicks "Add to Cart" in the modal
document.getElementById('addToCart').addEventListener('click', () => {
  const qty = parseInt(el('#orderQty').value) || 1;
  if(currentOrderId) addToCart(currentOrderId, qty); // Use the main function!
   const om = bootstrap.Modal.getOrCreateInstance(document.getElementById('orderModal'));
  om.hide();
});
</script>
</body>
</html>
