<?php
include __DIR__ . '/../../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');

    $email       = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $stmt = $conn->prepare("SELECT * FROM user_information WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email is Already in use. Please use Another.']);
        $stmt->close();
        exit;
    } else {

        $role = (string)($_POST['role'] ?? '');

        // PERSONAL INFORMATION
        $firstName     = trim($_POST['firstName'] ?? 'N/A');
        $lastName      = trim($_POST['lastName'] ?? 'N/A');
        $middleName    = trim($_POST['middleName'] ?? 'N/A');
        $extensionName = trim($_POST['exName'] ?? 'N/A');
        $birthDate     = $_POST['birthDate'] ?? 'N/A';
        $age           = (int) ($_POST['age'] ?? 0);
        $nationality   = trim($_POST['nationality'] ?? 'N/A');
        $civilStatus   = $_POST['civilStatus'] ?? 'N/A';
        $Gender        = $_POST['gender'] ?? 'N/A';


        // CONTACT INFORMATION
        $phoneNumber = preg_replace('/[^0-9]/', '', $_POST['phoneNumber'] ?? 'N/A');
        $address     = trim($_POST['address'] ?? 'N/A');
        $barangay    = trim($_POST['barangayInput'] ?? 'N/A');
        $city        = trim($_POST['city'] ?? 'N/A');
        $province    = trim($_POST['province'] ?? 'N/A');
        $zipCode     = trim($_POST['zipCode'] ?? 'N/A');


        // ACADEMIC INFORMATION
        $program        = $_POST['program'] ?? 'N/A';
        $applicationType    = $_POST['applicationType'] ?? 'N/A';

        // ACADEMIC INFORMATION FOR ALUMNIS
        $graduation_year = $_POST['graduationYear'] ?? 'N/A';
        $honors = $_POST['honors'] ?? 'N/A';

        // CAREER INFORMATION FOR ALUMNIS
        $employment_status = $_POST['employmentStatus'] ?? 'N/A';
        $company_name = $_POST['companyName'] ?? 'N/A';
        $job_title = $_POST['jobTitle'] ?? 'N/A';
        $work_location = $_POST['workLocation'] ?? 'N/A';

        // EMERGENCY CONTACT
        $guardianName  = trim($_POST['guardianName'] ?? 'N/A');
        $relationship  = $_POST['relationship'] ?? 'N/A';
        $guardianPhone = preg_replace('/[^0-9]/', '', $_POST['guardianPhone'] ?? 'N/A');
        $guardianEmail = filter_input(INPUT_POST, 'guardianEmail', FILTER_SANITIZE_EMAIL) ?? 'N/A';


        // ACCOUNT INFORMATION
        $accountUsername = trim($_POST['accountUsername'] ?? 'N/A');
        $password        = $_POST['password'] ?? 'N/A';
        $hashedPassword  = password_hash($password, PASSWORD_BCRYPT);
        $recoveryEmail   = filter_input(INPUT_POST, 'recoveryInput', FILTER_SANITIZE_EMAIL);

        // Start transaction
        $conn->begin_transaction();

        try {
            // First query - Insert student
            $stmt = $conn->prepare("INSERT INTO user_information (
                                            role,
                                            FirstName, LastName, MiddleName, Ext_Name,
                                            BirthDate, Age, Nationality, CivilStatus,
                                            Gender, Email, PhoneNumber, Address, Barangay,
                                            City, Province, ZipCode, Program, ApplicationType,
                                            GuardianName, Relationship,
                                            GuardianPhone, GuardianEmail, GraduationYear, Honors,
                                            EmploymentStatus, CompanyName, JobTitle, WorkLocation
                                            )
                                            VALUES
                                            (
                                            ?,
                                            ?,?,?,?,
                                            ?,?,?,?,
                                            ?,?,?,?,?,
                                            ?,?,?,?,
                                            ?,?,?,?,
                                            ?,?,?,?,
                                            ?,?,?
                                            )
                                            ");

            $stmt->bind_param(
                "ssssssissssssssssssssssssssss",
                $role,
                $firstName,
                $lastName,
                $middleName,
                $extensionName,
                $birthDate,
                $age,
                $nationality,
                $civilStatus,
                $Gender,
                $email,
                $phoneNumber,
                $address,
                $barangay,
                $city,
                $province,
                $zipCode,
                $program,
                $applicationType,
                $guardianName,
                $relationship,
                $guardianPhone,
                $guardianEmail,
                $graduation_year,
                $honors,
                $employment_status,
                $company_name,
                $job_title,
                $work_location
            );

            $stmt->execute();
            $student_id = $conn->insert_id;
            $stmt->close();

            $profile_picture = '/Modern Student Portal/public/Uploads/profile_pictures/default-profile-picture.jpg'; // DEFAULT PROFILE PICTURE

            // Second query - INSERT ACCOUNT
            $stmt = $conn->prepare("INSERT INTO users (profile_picture, student_id, account_email, account_username, account_password, recovery_email) 
                                VALUES (?, ?,?,?,?,?)");

            $stmt->bind_param("sissss", $profile_picture, $student_id, $email, $accountUsername, $hashedPassword, $recoveryEmail);
            $stmt->execute();
            $stmt->close();

            // LOGS
            $log_description = 'New ' . $role . ' Registration';
            $log_owner = $firstName . ' ' . $lastName;
            $log_type = 'Registration';

            $stmt = $conn->prepare("INSERT INTO logs (student_id, log_description, log_owner,log_type) VALUES (?,?,?,?)");
            $stmt->bind_param("isss", $student_id, $log_description, $log_owner, $log_type);
            $stmt->execute();
            $stmt->close();

            // Commit all queries
            $conn->commit();

            echo json_encode(['success' => true, 'message' => 'Registration successful']);
        } catch (Exception $e) {
            // Rollback if any query fails
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $e]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request. Please Try again.']);
}
