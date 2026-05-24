     <aside id="sidebar" style="position: fixed; height:100vh;">
         <div class="d-flex">
             <button id="toggle-btn">
                 <i class="bi bi-grid"></i>
             </button>
             <div class="sidebar-logo">
                 <a href="#">Welcome, <?= $_SESSION['account_username'] ?? '' ?>!</a>
             </div>
         </div>

         <ul class="sidebar-nav">

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/AdminDashboard.php" class="sidebar-link">
                     <i class="bi bi-house"></i>
                     <span>Dashboard</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/VerifyUsers.php" class="sidebar-link">
                     <i class="bi bi-check2"></i>
                     <span>Verify Users</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/DeniedStudents.php" class="sidebar-link">
                     <i class="bi bi-archive"></i>
                     <span>Deleted Users</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/UserManagement.php" class="sidebar-link">
                     <i class="bi bi-people"></i>
                     <span>User Management</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/TeacherManagement.php" class="sidebar-link">
                     <i class="bi bi-eyeglasses"></i>
                     <span>Manage Teachers</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/Content&Posts.php" class="sidebar-link">
                     <i class="bi bi-megaphone"></i>
                     <span>Posts & Announcements</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a href="/Modern Student Portal/public/admin/Pages/SetEvent.php" class="sidebar-link">
                     <i class="bi bi-calendar"></i>
                     <span>Event Calendar</span>
                 </a>
             </li>

             <li class="navbar-item">
                 <a onclick="logoutConfirmation()" class="sidebar-link">
                     <i class="bi bi-box-arrow-left"></i>
                     <span>Logout</span>
                 </a>
             </li>

         </ul>

     </aside>

     <script>
         function logoutConfirmation() {
             Swal.fire({
                 title: "Log out Confirmation",
                 text: "Are you sure you want to Log out?",
                 icon: "warning",
                 showCancelButton: true,
                 confirmButtonColor: "#d33",
                 cancelButtonColor: "#3085d6",
                 cancelButtonText: "I will stay",
                 confirmButtonText: "Let me out!"
             }).then((result) => {
                 if (result.isConfirmed) {
                     window.location.href = "/Modern%20Student%20Portal/public/backend/logout.php";
                 }
             });

         }
     </script>