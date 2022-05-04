<?php require './../../components/layout/head.layout.php'; ?>



<div class="auth-layout-container">
  <div class="form-container">
    <div class="form-content">
      <h3>
        R&R PERFUMES COLLECTION
      </h3>

      <p>
        Access and manage your store's inventory, sales, orders, reports, users and much more
      </p>

      <form method="POST">
        <div class="form-group">
          <label for="emailInput">E-mail</label>
          <input type="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="passwordInput">Password</label>
          <input type="password" name="password" required>
        </div>

        <div class="form-group form-checkbox">
          <input type="checkbox" name="" id="">
          <label for="rememberMe">Remember me</label>
        </div>

        <div class="forgot-password-link d-none">
          <small>
            <a href="#" onclick="redirectTo('/auth/forgot-password.php')">Forgot your password?</a>
          </small>
        </div>

        <button type="submit" name="btn-login" class="btn w-100">LOG IN</button>
      </form>
    </div>
  </div>
</div>

<script>
  setPageTitle('Log In')

  $(document).ready(() => {
    const handleLogin = async () => {
      let formData = Object.fromEntries(
        new FormData(document.querySelector('form'))
        .entries()
      )

      await httpRequest(
        "/auth/",
        "post",
        {
          ...formData,
          fnName: 'user-login'
        }
      ).then(response => {
        localStorage.setItem('user', JSON.stringify(response.data))
        localStorage.setItem('isUserLoggedIn', 1)

        setTimeout(() => {
          redirectTo('/')
        }, 800)
      }).catch(err => {
        if (err.response.status === 401) {
          Swal.fire({
            title: 'Unauthorized!',
            text: 'Invalid credentials provided!',
            icon: 'error',
          })
        }
      })
    }

    $('form').submit(e => {
      e.preventDefault();
      handleLogin();
    })
  })

  
</script>

<?php require './../../components/layout/foot.layout.php'; ?>