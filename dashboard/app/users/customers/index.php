<?php require './../../../components/layout/head.layout.php'; ?>

<div class="dashboard-layout-container">
  <div class="sidebar-container">
    <?php require './../../../components/navigation/sidebar.component.php'; ?>
  </div>


  <div class="dashboard-content-container">
    <?php require './../../../components/navigation/navbar.component.php'; ?>

    <div class="dashboard-content">
      <div class="page-header">
        <h1>
          Customers
        </h1>
      </div>

      
    </div>
  </div>
</div>

<script>
  setPageTitle("Customers")
  requiresAuthCheck()
</script>

<?php require './../../../components/layout/foot.layout.php'; ?>