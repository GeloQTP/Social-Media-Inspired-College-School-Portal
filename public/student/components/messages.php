<?php
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

$stmt = $conn->prepare("
    SELECT * 
    FROM user_information 
    LEFT JOIN users 
    ON user_information.student_id = users.student_id 
    WHERE role = 'Teacher' OR role = 'Admin'
");

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="card shadow-sm border-0 rounded-1 overflow-hidden">

    <!-- Header -->
    <div class="card-header bg-success text-white border-0 p-4">
        <h4 class="mb-0 fw-bold">Send Message</h4>
        <small>Send a formal message to Teachers & Administrators</small>
    </div>

    <div class="row g-0">

        <!-- LEFT SIDE : RECIPIENT LIST -->
        <div class="col-md-4 border-end bg-light">

            <div class="p-3 border-bottom">
                <input type="text"
                    class="form-control form-control-sm rounded-pill"
                    placeholder="Search recipient...">
            </div>

            <div class="list-group list-group-flush">

                <?php while ($stafflist = $result->fetch_assoc()) { ?>

                    <label class="list-group-item d-flex align-items-center gap-3 py-3">

                        <!-- Radio -->
                        <input class="form-check-input"
                            type="radio"
                            name="receiver_id"
                            value="<?= $stafflist['student_id'] ?>">

                        <!-- Avatar -->
                        <div class="rounded-circle overflow-hidden d-flex justify-content-center align-items-center"
                            style="width:45px;height:45px;">

                            <?php if (!empty($stafflist['profile_picture'])) { ?>

                                <img src="<?= htmlspecialchars($stafflist['profile_picture']) ?>"
                                    alt="profile"
                                    class="w-100 h-100"
                                    style="object-fit: cover;">

                            <?php } else { ?>

                                <div class="bg-dark text-white w-100 h-100 d-flex justify-content-center align-items-center fw-bold">
                                    <?= strtoupper(substr($stafflist['account_username'], 0, 1)) ?>
                                </div>

                            <?php } ?>

                        </div>

                        <!-- Info -->
                        <div>
                            <div class="fw-bold">
                                <?= htmlspecialchars($stafflist['FirstName']) ?>, <?= htmlspecialchars($stafflist['LastName']) ?>
                            </div>

                            <small class="text-muted">
                                <?= htmlspecialchars($stafflist['role']) ?>
                            </small>
                        </div>

                    </label>

                <?php } ?>

            </div>

        </div>

        <!-- RIGHT SIDE : LETTER FORM -->
        <div class="col-md-8">

            <form method="POST">

                <!-- Letter Header -->
                <div class="p-4 border-bottom bg-light">

                    <h5 class="fw-bold mb-3">Compose Letter</h5>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Subject</label>

                        <input type="text"
                            name="subject"
                            class="form-control"
                            placeholder="Enter subject...">
                    </div>

                </div>

                <!-- Letter Body -->
                <div class="p-4">

                    <label class="form-label fw-semibold">Message</label>

                    <textarea name="message"
                        class="form-control"
                        rows="12"
                        placeholder="Write your letter here..."
                        style="resize:none;"></textarea>

                </div>

                <!-- Footer -->
                <div class="p-4 border-top d-flex justify-content-end gap-2 bg-light">

                    <button type="reset" class="btn btn-outline-secondary px-4">
                        Clear
                    </button>

                    <button type="submit" class="btn btn-success px-4">
                        Send Letter
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>