<div class="modal fade" id="editUserDetailsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title lead ms-auto" id="exampleModalLabel">Configure <span id="edit_student_name"></span>'s Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">

                <form id="editUserForm" class="row">
                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Personal and Contact Information
                    </p>

                    <div class="col-lg-2 mb-5">
                        <strong>First Name</strong><br>
                        <input id="FirstName" name="FirstName" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Middle Name</strong><br>
                        <input id="MiddleName" name="MiddleName" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Last Name</strong><br>
                        <input id="LastName" name="LastName" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Suffix</strong><br>
                        <input id="Ext_Name" name="Ext_Name" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Date of Birth</strong><br>
                        <input type="date" id="BirthDate" name="BirthDate" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Age</strong><br>
                        <input id="Age" name="Age" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Nationality</strong><br>
                        <input id="Nationality" name="Nationality" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Civil Status</strong><br>
                        <input id="CivilStatus" name="CivilStatus" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Gender</strong><br>
                        <input id="Gender" name="Gender" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Phone Number</strong><br>
                        <input id="PhoneNumber" name="PhoneNumber" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Barangay</strong><br>
                        <input id="Barangay" name="Barangay" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>City</strong><br>
                        <input id="City" name="City" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Province</strong><br>
                        <input id="Province" name="Province" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Zip Code</strong><br>
                        <input id="ZipCode" name="ZipCode" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Email</strong><br>
                        <input id="Email" name="Email" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>User Status</strong><br>
                        <select id="current_status" name="current_status" class="placeholders form-select form-select-sm">
                            <option value="verified">Verified</option>
                            <option value="pending">Pending</option>
                            <option value="enrolled">Enrolled</option>
                        </select>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>User Role</strong><br>
                        <select id="role" name="role" class="placeholders form-select form-select-sm">
                            <option value="Student">Student</option>
                            <option value="Alumni">Alumni</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Academic Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Program</strong><br>
                        <input id="Program" name="Program" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Year Level</strong><br>
                        <input id="YearLevel" name="YearLevel" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Graduation Year</strong><br>
                        <select name="GraduationYear" id="GraduationYear"
                            class="form-select form-select-sm text-dark border-1" required>
                            <option value="" disabled selected>Select Year</option>
                            <option value="N/A">N/A</option>
                            <?php
                            $currentYear = date("Y");
                            for ($i = $currentYear; $i >= $currentYear - 50; $i--) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Honors</strong><br>
                        <input id="Honors" name="Honors" class="placeholders form-control form-control-sm">
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Career Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Employment Status</strong><br>
                        <input id="EmploymentStatus" name="EmploymentStatus" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Company Name</strong><br>
                        <input id="CompanyName" name="CompanyName" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Job Title</strong><br>
                        <input id="JobTitle" name="JobTitle" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Work Location</strong><br>
                        <input id="WorkLocation" name="WorkLocation" class="placeholders form-control form-control-sm">
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Emergency Contact
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Guardian's Name</strong><br>
                        <input id="GuardianName" name="GuardianName" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Relationship</strong><br>
                        <input id="Relationship" name="Relationship" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Guardian's Phone</strong><br>
                        <input id="GuardianPhone" name="GuardianPhone" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Guardian's Email</strong><br>
                        <input id="GuardianEmail" name="GuardianEmail" class="placeholders form-control form-control-sm">
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Account Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Account Email</strong><br>
                        <input id="account_email" name="account_email" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Account Username</strong><br>
                        <input id="account_username" name="account_username" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Update Password</strong><br>
                        <input id="new_account_password" name="new_account_password" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Recovery Email</strong><br>
                        <input id="recovery_email" name="recovery_email" class="placeholders form-control form-control-sm">
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Activation Status</strong><br>
                        <select id="activationStatus" name="activationStatus" class="placeholders form-select form-select-sm">
                            <option value="disabled">Disabled</option>
                            <option value="active">Active</option>
                            <option value="restricted">Restricted</option>
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <strong>Profile Picture</strong><br>

                        <img
                            id="profile_picture"
                            src="your-image.jpg"
                            alt="Profile Picture"
                            style="
                            width: 150px;
                            height: 140px;
                            border-radius: 50%;
                            object-fit: cover;">
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Registration Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Registration Date</strong><br>
                        <small id="RegistrationDate" class="placeholders"></small>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Verification Date</strong><br>
                        <small id="date_verified" class="placeholders"></small>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Enrollment Date</strong><br>
                        <small id="EnrollmentDate" class="placeholders"></small>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-success" id="update_student" onclick="updateUserVerification(this.value)">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->