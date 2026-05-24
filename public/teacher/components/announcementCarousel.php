 <?php
    $time = date("Y-m-d");

    try {
        $stmt = $conn->prepare("SELECT * FROM broadcasts WHERE expires_at > ?");
        $stmt->bind_param("s", $time);
        $stmt->execute();
    } catch (Exception $e) {
    }
    $result = $stmt->get_result();
    ?>

 <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
     <div class="carousel-inner">
         <div class="carousel-item active mb-2">
             <div class="card bg-success text-light" style="width:100%">
                 <div class="card-body text-center">
                     <h5 class="card-title">
                         <span class="timeEmojis">1</span>
                         <span id="greet"></span> <?= htmlspecialchars($_SESSION['account_username']) ?>
                         <span class="timeEmojis">2</span>
                     </h5>
                     <p class="card-text">Here are some Announcements for you this<span id="timeOfDay"></span></p>
                 </div>
             </div>
         </div>
         <?php while ($row = $result->fetch_assoc()) { ?>
             <div class="carousel-item mb-2">
                 <div class="card <?= htmlspecialchars($row['theme_color']) ?>" style="width:100%">
                     <div class="card-body">
                         <h5 class="card-title text-center">
                             📢 <?= htmlspecialchars($row['title']) ?>!
                         </h5>
                         <p class="card-text text-center"><?= $row['announcement_message'] ?></p>
                     </div>
                 </div>
             </div>
         <?php } ?>
     </div>
 </div>

 <script>
     const date = new Date();
     const hour = date.getHours();

     const greet = document.getElementById("greet");
     const timeEmojis = document.querySelectorAll(".timeEmojis");
     const timeOfDay = document.getElementById("timeOfDay");

     if (hour < 12) { // GREET THE USER DEPENDING ON WHAT TIME IT IS
         timeEmojis.forEach(el => {
             el.innerHTML = '🌅 🌅';
         });

         greet.innerHTML = 'Good Morning!';
         timeOfDay.innerHTML = ' morning';
     } else if (hour < 18) {
         timeEmojis.forEach(el => {
             el.innerHTML = '🌇 🌇';
         });

         greet.innerHTML = 'Good Afternoon';
         timeOfDay.innerHTML = ' afternoon';
     } else if (hour <= 23) {
         timeEmojis.forEach(el => {
             el.innerHTML = '🌃 🌃';
         });

         greet.innerHTML = 'Good Evening';
         timeOfDay.innerHTML = ' evening!';
     }
 </script>