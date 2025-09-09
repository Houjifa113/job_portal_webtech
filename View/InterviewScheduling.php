<?php
session_start();

if(!isset($_SESSION['status']) || !isset($_COOKIE['status'])){
    header('location: UserAuthetication.php?error=badrequest');
    exit();
}


if(isset($_REQUEST['error'])){
    $error=$_REQUEST['error'];
    if($error=='notimeselected'){
        echo"<p style='color:red;'>Please select a time slot.</p>";
}

elseif($error=='invalidtime'){
        echo"<p style='color:red;'>Invalid time selected. Please choose a valid time slot.</p>";
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
    <h1>Set Your Interview Availability</h1>
    <p>Select a time when you're available for an interview:</p>
    <form action="../Controllers/InterviewCheck.php" method="post" onsubmit="return  submitAvailability()">
        <div class="form-group">
    <select id="timeSelector" class="form-control" name="timeSlot">
        <option value="">-- Select a time --</option>
        <option value="9:00 AM">9:00 AM</option>
        <option value="10:00 AM">10:00 AM</option>
        <option value="11:00 AM">11:00 AM</option>
        <option value="12:00 PM">12:00 PM</option>
        <option value="1:00 PM">1:00 PM</option>
        <option value="2:00 PM">2:00 PM</option>
        <option value="3:00 PM">3:00 PM</option>
        <option value="4:00 PM">4:00 PM</option>
    </select>

    <span id="timeError" style="color: red;"></span>
</div>

    <br><br>
    <button type="submit" class="btn btn-success">Submit My Availability</button>
</form>

<?php if(isset($_REQUEST['success']) && $_REQUEST['success'] == 'scheduled'): ?>
    <div class="container" style="border: 2px solid green; padding: 20px; margin: 20px 0;">
        <h2 style="color: green;">✅ Availability Submitted Successfully!</h2>
        <p>You are available at: <strong><?php echo $_SESSION['scheduled_time']; ?></strong></p>
        <p>Employers will contact you at this time.</p>
        <a href="dashboard.php"><button class="btn">Back to Dashboard</button></a>
    </div>
    <?php endif; ?>

</div>

    
    </body>
    <script src="../Asset/InterviewScheduling.js"></script>
    </html>