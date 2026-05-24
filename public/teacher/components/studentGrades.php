<!-- GRADING CARD -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <!-- TOP HEADER -->
    <div class="bg-info text-white p-4">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

            <!-- TEACHER PROFILE -->
            <div class="d-flex align-items-center gap-3">

                <img src="<?= $row['profile_picture'] ?>"
                    class="rounded-circle border border-3 border-white"
                    width="80"
                    height="80"
                    alt="Faculty">

                <div>

                    <h3 class="fw-bold mb-1">
                        <?= $row['FirstName']; ?> <?= $row['LastName']; ?>
                    </h3>

                    <div class="small opacity-75">
                        Tomas Del Rosario College
                    </div>

                    <div class="small opacity-75">
                        <?= $row['Program'] ?>
                    </div>

                </div>

            </div>

            <!-- QUICK STATS -->
            <div class="row text-center g-3">

                <div class="col">

                    <div class="bg-white bg-opacity-10 rounded-4 px-4 py-3">

                        <h4 class="fw-bold mb-0">
                            148
                        </h4>

                        <small>
                            Students
                        </small>

                    </div>

                </div>

                <div class="col">

                    <div class="bg-white bg-opacity-10 rounded-4 px-4 py-3">

                        <h4 class="fw-bold mb-0">
                            6
                        </h4>

                        <small>
                            Subjects
                        </small>

                    </div>

                </div>

                <div class="col">

                    <div class="bg-white bg-opacity-10 rounded-4 px-4 py-3">

                        <h4 class="fw-bold mb-0">
                            Midterm
                        </h4>

                        <small>
                            Current Term
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- BODY -->
    <div class="card-body p-4">

        <!-- TOP CONTROLS -->
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">

            <!-- SUBJECT TABS -->
            <ul class="nav nav-pills flex-wrap gap-2">

                <li class="nav-item">
                    <button class="nav-link active rounded-pill px-4"
                        data-bs-toggle="pill"
                        data-bs-target="#webdev">
                        Web Development
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link rounded-pill px-4"
                        data-bs-toggle="pill"
                        data-bs-target="#datastruct">
                        Data Structures
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link rounded-pill px-4"
                        data-bs-toggle="pill"
                        data-bs-target="#softwareeng">
                        Software Engineering
                    </button>
                </li>

            </ul>

            <!-- SEARCH -->
            <div class="input-group" style="max-width: 300px;">

                <span class="input-group-text bg-light border-0">
                    <i class="bi bi-search"></i>
                </span>

                <input type="text"
                    class="form-control border-0 bg-light"
                    placeholder="Search student...">

            </div>

        </div>

        <!-- TAB CONTENT -->
        <div class="tab-content">

            <!-- WEB DEVELOPMENT -->
            <div class="tab-pane fade show active" id="webdev">

                <div class="table-responsive">

                    <table class="table align-middle table-hover">

                        <thead class="table-light">

                            <tr>

                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Section</th>
                                <th>Prelim</th>
                                <th>Midterm</th>
                                <th>Final</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <!-- STUDENT -->
                            <tr>

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <img src="https://i.pravatar.cc/50?img=11"
                                            class="rounded-circle"
                                            width="45"
                                            height="45">

                                        <div>

                                            <div class="fw-semibold">
                                                Juan Dela Cruz
                                            </div>

                                            <small class="text-muted">
                                                BSCS Student
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    2026-00124
                                </td>

                                <td>
                                    BSCS 3A
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                        1.50
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                        1.25
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                        Pending
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        Passed
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Grade
                                    </button>

                                </td>

                            </tr>

                            <!-- STUDENT -->
                            <tr>

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <img src="https://i.pravatar.cc/50?img=12"
                                            class="rounded-circle"
                                            width="45"
                                            height="45">

                                        <div>

                                            <div class="fw-semibold">
                                                Maria Santos
                                            </div>

                                            <small class="text-muted">
                                                BSCS Student
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    2026-00452
                                </td>

                                <td>
                                    BSCS 3A
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                        1.75
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                        1.50
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                        Missing
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                        Incomplete
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button class="btn btn-success btn-sm rounded-pill px-3">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Grade
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- DATA STRUCTURES -->
            <div class="tab-pane fade" id="datastruct">

                <div class="p-5 text-center text-muted">

                    <i class="bi bi-journal-text fs-1 d-block mb-3"></i>

                    No students assigned yet for this subject.

                </div>

            </div>

            <!-- SOFTWARE ENGINEERING -->
            <div class="tab-pane fade" id="softwareeng">

                <div class="p-5 text-center text-muted">

                    <i class="bi bi-folder2-open fs-1 d-block mb-3"></i>

                    Select a section to begin grading students.

                </div>

            </div>

        </div>

    </div>

</div>