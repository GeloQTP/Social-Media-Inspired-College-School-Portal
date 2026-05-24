<!-- FACULTY CARD -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <!-- TOP HEADER -->
    <div class="bg-info text-white p-4">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

            <div class="d-flex align-items-center gap-3">

                <!-- PROFILE -->
                <img src="<?= $row['profile_picture'] ?>"
                    class="rounded-circle border border-3 border-white"
                    width="80"
                    height="80"
                    alt="Faculty">

                <div>
                    <h3 class="fw-bold mb-1">
                        <?= $row['FirstName']; ?>, <?= $row['LastName']; ?>
                    </h3>

                    <div class="small opacity-75">
                        Tomasl Del Rosario College
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
                        <h4 class="fw-bold mb-0">24</h4>
                        <small>Total Units</small>
                    </div>
                </div>

                <div class="col">
                    <div class="bg-white bg-opacity-10 rounded-4 px-4 py-3">
                        <h4 class="fw-bold mb-0">6</h4>
                        <small>Subjects</small>
                    </div>
                </div>

                <div class="col">
                    <div class="bg-white bg-opacity-10 rounded-4 px-4 py-3">
                        <h4 class="fw-bold mb-0">4</h4>
                        <small>Sections</small>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- BODY -->
    <div class="card-body p-4">

        <!-- DAY TABS -->
        <ul class="nav nav-pills flex-wrap gap-2 mb-4">

            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4"
                    data-bs-toggle="pill"
                    data-bs-target="#monday">
                    Monday
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill px-4"
                    data-bs-toggle="pill"
                    data-bs-target="#tuesday">
                    Tuesday
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill px-4"
                    data-bs-toggle="pill"
                    data-bs-target="#wednesday">
                    Wednesday
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill px-4"
                    data-bs-toggle="pill"
                    data-bs-target="#thursday">
                    Thursday
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill px-4"
                    data-bs-toggle="pill"
                    data-bs-target="#friday">
                    Friday
                </button>
            </li>

        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content">

            <!-- MONDAY -->
            <div class="tab-pane fade show active" id="monday">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Time</th>
                                <th>Course</th>
                                <th>Section</th>
                                <th>Room</th>
                                <th>Type</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td class="fw-semibold">
                                    7:30 AM - 9:00 AM
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        Web Development
                                    </div>

                                    <small class="text-muted">
                                        CS 311
                                    </small>
                                </td>

                                <td>BSCS 3A</td>

                                <td>Lab 204</td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        Laboratory
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">
                                    10:00 AM - 11:30 AM
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        Data Structures
                                    </div>

                                    <small class="text-muted">
                                        CS 204
                                    </small>
                                </td>

                                <td>BSCS 2B</td>

                                <td>Room 302</td>

                                <td>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        Lecture
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td class="fw-semibold">
                                    1:00 PM - 4:00 PM
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        Capstone Project
                                    </div>

                                    <small class="text-muted">
                                        CS 401
                                    </small>
                                </td>

                                <td>BSCS 4A</td>

                                <td>Research Lab</td>

                                <td>
                                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                        Advising
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- TUESDAY -->
            <div class="tab-pane fade" id="tuesday">

                <div class="p-5 text-center text-muted">

                    <i class="bi bi-calendar2-x fs-1 d-block mb-3"></i>

                    No teaching schedule for Tuesday.

                </div>

            </div>

            <!-- WEDNESDAY -->
            <div class="tab-pane fade" id="wednesday">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Time</th>
                                <th>Course</th>
                                <th>Section</th>
                                <th>Room</th>
                                <th>Type</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td class="fw-semibold">
                                    8:00 AM - 11:00 AM
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        Database Systems
                                    </div>

                                    <small class="text-muted">
                                        CS 305
                                    </small>
                                </td>

                                <td>BSIT 3A</td>

                                <td>Lab 101</td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        Laboratory
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- THURSDAY -->
            <div class="tab-pane fade" id="thursday">

                <div class="p-5 text-center text-muted">
                    Faculty meeting / consultation day.
                </div>

            </div>

            <!-- FRIDAY -->
            <div class="tab-pane fade" id="friday">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Time</th>
                                <th>Course</th>
                                <th>Section</th>
                                <th>Room</th>
                                <th>Type</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td class="fw-semibold">
                                    9:00 AM - 12:00 PM
                                </td>

                                <td>
                                    <div class="fw-bold">
                                        Software Engineering
                                    </div>

                                    <small class="text-muted">
                                        CS 320
                                    </small>
                                </td>

                                <td>BSCS 3B</td>

                                <td>Room 402</td>

                                <td>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        Lecture
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>