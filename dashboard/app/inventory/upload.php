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
          <a href="#">
            Inventory
          </a>
        </p>

        <span class="slash-label">/</span>

        <p>
          Upload Product
        </p>
      </div>

      <div class="page-header">
        <h2>
          New Product
        </h2>
      </div>
      
      
      <form method="POST">
        <div class="card form-card w-100">
          <div class="card-body">
            <div class="form-group">
              <label for="productName">Category</label>
              <select name="category" required>
                <option value="">-</option>
                <option value="Men">Men</option>
                <option value="Women">Women</option>
                <option value="Other Products">Other Products</option>
              </select>
            </div>

            <div class="form-group">
              <label for="productName">Name</label>
              <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
              <label for="productDescription">Description</label>
              <textarea rows="8" name="description" required></textarea>
            </div>

            <div class="form-group">
              <label for="productQuantity">Quantity</label>
              <input type="number" name="quantity" required>
            </div>

            <div class="form-group">
              <label for="productPrice">Price</label>
              <input type="number" name="price" required>
            </div>

            <div class="form-group">
              <label for="productImage">Image</label>
              <div class="form-file-upload">
                <input type="hidden" name="image">
                
                <p>
                  Drag an image or 
                  <a href="">click here</a>
                  to upload a file
                </p>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-round">
            <i class="fa-solid fa-check"></i>
            Upload Product
          </button>
        </div>
      </form>
    </div>

  </div>
</div>

<script>
  setPageTitle("New Inventory")
  requiresAuthCheck()

  $(document).ready(() => {
    const handleProductUpload = async () => {
      let formData = Object.fromEntries(
        new FormData(document.querySelector('form'))
        .entries()
      )
      
      await httpRequest(
        "/products/",
        "post",
        {
          ...formData,
          fnName: 'product-create'
        }
      ).then(response => {
        Swal.fire({
          title: 'Uploaded!',
          text: 'Successfully uploaded new product!',
          icon: 'success',
          showConfirmButton: false,
        })

        setTimeout(() => {
          redirectTo('/inventory/')
        }, 2000);
      }).catch(err => {
        console.log(err)
        if (err.response.status === 500) {
          Swal.fire({
            title: 'Error!',
            text: 'Failed to upload product!',
            icon: 'error',
          })
        }
      })

      $('form')[0].reset()
    }

    $('form').submit(e => {
      e.preventDefault();
      handleProductUpload();
    })
  })
</script>

<?php require './../../components/layout/foot.layout.php'; ?>