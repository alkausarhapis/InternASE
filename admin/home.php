<?php include('view/header.php') ?>
    <!-- Bagian 1 -->
    <div class="section-1">
        <h1>Welcome to Advanced Software Engineering Laboratory!</h1>
        <p>Your journey begins here.</p>
    </div>
    <div class="container mt-5">

        <!-- Bagian 2 -->
        <div class="section-2 container">
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <img src="assets/img/Rocket.png" alt="Vision Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="font-weight-bold">OUR VISION</h2>
                    <p>
                        Creating an atmosphere and an environment that are comfortable in RPLGDC Laboratorium, creating a more quality assured working conditions & events, working together as well as expanding the sphere of influence to other IF Faculty laboratoriums and other majors in other faculties, giving a qualified & capable human resources output that are needed in the IT World.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bagian 3 -->
        <div class="section-3 container">
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <h2 class="font-weight-bold">OUR MISSION</h2>
                    <ul>
                        <li>Creating a clean, fresh, and comfortable laboratorium environment.</li>
                        <li>Providing polished ‘quality-oriented’ laboratory work.</li>
                        <li>Fostering collaborations and workshops with other laboratories inside or outside of the IF Faculty.</li>
                        <li>Offering opportunities to learn, propose projects, and participate in brainstorming sessions to stimulate positive feedback in the IT World.</li>
                        <li>Encouraging other laboratories to achieve maximized performance through teamwork.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <img src="assets/img/Rocket.png" alt="Mission Image" class="img-fluid">
                </div>
            </div>
        </div>

        <!-- Bagian 4 -->
        <div class="section-4 container">
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <img src="assets/img/Rocket.png" alt="Member Benefit Image" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h2 class="font-weight-bold">MEMBER BENEFITS</h2>
                    <ul>
                        <li>Explore and learn new knowledge previously unknown.</li>
                        <li>Meet new bright minds with similar interests in software and/or game development.</li>
                        <li>Share knowledge with others inside or outside the laboratory environment.</li>
                        <li>Apply skills and knowledge to development projects.</li>
                        <li>Have a platform to implement software and/or game development skills.</li>
                        <li>Participate in a research group discussing the latest topics in software and/or game development.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/datatables-simple-demo.js"></script>
    <script>
        // Load the appropriate navigation file based on the user's role
        const role = sessionStorage.getItem('role');
        let navigationFile = '';

        if (role === 'admin') {
            navigationFile = 'navigasiadmin.html';
        } else if (role === 'mahasiswa') {
            navigationFile = 'navigasimahasiswa.html';
        } else if (role === 'dosen') {
            navigationFile = 'navigasidosen.html';
        }

        if (navigationFile) {
            fetch(navigationFile)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('nav-container').innerHTML = data;
                    // Reinitialize any JavaScript functionality for the navigation
                    const accountName = sessionStorage.getItem('username');
                    document.getElementById('accountName').textContent = accountName || "Guest";
                })
                .catch(error => console.error('Error loading navigation:', error));
        }
        
        // Load the footer
        fetch('navigasifooter.html')
            .then(response => response.text())
            .then(data => {
                 document.body.insertAdjacentHTML('beforeend', data);
            })
            .catch(error => console.error('Error loading footer:', error));
    </script>
</body>

</html>
