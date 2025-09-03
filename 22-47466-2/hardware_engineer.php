<?php
session_start();

// Job name
$job_name = 'hardware_engineer';

// Initialize applied jobs array
if (!isset($_SESSION['applied_jobs'])) {
    $_SESSION['applied_jobs'] = array();
}

// Check if job is already applied
$already_applied = in_array($job_name, $_SESSION['applied_jobs']);

// Handle apply action
if (isset($_GET['apply']) && !$already_applied) {
    $_SESSION['applied_jobs'][] = $job_name;
    $already_applied = true;
    $message = "You have successfully applied for Hardware Engineer!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Engineer</title>
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
    <div class="job-name">Hardware Engineer</div>
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

<!-- Job Details -->
<form>
    <table>
        <tr>
            <td>
                <h2>Summary:</h2>
                <p>Age: 28 to 40 years</p>
                <p>Experience: At least 3 years in hardware design or development</p>
                <p>Salary: Negotiable</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Minimum qualifications:</h2>
                <ul>
                    <li>Bachelor’s degree in Electrical Engineering, Electronics, or related field.</li>
                    <li>2-3 years of experience in hardware design, testing, and maintenance.</li>
                    <li>Knowledge of circuit design, embedded systems, and debugging tools.</li>
                    <li>Familiarity with microcontrollers, FPGA, or ASIC design.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Preferred qualifications:</h2>
                <ul>
                    <li>Master's degree in Electrical or Computer Engineering.</li>
                    <li>Experience in hardware simulation and prototyping.</li>
                    <li>Knowledge of high-speed digital design and PCB layout.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>About the job:</h2>
                <p>The Hardware Engineer will design, develop, and maintain computer hardware, circuits, and devices. Responsibilities include testing hardware components, ensuring reliability, and working closely with software teams for integration. The role requires attention to detail, problem-solving skills, and experience with hardware lifecycle management.</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Responsibilities:</h2>
                <ul>
                    <li>Design and develop computer hardware components and systems.</li>
                    <li>Test and debug circuits, boards, and embedded systems.</li>
                    <li>Collaborate with software engineers for hardware-software integration.</li>
                    <li>Maintain documentation for designs and testing procedures.</li>
                    <li>Participate in hardware review and validation processes.</li>
                </ul>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
