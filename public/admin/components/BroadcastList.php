<div class="tab-pane fade show active" id="broadcastTab">

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h6 class="mb-0">All Broadcasts</h6>
                <select id="filterSelection" class="form-select form-select-sm w-auto" onchange="loadAnnouncementList(this.value)">
                    <option value="undefined">All</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="archived">Archived</option>
                </select>
            </div>

            <div class="list-group">
                <!-- DYNAMIC LIST -->
            </div>
        </div>
    </div>
</div>

<script>
    loadAnnouncementList();

    async function loadAnnouncementList(filter) { // LOAD LIST
        const list_group = document.querySelector(".list-group");
        try {

            const res = await fetch('./../../../api/AnnouncementController.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'load',
                    filter: filter,
                }),
            });

            if (!res.ok) throw new Error('Network response is not ok.');

            const data = await res.json();

            const announcements = data.map(data => {

                const status_colors = {
                    draft: 'secondary',
                    archived: 'warning',
                    published: 'success',
                }

                const status = data.status;
                const status_color = status_colors[status] || 'secondary';

                return `<div class="card border mb-2">
                    <div class="card-body d-flex justify-content-between align-items-start">

                        <div class="d-flex">

                            <div class="me-3">
                                <div class="rounded-circle ${data.theme_color}" style="width: 12px; height: 12px;"></div>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1">
                                    📢 ${data.title}!
                                    <small class="text-muted ms-4">${data.created_at}</small>
                                </h6>

                                <p class="my-2 text-muted small">  
                                        ${data.announcement_message}
                                </p>

                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-${status_color}">${data.status}</span>
                                    <small class="text-muted">Expires: ${data.expires_at}</small>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group btn-group-sm">
                            <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#editBroadcastModal" onclick="getAnnouncementInformation(${data.broadcast_id})">
                                <i class="bi bi-pencil h5"></i>
                            </button>
                            <button class="btn text-warning" onclick="archiveAnnouncementConfirmation(${data.broadcast_id})">
                                <i class="bi bi-archive h5"></i>
                            </button>
                            <button class="btn text-danger" onclick="deleteAnnouncementConfirmation(${data.broadcast_id})">
                                <i class="bi bi-trash h5"></i>
                            </button>
                        </div>

                    </div>
                </div>`;
            }).join('');

            list_group.innerHTML = announcements;

        } catch {

        } finally {

        }
    }

    function deleteAnnouncementConfirmation(announcement_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Delete this Announcement?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DC3545",
            confirmButtonText: "Delete"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteAnnouncement(announcement_id);
            }
        });
    }

    async function deleteAnnouncement(announcement_id) {

        try {

            const res = await fetch('./../../../api/AnnouncementController.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'delete',
                    announcement_id: announcement_id,
                }),
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error('Network response error');

            const data = await res.json();

            if (data.success) {
                loadAnnouncementList();
                Swal.fire({
                    title: "Deletion Successful",
                    text: "Broadcast Deleted.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Deletion Unsuccessful",
                    text: "Broadcast Deletion Failed.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }

        } catch {

        } finally {

        }

    }

    function archiveAnnouncementConfirmation(announcement_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Arhive this Announcement?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#ffc107",
            confirmButtonText: "Archive"
        }).then((result) => {
            if (result.isConfirmed) {
                archiveAnnouncement(announcement_id);
            }
        });
    }

    async function archiveAnnouncement(announcement_id) {
        try {

            const res = await fetch('./../../../api/AnnouncementController.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'archive',
                    announcement_id: announcement_id,
                }),
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error('Network response error');

            const data = await res.json();

            if (data.success) {
                loadAnnouncementList();
                Swal.fire({
                    title: "Archiving Successful",
                    text: "The Broadcast has been Archived.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    title: "Archiving Unsuccessful",
                    text: "The Broadcast could not be archived.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }

        } catch {

        } finally {

        }
    }
</script>