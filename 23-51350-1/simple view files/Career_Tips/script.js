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

addVideoRow("https://www.youtube.com/watch?v=Tt08KmFfIYQ", "Write an Incredible Resume: 5 Golden Rules!");
addVideoRow("https://www.youtube.com/watch?v=rvKNhhhzkP8", "How to Drastically Improve Your RESUME with 3 SMALL Changes");
addVideoRow("https://www.youtube.com/watch?v=8_ImWB1qMf8", "5 Things You Don't Need on Your Resume Anymore");
