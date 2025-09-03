let table = document.getElementById("infoVideosTable");

function addVideoRow(videoUrl, title) {
    let rowVideo = document.createElement("tr");
    let cellVideo = document.createElement("td");
    let iframe = document.createElement("iframe");
    iframe.width = "560"; 
    iframe.height = "315"; 
    iframe.src = videoUrl.replace("watch?v=", "embed/");
    iframe.allowFullscreen = true;
    cellVideo.appendChild(iframe);
    rowVideo.appendChild(cellVideo);
    table.appendChild(rowVideo);

    let rowTitle = document.createElement("tr");
    let cellTitle = document.createElement("td");
    let p = document.createElement("p");
    p.innerHTML = "<b>" + title + "</b>";
    cellTitle.appendChild(p);
    rowTitle.appendChild(cellTitle);
    table.appendChild(rowTitle);
}
if(table){
addVideoRow("https://www.youtube.com/watch?v=Tt08KmFfIYQ", "Write an Incredible Resume: 5 Golden Rules!");
addVideoRow("https://www.youtube.com/watch?v=rvKNhhhzkP8", "How to Drastically Improve Your RESUME with 3 SMALL Changes");
addVideoRow("https://www.youtube.com/watch?v=8_ImWB1qMf8", "5 Things You Don't Need on Your Resume Anymore");
}

function toggleRefresh() {
  return true;
}
let searchHistory = [
  { JobTitle: "Software Engineer", Status: "Remote", Location: "Dhaka" },
  { JobTitle: "Data Scientist", Status: "Hybrid", Location: "Chattogram" },
  { JobTitle: "Product Manager", Status: "On-site", Location: "Khulna" },
];

let table1 = document.getElementById("searchHistoryTable");
if (table1) {
  for (let i = 0; i < searchHistory.length; i++) {
    let row = document.createElement("tr");

    let jobTitleTd = document.createElement("td");
    jobTitleTd.colSpan = 2;
    jobTitleTd.textContent = searchHistory[i]["JobTitle"];
    row.appendChild(jobTitleTd);

    let statusTd = document.createElement("td");
    statusTd.textContent = searchHistory[i]["Status"];
    row.appendChild(statusTd);

    let locationTd = document.createElement("td");
    locationTd.textContent = searchHistory[i]["Location"];
    row.appendChild(locationTd);

    let goToTd = document.createElement("td");
    let btn = document.createElement("button");
    btn.textContent = "Click here";
    btn.className = "search-button";

    let url = "/searchBar.html?";
    url += "JobTitle=" + searchHistory[i]["JobTitle"];
    url += "&Status=" + searchHistory[i]["Status"];
    url += "&Location=" + searchHistory[i]["Location"];

    let link = document.createElement("a");
    link.href = url;
    link.appendChild(btn);

    goToTd.appendChild(link);
    row.appendChild(goToTd);

    table1.appendChild(row);
  }
}
let table2 = document.getElementById("queryManagerTable");

if (table2) {
  for (let i = 0; i < searchHistory.length; i++) {
    let row = document.createElement("tr");

    let jobTitleTd = document.createElement("td");
    jobTitleTd.style.padding = "1%";
    jobTitleTd.style.color = "azure";
    jobTitleTd.style.textAlign = "center";
    jobTitleTd.colSpan = 2;
    jobTitleTd.textContent = searchHistory[i]["JobTitle"];
    row.appendChild(jobTitleTd);

    let statusTd = document.createElement("td");
    statusTd.textContent = searchHistory[i]["Status"];
    row.appendChild(statusTd);

    let locationTd = document.createElement("td");
    locationTd.textContent = searchHistory[i]["Location"];
    row.appendChild(locationTd);

    let goToTd = document.createElement("td");
    let btn = document.createElement("button");
    btn.textContent = "Click here";
    btn.className = "search-button";

    let url = "/searchBar.html?";
    url += "JobTitle=" + searchHistory[i]["JobTitle"];
    url += "&Status=" + searchHistory[i]["Status"];
    url += "&Location=" + searchHistory[i]["Location"];

    let link = document.createElement("a");
    link.href = url;
    link.appendChild(btn);

    goToTd.appendChild(link);
    row.appendChild(goToTd);

    let deleteTd = document.createElement("td");
    let deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.className = "search-button";
    deleteBtn.onclick = function () {
      table2.removeChild(row);
      searchHistory.splice(i, 1);
    };
    deleteTd.appendChild(deleteBtn);
    row.appendChild(deleteTd);

    table2.appendChild(row);
  }
}
