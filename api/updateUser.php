<?php
header('Content-Type: application/json');
include __DIR__ . '/../includes/db_connect.php';
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // USER INDEX
    $student_id        = (int)($_POST['student_id'] ?? 0);

    // USER INFORMATION
    $current_status    = (string)($_POST['current_status'] ?? '');
    $firstName         = (string)($_POST['FirstName'] ?? '');
    $middleName        = (string)($_POST['MiddleName'] ?? '');
    $lastName          = (string)($_POST['LastName'] ?? '');
    $extName           = (string)($_POST['Ext_Name'] ?? '');

    $birthDate         = (string)($_POST['BirthDate'] ?? '');
    $age               = (int)($_POST['Age'] ?? 0);
    $nationality       = (string)($_POST['Nationality'] ?? '');
    $civilStatus       = (string)($_POST['CivilStatus'] ?? '');
    $gender            = (string)($_POST['Gender'] ?? '');
    $phoneNumber       = (string)($_POST['PhoneNumber'] ?? '');

    $barangay          = (string)($_POST['Barangay'] ?? '');
    $city              = (string)($_POST['City'] ?? '');
    $province          = (string)($_POST['Province'] ?? '');
    $zipCode           = (int)($_POST['ZipCode'] ?? 0);

    $email             = (string)($_POST['Email'] ?? '');
    $user_role         = (string)($_POST['role'] ?? '');

    $program           = (string)($_POST['Program'] ?? '');
    $yearLevel         = (string)($_POST['YearLevel'] ?? '');
    $graduationYear    = (int)($_POST['GraduationYear'] ?? 0);
    $honors            = (string)($_POST['Honors'] ?? '');

    $employmentStatus  = (string)($_POST['EmploymentStatus'] ?? '');
    $companyName       = (string)($_POST['CompanyName'] ?? '');
    $jobTitle          = (string)($_POST['JobTitle'] ?? '');
    $workLocation      = (string)($_POST['WorkLocation'] ?? '');

    $guardianName      = (string)($_POST['GuardianName'] ?? '');
    $relationship      = (string)($_POST['Relationship'] ?? '');
    $guardianPhone     = (string)($_POST['GuardianPhone'] ?? '');
    $guardianEmail     = (string)($_POST['GuardianEmail'] ?? '');

    // USER ACCOUNT TABLE
    $accountEmail      = (string)($_POST['account_email'] ?? '');
    $accountUsername   = (string)($_POST['account_username'] ?? '');
    $new_account_password =  trim($_POST['new_account_password'] ?? '');
    $recoveryEmail     = (string)($_POST['recovery_email'] ?? '');
    $activationStatus  = (string)($_POST['activationStatus'] ?? 'disabled');

    $conn->begin_transaction();

    try {

        // USER_INFORMATION QUERY
        $stmt = $conn->prepare("UPDATE user_information SET
                                    current_status = ?,
                                    FirstName = ?, 
                                    MiddleName = ?, 
                                    LastName = ?, 
                                    Ext_Name = ?,
                                    BirthDate = ?, 
                                    Age = ?, 
                                    Nationality = ?, 
                                    CivilStatus = ?, 
                                    Gender = ?, 
                                    PhoneNumber = ?, 
                                    Barangay = ?, 
                                    City = ?, 
                                    Province = ?, 
                                    ZipCode = ?, 
                                    Email = ?, 
                                    role = ?,
                                    Program = ?,
                                    YearLevel = ?, 
                                    GraduationYear = ?, 
                                    Honors = ?, 
                                    EmploymentStatus = ?, 
                                    CompanyName = ?, 
                                    JobTitle = ?, 
                                    WorkLocation = ?,
                                    GuardianName = ?, 
                                    Relationship = ?, 
                                    GuardianPhone = ?, 
                                    GuardianEmail = ?
                                    WHERE student_id = ?
    ");

        $stmt->bind_param(
            "ssssssissssssssssssssssssssssi",

            $current_status,
            $firstName,
            $middleName,
            $lastName,
            $extName,
            $birthDate,
            $age,
            $nationality,
            $civilStatus,
            $gender,
            $phoneNumber,
            $barangay,
            $city,
            $province,
            $zipCode,
            $email,
            $user_role,
            $program,
            $yearLevel,
            $graduationYear,
            $honors,
            $employmentStatus,
            $companyName,
            $jobTitle,
            $workLocation,
            $guardianName,
            $relationship,
            $guardianPhone,
            $guardianEmail,
            $student_id
        );
        $stmt->execute();
        $stmt->close();

        if (!empty($new_account_password)) {

            $hashedPassword = password_hash($new_account_password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare(" UPDATE users SET account_email = ?, account_username = ?, account_password = ?, recovery_email = ?,activationStatus = ? WHERE student_id = ?");

            $stmt->bind_param(
                "sssssi",
                $accountEmail,
                $accountUsername,
                $hashedPassword,
                $recoveryEmail,
                $activationStatus,
                $student_id
            );
        } else {

            $stmt = $conn->prepare(" UPDATE users SET account_email = ?, account_username = ?, recovery_email = ?, activationStatus = ? WHERE student_id = ?
    ");
            $stmt->bind_param(
                "ssssi",
                $accountEmail,
                $accountUsername,
                $recoveryEmail,
                $activationStatus,
                $student_id
            );
        }

        $stmt->execute();
        $stmt->close();

        //GET STUDENT NAME
        $stmt = $conn->prepare("SELECT FirstName, LastName FROM user_information WHERE student_id = ?");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $log_owner = $row['FirstName'] . ' ' .  $row['LastName'];
        $stmt->close();

        // INSERT LOG
        $log_description = 'Edited by Admin';
        $log_type = 'Information Edit';
        $stmt = $conn->prepare("INSERT INTO logs (student_id, log_owner, log_description, log_type) VALUES (?,?,?,?)");
        $stmt->bind_param("isss", $student_id, $log_owner, $log_description, $log_type);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e]);
    }
}
