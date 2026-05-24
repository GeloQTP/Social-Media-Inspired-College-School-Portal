<div class="modal fade" id="editProfilePicture" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title lead ms-auto" id="exampleModalLabel">Update Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">

                <form id="imageForm" method="post" enctype="multipart/form-data">
                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" id="profilePicture" name="profilePicture" class="form-control" accept="image/*">
                    </div>
                </form>

                <!-- Image Preview -->
                <div class="mb-3 text-center" style="height: 500px;">
                    <img id="image_preview"
                        class="img-fluid mt-2"
                        style="max-height: 500px; border-radius: 50%; height:500px; max-width:500px;">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-success" id="update_student" onclick="updateProfilePictureConfirmation(<?= $_SESSION['user_id'] ?>)">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateProfilePictureConfirmation(user_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Update your Profile?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Save Changes"
        }).then((result) => {
            if (result.isConfirmed) {
                updateProfilePicture(user_id);
            }
        });
    }

    async function updateProfilePicture(user_id) {

        try {
            const imageForm = document.getElementById("imageForm");
            const imageFormData = new FormData(imageForm);

            const res = await fetch(`./../../backend/updatePicture.php`, {
                method: 'POST',
                body: imageFormData,
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error("Network response Error");

            const data = await res.json();

            if (data.success) {
                location.reload();
            }

        } catch {

        } finally {

        }

    }
</script>

<script>
    // IMAGE PREVIEW FUNCTIONALITY
    document.addEventListener('DOMContentLoaded', function() {

        const profilePicture = document.getElementById('profilePicture');
        const preview = document.getElementById('preview');

        profilePicture.addEventListener('change', function() {
            const file = this.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    image_preview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                image_preview.src = '';
            }
        });

    });
</script>