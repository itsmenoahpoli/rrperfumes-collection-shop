<?php require './../../components/layout/head.layout.php'; ?>

<div class="dashboard-layout-container">
  <div class="sidebar-container">
    
    <?php require './../../components/navigation/sidebar.component.php'; ?>
  </div>


  <div class="dashboard-content-container">
    <?php require './../../components/navigation/navbar.component.php'; ?>

    <div class="dashboard-content">
      <div class="breadcrumb-container">
        <p>
          <a href="#">
            Dashboard
          </a>
        </p>

        <span class="slash-label">/</span>

        <p>
          Inventory
        </p>

        <span class="slash-label">/</span>

        <p>
          Inventory Monitoring
        </p>
      </div>

      <div class="page-header">
        <h2>
          Inventory Monitoring
        </h2>

        <div class="page-header-grid">
          <div class="form-group">
            <input type="text" oninput="getData(this.value)" placeholder="SEARCH (sku, name, category, price)">
          </div>

          <div class="btn-container">
            <button class="btn btn-outline-dark btn-round">
              Export to CSV
            </button>
          </div>
        </div>
      </div>

      <div class="card no-padding">
        <div class="card-body">
          <table id="tbl-inventory">
            <thead>
              <tr>
                <th>
                  <input type="checkbox">
                </th>
                <th>SKU</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Checkout Date</th>
                <th>Type</th>
              </tr>
            </thead>

            <tbody>
              <!--  -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  setPageTitle("Inventory")
  requiresAuthCheck()

  const clearTableData = () => {
    $('table>tbody').empty()
  }

  const noDataTr = `
    <tr>
      <td colspan="12" class="no-data-td">
        <h3>No data found</h3>
      </td>
    </tr>
  `

  const getData = async (q = "") => {
    clearTableData()

    await httpRequest(
      "/products/",
      "post",
      {
        fnName: 'products-getAll',
        q
      }
    ).then(response => {
      if (response.data.length > 0) {
        response.data.map(row => {
          const price = row.price;

          let tableRow = `
            <tr>
              <td>
                <input type="checkbox">
              </td>
              <td class="img-td">
                <img src="./../../assets/images/perfume-img.jpg" alt="perfume-img">
                <span>
                  ${row.sku}
                </span>
              </td>
              <td>${row.name}</td>
              <td>${row.category}</td>
              <td>₱ ${Number(price).toFixed(2)}</td>
              <td>${formatDate(row.created_at)}</td>
              <td><span class="badge badge-warning">Sold</span></td>
            </tr>
          `;

          $('table>tbody').append(tableRow)
        })
      }

      if (!response.data.length) {
        $('table>tbody').append(noDataTr)
      }
    }).catch(err => {
      console.log(err)
      $('table>tbody').append(noDataTr)
    })
  }

  (async () => {
    await getData();
  })()
</script>

<?php require './../../components/layout/foot.layout.php'; ?>