<div class="card shadow-sm border-0 rounded-4">

    <!-- Header -->
    <div class="card-header bg-success text-white border-0 p-4">
        <h4 class="mb-0 fw-bold">Curriculum Overview</h4>
        <small><?= $row['Program'] ?> • Academic Curriculum Flow</small>
    </div>

    <div class="card-body p-3">

        <!-- Year Tabs -->
        <ul class="nav nav-pills mb-4 gap-2" role="tablist">

            <li class="nav-item">
                <button class="nav-link active rounded-pill"
                    data-bs-toggle="pill"
                    data-bs-target="#firstyear">
                    1st Year
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill"
                    data-bs-toggle="pill"
                    data-bs-target="#secondyear">
                    2nd Year
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill"
                    data-bs-toggle="pill"
                    data-bs-target="#thirdyear">
                    3rd Year
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link rounded-pill"
                    data-bs-toggle="pill"
                    data-bs-target="#fourthyear">
                    4th Year
                </button>
            </li>

        </ul>

        <!-- Curriculum Content -->
        <div class="tab-content">

            <!-- FIRST YEAR -->
            <div class="tab-pane fade show active" id="firstyear">

                <div class="row g-3">

                    <!-- First Sem -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">First Semester</h6>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">

                                        <tr>
                                            <td>CC101</td>
                                            <td>Introduction to Computing</td>
                                            <td>3</td>
                                            <td>
                                                <span class=" badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CC102</td>
                                            <td>Computer Programming 1</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>MATH101</td>
                                            <td>Discrete Mathematics</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>GE101</td>
                                            <td>Understanding the Self</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                    <!-- Second Sem -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">Second Semester</h6>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">

                                        <tr>
                                            <td>CC103</td>
                                            <td>Computer Programming 2</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>MATH101</td>
                                            <td>Discrete Mathematics</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>GE101</td>
                                            <td>Understanding the Self</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
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

            <!-- SECOND YEAR -->
            <div class="tab-pane fade" id="secondyear">

                <div class="row g-3">

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">First Semester</h6>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC201</td>
                                            <td>Object-Oriented Programming</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CC202</td>
                                            <td>Database Management Systems</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CC203</td>
                                            <td>Networking Fundamentals</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">

                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">Second Semester</h6>
                            </div>

                            <div class="card-body">

                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC204</td>
                                            <td>Web Development</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CC205</td>
                                            <td>Human Computer Interaction</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CC206</td>
                                            <td>Software Engineering</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
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

            <!-- THIRD YEAR -->
            <div class="tab-pane fade" id="thirdyear">

                <div class="alert alert-success rounded-4 border-0">
                    <strong>Major Subjects Focus:</strong>
                    Advanced programming, system integration,
                    application development, and research preparation.
                </div>

                <div class="row g-3">

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">First Semester</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC301</td>
                                            <td>Advanced Database Systems</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC302</td>
                                            <td>Information Assurance & Security</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Taken</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC303</td>
                                            <td>Application Development</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">Second Semester</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC304</td>
                                            <td>Research Methods</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC305</td>
                                            <td>System Integration</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC306</td>
                                            <td>Mobile Application Development</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
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

            <!-- FOURTH YEAR -->
            <div class="tab-pane fade" id="fourthyear">

                <div class="row g-3">

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">First Semester</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC401</td>
                                            <td>Capstone Project Planning</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC402</td>
                                            <td>IT Governance and Audit</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC403</td>
                                            <td>Emerging Technologies</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                    Taken
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            <div class="card-header bg-light border-0 rounded-top-4">
                                <h6 class="fw-bold mb-0">Second Semester</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Code</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td>CC404</td>
                                            <td>Independent Student Project(Thesis)</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">Ongoing</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CC405</td>
                                            <td>Computer Developments</td>
                                            <td>3</td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2">Ongoing</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>