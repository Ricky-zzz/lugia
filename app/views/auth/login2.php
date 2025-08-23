<?php include __DIR__ . '/../admin/partials/head.php'; ?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Lugia</h2>
  <form action="/login" method="POST" class="card p-4 shadow mx-auto" style="max-width: 400px;">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input" id="remember">
      <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
    <div class="mt-2 text-start">
      <a href="/register">Register</a>
    </div>
  </form>
</div>

<?php include __DIR__ . '/../admin/partials/footer.php'; ?>
