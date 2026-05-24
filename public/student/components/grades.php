<div class="card shadow-sm border-0 rounded-4">

    <!-- Header -->
    <div class="card-header bg-success text-white border-0 p-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <h4 class="mb-0 fw-bold">My Grades</h4>
                <small><?= $row['Program'] ?> • Academic Performance</small>
            </div>

            <!-- DOWNLOAD PDF BUTTON -->
            <a href="/Modern Student Portal/public/Uploads/assets/MyGrades.pdf"
                class="btn btn-light btn-sm rounded-pill px-3"
                target="_blank" download>
                <i class="bi bi-download me-1"></i>
                Download PDF
            </a>

        </div>

    </div>

    <div class="card-body p-3">

        <!-- Semester Filter -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <select class="form-select form-select-sm rounded-pill">
                    <option>1st Semester</option>
                    <option>2nd Semester</option>
                    <option>Summer</option>
                </select>
            </div>

            <div class="text-muted small">
                SY 2025 - 2026
            </div>

        </div>

        <!-- Grades Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th>Units</th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>AVG</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>Web Development</td>
                        <td>3</td>
                        <td>84</td>
                        <td>86</td>
                        <td>90</td>
                        <td>1.75</td>
                        <td><span class="badge bg-success">Passed</span></td>
                    </tr>

                    <tr>
                        <td>Data Structures & Algorithms</td>
                        <td>4</td>
                        <td>78</td>
                        <td>80</td>
                        <td>82</td>
                        <td>2.25</td>
                        <td><span class="badge bg-success">Passed</span></td>
                    </tr>

                    <tr>
                        <td>Game Development</td>
                        <td>3</td>
                        <td>74</td>
                        <td>76</td>
                        <td>75</td>
                        <td>3.00</td>
                        <td><span class="badge bg-warning text-dark">Conditional</span></td>
                    </tr>

                    <tr>
                        <td>Discrete Mathematics</td>
                        <td>3</td>
                        <td>92</td>
                        <td>94</td>
                        <td>93</td>
                        <td>1.25</td>
                        <td><span class="badge bg-success">Passed</span></td>
                    </tr>

                    <tr>
                        <td>Operating Systems</td>
                        <td>3</td>
                        <td>68</td>
                        <td>70</td>
                        <td>69</td>
                        <td>5.00</td>
                        <td><span class="badge bg-danger">Failed</span></td>
                    </tr>

                </tbody>

            </table>
        </div>

        <!-- Summary -->
        <div class="row text-center mt-3">

            <div class="col">
                <div class="p-2 bg-light rounded-3">
                    <small class="text-muted">GPA</small>
                    <h5 class="mb-0">2.25</h5>
                </div>
            </div>

            <div class="col">
                <div class="p-2 bg-light rounded-3">
                    <small class="text-muted">Passed</small>
                    <h5 class="mb-0 text-success">3</h5>
                </div>
            </div>

            <div class="col">
                <div class="p-2 bg-light rounded-3">
                    <small class="text-muted">Failed</small>
                    <h5 class="mb-0 text-danger">1</h5>
                </div>
            </div>

        </div>

        <!-- Grade Scale -->
        <div class="mt-3 p-3 bg-light rounded-3 small">

            <strong>Grade Scale:</strong><br>
            1.00 – 1.50 → Excellent (90–100)<br>
            1.75 – 2.25 → Very Good (85–89)<br>
            2.50 – 2.75 → Good (80–84)<br>
            3.00 → Passing (75–79)<br>
            5.00 → Failed (below 75)

        </div>

    </div>

</div>