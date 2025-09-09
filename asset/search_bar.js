document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById('jobForm');
  const searchInput = document.getElementById('search');
  const preferenceSelect = document.getElementById('preference');

  function search_bar_validation() {
    const searchText = searchInput.value.trim();
    const errorSpan = document.getElementById('search_bar_error');
    if (!searchText) {
      errorSpan.innerText = 'Enter the job name';
      errorSpan.style.color = 'red';
      return false;
    }
    errorSpan.innerText = '';
    return true;
  }

  function preference_validation() {
    const preference = preferenceSelect.value;
    const errorSpan = document.getElementById('preference_error');
    if (!preference) {
      errorSpan.innerText = 'Select job type preference';
      errorSpan.style.color = 'red';
      return false;
    }
    errorSpan.innerText = '';
    return true;
  }

  function filterJobs() {
    const searchText = searchInput.value.toLowerCase().trim();
    const selectedPreference = preferenceSelect.value.toLowerCase();

    const allJobs = document.querySelectorAll('.job-item');
    allJobs.forEach(job => {
      const title = job.querySelector('a').textContent.toLowerCase();
      const status = job.querySelector('.job-status').textContent.toLowerCase();
      const matchesSearch = title.includes(searchText);
      const matchesPreference = !selectedPreference || status.includes(selectedPreference);
      job.style.display = (matchesSearch && matchesPreference) ? 'block' : 'none';
    });
  }

  function saveSearchToServer(searchText, status) {
    const fd = new FormData();
    fd.append('search', searchText);
    fd.append('preference', status);

    return fetch("../controller/save_search.php", {
      method: 'POST',
      body: fd
    })
    .then(response => response.text())
    .then(text => console.log('Search saved:', text))
    .catch(err => console.error('Failed to save search:', err));
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    if (!search_bar_validation() || !preference_validation()) return false;

    const searchText = searchInput.value.trim();
    const status = preferenceSelect.value;

    saveSearchToServer(searchText, status);
    filterJobs();
  });

  filterJobs();
});
