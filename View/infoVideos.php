<!DOCTYPE html>
<html lang="en">
<head>
    <title>Informational Videos</title>
    <style>
        body {
            background-color: #252525;
            font-family: Arial, sans-serif;
            color: white;
        }
        .standardTable {
            width: 80%;
            border: 1px solid #FF0000;
            border-radius: 20px;
            padding: 3%;
            background-color: #333333;
            margin: 10%;
            text-align: center;
        }
        .standardTable td {
            padding: 8px 10px;
            border: none;
        }
        .standardTable label {
            font-weight: normal;
            color: #fff;
        }
        .tips-button {
            background-color: #FF0000;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 70%;
        }
    </style>
</head>
<body>
    <a href="./home.php">
        <input type="button" value="Home" id="home" class="tips-button" style="position: absolute;left: 2%;top: 2%;width: 8%;">
    </a>
    <table class="standardTable" id="infoVideosTable">
        <tr>
            <td style="padding: 3%; background-color: red; color: azure; text-align: left;" colspan="2">
                <b>Career Informational Videos</b>
            </td>
        </tr>
    </table>
    <script>
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
        if (table) {
            addVideoRow("https://www.youtube.com/watch?v=Tt08KmFfIYQ", "Write an Incredible Resume: 5 Golden Rules!");
            addVideoRow("https://www.youtube.com/watch?v=rvKNhhhzkP8", "How to Drastically Improve Your RESUME with 3 SMALL Changes");
            addVideoRow("https://www.youtube.com/watch?v=8_ImWB1qMf8", "5 Things You Don't Need on Your Resume Anymore");
        }
    </script>
</body>
</html>
