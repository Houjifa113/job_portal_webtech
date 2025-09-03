<?php
session_start();

// Job name
$job_name = 'system_analyst';

//  applied jobs array
if (!isset($_SESSION['applied_jobs'])) {
    $_SESSION['applied_jobs'] = array();
}

//  if job is already applied
$already_applied = in_array($job_name, $_SESSION['applied_jobs']);

//  apply 
if (isset($_GET['apply']) && !$already_applied) {
    $_SESSION['applied_jobs'][] = $job_name;
    $already_applied = true;
    $message = "You have successfully applied for System Analyst!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Analyst</title>
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
    <div class="job-name">System Analyst</div>
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
                <p>Experience: At least 3 years in IT or business systems</p>
                <p>Salary: Negotiable</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Minimum qualifications:</h2>
                <ul>
                    <li>Bachelor’s degree in Computer Science, Information Systems, or related field.</li>
                    <li>Experience analyzing and improving IT systems.</li>
                    <li>Knowledge of databases, networks, and software lifecycle management.</li>
                    <li>Strong problem-solving and analytical skills.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Preferred qualifications:</h2>
                <ul>
                    <li>Master's degree in IT, Business Analytics, or related field.</li>
                    <li>Experience with project management and business process modeling.</li>
                    <li>Knowledge of software development methodologies and tools.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>About the job:</h2>
                <p>The System Analyst will evaluate, analyze, and improve IT systems within the organization. You will work closely with stakeholders and development teams to ensure systems meet business requirements. Responsibilities include documenting processes, gathering requirements, recommending solutions, and supporting system implementation.</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Responsibilities:</h2>
                <ul>
                    <li>Analyze existing IT systems and recommend improvements.</li>
                    <li>Gather and document business requirements.</li>
                    <li>Work with developers to design solutions that meet organizational needs.</li>
                    <li>Perform system testing and validation.</li>
                    <li>Provide ongoing support and troubleshooting for systems.</li>
                </ul>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
