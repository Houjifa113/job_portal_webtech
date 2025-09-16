<?php
session_start();
require_once '../Model/database.php';

// Check if user is logged in and is admin
if(!isset($_SESSION['status']) || $_SESSION['user_role'] != 'Admin'){
    die('Unauthorized access');
}

$export_type = $_POST['export_type'];
$export_format = $_POST['export_format'];

// Get current date for filename
$date = date('Y-m-d');

// Get data based on type
$data = array();
$filename = '';
$headers = array();

if($export_type == 'users') {
    $sql = "SELECT name, email, role, created_at FROM users ORDER BY created_at DESC";
    $headers = array('Name', 'Email', 'Role', 'Created Date');
    $filename = 'users_export_' . $date;
    
} elseif($export_type == 'jobs') {
    $sql = "SELECT j.title, u.name as company, j.location, j.salary, j.status, j.created_at 
           FROM jobs j 
           JOIN users u ON j.employer_id = u.id 
           ORDER BY j.created_at DESC";
    $headers = array('Job Title', 'Company', 'Location', 'Salary', 'Status', 'Posted Date');
    $filename = 'jobs_export_' . $date;
    
} elseif($export_type == 'applications') {
    $sql = "SELECT ja.id, u1.name as applicant, j.title as job_title, u2.name as company, ja.status, ja.applied_at 
           FROM job_applications ja
           JOIN users u1 ON ja.user_id = u1.id
           JOIN jobs j ON ja.job_id = j.id
           JOIN users u2 ON j.employer_id = u2.id
           ORDER BY ja.applied_at DESC";
    $headers = array('Application ID', 'Applicant', 'Job Title', 'Company', 'Status', 'Applied Date');
    $filename = 'applications_export_' . $date;
    
} elseif($export_type == 'logs') {
    $sql = "SELECT user_name, action, created_at FROM activity_logs ORDER BY created_at DESC";
    $headers = array('User', 'Action', 'Date & Time');
    $filename = 'activity_logs_export_' . $date;
}

// Execute query and get data
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Generate file based on format
if($export_format == 'excel') {
    // Create Excel file (actually tab-separated values)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    
    // Print headers
    echo implode("\t", $headers) . "\n";
    
    // Print data
    foreach($data as $row) {
        $row_values = array();
        foreach($row as $value) {
            $row_values[] = $value;
        }
        echo implode("\t", $row_values) . "\n";
    }
    
} elseif($export_format == 'pdf') {
    // Create HTML file that can be saved as PDF
    header('Content-Type: text/html');
    header('Content-Disposition: attachment; filename="' . $filename . '.html"');
    
    echo '<!DOCTYPE html>';
    echo '<html><head>';
    echo '<title>' . $filename . '</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; margin: 20px; }';
    echo 'h1 { color: #333; text-align: center; }';
    echo 'table { width: 100%; border-collapse: collapse; margin-top: 20px; }';
    echo 'th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }';
    echo 'th { background-color: #f2f2f2; font-weight: bold; }';
    echo 'tr:nth-child(even) { background-color: #f9f9f9; }';
    echo '</style>';
    echo '</head><body>';
    
    echo '<h1>' . strtoupper(str_replace('_', ' ', $export_type)) . ' EXPORT REPORT</h1>';
    echo '<p><strong>Generated on:</strong> ' . date('F j, Y \a\t g:i A') . '</p>';
    
    echo '<table>';
    echo '<thead><tr>';
    foreach($headers as $header) {
        echo '<th>' . $header . '</th>';
    }
    echo '</tr></thead>';
    
    echo '<tbody>';
    foreach($data as $row) {
        echo '<tr>';
        foreach($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    
    echo '<p style="margin-top: 30px; font-size: 12px; color: #666;">';
    echo 'Total Records: ' . count($data);
    echo '</p>';
    
    echo '</body></html>';
}

// Log the export activity
$log_sql = "INSERT INTO activity_logs (user_id, user_name, action) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_name']."', 'Exported $export_type data in $export_format format')";
mysqli_query($conn, $log_sql);

exit();
?>
