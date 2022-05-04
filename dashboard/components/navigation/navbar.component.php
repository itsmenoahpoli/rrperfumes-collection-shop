<div class="navbar">
  <div>
    <small>
      Logged-In as: <span id="userType"></span>
    </small>
  </div>
  
  <div>
    <button>
      My Account
    </button>

    <button onclick="handleLogout()">
      Log Out
    </button>
  </div>
</div>

<script>
  let user = localStorage.getItem('user')

  if (user !== null)
  {
    $('#userType').html(JSON.parse(user).user_type)
  }

  const handleLogout = () => {
    localStorage.removeItem('user')
    localStorage.removeItem('userIsLoggedIn')

    redirectTo('/auth/login.php')
  }
</script>