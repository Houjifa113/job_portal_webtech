<?php
session_start();

// Job name
$job_name = 'network_engineer';


if (!isset($_SESSION['applied_jobs'])) {
    $_SESSION['applied_jobs'] = array();
}


$already_applied = in_array($job_name, $_SESSION['applied_jobs']);


if (isset($_GET['apply']) && !$already_applied) {
    $_SESSION['applied_jobs'][] = $job_name;
    $already_applied = true;
    $message = "You have successfully applied for Network Engineer!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Network Engineer</title>
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
    <div class="job-name">Network Engineer</div>
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
                <p>Experience: At least 3 years in network engineering</p>
                <p>Salary: Negotiable</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Minimum qualifications:</h2>
                <ul>
                    <li>Bachelor’s degree in Computer Science, IT, or related field.</li>
                    <li>Experience with network design, configuration, and troubleshooting.</li>
                    <li>Knowledge of LAN/WAN, routers, switches, firewalls, and protocols (TCP/IP, DNS, DHCP).</li>
                    <li>Familiarity with network monitoring and security tools.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Preferred qualifications:</h2>
                <ul>
                    <li>Certifications such as CCNA, CCNP, or equivalent.</li>
                    <li>Experience in cloud networking and hybrid network infrastructures.</li>
                    <li>Knowledge of network automation and scripting.</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                <h2>About the job:</h2>
                <p>The Network Engineer is responsible for designing, implementing, and maintaining robust network solutions for the organization. You will work with IT teams to ensure network reliability, security, and performance. The role includes troubleshooting network issues, deploying new network devices, and monitoring network health.</p>
            </td>
        </tr>
        <tr>
            <td>
                <h2>Responsibilities:</h2>
                <ul>
                    <li>Design, configure, and maintain enterprise networks.</li>
                    <li>Monitor network performance and troubleshoot issues.</li>
                    <li>Implement security measures, firewalls, and access controls.</li>
                    <li>Collaborate with IT and development teams on network requirements.</li>
                    <li>Document network configurations, processes, and changes.</li>
                </ul>
            </td>
        </tr>
    </table>
</form>

</body>
</html>
