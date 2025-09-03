 
        
        function submitAvailability() {
            let selectedTime = document.getElementById("timeSelector").value;
            
            if (selectedTime === "") {
                alert("Please select a time slot.");
                return;
            }
            
            // Show the selected time in confirmation message
            document.getElementById("selectedTime").innerHTML = selectedTime;
            document.getElementById("confirmation").style.display = "block";
            
            alert("Your availability has been submitted!");
        }
   


