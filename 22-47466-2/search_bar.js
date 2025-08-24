// Locations
let locations = [
  "Dhaka", "Chattogram", "Khulna", "Sylhet", "Rajshahi",
  "Barisal", "Rangpur", "Mymensingh", "Gazipur", "Narayanganj"
];

function getLocation() {
  return Math.random() < 0.6 ? "Dhaka" : locations[Math.floor(Math.random() * locations.length)];
}

// Random job status
let statuses = ["Remote", "Onsite", "Hybrid"];
function getJobStatus() {
  return statuses[Math.floor(Math.random() * statuses.length)];
}

// Validation
let search_bar_validation = () => {
  const search_bar = document.getElementById('search').value.trim();
  const search_bar_error = document.getElementById('search_bar_error');
  if (search_bar === '') {
    search_bar_error.innerHTML = 'Enter the company or job name';
    search_bar_error.style.color = 'red';
    return false;
  } else {
    search_bar_error.innerHTML = '';
    return true;
  }
};

let preference_validation = () => {
  const preference = document.getElementById('preference').value;
  const preference_error = document.getElementById('preference_error');
  if (preference === '') {
    preference_error.innerHTML = 'Select job type preference';
    preference_error.style.color = 'red';
    return false;
  } else {
    preference_error.innerHTML = '';
    return true;
  }
};

let validation = () => {
  if (!search_bar_validation() || !preference_validation()) return false;
  renderJobs(1); // show filtered jobs
  return false;  // prevent form reload
};

// Jobs array (50 jobs)
let jobs = [
  { title: "Software Engineer", link: "#", highlight: "Develop and maintain applications" },
  { title: "Hardware Engineer", link: "#", highlight: "Design and test computer hardware" },
  { title: "Systems Analyst", link: "#", highlight: "Analyze and improve IT systems" },
  { title: "Embedded Systems Engineer", link: "#", highlight: "Work with microcontrollers and devices" },
  { title: "Network Engineer", link: "#", highlight: "Design and manage network systems" },
  { title: "Cybersecurity Engineer", link: "#", highlight: "Protect systems from cyber threats" },
  { title: "AI/ML Engineer", link: "#", highlight: "Build machine learning models" },
  { title: "Database Administrator", link: "#", highlight: "Manage and secure databases" },
  { title: "Cloud Engineer", link: "#", highlight: "Deploy and manage cloud platforms" },
  { title: "DevOps Engineer", link: "#", highlight: "Automate software deployment" },
  { title: "Data Engineer", link: "#", highlight: "Build and maintain data pipelines" },
  { title: "Computer Vision Engineer", link: "#", highlight: "Implement computer vision algorithms" },
  { title: "Game Developer", link: "#", highlight: "Design and develop interactive games" },
  { title: "Mobile App Developer", link: "#", highlight: "Create applications for mobile platforms" },
  { title: "Full Stack Developer", link: "#", highlight: "Work on front-end and back-end" },
  { title: "Front-End Developer", link: "#", highlight: "Develop user interfaces" },
  { title: "Back-End Developer", link: "#", highlight: "Implement server-side logic" },
  { title: "Firmware Engineer", link: "#", highlight: "Write low-level embedded software" },
  { title: "IT Support Engineer", link: "#", highlight: "Provide technical support" },
  { title: "Computer Architect", link: "#", highlight: "Design CPU and system architectures" },
  { title: "Systems Administrator", link: "#", highlight: "Manage IT infrastructure" },
  { title: "Security Analyst", link: "#", highlight: "Monitor and protect systems" },
  { title: "Machine Learning Scientist", link: "#", highlight: "Research and develop ML models" },
  { title: "Blockchain Developer", link: "#", highlight: "Develop blockchain solutions" },
  { title: "Computer Hardware Designer", link: "#", highlight: "Design circuits and PCBs" },
  { title: "High Performance Computing Engineer", link: "#", highlight: "Optimize computing systems for performance" },
  { title: "Digital Design Engineer", link: "#", highlight: "Work on digital circuit design" },
  { title: "VLSI Engineer", link: "#", highlight: "Design very large-scale integrated circuits" },
  { title: "Robotics Engineer", link: "#", highlight: "Design and program robots" },
  { title: "Automation Engineer", link: "#", highlight: "Automate industrial processes" },
  { title: "AI Researcher", link: "#", highlight: "Research new AI algorithms" },
  { title: "Software Tester", link: "#", highlight: "Test software for bugs and quality" },
  { title: "QA Engineer", link: "#", highlight: "Ensure software quality standards" },
  { title: "Big Data Engineer", link: "#", highlight: "Process and manage large datasets" },
  { title: "Site Reliability Engineer", link: "#", highlight: "Ensure systems are reliable and scalable" },
  { title: "UI/UX Engineer", link: "#", highlight: "Design user-friendly interfaces" },
  { title: "Computer Science Lecturer", link: "#", highlight: "Teach computer science courses" },
  { title: "Research Scientist (CS)", link: "#", highlight: "Conduct computer science research" },
  { title: "Computer Network Architect", link: "#", highlight: "Design network infrastructures" },
  { title: "Parallel Computing Engineer", link: "#", highlight: "Develop parallel computing systems" },
  { title: "Operating Systems Developer", link: "#", highlight: "Develop and maintain OS kernels" },
  { title: "Compiler Engineer", link: "#", highlight: "Design and optimize compilers" },
  { title: "Cloud Security Engineer", link: "#", highlight: "Secure cloud infrastructures" },
  { title: "Application Developer", link: "#", highlight: "Build desktop and web applications" },
  { title: "Bioinformatics Software Engineer", link: "#", highlight: "Develop software for bioinformatics" },
  { title: "Augmented Reality Engineer", link: "#", highlight: "Build AR applications" },
  { title: "Virtual Reality Engineer", link: "#", highlight: "Develop VR experiences" },
  { title: "Edge Computing Engineer", link: "#", highlight: "Deploy computing at the edge" },
  { title: "Computer Graphics Engineer", link: "#", highlight: "Develop 3D graphics and rendering" },
  { title: "Quantum Computing Engineer", link: "#", highlight: "Research and build quantum systems" },
  { title: "Mobile Game Developer", link: "#", highlight: "Develop mobile-based games" },
  { title: "Embedded Software Developer", link: "#", highlight: "Write software for embedded devices" },
  { title: "IT Project Manager", link: "#", highlight: "Manage IT projects and teams" },
  { title: "Software Architect", link: "#", highlight: "Design high-level software solutions" },
  { title: "Network Security Specialist", link: "#", highlight: "Protect network infrastructures" }
];

// Assign random status to each job
jobs.forEach(job => { job.status = getJobStatus(); });

// Pagination
let currentPage = 1;
let jobsPerPage = 10;

function renderJobs(page) {
  let jobListDiv = document.getElementById('job_list');
  jobListDiv.innerHTML = "";

  const searchText = document.getElementById('search').value.trim().toLowerCase();
  const selectedPreference = document.getElementById('preference').value.toLowerCase();

  // Filter jobs by search text AND preference
  let filteredJobs = jobs.filter(job => {
    const matchesSearch = job.title.toLowerCase().includes(searchText);
    const matchesPreference = selectedPreference === "" || job.status.toLowerCase() === selectedPreference;
    return matchesSearch && matchesPreference;
  });

  let start = (page - 1) * jobsPerPage;
  let end = start + jobsPerPage;
  let paginatedJobs = filteredJobs.slice(start, end);

  paginatedJobs.forEach(job => {
    let jobContainer = document.createElement('div');
    jobContainer.classList.add("job-item");

    let jobLink = document.createElement('a');
    jobLink.href = job.link;
    jobLink.textContent = job.title;
    jobContainer.appendChild(jobLink);

    let highlight = document.createElement('p');
    highlight.textContent = job.highlight;
    highlight.classList.add("job-highlight");
    jobContainer.appendChild(highlight);

    let location = document.createElement('p');
    location.textContent = " Location: " + getLocation();
    location.classList.add("job-location");
    jobContainer.appendChild(location);

    let status = document.createElement('p');
    status.textContent = " Status: " + job.status;
    status.classList.add("job-status");
    jobContainer.appendChild(status);

    jobListDiv.appendChild(jobContainer);
  });

  renderPagination(filteredJobs.length);
}

function renderPagination(totalJobs) {
  let paginationDiv = document.getElementById('pagination');
  paginationDiv.innerHTML = "";

  let totalPages = Math.ceil(totalJobs / jobsPerPage);
  for (let i = 1; i <= totalPages; i++) {
    let pageLink = document.createElement('span');
    pageLink.textContent = i;
    pageLink.classList.add("page-link");
    if (i === currentPage) pageLink.classList.add("active");

    pageLink.onclick = function () {
      currentPage = i;
      renderJobs(currentPage);
    };
    paginationDiv.appendChild(pageLink);
  }
}

// Initial load
renderJobs(currentPage);
