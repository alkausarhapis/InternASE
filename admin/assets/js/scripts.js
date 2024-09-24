function selectRole(role) {
  sessionStorage.setItem("role", role);
  let targetPage = "";

  if (role === "admin") {
    targetPage = "admin-login.html";
  } else if (role === "mahasiswa") {
    targetPage = "mahasiswa-login.html";
  } else if (role === "dosen") {
    targetPage = "dosen-login.html";
  }

  if (targetPage) {
    window.location.href = targetPage;
  }
}

function toggleMenu() {
  console.log("Burger menu clicked"); // Debugging message
  const menu = document.getElementById("menu");
  if (menu.style.display === "block") {
    menu.style.display = "none";
  } else {
    menu.style.display = "block";
  }
}

// Set the account name and adjust the menu when the home page is loaded
window.onload = function () {
  // Update menu content based on role
  if (menu) {
    // Ensure menu exists before updating
    menu.innerHTML = `
                <img src="assets/img/logo.jpeg" alt="Advanced Software Engineering Laboratory" class="logo mx-auto d-block">
                <a href="../admin/index.php">Home</a>
                <a href="../admin/document.php">Document</a>
                <a href="../admin/agenda/index.php">Agenda</a>
                <a href="#jadwal-ruangan">Jadwal Ruangan</a>
                <a href="../admin/daftarAnggota.php">Data Anggota</a>
                <a href="../admin/inventaris.php">Inventaris</a>
                <a href="../admin/document.php">Daftar Pertemuan</a>
                <a href="../admin/user.php">Daftar User</a>
            `;
  } else {
    console.error("Menu element not found");
  }
};

// Example of fetching and loading navigation (if needed)
function loadNavigation(navFile) {
  fetch(navFile)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Failed to load ${navFile}: ${response.statusText}`);
      }
      return response.text();
    })
    .then((data) => {
      document.getElementById("menu").innerHTML = data;
    })
    .catch((error) => {
      console.error("Error fetching navigation:", error);
      alert("Error loading navigation. Please try again later.");
    });
}

function searchTable() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toLowerCase();
  const table = document.querySelector(".table tbody");
  const rows = table.querySelectorAll("tr");

  rows.forEach((row) => {
    const titleCell = row.querySelector("td strong");
    const titleText = titleCell ? titleCell.innerText.toLowerCase() : "";

    if (titleText.includes(filter)) {
      row.style.display = ""; // Show row
    } else {
      row.style.display = "none"; // Hide row
    }
  });
}

function copyLink() {
  // Get the text field
  var copyText = document.getElementById("meeting_link");

  // Select the text field

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  alert("Copied the text: " + copyText.value);
}
