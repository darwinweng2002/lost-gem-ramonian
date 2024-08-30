<!-- ======= Sidebar and Styling ======= -->
<style type="text/css">
/* Sidebar styling */
#side-nav-bar {
    position: fixed;
    left: -250px; /* Initially hide the sidebar */
    top: 0;
    width: 250px;
    height: 100%;
    background-color: #2c3e50; /* Dark background for a professional look */
    color: #ecf0f1; /* Light text color */
    transition: left 0.3s ease; /* Smooth transition */
    z-index: 9999; /* Make sure it's above other elements */
    overflow-y: auto;
    padding-top: 20px;
    box-shadow: 2px 0 5px rgba(0,0,0,0.5); /* Add subtle shadow */
}

/* Sidebar links */
#side-nav-bar ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

#side-nav-bar ul li {
    padding: 10px;
    border-bottom: 1px solid #34495e; /* Light border for separation */
}

#side-nav-bar ul li a {
    text-decoration: none;
    color: #ecf0f1; /* Match text color with the sidebar */
    display: block;
    font-size: 16px;
    transition: background-color 0.3s ease, padding-left 0.3s ease;
}

#side-nav-bar ul li a:hover {
    background-color: #34495e; /* Slightly lighter background on hover */
    padding-left: 20px; /* Indent the link on hover for a subtle effect */
}

/* Sidebar toggle button */
#sidebar-toggle-button {
    position: fixed;
    left: 0;
    top: 20px; /* Adjust to align with your design */
    background-color: #3498db; /* Professional color */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    z-index: 10000; /* Make sure it's above other elements */
}

#sidebar-toggle-button:hover {
    background-color: #2980b9; /* Darker shade on hover */
}

/* Responsive adjustments for sidebar */
@media (max-width: 800px) {
    #side-nav-bar {
        width: 50%; /* Adjust width for small screens */
        left: -100%; /* Initially hide the sidebar */
    }
    #sidebar-toggle-button {
        display: block;
    }
}
</style>

<!-- Toggle Button -->
<button id="sidebar-toggle-button">☰</button>

<!-- Sidebar -->
<div id="side-nav-bar">
    <ul>
        <br>
        <br>
        <li><a href="http://localhost/lostgemramonian/user_members/dashboard.php">Profile</a></li>
        <li><a href="<?= base_url.'?page=settings' ?>">Settings</a></li>
        <li><a href="<?= base_url.'?page=logout' ?>">Logout</a></li>
    </ul>
</div>

<!-- JavaScript to Toggle Sidebar -->
<script type="text/javascript">
document.getElementById('sidebar-toggle-button').addEventListener('click', function() {
    const sideNavBar = document.getElementById('side-nav-bar');
    if (sideNavBar.style.left === '0px') {
        sideNavBar.style.left = '-250px'; // Hide the sidebar
    } else {
        sideNavBar.style.left = '0'; // Show the sidebar
    }
});
</script>
