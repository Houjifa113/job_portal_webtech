<?php
session_start();

// Job name
$job_name = 'embedded_systems_engineer';

//  applied jobs array
if (!isset($_SESSION['applied_jobs'])) {
    $_SESSION['applied_jobs'] = array();
}

//  if job is already applied
$already_applied = in_array($job_name, $_SESSION['applied_jobs']);

// apply 
if (isset($_GET['apply']) && !$already_applied) {
    $_SESSION['applied_jobs'][] = $job_name;
    $already_applied = true;
    $message = "You have successfully applied for Embedded Systems Engineer!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embedded Systems Engineer</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .job-name { font-size: 24px; font-weight: bold; }
        .apply-btn { background-color: green; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .apply-btn:disabled { background-color: gray; cursor: not-allowed; }
        .message { margin-bottom: 20px; color: blue; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 10px; vertical-align: top; }
        h2 { margin-bottom: 5px; }
        ul { margin-top: 0; }
    </style>
</head>
<body>

<div class="header">
    <div class="job-name">Embedded Systems Engineer</div>
    <div>
        <?php if (!$already_applied): ?>
            <a href="?apply=1"><button class="apply-btn">Apply</button></a>
        <?php else: ?>
            <button class="apply-btn" disabled>Already Applied</button>
        <?php endif; ?>
        <a href="apply_history.php" style="margin-left: 15px;">Apply History</a>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<form>
    <table>
        <tr>
            <td>
                <h2>Summary:</h2>
                <p>Age: 25 to 40 years</p>
                <p>Experience: At least 3 years in embedded systems</p>
                <p>Salary: Negotiable</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Minimum qualifications:</h2>
                <ul>
                    <li>Bachelor’s degree in Electronics, Computer Engineering, or related field.</li>
                    <li>Experience in designing and programming embedded systems.</li>
                    <li>Knowledge of microcontrollers, sensors, and communication protocols.</li>
                    <li>Proficient in C/C++ or other low-level programming languages.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Preferred qualifications:</h2>
                <ul>
                    <li>Master's degree in Embedded Systems or related field.</li>
                    <li>Experience with real-time operating systems (RTOS) and IoT devices.</li>
                    <li>Knowledge of PCB design and hardware debugging.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>About the job:</h2>
                <p>The Embedded Systems Engineer will design, develop, and maintain embedded systems for various applications. You will work with hardware and software teams to integrate microcontrollers, sensors, and actuators into reliable systems. You will also be responsible for testing, debugging, and optimizing firmware to meet performance requirements.</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Responsibilities:</h2>
                <ul>
                    <li>Design and program embedded systems using microcontrollers and sensors.</li>
                    <li>Develop firmware in C/C++ and ensure system reliability.</li>
                    <li>Collaborate with hardware engineers to design and test prototypes.</li>
                    <li>Debug, troubleshoot, and optimize embedded software.</li>
                    <li>Document designs, processes, and testing procedures.</li>
                </ul>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
