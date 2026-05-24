<div class="card shadow-sm border-0 rounded-4">

    <!-- Header -->
    <div class="card-header bg-success text-white border-0 p-4">
        <h4 class="mb-0 fw-bold">My Schedule</h4>
        <small><?= $row['Program'] ?> • Full Weekly Load</small>
    </div>

    <div class="card-body p-3">

        <!-- Tabs -->
        <ul class="nav nav-pills mb-3 gap-2" role="tablist">

            <li class="nav-item">
                <button class="nav-link active rounded-pill" data-bs-toggle="pill" data-bs-target="#mon">Mon</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#tue">Tue</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#wed">Wed</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#thu">Thu</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#fri">Fri</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#sat">Sat</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill" data-bs-toggle="pill" data-bs-target="#sun">Sun</button>
            </li>

        </ul>

        <!-- CONTENT -->
        <div class="tab-content">

            <!-- MONDAY -->
            <div class="tab-pane fade show active" id="mon">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Time</th>
                            <th>Subject</th>
                            <th>Room</th>
                            <th>Instructor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>8:00 - 9:30 AM</td>
                            <td>Web Development</td>
                            <td>Room 305</td>
                            <td>Prof. Elton</td>
                        </tr>
                        <tr>
                            <td>10:00 - 11:30 AM</td>
                            <td>Data Structures & Algorithms</td>
                            <td>Lab 204</td>
                            <td>Prof. Wala Umalis</td>
                        </tr>
                        <tr>
                            <td>1:00 - 2:30 PM</td>
                            <td>Computer Organization</td>
                            <td>Room 402</td>
                            <td>Prof. Dela Cruz</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- TUESDAY -->
            <div class="tab-pane fade" id="tue">
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr>
                            <td>8:00 - 10:00 AM</td>
                            <td>Database Systems</td>
                            <td>Lab 101</td>
                            <td>Prof. Ephraim</td>
                        </tr>
                        <tr>
                            <td>10:30 - 12:00 PM</td>
                            <td>Discrete Mathematics</td>
                            <td>Room 210</td>
                            <td>Prof. Lim</td>
                        </tr>
                        <tr>
                            <td>1:00 - 3:00 PM</td>
                            <td>HCI</td>
                            <td>Room 402</td>
                            <td>Prof. Cruz</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- WEDNESDAY -->
            <div class="tab-pane fade" id="wed">
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr>
                            <td>8:00 - 10:00 AM</td>
                            <td>Networking Fundamentals</td>
                            <td>Lab 303</td>
                            <td>Prof. Mia</td>
                        </tr>
                        <tr>
                            <td>10:30 - 12:00 PM</td>
                            <td>Programming Logic</td>
                            <td>Room 105</td>
                            <td>Prof. Aristotle</td>
                        </tr>
                        <tr>
                            <td>1:00 - 3:00 PM</td>
                            <td>Web Development Lab</td>
                            <td>Lab 204</td>
                            <td>Prof. Santos</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- THURSDAY -->
            <div class="tab-pane fade" id="thu">
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr>
                            <td>8:00 - 10:00 AM</td>
                            <td>Operating Systems</td>
                            <td>Room 310</td>
                            <td>Prof. Dela Cruz</td>
                        </tr>
                        <tr>
                            <td>10:30 - 12:00 PM</td>
                            <td>Software Engineering</td>
                            <td>Room 220</td>
                            <td>Prof. Gomez</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- FRIDAY -->
            <div class="tab-pane fade" id="fri">
                <table class="table table-hover align-middle">
                    <tbody>
                        <tr>
                            <td>8:00 - 10:00 AM</td>
                            <td>AI Fundamentals</td>
                            <td>Room 405</td>
                            <td>Prof. Tan</td>
                        </tr>
                        <tr>
                            <td>10:30 - 12:00 PM</td>
                            <td>Ethics in Computing</td>
                            <td>Room 101</td>
                            <td>Prof. Lim</td>
                        </tr>
                        <tr>
                            <td>1:00 - 3:00 PM</td>
                            <td>Capstone Prep</td>
                            <td>Lab 204</td>
                            <td>Prof. Reyes</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- SATURDAY -->
            <div class="tab-pane fade" id="sat">
                <div class="text-muted p-3">No regular classes. Optional review / group work day.</div>
            </div>

            <!-- SUNDAY -->
            <div class="tab-pane fade" id="sun">
                <div class="text-muted p-3">Rest day 🎉</div>
            </div>

        </div>

    </div>
</div>