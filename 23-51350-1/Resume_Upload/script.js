function resumeUpload()
{
    let fileInput = document.getElementById('resumeFile');
    if (fileInput.files.length === 0) {
        alert("Please select a file to upload.");
        return false;
    }
    return true;
}