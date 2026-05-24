 <?php
    try {
        $user_id = $_SESSION['user_id']; //  SHOW POST LIKES
        $status = 'Published';
        $stmt = $conn->prepare("SELECT 
                                        p.post_id,
                                        p.post_title,
                                        p.posted_by,
                                        p.post_caption,
                                        p.image_src,
                                        p.post_date,
                                        COUNT(l.post_id) AS likeCount,
                                        COUNT(l.post_id) AS commentCount,
                                        MAX(CASE WHEN l.user_id = ? THEN 1 ELSE 0 END) AS isLiked
                                FROM posts p
                                LEFT JOIN likes l ON p.post_id = l.post_id
                                WHERE p.status = ?
                                GROUP BY p.post_id ORDER BY p.post_id DESC");
        $stmt->bind_param("is", $user_id, $status);
        $stmt->execute();
    } catch (Exception $e) {
    }
    $result = $stmt->get_result();
    ?>
 <div class="overflow-auto bg-light rounded pt-3" style="max-height: 80.8vh;">
     <?php while ($row = $result->fetch_assoc()) { ?>

         <div class="card border shadow-sm content-card mx-auto mb-5" id="posts_wrapper">

             <div class="card-body">

                 <!-- HEADER -->
                 <div class="d-flex align-items-center mb-2">
                     <div>
                         <h6 class="mb-0 fw-semibold"><?= htmlspecialchars($row['post_title']) ?></h6>
                         <small class="text-muted">
                             By <?= htmlspecialchars($row['posted_by']) ?> • <?= htmlspecialchars($row['post_date']) ?>
                         </small>
                     </div>
                 </div>

                 <!-- IMAGE -->
                 <img src="<?= $row['image_src'] ?>"
                     class="card-img-top object-fit-cover rounded mb-2 post-image"
                     style="width:100%; cursor:pointer;"
                     onclick="openImagePreview(this.src)">

                 <!-- CAPTION -->
                 <p class="text-muted small mb-1" style="overflow-y:auto; max-height:60.5px;">
                     <?= htmlspecialchars($row['post_caption']) ?>
                 </p>

             </div>

             <!-- FOOTER ACTIONS -->
             <div class="card-footer bg-white border-0 pt-0 pb-3">
                 <div class="d-flex justify-content-between">
                     <span class="ms-3" style="transform: translate(0px, 7px)"><i class="bi bi-heart me-1"></i><span id="likeCount<?= $row['post_id'] ?>" class="small"><?= $row['likeCount'] ?></span></span>

                     <div class="btn-group btn-group-sm ms-auto">
                         <?php if ($row['isLiked']) { ?>
                             <button class="btn text-secondary text-danger" onclick="likePost(<?= $row['post_id'] ?>)">
                                 <i class="bi bi-heart-fill h5" id="<?= $row['post_id'] ?>"></i>
                             </button>
                         <?php } else { ?>
                             <button class="btn text-secondary text-danger" onclick="likePost(<?= $row['post_id'] ?>)">
                                 <i class="bi bi-heart h5" id="<?= $row['post_id'] ?>"></i>
                             </button>
                         <?php } ?>
                         <button class="btn text-secondary" style="transform: translate(0px, -1px)" data-bs-toggle="modal" data-bs-target="#commentModal" onclick="getPostContent(<?= $row['post_id'] ?>)">
                             <i class="bi bi-chat h5"></i><span class="ms-1"><?= $row['commentCount'] ?></span>
                         </button>
                     </div>

                 </div>
             </div>

         </div>
     <?php } ?>

     <!-- IMAGE PREVIEW MODAL -->
     <div id="imagePreviewModal"
         class="position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center"
         style="background: rgba(0,0,0,0.9); z-index: 9999;">

         <!-- CLOSE BUTTON -->
         <button class="btn btn-light position-absolute top-0 end-0 m-4 rounded-circle shadow"
             style="width:50px; height:50px;"
             onclick="closeImagePreview()">

             <i class="bi bi-x-lg"></i>

         </button>

         <!-- IMAGE -->
         <img id="previewImage"
             src=""
             class="img-fluid rounded shadow-lg"
             style="max-width:90%; max-height:90%; object-fit:contain;">

     </div>

 </div>

 <script>
     async function likePost(post_id) {

         const likeBtn = document.getElementById(post_id);
         const likeCount = document.getElementById("likeCount" + post_id);

         const res = await fetch(`./../backend/likePost.php`, {
             method: 'POST',
             body: new URLSearchParams({
                 post_id: post_id,
             }),
             credentials: "same-origin",
         });

         if (!res.ok) throw new Error("Network response Error.");

         const data = await res.json();

         if (!data.success) {
             return;
         }

         if (data.status === 'unliked') {
             likeBtn.classList.remove("bi-heart-fill");
             likeBtn.classList.add("bi-heart");
             likeCount.textContent = data.likeCount;
         }

         if (data.status === 'liked') {
             likeBtn.classList.remove("bi-heart");
             likeBtn.classList.add("bi-heart-fill");
             likeCount.textContent = data.likeCount;
         }

     }

     function openImagePreview(imageSrc) {

         const modal = document.getElementById("imagePreviewModal");
         const previewImage = document.getElementById("previewImage");

         previewImage.src = imageSrc;

         modal.classList.remove("d-none");
         modal.classList.add("d-flex");

         document.body.style.overflow = "hidden";
     }

     function closeImagePreview() {

         const modal = document.getElementById("imagePreviewModal");

         modal.classList.remove("d-flex");
         modal.classList.add("d-none");

         document.body.style.overflow = "auto";
     }

     // CLOSE WHEN CLICKING OUTSIDE IMAGE
     document.getElementById("imagePreviewModal").addEventListener("click", function(e) {

         if (e.target.id === "imagePreviewModal") {
             closeImagePreview();
         }

     });

     // ESC KEY CLOSE
     document.addEventListener("keydown", function(e) {

         if (e.key === "Escape") {
             closeImagePreview();
         }

     });
 </script>