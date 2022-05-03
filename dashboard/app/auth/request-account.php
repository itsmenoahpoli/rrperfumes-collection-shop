<?php require './../../components/layout/head.layout.php'; ?>

<div class="auth-layout-container">
  <div class="form-container">
    <div class="form-content">
      <h3>
        R&R PERFUMES COLLECTION
      </h3>

      <p>
        Your account request approval status will be sent to the e-mail you provided
      </p>

      <form>
        <div class="form-group">
          <label for="fnameInput">Account Type</label>
          <select>
            <option value="">--</option>
            <option value="">Employee</option>
            <option value="">Manager</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fnameInput">First Name</label>
          <input type="text">
        </div>

        <div class="form-group">
          <label for="mnameInput">Middle Name</label>
          <input type="text">
        </div>

        <div class="form-group">
          <label for="lnameInput">Last Name</label>
          <input type="text">
        </div>

        <div class="form-group">
          <label for="passwordInput">Password</label>
          <input type="password">
        </div>

        <div class="form-group">
          <label for="confirmPasswordInput">Confirm Password</label>
          <input type="password">
        </div>

        <div class="form-group">
          <small class="info-label">
            Already have an account?
            <a href="#" onclick="redirectTo('/auth/login.php')">Log In</a>
          </small>
        </div>

        <button class="btn w-100">SUBMIT</button>
      </form>
    </div>
  </div>
</div>

<script>
  setPageTitle('Request Account')
</script>

<?php require './../../components/layout/foot.layout.php'; ?>