<!-- Edit Profile Modal -->
<div class="modal fade" id="edit-profile-modal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    
      <form method="POST" action="api/update_profile.php">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="edit-name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" id="edit-name" value="<?= $user['full_name'] ?>" required> 
          </div>
          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="edit-email" value="<?= $user['email'] ?>" required> 
          </div>
          <div class="mb-3">
            <label for="edit-phone" class="form-label">Phone number</label>
            <input type="text" class="form-control" name="phone_number" id="edit-phone" value="<?= $user['phone_number'] ?>" required> 
          </div>
          <div class="mb-3">
            <label for="edit-college" class="form-label">College</label>
            <input type="text" class="form-control" name="college_name" id="edit-college" value="<?= $user['college_name'] ?>" required> 
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>

    </div>
  </div>
</div>
