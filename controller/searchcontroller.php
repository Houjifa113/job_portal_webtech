<?php
session_start();

if (isset($_REQUEST["submit"])) {

$jobs = [
    ["title" => "Software Engineer", "link" => "software_engineering.php", "highlight" => "Develop and maintain applications", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Hardware Engineer", "link" => "hardware_engineer.php", "highlight" => "Design and test computer hardware", "location" => "Chattogram", "status" => "Onsite"],
    ["title" => "Systems Analyst", "link" => "system_analyst.php", "highlight" => "Analyze and improve IT systems", "location" => "Dhaka", "status" => "Hybrid"],
    ["title" => "Embedded Systems Engineer", "link" => "embedded_system_engineer.php", "highlight" => "Work with microcontrollers and devices", "location" => "Khulna", "status" => "Remote"],
    ["title" => "Network Engineer", "link" => "network_engineer.php", "highlight" => "Design and manage network systems", "location" => "Sylhet", "status" => "Onsite"],
    ["title" => "Cybersecurity Engineer", "link" => "cybersecurity_engineer.php", "highlight" => "Protect systems from cyber threats", "location" => "Dhaka", "status" => "Hybrid"],
    ["title" => "AI/ML Engineer", "link" => "ai_ml_engineer.html", "highlight" => "Build machine learning models", "location" => "Rajshahi", "status" => "Remote"],
    ["title" => "Database Administrator", "link" => "database_adminstrator.html", "highlight" => "Manage and secure databases", "location" => "Barisal", "status" => "Onsite"],
    ["title" => "Cloud Engineer", "link" => "#", "highlight" => "Deploy and manage cloud platforms", "location" => "Rangpur", "status" => "Hybrid"],
    ["title" => "DevOps Engineer", "link" => "#", "highlight" => "Automate software deployment", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Data Engineer", "link" => "#", "highlight" => "Build and maintain data pipelines", "location" => "Narayanganj", "status" => "Onsite"],
    ["title" => "Computer Vision Engineer", "link" => "#", "highlight" => "Implement computer vision algorithms", "location" => "Gazipur", "status" => "Hybrid"],
    ["title" => "Game Developer", "link" => "#", "highlight" => "Design and develop interactive games", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Mobile App Developer", "link" => "#", "highlight" => "Create applications for mobile platforms", "location" => "Mymensingh", "status" => "Onsite"],
    ["title" => "Full Stack Developer", "link" => "#", "highlight" => "Work on front-end and back-end", "location" => "Dhaka", "status" => "Hybrid"],
    ["title" => "Front-End Developer", "link" => "#", "highlight" => "Develop user interfaces", "location" => "Chattogram", "status" => "Remote"],
    ["title" => "Back-End Developer", "link" => "#", "highlight" => "Implement server-side logic", "location" => "Khulna", "status" => "Onsite"],
    ["title" => "Firmware Engineer", "link" => "#", "highlight" => "Write low-level embedded software", "location" => "Sylhet", "status" => "Hybrid"],
    ["title" => "IT Support Engineer", "link" => "#", "highlight" => "Provide technical support", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Computer Architect", "link" => "#", "highlight" => "Design CPU and system architectures", "location" => "Rajshahi", "status" => "Onsite"],
    ["title" => "Embedded Systems Engineer", "link" => "embedded_system_engineer.php", "highlight" => "Work with microcontrollers and devices", "location" => "Khulna", "status" => "Remote"],
    ["title" => "Network Engineer", "link" => "network_engineer.php", "highlight" => "Design and manage network systems", "location" => "Sylhet", "status" => "Onsite"],
    ["title" => "Cybersecurity Engineer", "link" => "cybersecurity_engineer.php", "highlight" => "Protect systems from cyber threats", "location" => "Dhaka", "status" => "Hybrid"],
    ["title" => "AI/ML Engineer", "link" => "ai_ml_engineer.html", "highlight" => "Build machine learning models", "location" => "Rajshahi", "status" => "Remote"],
    ["title" => "Database Administrator", "link" => "database_adminstrator.html", "highlight" => "Manage and secure databases", "location" => "Barisal", "status" => "Onsite"],
    ["title" => "Cloud Engineer", "link" => "#", "highlight" => "Deploy and manage cloud platforms", "location" => "Rangpur", "status" => "Hybrid"],
    ["title" => "DevOps Engineer", "link" => "#", "highlight" => "Automate software deployment", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Data Engineer", "link" => "#", "highlight" => "Build and maintain data pipelines", "location" => "Narayanganj", "status" => "Onsite"],
    ["title" => "Computer Vision Engineer", "link" => "#", "highlight" => "Implement computer vision algorithms", "location" => "Gazipur", "status" => "Hybrid"],
    ["title" => "Game Developer", "link" => "#", "highlight" => "Design and develop interactive games", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Mobile App Developer", "link" => "#", "highlight" => "Create applications for mobile platforms", "location" => "Mymensingh", "status" => "Onsite"],
    ["title" => "Full Stack Developer", "link" => "#", "highlight" => "Work on front-end and back-end", "location" => "Dhaka", "status" => "Hybrid"],
    ["title" => "Front-End Developer", "link" => "#", "highlight" => "Develop user interfaces", "location" => "Chattogram", "status" => "Remote"],
    ["title" => "Back-End Developer", "link" => "#", "highlight" => "Implement server-side logic", "location" => "Khulna", "status" => "Onsite"],
    ["title" => "Firmware Engineer", "link" => "#", "highlight" => "Write low-level embedded software", "location" => "Sylhet", "status" => "Hybrid"],
    ["title" => "IT Support Engineer", "link" => "#", "highlight" => "Provide technical support", "location" => "Dhaka", "status" => "Remote"],
    ["title" => "Computer Architect", "link" => "#", "highlight" => "Design CPU and system architectures", "location" => "Rajshahi", "status" => "Onsite"],
];


    $_SESSION["jobs"] = $jobs;

    header('Location: ../view/job.php');
    exit();
}
?>

