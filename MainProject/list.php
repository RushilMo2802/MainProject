  <?php 
  @include'config.php';
  ?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>Company CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  </head>

  <body>
    <div class="container mt-4">
      <h2>Company Records</h2>
      <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Add New Company</a>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Logo Image</th>
            <th>Contact Number</th>
            <th>Contact Number</th>
            <th>Services</th>
            <th>Product</th>
            <th>Client</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $query = "SELECT * FROM company";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) : ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td>
              <?php 
              $user_id = $row['id'];
              $user_name = $row['name'];
              $image_folder_path = "uploads/" . $user_name . "/";
              $image_query = "SELECT image_path FROM user_images WHERE id = $user_id";
              $image_result = mysqli_query($conn, $image_query);
              while ($image_row = mysqli_fetch_assoc($image_result)) {
              ?>
                <img src="<?php echo $image_row['image_path']; ?>" alt="User Image" width="50" height="50">   
              <?php
              } ?>
            </td>
            <td><?php echo $row['num1']; ?></td>
            <td><?php echo $row['num2']; ?></td>
            <td class="user-actions">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateModal-<?php echo $row['id']; ?>">Update</button>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
      </table>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="add.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="addModalLabel">Add New Company</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="form-group">
                <label for="logo">Logo Image:</label>
                <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
              </div>
              <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
              </div>
              <div class="form-group">
                <label for="contact">Contact Number:</label>
                <input type="text" class="form-control" id="contact1" name="contact1" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="update.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h5 class="modal-title" id="editModalLabel">Edit Company Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="edit_id" name="id">
              <div class="form-group">
                <label for="edit_name">Name:</label>
                <input type="text" class="form-control" id="edit_name" name="name" required>
              </div>
              <div class="form-group">
                <label for="edit_logo">Logo Image:</label>
                <input type="file" class="form-control" id="edit_logo" name="logo" accept="image/*">
              </div>
              <div class="form-group">
                <label for="edit_contact">Contact Number:</label>
                <input type="text" class="form-control" id="edit_contact" name="contact" required>
              </div>
              <div class="form-group">
                <label for="edit_services">Services:</label>
                <textarea class="form-control" id="edit_services" name="services" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="edit_product">Product:</label>
                <textarea class="form-control" id="edit_product" name="product" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="edit_client">Client:</label>
                <textarea class="form-control" id="edit_client" name="client" rows="3"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
      // Fill edit modal with data
      $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var logo = button.data('logo');
        var contact = button.data('contact');
        var services = button.data('services');
        var product = button.data('product');
        var client = button.data('client');

        var modal = $(this);
        modal.find('.modal-body #edit_id').val(id);
        modal.find('.modal-body #edit_name').val(name);
        modal.find('.modal-body #edit_contact').val(contact);
        modal.find('.modal-body #edit_services').val(services);
        modal.find('.modal-body #edit_product').val(product);
        modal.find('.modal-body #edit_client').val(client);
      });
    </script>
  </body>

  </html>