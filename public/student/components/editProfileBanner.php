<div class="modal fade" id="editProfileBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title lead ms-auto" id="exampleModalLabel">Update Profile Banner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">

                <form id="bannerForm" method="post" enctype="multipart/form-data">
                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" id="profileBanner" name="profileBanner" class="form-control" accept="image/*">
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-success" id="update_student" onclick="updateProfileBannerConfirmation(<?= $_SESSION['user_id'] ?>)">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateProfileBannerConfirmation(user_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Update your Profile Banner?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Save Changes"
        }).then((result) => {
            if (result.isConfirmed) {
                updateProfileBanner(user_id);
            }
        });
    }

    async function updateProfileBanner(user_id) {

        try {
            const bannerForm = document.getElementById("bannerForm");
            const bannerFormData = new FormData(bannerForm);

            const res = await fetch(`./../backend/updateProfileBanner.php`, {
                method: 'POST',
                body: bannerFormData,
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error("Network response Error");

            const data = await res.json();
            console.log(data);

            if (data.success) {
                location.reload();
            }

        } catch {

        } finally {

        }

    }
</script>