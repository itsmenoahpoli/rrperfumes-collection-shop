<?php require './../../components/layout/head.layout.php'; ?>

<div class="auth-layout-container">
  <div class="form-container">
    <div class="form-content">
      <h4>
        R&R PERFUMES COLLECTION
      </h4>

      <form>
        <div class="form-group">
          <label for="emailInput">E-mail</label>
          <input type="input">
        </div>

        <p>
          A reset link will be sent to your email to reset your password
        </p>

        <button class="btn w-100">SEND RESET LINK</button>
      </form>
    </div>
  </div>
</div>

<script>
  setPageTitle("Forgot Password")
</script>

<?php require './../../components/layout/foot.layout.php'; ?>