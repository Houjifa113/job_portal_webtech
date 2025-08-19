function resumeUpload()
{
    let fileInput = document.getElementById('resumeFile');
    let fileError= document.getElementById('resumeFileError');
    if (fileInput.files.length === 0) {
        fileError.innerHTML = "Please select a file to upload!";
        fileError.style.color = "red";
        return false;
    }
    let fileName = document.getElementById('resumeFile').value;
    let fileExtension = fileName.split('.');
    fileExtension = fileExtension[fileExtension.length - 1].toLowerCase();
    if (fileExtension !== 'pdf' && fileExtension !== 'docx') {
        fileError.innerHTML = "Please select PDF or DOC!";
        fileError.style.color = "red";
        return false;
    }
    return true;
}