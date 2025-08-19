let table = document.getElementById("infoVideosTable");


let row1 = document.createElement("tr");
let cell1 = document.createElement("td");
let p1 = document.createElement("p");
let link1 = document.createElement("a");
link1.href = "https://www.youtube.com/watch?v=Tt08KmFfIYQ";
link1.className = "tips-button";
link1.innerText = "Write an Incredible Resume: 5 Golden Rules!";
cell1.appendChild(p1);
p1.appendChild(link1);
row1.appendChild(cell1);
table.appendChild(row1);

let row2 = document.createElement("tr");
let cell2 = document.createElement("td");
let p2 = document.createElement("p");
let link2 = document.createElement("a");
link2.href = "https://www.youtube.com/watch?v=rvKNhhhzkP8";
link2.className = "tips-button";
link2.innerText = "How to Drastically Improve Your RESUME with 3 SMALL Changes";
cell2.appendChild(p2);
p2.appendChild(link2);
row2.appendChild(cell2);
table.appendChild(row2);

let row3 = document.createElement("tr");
let cell3 = document.createElement("td");
let p3 = document.createElement("p");
let link3 = document.createElement("a");
link3.href = "https://www.youtube.com/watch?v=8_ImWB1qMf8";
link3.className = "tips-button";
link3.innerText = "5 Things You Don't Need on Your Resume Anymore";
cell3.appendChild(p3);
p3.appendChild(link3);
row3.appendChild(cell3);
table.appendChild(row3);
