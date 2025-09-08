let jobsApplied=5;
let upcomingInterviews=2;
let appsViewed=10;

let recentActivities=[
   "You applied for Web Developer at TechSoft",
    "Interview scheduled for June 5th at 2:00 PM",
    "Your application for Data Analyst was viewed"
];


document.getElementById("jobsAppliedCount").innerHTML=jobsApplied;
document.getElementById("interviewsCount").innerHTML=upcomingInterviews;
document.getElementById("viewsCount").innerHTML=appsViewed;

let activityList=document.getElementById("activityList");

activityList.innerHTML="";

for(let i=0;i<recentActivities.length;i++){
  activityList.innerHTML+= "<li>" + recentActivities[i] + "</li>";
}