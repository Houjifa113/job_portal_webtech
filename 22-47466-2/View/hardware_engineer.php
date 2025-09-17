<?php
session_start();
require_once('../Model/dbConnection.php'); 

$conn = getConnection();

r
$user_id = $_SESSION['user_id'] ?? 1;
$job_name = 'Hardware Engineer';


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_job'])) {
    
    $stmt = $conn->prepare("SELECT id FROM apply_history WHERE user_id = ? AND jobname = ? LIMIT 1");
    $stmt->bind_param("is", $user_id, $job_name);
    $stmt->execute();
    $stmt->store_result();
    $already_applied = $stmt->num_rows > 0;
    $stmt->close();

    if ($already_applied) {
        $message = "You have already applied for Hardware Engineer.";
    } else {
        $stmt = $conn->prepare("INSERT INTO apply_history (user_id, jobname, apply_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("is", $user_id, $job_name);
        if ($stmt->execute()) {
            $message = "Application saved successfully!";
        } else {
            $message = "Error saving application.";
        }
        $stmt->close();
    }
}


$stmt = $conn->prepare("SELECT id FROM apply_history WHERE user_id = ? AND jobname = ? LIMIT 1");
$stmt->bind_param("is", $user_id, $job_name);
$stmt->execute();
$stmt->store_result();
$already_applied = $stmt->num_rows > 0;
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hardware Engineer</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f7f9fc; color: #333; }
.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.job-name { font-size: 28px; font-weight: bold; color: #2c3e50; }
.apply-btn { background-color: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
.apply-btn:disabled { background-color: gray; cursor: not-allowed; }
.message { margin-bottom: 20px; color: #2980b9; font-weight: bold; }
table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; margin-bottom: 20px; }
td { padding: 15px; vertical-align: top; }
h2 { margin-bottom: 10px; color: #34495e; }
ul { margin-top: 0; padding-left: 20px; }
a { text-decoration: none; color: #fff; background: #2980b9; padding: 10px 15px; border-radius: 5px; }
a:hover { background: #1f618d; }
</style>
</head>
<body>

<div class="header">
    <div class="job-name">Hardware Engineer</div>
    <div>
        <?php if (!$already_applied): ?>
            <form method="POST" action="" style="display:inline;">
                <input type="hidden" name="apply_job" value="1">
                <button type="submit" class="apply-btn">Apply</button>
            </form>
        <?php else: ?>
            <button class="apply-btn" disabled>Already Applied</button>
        <?php endif; ?>
        <a href="applyHistory.php" style="margin-left: 15px;">Apply History</a>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="message"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<table>
    <tr>
        <td>
            <h2>Summary:</h2>
            <p>Age: 26 to 42 years</p>
            <p>Experience: At least 3 years in hardware design or testing</p>
            <p>Salary: Negotiable</p>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Minimum qualifications:</h2>
            <ul>
                <li>Bachelor’s degree in Electrical Engineering, Computer Engineering, or related field.</li>
                <li>Experience in hardware circuit design, testing, and debugging.</li>
                <li>Knowledge of microprocessors, digital/analog circuits, and embedded systems.</li>
                <li>Familiarity with CAD tools for PCB design and simulation.</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Preferred qualifications:</h2>
            <ul>
                <li>Master’s degree in Electronics or related technical field.</li>
                <li>Experience with FPGA, ASIC design, or VLSI technologies.</li>
                <li>Knowledge of hardware security, performance optimization, and low-power design.</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <h2>About the job:</h2>
            <p>The Hardware Engineer will be responsible for designing, testing, and maintaining computer hardware components such as processors, circuit boards, memory devices, and routers. You will work closely with cross-functional teams to ensure the integration of hardware and software solutions while meeting performance, cost, and reliability requirements.</p>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Responsibilities:</h2>
            <ul>
                <li>Design, develop, and test hardware components and systems.</li>
                <li>Collaborate with software and manufacturing teams to optimize performance.</li>
                <li>Perform debugging, troubleshooting, and performance analysis.</li>
                <li>Ensure compliance with safety, quality, and industry standards.</li>
                <li>Document design processes, test results, and technical specifications.</li>
            </ul>
        </td>
    </tr>
</table>

</body>
</html>
