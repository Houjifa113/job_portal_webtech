document.addEventListener("DOMContentLoaded", function() {

  const locations = ["Dhaka", "Chattogram", "Khulna", "Sylhet", "Rajshahi", "Barisal", "Rangpur", "Mymensingh", "Gazipur", "Narayanganj"];
  function getLocation() {
    return Math.random() < 0.6 ? "Dhaka" : locations[Math.floor(Math.random() * locations.length)];
  }

  
  const statuses = ["Remote", "Onsite", "Hybrid"];
  function getJobStatus() {
    return statuses[Math.floor(Math.random() * statuses.length)];
  }


  function search_bar_validation() {
    const search_bar = document.getElementById('search').value.trim();
    const search_bar_error = document.getElementById('search_bar_error');
    if (!search_bar) {
      search_bar_error.innerHTML = 'Enter the job name';
      search_bar_error.style.color = 'red';
      return false;
    }
    search_bar_error.innerHTML = '';
    return true;
  }

  function preference_validation() {
    const preference = document.getElementById('preference').value;
    const preference_error = document.getElementById('preference_error');
    if (!preference) {
      preference_error.innerHTML = 'Select job type preference';
      preference_error.style.color = 'red';
      return false;
    }
    preference_error.innerHTML = '';
    return true;
  }

  const jobs = [
    { title: "Software Engineer", link: "software_engineering.html", highlight: "Develop and maintain applications" },
    { title: "Hardware Engineer", link: "hardware_engineer.html", highlight: "Design and test computer hardware" },
    { title: "Systems Analyst", link: "system_analyst.html", highlight: "Analyze and improve IT systems" },
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

  jobs.forEach(job => { job.status = getJobStatus(); });

  let currentPage = 1;
  const jobsPerPage = 10;

  function renderJobs(page) {
    const jobListDiv = document.getElementById('job_list');
    jobListDiv.innerHTML = '';

    const searchText = document.getElementById('search').value.trim().toLowerCase();
    const selectedPreference = document.getElementById('preference').value.toLowerCase();

    const filteredJobs = jobs.filter(job => {
      const matchesSearch = job.title.toLowerCase().includes(searchText);
      const matchesPreference = !selectedPreference || job.status.toLowerCase() === selectedPreference;
      return matchesSearch && matchesPreference;
    });

    const start = (page - 1) * jobsPerPage;
    const end = start + jobsPerPage;
    const paginatedJobs = filteredJobs.slice(start, end);

    paginatedJobs.forEach(job => {
      const jobContainer = document.createElement("div");
      jobContainer.classList.add("job-item");

      const jobLink = document.createElement("a");
      jobLink.href = job.link;
      jobLink.textContent = job.title;

      if (job.title === "Software Engineer") jobLink.target = "_blank";

      jobContainer.appendChild(jobLink);

      const highlight = document.createElement("p");
      highlight.textContent = job.highlight;
      highlight.classList.add("job-highlight");
      jobContainer.appendChild(highlight);

      const location = document.createElement("p");
      location.textContent = " Location: " + getLocation();
      location.classList.add("job-location");
      jobContainer.appendChild(location);

      const status = document.createElement("p");
      status.textContent = " Status: " + job.status;
      status.classList.add("job-status");
      jobContainer.appendChild(status);

      jobListDiv.appendChild(jobContainer);
    });

    renderPagination(filteredJobs.length);
  }

  function renderPagination(totalJobs) {
    const paginationDiv = document.getElementById('pagination');
    paginationDiv.innerHTML = '';

    const totalPages = Math.ceil(totalJobs / jobsPerPage);
    for (let i = 1; i <= totalPages; i++) {
      const pageLink = document.createElement("span");
      pageLink.textContent = i;
      pageLink.classList.add("page-link");
      if (i === currentPage) pageLink.classList.add("active");

      pageLink.addEventListener("click", function() {
        currentPage = i;
        renderJobs(currentPage);
      });

      paginationDiv.appendChild(pageLink);
    }
  }


  document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();
    if (!search_bar_validation() || !preference_validation()) return false;
    currentPage = 1;
    renderJobs(currentPage);
  });


  renderJobs(currentPage);

});
