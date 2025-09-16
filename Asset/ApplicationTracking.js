let applications = [
    ["TechCorp", "Frontend Developer", "May 15, 2024", "Under Review"],
    ["DataSoft", "Data Analyst", "May 10, 2024", "Interview Scheduled"],
    ["WebSolutions", "Web Designer", "May 5, 2024", "Application Submitted"],
    ["CloudSystems", "DevOps Engineer", "April 28, 2024", "Rejected"]
];


function displayApplications() {
    let container = document.getElementById("applications-list");
    
   
    container.innerHTML = "";
    
    // Build HTML for each application
    for (let i = 0; i < applications.length; i++) {
       
        let company = applications[i][0];
        let position = applications[i][1];
        let date = applications[i][2];
        let status = applications[i][3];
        
       
        container.innerHTML += "<div class='application'>";
        container.innerHTML += "<h3>" + position + " at " + company + "</h3>";
        container.innerHTML += "<p>Applied on: " + date + "</p>";
        container.innerHTML += "<p>Status: <strong>" + status + "</strong></p>";
        container.innerHTML += "</div>";
    }
}


displayApplications();