<?php
session_start();

// Job name
$job_name = 'cybersecurity_engineer';

//  applied jobs array
if (!isset($_SESSION['applied_jobs'])) {
    $_SESSION['applied_jobs'] = array();
}

// if job is already applied
$already_applied = in_array($job_name, $_SESSION['applied_jobs']);

// apply 
if (isset($_GET['apply']) && !$already_applied) {
    $_SESSION['applied_jobs'][] = $job_name;
    $already_applied = true;
    $message = "You have successfully applied for Cybersecurity Engineer!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Engineer</title>
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
    <div class="job-name">Cybersecurity Engineer</div>
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
                <p>Age: 28 to 45 years</p>
                <p>Experience: At least 3 years in cybersecurity</p>
                <p>Salary: Negotiable</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Minimum qualifications:</h2>
                <ul>
                    <li>Bachelor’s degree in Computer Science, Information Security, or related field.</li>
                    <li>Experience with firewalls, VPNs, IDS/IPS, and security monitoring tools.</li>
                    <li>Knowledge of TCP/IP, network protocols, and encryption technologies.</li>
                    <li>Familiarity with regulatory compliance and security standards.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Preferred qualifications:</h2>
                <ul>
                    <li>Certifications like CISSP, CISM, CEH, or equivalent.</li>
                    <li>Experience in cloud security, penetration testing, and threat analysis.</li>
                    <li>Knowledge of security automation and scripting.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>About the job:</h2>
                <p>The Cybersecurity Engineer will protect the organization’s systems, networks, and data from cyber threats. You will design, implement, and maintain security solutions, monitor for vulnerabilities, and respond to incidents. The role involves collaboration with IT and development teams to ensure secure deployment and maintenance of technology solutions.</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Responsibilities:</h2>
                <ul>
                    <li>Implement and maintain security measures across network and systems.</li>
                    <li>Monitor systems for security breaches and investigate incidents.</li>
                    <li>Conduct vulnerability assessments and penetration tests.</li>
                    <li>Collaborate with teams to ensure secure software and infrastructure.</li>
                    <li>Document security policies, procedures, and incident reports.</li>
                </ul>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
