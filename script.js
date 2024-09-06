function selectRole(role) {
    sessionStorage.setItem('role', role);
    let targetPage = '';

    if (role === 'admin') {
        targetPage = 'admin-login.html';
    } else if (role === 'mahasiswa') {
        targetPage = 'mahasiswa-login.html';
    } else if (role === 'dosen') {
        targetPage = 'dosen-login.html';
    }

    if (targetPage) {
        window.location.href = targetPage;
    }
}

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username && password) {
        // Simulate a successful login
        sessionStorage.setItem('username', username); // Store username in session storage
        window.location.href = 'home.html'; // Redirect to home page after login
    } else {
        alert('Please enter both username and password');
    }
}

function toggleMenu() {
    console.log("Burger menu clicked"); // Debugging message
    const menu = document.getElementById('menu');
    if (menu.style.display === 'block') {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
}

// Set the account name and adjust the menu when the home page is loaded
window.onload = function() {
    const accountName = sessionStorage.getItem('username');
    const role = sessionStorage.getItem('role');
    const menu = document.getElementById('menu');

    console.log('Role:', role); // Debugging log
    console.log('Username:', accountName); // Debugging log

    if (accountName) {
        document.getElementById('accountName').textContent = accountName;
    } else {
        document.getElementById('accountName').textContent = "Guest";
    }

    // Update menu content based on role
    if (menu) {  // Ensure menu exists before updating
        if (role === 'admin') {
            menu.innerHTML = `
                <a href="#home">Home</a>
                <a href="#dokumen">Dokumen</a>
                <a href="#agenda">Agenda</a>
                <a href="#jadwal-ruangan">Jadwal Ruangan</a>
                <a href="#data-anggota">Data Anggota</a>
                <a href="#inventaris">Inventaris</a>
                <a href="#daftar-pertemuan">Daftar Pertemuan</a>
            `;
        } else if (role === 'mahasiswa' || role === 'dosen') {
            menu.innerHTML = `
                <a href="#home">Home</a>
                <a href="#dokumen">Dokumen</a>
                <a href="#jadwal-ruangan">Jadwal Ruangan</a>
            `;
        } else {
            console.error('Unrecognized role:', role); // Debugging log
        }
    } else {
        console.error('Menu element not found');
    }
};

// Example of fetching and loading navigation (if needed)
function loadNavigation(navFile) {
    fetch(navFile)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load ${navFile}: ${response.statusText}`);
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('menu').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching navigation:', error);
            alert('Error loading navigation. Please try again later.');
        });
}

function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.querySelector('.table tbody');
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const titleCell = row.querySelector('td strong');
        const titleText = titleCell ? titleCell.innerText.toLowerCase() : '';
        
        if (titleText.includes(filter)) {
            row.style.display = '';  // Show row
        } else {
            row.style.display = 'none';  // Hide row
        }
    });
}