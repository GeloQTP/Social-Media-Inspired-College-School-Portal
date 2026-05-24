<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: /Modern Student Portal/public/visitors/LoginPage.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management - Tomas Del Rosario College</title>
    <link rel="icon" type="image/png" href="/Modern Student Portal/src/img/TRC_LOGO.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../components/sidebar.css">
</head>

<body>

    <form method="POST" action="delete_teacher.php" onsubmit="return confirm('Delete this teacher?')">
        <input type="hidden" name="id" value="1">
        <button class="btn btn-danger btn-sm">
            <i class="bi bi-trash"></i>
        </button>
    </form>

    <div class="modal fade" id="editTeacherModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="update_teacher.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Teacher</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="mb-2">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-warning">Update</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addTeacherModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="add_teacher.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Teacher</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-2">
                            <label>Subject</label>
                            <input type="text" name="subject" class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main ms-5 ps-4">
        <nav class="navbar navbar-expand-lg bg-light border-bottom mb-3">
            <div class="container-fluid">
                <h4 class="text-success">Teacher Management</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                    <i class="bi bi-plus-circle"></i> Add Teacher
                </button>
            </div>
        </nav>

        <!-- Search -->
        <div class="mb-3">
            <input type="text" class="form-control" placeholder="Search teachers...">
        </div>

        <!-- Teacher Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- SAMPLE ROW -->
                    <tr>
                        <td>1</td>
                        <td>Juan Dela Cruz</td>
                        <td>juan@email.com</td>
                        <td>Mathematics</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTeacherModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="./../scripts/sidebar.js"></script>

</html>