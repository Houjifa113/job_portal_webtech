<?php
    require_once('db.php');
    
    function getPassword($id){
        $con=getConnection();
        $sql = "SELECT password FROM users WHERE id={$id}";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['password'];
    }
    function updatePassword($id, $newpassword){
        $con=getConnection();
        $sql = "UPDATE users SET password='{$newpassword}' WHERE id={$id}";
        if(mysqli_query($con, $sql)){
            return true;
        }else{
            return false;
        }
    }
    function getSearchHistory($id){
        $con=getConnection();
        $sql = "SELECT search_term as job_title, status FROM search_history WHERE user_id={$id}";
        $result = mysqli_query($con, $sql);
        $history = [];
        while($row = mysqli_fetch_assoc($result)){
            $history[] = $row;
        }
        return $history;
    }
    function getSavedSearches($id){
        $con=getConnection();
        $sql = "SELECT id,job_title, status FROM saved_searches WHERE user_id={$id}";
        $result = mysqli_query($con, $sql);
        $history = [];
        while($row = mysqli_fetch_assoc($result)){
            $history[] = $row;
        }
        return $history;
    }
    function deleteSavedSearches($entryId){
        $con=getConnection();
        $sql = "DELETE FROM saved_searches WHERE id={$entryId}";
        if(mysqli_query($con, $sql)){
            return true;
        }else{
            return false;
        }
    }


function getUserById($id){
    $con = getConnection();

    $sql = "SELECT name, email FROM users WHERE id={$id}";
    $res = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($res);

    if(!$user) return json_encode(["error" => "User not found"]);

    $fullName = $user['name'];
    $email = $user['email'];

    $sql = "SELECT phone, linkedIn, bio FROM user_profile WHERE user_id={$id}";
    $res = mysqli_query($con, $sql);
    $profile = mysqli_fetch_assoc($res);

    $edu = [];
    $res = mysqli_query($con, "SELECT institute, program, start_date AS start, end_date AS end FROM education WHERE user_id={$id}");
    while($row = mysqli_fetch_assoc($res)) $edu[] = $row;

    $skills = [];
    $res = mysqli_query($con, "SELECT skill_name FROM skills WHERE user_id={$id}");
    while($row = mysqli_fetch_assoc($res)) $skills[] = $row['skill_name'];

    $experience = [];
    $res = mysqli_query($con, "SELECT company, position, description AS 'desc', start_date AS start, end_date AS end FROM experience WHERE user_id={$id}");
    while($row = mysqli_fetch_assoc($res)) $experience[] = $row;

    $languages = [];
    $res = mysqli_query($con, "SELECT language_name FROM languages WHERE user_id={$id}");
    while($row = mysqli_fetch_assoc($res)) $languages[] = $row['language_name'];

    $certifications = [];
    $res = mysqli_query($con, "SELECT certification_name FROM certifications WHERE user_id={$id}");
    while($row = mysqli_fetch_assoc($res)) $certifications[] = $row['certification_name'];

    $final = [
        $id => [
            "fullName" => $fullName,
            "email" => $email,
            "phone" => $profile['phone'] ?? null,
            "linkedIn" => $profile['linkedIn'] ?? null,
            "bio" => $profile['bio'] ?? null,
            "education" => $edu,
            "skills" => $skills,
            "experience" => $experience,
            "languages" => $languages,
            "certifications" => $certifications
        ]
    ];

    return json_encode($final);
}

function updateUsername($id, $name)
{
    $con = getConnection();
    $sql = "UPDATE users SET name='{$name}' WHERE id={$id}";
    return mysqli_query($con, $sql);
}

function updateUser($id, $bio, $phone, $linkedIn) {
    $con = getConnection();
    $check = mysqli_query($con, "SELECT id FROM user_profile WHERE user_id={$id}");
    if (mysqli_num_rows($check) > 0) {
        $sql = "UPDATE user_profile 
                SET phone='{$phone}', linkedIn='{$linkedIn}', bio='{$bio}' 
                WHERE user_id={$id}";
    } else {
        $sql = "INSERT INTO user_profile (user_id, phone, linkedIn, bio) 
                VALUES ({$id}, '{$phone}', '{$linkedIn}', '{$bio}')";
    }
    return mysqli_query($con, $sql);
}

function updateSkills($id, $skills) {
    $con = getConnection();
    mysqli_query($con, "DELETE FROM skills WHERE user_id={$id}");
    foreach ($skills as $skill) {
        if (!empty($skill)) {
            $sql = "INSERT INTO skills (user_id, skill_name) VALUES ({$id}, '{$skill}')";
            mysqli_query($con, $sql);
        }
    }
    return true;
}

function updateExperience($id, $experience) {
    $con = getConnection();
    mysqli_query($con, "DELETE FROM experience WHERE user_id={$id}");
    foreach ($experience as $exp) {
        $company = $exp['company'];
        $position = $exp['position'];
        $desc = $exp['desc'];
        $start = $exp['start'];
        $end = $exp['end'];
        $sql = "INSERT INTO experience (user_id, company, position, description, start_date, end_date) 
                VALUES ({$id}, '{$company}', '{$position}', '{$desc}', '{$start}', '{$end}')";
        mysqli_query($con, $sql);
    }
    return true;
}

function updateEducation($id, $education) {
    $con = getConnection();
    mysqli_query($con, "DELETE FROM education WHERE user_id={$id}");
    foreach ($education as $edu) {
        $institute = $edu['institute'];
        $program = $edu['program'];
        $start = $edu['start'];
        $end = $edu['end'];
        $sql = "INSERT INTO education (user_id, institute, program, start_date, end_date) 
                VALUES ({$id}, '{$institute}', '{$program}', '{$start}', '{$end}')";
        mysqli_query($con, $sql);
    }
    return true;
}

function updateLanguages($id, $languages) {
    $con = getConnection();
    mysqli_query($con, "DELETE FROM languages WHERE user_id={$id}");
    foreach ($languages as $lang) {
        if (!empty($lang)) {
            $sql = "INSERT INTO languages (user_id, language_name) VALUES ({$id}, '{$lang}')";
            mysqli_query($con, $sql);
        }
    }
    return true;
}

function updateCertifications($id, $certifications) {
    $con = getConnection();
    mysqli_query($con, "DELETE FROM certifications WHERE user_id={$id}");
    foreach ($certifications as $cert) {
        if (!empty($cert)) {
            $sql = "INSERT INTO certifications (user_id, certification_name) VALUES ({$id}, '{$cert}')";
            mysqli_query($con, $sql);
        }
    }
    return true;
}


function getStrengthByID($id) {
    $profile = json_decode(getUserById($id), true)[$id];
    $checks = [
        "fullName" => !empty($profile['fullName']),
        "email" => !empty($profile['email']),
        "phone" => !empty($profile['phone']),
        "linkedIn" => !empty($profile['linkedIn']),
        "bio" => !empty($profile['bio']),
        "education" => !empty($profile['education']),
        "skills" => !empty($profile['skills']),
        "experience" => !empty($profile['experience']),
        "languages" => !empty($profile['languages']),
        "certifications" => !empty($profile['certifications']),
    ];

    $total = count($checks);
    $completed = 0;
    $missing = [];

    foreach ($checks as $field => $ok) {
        if ($ok) {
            $completed++;
        } else {
            $missing[] = $field;
        }
    }

    $percentage = ($completed / $total) * 100;

    return [
        "percentage" => round($percentage),
        "completed" => $completed,
        "total" => $total,
        "missing" => $missing,
        "details" => $checks
    ];
}


?>