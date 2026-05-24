<nav class="navbar navbar-expand-lg bg-light border border-bottom fixed-top">

    <img src="/Modern Student Portal/src/img/TRC_LOGO.png" alt="TRC_LOGO" style="width: 50px; cursor: pointer;" class="ms-3 d-none d-lg-block"
        onclick="window.location.href=`/Modern%20Student%20Portal/public/student/StudentDashboard.php`">

    <button class="navbar-toggler ms-3 border-primary" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="position-relative mx-auto" style="width: 45%;">

        <!-- Search Input -->
        <div class="input-group">
            <span class="input-group-text bg-light border rounded-start-pill">
                <i class="bi bi-search"></i>
            </span>
            <input
                type="text"
                class="form-control bg-light rounded-end-pill"
                placeholder="Search Teachers and People in your Department . . ."
                onkeyup="search_classmates(this.value)">
        </div>

        <!-- Dropdown Results -->
        <div class="dropdown-menu show w-lg-100 mt-2 border-0 rounded p-0" id="search_results">
            <!-- DYNAMIC LIST -->
        </div>

    </div>

    <div class="me-3 me-lg-5">
        <div class="h3 mt-2">
            <span id="hours">00</span>
            <span>:</span>
            <span id="minutes">00</span>
            <span id="session" style="font-size: 15px;">AM</span>
        </div>
    </div>

    <script>
        function getTime() {
            const date = new Date();
            let hour = date.getHours();
            let minute = date.getMinutes();

            const hoursDisplay = document.getElementById("hours");
            const minutesDisplay = document.getElementById("minutes");
            const sessionDisplay = document.getElementById("session");

            hoursDisplay.textContent = hour;
            minutesDisplay.textContent = minute;
            if (hour > 12) {
                sessionDisplay.textContent = "PM";
            }
        }
        setInterval(getTime, 1000);
    </script>

    <div class="me-4 h4 pt-2 text-primary d-none d-lg-flex">
        <i class="bi bi-primary-circle"></i>
    </div>

</nav>

<script>
    async function search_classmates(searchQueue) {

        const search_results = document.getElementById("search_results");

        search_results.innerHTML = `
            <div class="text-center text-muted p-5 rounded">
                Searching...
            </div>
        `;

        const searchQueueString = searchQueue || 'null';

        if (searchQueueString === 'null') {
            search_results.innerHTML = ``;
            return;
        }

        try {

            const res = await fetch(`./../../backend/studentSearchbar.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    searchQueueString: searchQueueString,
                }),
                credentials: "same-origin"
            });

            if (!res.ok) throw new Error("Network Response Error.");

            const data = await res.json();
            const data_length = Object.keys(data).length;

            if (data_length === 0) {
                search_results.innerHTML =
                    `
                <div class="text-center text-muted p-5 border rounded">
                No results found.
                </div>
                `;
                return;
            }

            const list = data.map(data => {

                let roleIcons = {
                    Teacher: '<i class="bi bi-eyeglasses text-success h2"></i>',
                    Student: '<i class="bi bi-person text-success h2"></i>',
                    Alumni: '<i class="bi bi-mortarboard text-primary h2"></i>',
                    Admin: '<i class="bi bi-shield text-info h2"></i>',
                };

                const roleIcon = roleIcons[data.role];

                return `
                <a href="/Modern%20Student%20Portal/public/student/viewProfile.php?user_id=${data.user_id}" class="dropdown-item d-flex align-items-center gap-2 rounded-3 py-2 border">
                    <img src="${data.profile_picture}" class="rounded-circle" width="35" height="35">
                        <div>
                            <div class="fw-semibold">${data.FirstName}, ${data.LastName}</div>
                            <small class="text-success">${data.Program}</small>
                        </div>
                       <div class="d-flex ms-auto d-none d-lg-flex">
                        <span class="ms-2">${roleIcon}</span>
                       </div>
                </a>
            `;
            }).join('');

            search_results.innerHTML = list;

        } catch (error) {} finally {

        }

    }
</script>