function toggleRefresh() {
  return true;
}
let searchHistory = [
  { JobTitle: "Software Engineer", Status: "Remote", Location: "Dhaka" },
  { JobTitle: "Data Scientist", Status: "Hybrid", Location: "Chattogram" },
  { JobTitle: "Product Manager", Status: "On-site", Location: "Khulna" },
];

let table = document.getElementById("searchHistoryTable");
if (table) {
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

    table.appendChild(row);
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
