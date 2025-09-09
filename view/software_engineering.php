<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$database = "applyhistory";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$job_name = 'software_engineer';


$stmt = $conn->prepare("SELECT * FROM applyhistory WHERE jobname = ?");
$stmt->bind_param("s", $job_name);
$stmt->execute();
$stmt->store_result();
$already_applied = $stmt->num_rows > 0;
$stmt->close();


$message = '';
if ($already_applied) {
    $message = "You have already applied for Software Engineer.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Software Engineer</title>
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
    <div class="job-name">Software Engineer</div>
    <div>
        <?php if (!$already_applied): ?>
            <form method="POST" action="../controller/apply.php" style="display:inline;">
                <input type="hidden" name="job" value="<?php echo $job_name; ?>">
                <input type="hidden" name="redirect" value="software_engineering.php">
                <button type="submit" class="apply-btn">Apply</button>
            </form>
        <?php else: ?>
            <button class="apply-btn" disabled>Already Applied</button>
        <?php endif; ?>
        <a href="apply_history.php" style="margin-left: 15px;">Apply History</a>
    </div>
</div>

<?php if (!empty($message)): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<table>
    <tr>
        <td>
            <h2>Summary:</h2>
            <p>Age: 30 to 42 years</p>
            <p>Experience: At least 5 years</p>
            <p>Salary: Negotiable</p>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Minimum qualifications:</h2>
            <ul>
                <li>Bachelor's degree or equivalent practical experience.</li>
                <li>2 years of experience with software development in C++, or 1 year of experience with an advanced degree.</li>
                <li>2 years of experience with data structures or algorithms.</li>
                <li>2 years of experience in data analysis with experience in SQL.</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Preferred qualifications:</h2>
            <ul>
                <li>Master's degree or PhD in Computer Science or a related technical field.</li>
                <li>Experience in developing accessible technologies.</li>
                <li>Experience in data analysis, problem-solving, machine learning, A/B testing.</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>
            <h2>About the job:</h2>
            <p>Google's software engineers develop the next-generation technologies that change how billions of users connect, explore, and interact with information and one another. Our products need to handle information at massive scale, and extend well beyond web search. We're looking for engineers who bring fresh ideas from all areas...</p>
        </td>
    </tr>
    <tr>
        <td>
            <h2>Responsibilities:</h2>
            <ul>
                <li>Write product or system development code.</li>
                <li>Participate in or lead design reviews with peers and stakeholders to decide amongst available technologies.</li>
                <li>Review code developed by other developers and provide feedback to ensure best practices.</li>
                <li>Contribute to existing documentation or educational content and adapt content based on product/program updates and user feedback.</li>
                <li>Triage product or system issues and debug/track/resolve by analyzing sources of issues and the impact on hardware, network, or service operations.</li>
            </ul>
        </td>
    </tr>
</table>

</body>
</html>
