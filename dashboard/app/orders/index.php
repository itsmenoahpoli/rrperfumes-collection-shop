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
          Orders
        </p>
      </div>

      <div class="page-header">
        <h2>
          Manage Orders
        </h2>

        <div class="page-header-grid">
          <div class="form-group">
            <input type="text" oninput="getData(this.value)" placeholder="SEARCH (order number)">
          </div>

          <div class="btn-container">
            <!-- <button class="btn btn-primary btn-round" onclick="redirectTo('/inventory/upload.php/')">
              <i class="fa-solid fa-plus"></i>

              Add Order
            </button> -->

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
                <th>Order #</th>
                <th>Customer Name</th>
                <th>Customer E-mail</th>
                <th>Customer Contacts</th>
                <th>Delivery Notes</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Checkout Date</th>
                <th>Last Updated</th>
                <th></th>
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
      "/orders/",
      "post",
      {
        fnName: 'orders-getAll',
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
              <td>${row.reference_code}</td>
              <td>${row.customer_name}</td>
              <td>${row.customer_email}</td>
              <td>${row.customer_contacts}</td>
              <td>${row.delivery_notes}</td>
              <td>₱ ${Number(price).toFixed(2)}</td>
              <td><span class="badge badge-warning">${row.status}</span></td>
              <td>${formatDate(row.created_at)}</td>
              <td>${formatDate(row.updated_at)}</td>
              <td>
                <button>
                  View Order
                </button>
              </td>
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

  const handleRowEdit = async (id) => {
    redirectTo(`/inventory/edit.php/?id=${id}`)
  }

  const handleRowDelete = async (id) => {
    if (confirm('Are you sure you want to delete this record?'))
    {
      await httpRequest(
        "/orders/",
        "post",
        {
          fnName: 'orders-delete',
          id: id
        }
      ).then(async (response) => {
        await getData()

        Swal.fire({
          title: 'Deleted!',
          text: 'Record has been successfully deleted from the database',
          icon: 'success',
        })
      }).catch(err => {
        Swal.fire({
          title: 'Failed!',
          text: 'Record failed to be deleted from the database',
          icon: 'warning',
        })
      })
    }
  }

  (async () => {
    await getData();
  })()
</script>

<?php require './../../components/layout/foot.layout.php'; ?>