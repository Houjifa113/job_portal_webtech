document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('jobForm');
  const searchInput = document.getElementById('search');
  const preferenceSelect = document.getElementById('preference');
  
  let currentPage = 1;
  const jobsPerPage = 10;

  function search_bar_validation() {
    const searchText = searchInput.value.trim();
    const errorSpan = document.getElementById('search_bar_error');
    if (!searchText) {
      errorSpan.innerHTML = "please type username first!";
      errorSpan.style.color = 'red';
      return false;
    }
    errorSpan.innerHTML = "";
    return true;
  }

  function preference_validation() {
    const preference = preferenceSelect.value;
    const errorSpan = document.getElementById('preference_error');
    if (!preference) {
      errorSpan.innerHTML = "Select job type preference";
      errorSpan.style.color = 'red';
      return false;
    }
    errorSpan.innerHTML = "";
    return true;
  }

  function saveSearchToServer(searchText, status) {
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../Controller/save_search.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log('Search saved:', this.responseText);
      }
    };
    
    xhttp.send('search=' + encodeURIComponent(searchText) + '&preference=' + encodeURIComponent(status));
  }

  function renderJobs(page) {
    const jobListDiv = document.getElementById('job_list');
    
  
    jobListDiv.innerHTML = '';

    const searchText = searchInput.value.trim().toLowerCase();
    const selectedPreference = preferenceSelect.value.toLowerCase();

    const filteredJobs = jobs.filter(job => {
      const matchesSearch = job.title.toLowerCase().includes(searchText);
      const matchesPreference = !selectedPreference || job.status.toLowerCase() === selectedPreference;
      return matchesSearch && matchesPreference;
    });

    const start = (page - 1) * jobsPerPage;
    const end = start + jobsPerPage;
    const paginatedJobs = filteredJobs.slice(start, end);

    if (paginatedJobs.length === 0) {
      jobListDiv.innerHTML = "<p>No jobs found.</p>";
    } else {
      let jobsHTML = '';
      paginatedJobs.forEach(job => {
        jobsHTML += '<div class="job-item">';
        jobsHTML += '<a href="' + job.link + '" target="_self">' + job.title + '</a>';
        jobsHTML += '<p class="job-highlight">' + job.highlight + '</p>';
        jobsHTML += '<p class="job-location">Location: ' + job.location + '</p>';
        jobsHTML += '<p class="job-status">Type: ' + job.status + '</p>';
        jobsHTML += '</div>';
      });
      jobListDiv.innerHTML = jobsHTML;
    }

    renderPagination(filteredJobs.length, page);
  }

  function renderPagination(totalJobs, currentPage) {
    const paginationDiv = document.getElementById('pagination');
    const totalPages = Math.ceil(totalJobs / jobsPerPage);
    
   
    paginationDiv.innerHTML = '';
    
    let paginationHTML = '';
    
    
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            paginationHTML += '<span class="page-link active" onclick="changePage(' + i + ')">' + i + '</span> ';
        } else {
            paginationHTML += '<span class="page-link" onclick="changePage(' + i + ')">' + i + '</span> ';
        }
    }
    
    paginationDiv.innerHTML = paginationHTML;
  }

 
  function changePage(pageNumber) {
    currentPage = pageNumber;
    renderJobs(currentPage);
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (!search_bar_validation() || !preference_validation()) return false;

    const searchText = searchInput.value.trim();
    const status = preferenceSelect.value;

    saveSearchToServer(searchText, status);
    currentPage = 1;
    renderJobs(currentPage);
  });

 
  renderJobs(currentPage);
});