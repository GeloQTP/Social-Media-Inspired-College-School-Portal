<div class="modal fade" id="editBroadcastModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Broadcast</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editBroadcastForm">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input id="title" type="text" class="form-control" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="announcement_message" class="form-label">Announcement Message</label> <small class="text-muted">(Max Character 100)</small>
                        <textarea id="announcement_message" class="form-control" rows="4" name="announcement_message" required maxlength="100"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="theme_color" class="form-label">Theme Color</label>
                            <select id="theme_color" class="form-select" name="theme_color" required>
                                <option value="bg-success text-light">Green (Important)</option>
                                <option value="bg-primary text-light">Blue (General)</option>
                                <option value="bg-warning">Yellow (Reminder)</option>
                                <option value="bg-danger text-light">Red (Urgent)</option>
                                <option value="bg-dark text-light">Dark (Neutral)</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="expires_at" class="form-label">Expiration Date</label>
                            <input id="expires_at" type="date" class="form-control" name="expires_at" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-select" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                </div>
            </form>

            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="editConfirmationModal(this.value)" id="announcement_id_holder">Save Changes</button>
            </div>

        </div>
    </div>
</div>

<script>
    function editConfirmationModal(announcement_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Update Announcement?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Save Changes"
        }).then((result) => {
            if (result.isConfirmed) {
                updateAnnouncement(announcement_id);
            }
        });
    }

    async function updateAnnouncement(announcement_id) {
        const editedForm = new FormData(document.getElementById("editBroadcastForm"));
        editedForm.append('action', 'edit');
        editedForm.append('announcement_id', announcement_id);

        try {

            const res = await fetch('./../../../api/AnnouncementController.php', {
                method: 'POST',
                body: editedForm,
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error('Network response error');

            const data = await res.json();

            if (data.success) {
                loadAnnouncementList();
                Swal.fire({
                    title: "Update Successful",
                    text: "This Broadcast has been configured.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Update Unsuccessful",
                    text: "Broadcast Configuration Failed.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }

        } catch {

        } finally {

        }

    }

    function populateEditModal(data) {

        const button = document.getElementById("announcement_id_holder");
        button.value = data.broadcast_id;

        Object.keys(data).forEach(key => {

            const element = document.getElementById(key);

            if (!element) {
                return;
            }

            element.value = data[key];

        });

    }

    async function getAnnouncementInformation(announcement_id) { // EDIT 

        try {

            const res = await fetch('./../../../api/AnnouncementController.php', {
                method: 'POST',
                body: new URLSearchParams({
                    announcement_id: announcement_id,
                    action: 'view',
                }),
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error('Network response is not ok.');

            const data = await res.json();

            populateEditModal(data);


        } catch {

        } finally {

        }
    }
</script>