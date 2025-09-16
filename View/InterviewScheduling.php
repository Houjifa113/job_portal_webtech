<?php
session_start();
require_once('../Model/connection.php');
require_once('../Model/interviewModel.php');

if(!isset($_SESSION['user_id'])) {
    header('location: UserAuthetication.php?error=badrequest');
    exit();
}

$user_id = $_SESSION['user_id'];
$interviews = getInterviewsByUserId($user_id);


if(isset($_REQUEST['error'])){
    $error = $_REQUEST['error'];
    if($error == 'notimeselected'){
        echo "<p style='color:red;'>Please select a time slot.</p>";
    } elseif($error == 'dberror') {
        echo "<p style='color:red;'>Database error occurred.</p>";
    }
}

if(isset($_REQUEST['success'])){
    $success = $_REQUEST['success'];
    if($success == 'scheduled'){
        echo "<p style='color:green;'>Interview scheduled successfully!</p>";
    } elseif($success == 'updated') {
        echo "<p style='color:green;'>Interview updated successfully!</p>";
    } elseif($success == 'deleted') {
        echo "<p style='color:green;'>Interview deleted successfully!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Interview Scheduling</title>
    <link rel="stylesheet" href="../Asset/Khorshida.css">
</head>
<body>
<div class="container">
    <h1>Schedule Your Interview</h1>
    
    <!-- CREATE FORM -->
    <form onsubmit="return submitInterview()">
        <input type="hidden" name="action" value="create">
        
        <div class="form-group">
            <select name="timeSlot" id="timeSlot" class="form-control" required>
                <option value="">-- Select Time --</option>
                <option value="9:00 AM">9:00 AM</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="1:00 PM">1:00 PM</option>
                <option value="2:00 PM">2:00 PM</option>
                <option value="3:00 PM">3:00 PM</option>
                <option value="4:00 PM">4:00 PM</option>
            </select>
        </div>

        <div class="form-group">
            <input type="date" name="interviewDate" id="interviewDate" class="form-control" required 
                   min="<?php echo date('Y-m-d'); ?>">
        </div>

        <button type="submit" class="btn btn-success">Schedule Interview</button>
    </form>

    <h2>Your Scheduled Interviews</h2>
    <?php if(empty($interviews)): ?>
        <p>No interviews scheduled yet.</p>
    <?php else: ?>
        <?php foreach($interviews as $interview): ?>
        <div class="application-card">
            <h3>Interview #<?php echo $interview['id']; ?></h3>
            <p>Time: <?php echo $interview['scheduled_time']; ?></p>
            <p>Date: <?php echo $interview['scheduled_date']; ?></p>
            <p>Status: <?php echo $interview['status']; ?></p>
            
            <!-- UPDATE FORM -->
            <form action="../Controllers/interviewCheck.php" method="post" style="display: inline;">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $interview['id']; ?>">
                
                <select name="scheduled_time" class="form-control" required>
        <option value="9:00 AM" <?php if($interview['scheduled_time'] == '9:00 AM') echo 'selected'; ?>>9:00 AM</option>
        <option value="10:00 AM" <?php if($interview['scheduled_time'] == '10:00 AM') echo 'selected'; ?>>10:00 AM</option>
        <option value="11:00 AM" <?php if($interview['scheduled_time'] == '11:00 AM') echo 'selected'; ?>>11:00 AM</option>
        <option value="12:00 PM" <?php if($interview['scheduled_time'] == '12:00 PM') echo 'selected'; ?>>12:00 PM</option>
        <option value="1:00 PM" <?php if($interview['scheduled_time'] == '1:00 PM') echo 'selected'; ?>>1:00 PM</option>
        <option value="2:00 PM" <?php if($interview['scheduled_time'] == '2:00 PM') echo 'selected'; ?>>2:00 PM</option>
        <option value="3:00 PM" <?php if($interview['scheduled_time'] == '3:00 PM') echo 'selected'; ?>>3:00 PM</option>
        <option value="4:00 PM" <?php if($interview['scheduled_time'] == '4:00 PM') echo 'selected'; ?>>4:00 PM</option>
    </select>
                
                <input type="date" name="scheduled_date" value="<?php echo $interview['scheduled_date']; ?>" required>
                <button type="submit" class="btn">Update</button>
            </form>
            
           <form action="../Controllers/interviewCheck.php" method="post" style="display: inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $interview['id']; ?>">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this interview?')">Delete</button>
            </form>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>  
    
    <a href="dashboard.php"><button class="btn">Back to Dashboard</button></a>
</div>

<script>
function submitInterview() {

    // Get form values 
    let timeSlot = document.getElementById('timeSlot').value;
    let interviewDate = document.getElementById('interviewDate').value;
    
    
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../Controllers/interviewCheck.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("ajax=true&action=create&timeSlot=" + timeSlot + "&interviewDate=" + interviewDate);
    
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          

            let response = JSON.parse(this.responseText);
            
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert(response.error);
            }
        }
    };
    
    return false; // Prevent form submission
}
</script>
</body>
</html>