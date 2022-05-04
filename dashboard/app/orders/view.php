<?php require './../../components/layout/head.layout.php'; ?>

<div class="dashboard-layout-container">
  <div class="sidebar-container">
    <?php require './../../components/navigation/sidebar.component.php'; ?>
  </div>


  <div class="dashboard-content-container">
    <div class="dashboard-content">
      <div class="breadcrumb-container">
        <p>
          <a href="#">
            Dashboard
          </a>
        </p>

        <span class="slash-label">/</span>

        <p>
          <a href="#">
            Orders
          </a>
        </p>

        <span class="slash-label">/</span>

        <p>
          View Order
        </p>
      </div>

      <div class="page-header">
        <h2>
          View Order
        </h2>
      </div>

      <div class="d-flex order-details-container">
        <div class="w-25">
          <div class="card">
            <div class="card-body">
              <div class="detail-content">
                <h4 class="text-center">
                  REFERENCE NO. &mdash; <span id="reference-code-label"></span>
                </h4>
              </div>

              <hr />

              <div class="detail-content">
                <div class="d-flex justify-content-space-around">
                  <div class="form-group">
                    <small>Checkout Date</small>
                    <p id="checkoutDate"></p>
                  </div>

                  <div class="form-group">
                    <small>Last Updated</small>
                    <p id="lastUpdatedDate"></p>
                  </div>
                </div>
              </div>

              <hr />

              <div class="detail-content">
                <div class="form-group">
                  <small>Order Status</small>
                  <!-- <p id="orderStatus"></p> -->
                  <select name="orderStatus" id="orderStatus" onchange="handleUpdateOrder(this.value)">
                    <option value="">--</option>
                    <option value="PENDING">PENDING</option>
                    <option value="PREPARE">PREPARE</option>
                    <option value="PACK FOR PICK-UP/DELIVERY">PACK FOR PICK-UP/DELIVERY</option>
                    <option value="MONITORING (PICKED UP)">MONITORING (PICKED UP)</option>
                    <option value="MONITORING (EN'ROUTE TO DELIVERY)">MONITORING (EN'ROUTE TO DELIVERY)</option>
                    <option value="CANCELLED">CANCELLED</option>
                    <option value="FOR RETURNS">FOR RETURNS</option>
                  </select>
                </div>

                <div class="form-group">
                  <small>Customer Name</small>
                  <p id="customerName"></p>
                </div>

                <div class="form-group">
                  <small>Customer E-mail</small>
                  <p id="customerEmail"></p>
                </div>

                <div class="form-group">
                  <small>Customer Address</small>
                  <p id="customerAddress"></p>
                </div>

                <div class="form-group">
                  <small>Delivery Notes</small>
                  <p id="deliveryNotes"></p>
                </div>

                <div class="form-group">
                  <small>Customer Contacts</small>
                  <p id="customerContacts"></p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card">
            <div class="card-body">
              <div class="detail-content">
                <h4>
                  Payment Details
                </h4>
              </div>

              <hr />

              <div class="detail-content">
                <div class="d-flex justify-content-start">
                  <div class="form-group">
                    <small>Shipping Fee (Fixed)</small>
                    <p>
                    ₱ <?php echo number_format(200, 2); ?>
                    </p>
                  </div>

                  <div class="form-group">
                    <small>Total Amount</small>
                    <p>
                    ₱ <span id="totalAmount"></span>
                    </p>
                  </div>
                </div>

                <div class="form-group">
                  <small>Payment Method</small>
                  <p>
                    Online (Via send payment proof)
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card w-75">
          <div class="card-body">
            <div class="detail-content">
              <h4>
                CART PRODUCTS
              </h4>
            </div>

            <hr />

            <br />

            <table class="table-scrollable">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
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
</div>

<script>
  setPageTitle("View Order")
  requiresAuthCheck()

  const reference_code = new URLSearchParams(window.location.search).get('reference_code')
  console.log(reference_code)

  const getData = async () => {
    await httpRequest(
      "/orders/",
      "post",
      {
        fnName: 'orders-getByRefCode',
        reference_code
      }
    ).then(response => {
      const { 
        reference_code, 
        customer_name, 
        customer_email, 
        customer_contacts, 
        customer_address, 
        delivery_notes,
        order_products,
        total_amount, 
        status, 
        created_at,
        updated_at 
      } = response.data
      
      $('#reference-code-label').text(`${reference_code}`)
      
      $('#customerName').html(customer_name)
      $('#customerEmail').html(customer_email)
      $('#customerContacts').html(customer_contacts)
      $('#customerAddress').html(customer_address)
      $('#deliveryNotes').html(delivery_notes)
      $('#checkoutDate').text(formatDate(created_at))
      $('#lastUpdatedDate').text(formatDate(updated_at))
      
      $('#orderStatus').val(status)
      $('#totalAmount').html(Number(parseInt(total_amount) + parseInt(200)).toFixed(2))

      JSON.parse(order_products).map((product) => {
        let tableRow = `
          <tr>
            <td class="img-td">
              <img src="./../../../assets/images/perfume-img.jpg" alt="perfume-img">
              <span>
                ${product.sku}
              </span>
            </td>
            <td>${product.name}</td>
            <td>${product.description}</td>
            <td>₱ ${Number(product.price).toFixed(2)}</td>
            <td>${product.quantity}</td>
            <td>₱ ${Number(parseInt(product.price) * parseInt(product.quantity)).toFixed(2)}</td>
          </tr>
        `;

        $('table>tbody').append(tableRow)
      })
    }).catch(err => {
      console.log(err)
    })
  }

  const handleUpdateOrder = async (status) => {
    await httpRequest(
      "/orders/",
      "post",
      {
        fnName: 'orders-updateByRefCode',
        reference_code,
        status
      }
    ).then(response => {
      Swal.fire({
        title: 'Status Updated!',
        text: 'Order status updated!',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
      })
    }).catch(err => {
      console.log(err)
    })
  }

  (async () => {
    await getData();
  })()
</script>

<?php require './../../components/layout/foot.layout.php'; ?>