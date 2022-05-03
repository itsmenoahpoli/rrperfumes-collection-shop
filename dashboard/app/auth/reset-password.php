<?php require './../../components/layout/head.layout.php'; ?>

<div class="auth-layout-container">
  <div class="form-container">
    <div class="form-content">
      <h4>
        R&R PERFUMES COLLECTION
      </h4>

      <form>
        <div class="form-group">
          <label for="otpInput">One-Time-Passcode</label>
          <input type="text">
        </div>

        <p>
          You must provide the OTP (One-time-passcode) sent to your email
        </p>

        <button class="btn w-100">RESET MY PASSWORD</button>
      </form>
    </div>
  </div>
</div>

<script>
  setPageTitle("Reset Password")
</script>

<?php require './../../components/layout/foot.layout.php'; ?>