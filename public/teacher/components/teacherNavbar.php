<nav class="navbar navbar-expand-lg bg-light border border-bottom fixed-top">

    <img src="/Modern Student Portal/src/img/TRC_LOGO.png" alt="TRC_LOGO" style="width: 50px;" class="ms-3 d-none d-lg-block">

    <button class="navbar-toggler ms-3 border-success" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="position-relative mx-auto" style="width: 40%;">

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
        <div class="dropdown-menu show w-100 mt-2 border-0 rounded p-0" id="search_results">
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

    <div class="me-3">
        <i class="bi bi-bell h4 text-success"></i>
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

            const res = await fetch(`./../backend/searchClassmates.php`, {
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
                return `
                <a href="#" class="dropdown-item d-flex align-items-center gap-2 rounded-3 py-2">
                    <img src="https://i.pravatar.cc/40?img=1" class="rounded-circle" width="35" height="35">
                        <div>
                            <div class="fw-semibold">${data.FirstName}</div>
                            <small class="text-success">${data.Program}</small>
                        </div>
                </a>
            `;
            }).join('');

            search_results.innerHTML = list;

        } catch (error) {} finally {

        }

    }
</script>