<div class="modal fade" id="edit_myProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title lead ms-auto" id="exampleModalLabel">Update Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-4">

                <form id="updateProfileForm" class="row">

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Account Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Account Email</strong><br>
                        <input id="account_email" name="account_email" class="placeholders form-control form-control-sm" require>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Account Username</strong><br>
                        <input id="account_username" name="account_username" class="placeholders form-control form-control-sm" require>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Recovery Email</strong><br>
                        <input id="recovery_email" name="recovery_email" class="placeholders form-control form-control-sm" require>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Badges</strong><br>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle w-100 text-start"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Select Status
                            </button>

                            <ul class="dropdown-menu w-100 p-2">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input status-checkbox" type="checkbox" value="badge1" id="badge1">
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input status-checkbox" type="checkbox" value="badge1" id="badge2">
                                        <label class="form-check-label" for="inactive">Inactive</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-5">
                        <strong>Quote</strong><br>
                        <textarea id="quote" name="quote" class="placeholders form-control form-control-sm"></textarea>
                    </div>

                    <div class="col-lg-6 mb-5">
                        <strong>Quote Author</strong><br>
                        <input id="quote_author" name="quote_author" class="placeholders form-control form-control-sm">
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Career Information
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Employment Status</strong><br>
                        <select id="EmploymentStatus" name="EmploymentStatus" class="form-select form-select-sm text-dark border-1">
                            <option value="Employed">Employed</option>
                            <option value="Unemployed">Unemployed</option>
                            <option value="Self_Employed">Self Employed</option>
                            <option value="N/A">Rather not say</option>
                        </select>
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
                        Personal and Contact Information <span class="text-danger fs-5">(Read Only)</span>
                    </p>

                    <div class="col-lg-2 mb-5">
                        <strong>First Name</strong><br>
                        <input id="FirstName" name="FirstName" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Middle Name</strong><br>
                        <input id="MiddleName" name="MiddleName" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Last Name</strong><br>
                        <input id="LastName" name="LastName" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Suffix</strong><br>
                        <input id="Ext_Name" name="Ext_Name" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Date of Birth</strong><br>
                        <input type="date" id="BirthDate" name="BirthDate" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Age</strong><br>
                        <input id="Age" name="Age" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Nationality</strong><br>
                        <input id="Nationality" name="Nationality" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Civil Status</strong><br>
                        <input id="CivilStatus" name="CivilStatus" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Gender</strong><br>
                        <input id="Gender" name="Gender" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Phone Number</strong><br>
                        <input id="PhoneNumber" name="PhoneNumber" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Barangay</strong><br>
                        <input id="Barangay" name="Barangay" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>City</strong><br>
                        <input id="City" name="City" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Province</strong><br>
                        <input id="Province" name="Province" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>Zip Code</strong><br>
                        <input id="ZipCode" name="ZipCode" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Email</strong><br>
                        <input id="Email" name="Email" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>User Status</strong><br>
                        <select id="current_status" name="current_status" class="placeholders form-select form-select-sm" disabled>
                            <option value="verified">Verified</option>
                            <option value="pending">Pending</option>
                            <option value="enrolled">Enrolled</option>
                        </select>
                    </div>

                    <div class="col-lg-2 mb-5">
                        <strong>User Role</strong><br>
                        <select id="role" name="role" class="placeholders form-select form-select-sm" disabled>
                            <option value="Student">Student</option>
                            <option value="Alumni">Alumni</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <p class="display-6 mb-4 w-100 text-dark fs-2" style="border-bottom:1px solid green">
                        Academic Information <span class="text-danger fs-5">(Read Only)</span>
                    </p>

                    <div class="col-lg-3 mb-5">
                        <strong>Program</strong><br>
                        <input id="Program" name="Program" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Year Level</strong><br>
                        <input id="YearLevel" name="YearLevel" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Graduation Year</strong><br>
                        <input id="GraduationYear" name="GraduationYear" class="placeholders form-control form-control-sm" readonly>
                    </div>

                    <div class="col-lg-3 mb-5">
                        <strong>Honors</strong><br>
                        <input id="Honors" name="Honors" class="placeholders form-control form-control-sm" readonly>
                    </div>
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-success" id="update_student" onclick="updateMyProfileConfirmation(<?= $_SESSION['user_id'] ?>)">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    function populateEditModal(data) {

        Object.keys(data).forEach(key => {
            const element = document.getElementById(key);

            if (!element) return;

            element.value = data[key];

        });

    }

    async function getMyProfile() {
        try {
            const res = await fetch(`./../../backend/getMyProfileInfo.php`);

            if (!res.ok) throw new Error("Network response Error");

            const data = await res.json();

            if (data.success) populateEditModal(data);

        } catch {

        } finally {

        }

    }

    function updateMyProfileConfirmation(user_id) {
        Swal.fire({
            title: "Are you sure?",
            text: `Update your Profile?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            confirmButtonText: "Save Changes"
        }).then((result) => {
            if (result.isConfirmed) {
                updateProfile(user_id);
            }
        });
    }

    async function updateProfile(user_id) {
        const form = document.getElementById("updateProfileForm");
        const newProfileFormData = new FormData(form);

        const res = await fetch(`./../../backend/updateProfile.php`, {
            method: 'POST',
            body: newProfileFormData,
            credentials: "same-origin",
        });

        if (!res.ok) throw new Error("Network response Error");

        const data = await res.json();

        if (data.success) {
            Swal.fire({
                title: "Changes Saved!",
                text: "Your information has been updated.",
                icon: "success"
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "Something went wrong. Please try again.",
                icon: "error"
            });
        }


        return;
    }
</script>

<!-- MODAL -->