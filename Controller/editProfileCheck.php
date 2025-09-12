<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $isValid = true;

    if (empty($_POST["skills"])) {
        $errors[] = "Please enter at least one skill.";
        $isValid = false;
    } else {
        $skills = is_array($_POST["skills"]) ? array_map('trim', $_POST["skills"]) : [];
        $skills = array_unique($skills);
        if (count($skills) < 1) {
            $errors[] = "Please enter at least one skill.";
            $isValid = false;
        }
    }

    if (empty($_POST["experience"])) {
        $errors[] = "Please enter at least one work experience.";
        $isValid = false;
    } else {
        foreach ($_POST["experience"] as $exp) {
            if (empty($exp["company"]) || empty($exp["position"]) || empty($exp["start"]) || empty($exp["end"]) || empty($exp["desc"])) {
                $errors[] = "Please fill in all fields for work experience.";
                $isValid = false;
            }
        }
    }

    if (empty($_POST["education"])) {
        $errors[] = "Please enter at least one education record.";
        $isValid = false;
    } else {
        foreach ($_POST["education"] as $edu) {
            if (empty($edu["institute"]) || empty($edu["program"]) || empty($edu["start"]) || empty($edu["end"])) {
                $errors[] = "Please fill in all fields for education.";
                $isValid = false;
            }
        }
    }

    if (empty($_POST["languages"])) {
        $errors[] = "Please enter at least one language spoken.";
        $isValid = false;
    } else {
        $languages = is_array($_POST["languages"]) ? array_map('trim', $_POST["languages"]) : [];
        $languages = array_unique($languages);
        if (count($languages) < 1) {
            $errors[] = "Please enter at least one language spoken.";
            $isValid = false;
        }
    }


    if (!$isValid) {
        $firstError = isset($errors[0]) ? $errors[0] : "";
        $errorStr = str_replace(' ', '_', $firstError);
        header("Location: ../view/editProfile.php?error=Error_$errorStr");
        exit;
    }

    header("Location: ../view/editProfile.php?error=");
    exit;
}