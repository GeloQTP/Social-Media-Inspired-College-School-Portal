    <div class="col-lg-8">
        <div class="card col-12" style="height: 38.5vh;">

            <div class="d-flex align-items-center justify-content-between border-bottom">
                <p class="text-muted fw-bold" style="transform: translate(19px,8.5px);">Recent Activities</p>
                <div>
                    <button class="btn btn-sm btn-danger me-1" onclick="clearLogsConfirmation()">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button class="btn btn-sm btn-success me-1" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
            </div>

            <div class="card-body overflow-y-scroll">
                <!-- LOG -->
                <?php while ($row = $result->fetch_assoc()) {

                    $statusColor = 'secondary';

                    if ($row['log_type'] === 'Registration') {
                        $statusColor = 'warning';
                    } elseif ($row['log_type'] === 'Verified') {
                        $statusColor = 'success';
                    } elseif ($row['log_type'] === 'Subscription') {
                        $statusColor = 'primary';
                    } elseif ($row['log_type'] === 'Rejected') {
                        $statusColor = 'danger';
                    }

                ?>
                    <div class="activity-item mb-3 pb-3 border-start border-3">
                        <div class="d-flex justify-content-between align-items-start ps-3">
                            <div>
                                <p class="mb-1 fw-semibold"><?= $row['log_owner'] ?></p>
                                <p class="mb-1 text-muted small"><?= $row['log_description'] ?></p>
                                <small class="text-muted"><?= $row['log_date'] ?></small>
                            </div>
                            <span class="badge text-bg-<?= $statusColor ?> text-light"><?= $row['log_type'] ?></span>
                        </div>
                    </div>
                <?php  } ?>
                <!-- LOG -->
            </div>

            <div class="ms-auto pe-3" style="transform: translate(0px, 10px)">
                <ul class="pagination pagination-sm">

                    <?php if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) { ?>

                        <li class="page-item">
                            <a class="page-link" href="?page-nr=<?= $_GET['page-nr'] - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>

                    <?php } else { ?>

                        <li class="page-item">
                            <a class="page-link disabled" href="" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>

                    <?php } ?>


                    <?php if (!isset($_GET['page-nr'])) { ?>

                        <li class="page-item">
                            <a class="page-link" href="?page-nr=2" aria-label="Next">
                                <span aria-hidden="true">Next &raquo;</span>
                            </a>
                        </li>

                    <?php } else { ?>

                        <?php if ($_GET['page-nr'] >= $pages) { ?>

                            <li class="page-item">
                                <a class="page-link disabled" href="" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>

                        <?php } else { ?>

                            <li class="page-item">
                                <a class="page-link" href="?page-nr=<?= $_GET['page-nr'] + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">Next &raquo;</span>
                                </a>
                            </li>

                        <?php } ?>

                    <?php } ?>

                </ul>
            </div>

        </div>
    </div>

    <script>
        function clearLogsConfirmation() {
            Swal.fire({
                title: "Are you sure?",
                text: `This will clear all Logs`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DC3545",
                confirmButtonText: "Clear Logs"
            }).then((result) => {
                if (result.isConfirmed) {
                    clearLogs();
                }
            });
        }

        async function clearLogs() {
            try {
                const res = await fetch(`./backend/deleteLogHistory.php`, {
                    method: 'DELETE',
                    credentials: "same-origin",
                });

                if (!res.ok) throw new Error("Network response Error");

                const data = await res.json();

                if (!data || !data.success) {
                    Swal.fire({
                        title: "Deletion Unsuccessful",
                        text: "Failed to delete Logs.",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    title: "Deletion Successful",
                    text: "The Page will reload automatically",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });

                setTimeout(() => {
                    location.reload();
                }, 3000);

                return;

            } catch {
                Swal.fire({
                    title: "Something went wrong.",
                    text: "Failed to delete Logs.",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
        }
    </script>