    <div class="tab-pane fade" id="postsTab">
        <div class="row g-4" id="post_list_group">
            <!-- DYNAMIC POST LIST -->
        </div>
    </div>

    <script>
        loadPosts();

        async function loadPosts() { // LOAD LIST

            const post_list_group = document.getElementById("post_list_group");

            try {

                const res = await fetch('./../../../api/PostController.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'load',
                    }),
                    credentials: "same-origin",
                });

                if (!res.ok) throw new Error('Network response is not ok.');

                const data = await res.json();

                const posts = data.map(data => {

                    const status_colors = {
                        Drafted: 'secondary',
                        Published: 'success',
                        Archived: 'warning',
                    }

                    const status = data.status;
                    const status_color = status_colors[status] || 'secondary';


                    return ` <div class="col-md-6 col-lg-4">
             <div class="card border shadow-sm h-100 content-card">

                <div class="card-body">

                     <!-- HEADER -->
                     <div class="d-flex align-items-center mb-2">
                         <div>
                             <h6 class="mb-0 fw-semibold">${data.post_title}</h6>
                             <small class="text-muted">
                                 By ${data.posted_by} • ${data.post_date}
                                 <span class="ms-3"><i class="bi bi-heart me-1"></i>${data.likeCount}</span>
                             </small>
                         </div>
                         <span class="badge bg-${status_color} ms-auto mb-3">${data.status}</span>
                     </div>

                     <!-- IMAGE -->
                     <img src="${data.image_src}"
                         class="card-img-top object-fit-cover rounded mb-2"
                         style="height:400px;">

                     <!-- CAPTION -->
                     <p class="text-muted small mb-1" style="overflow-y:auto; max-height:60.5px;">
                      ${data.post_caption}
                     </p>

                </div>

                 <!-- FOOTER ACTIONS -->
                 <div class="card-footer bg-white border-0 pt-0 pb-3">
                     <div class="d-flex justify-content-between">

                         <div class="btn-group btn-group-sm">
                             <button class="btn text-success" data-bs-toggle="modal" data-bs-target="#editPostModal"
                             onclick="getPostIfo(${data.post_id})">
                                 <i class="bi bi-pencil h5"></i>
                             </button>
                             <button class="btn text-warning" onclick="archivePostConfirmation(${data.post_id})">
                                 <i class="bi bi-archive h5"></i>
                             </button>
                             <button class="btn text-danger" onclick="deletePostConfirmation(${data.post_id}, '${data.image_src}')">
                                 <i class="bi bi-trash h5"></i>
                             </button>
                         </div>

                         <div class="btn-group btn-group-sm">
                             <button class="btn text-secondary" style="transform: translate(0px, -1px)" data-bs-toggle="modal" data-bs-target="#commentModal" onclick="getPostContent(${data.post_id})">
                             <i class="bi bi-chat h5"></i>
                         </button>
                         <span class="small text-muted">${data.commentCount}</span>
                         </div>

                     </div>
                 </div>

             </div>
         </div>`;
                }).join('');

                post_list_group.innerHTML = posts;

            } catch {

            } finally {

            }
        }

        function archivePostConfirmation(post_id) {
            Swal.fire({
                title: "Are you sure?",
                text: `Arhive this Post?`,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                confirmButtonText: "Archive"
            }).then((result) => {
                if (result.isConfirmed) {
                    archivePost(post_id);
                }
            });
        }

        async function archivePost(post_id) {

            try {

                const res = await fetch('./../../../api/PostController.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'archive',
                        post_id: post_id,
                        new_status: 'Archived',
                    }),
                    credentials: "same-origin",
                });

                if (!res.ok) throw new Error('Network response is not ok.');

                const data = await res.json();

                if (data.success) {
                    loadPosts();
                    Swal.fire({
                        title: "Archiving Successful",
                        text: "Post has been Archived.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: "Archiving Unsuccessful",
                        text: "Post could not be archived.",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }

            } catch {

            } finally {

            }

        }

        function deletePostConfirmation(post_id, image_src) {
            Swal.fire({
                title: "Are you sure?",
                text: `Delete this Post?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DC3545",
                confirmButtonText: "Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    deletePost(post_id, image_src);
                }
            });
        }

        async function deletePost(post_id, image_src) {

            try {

                const res = await fetch('./../../../api/PostController.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'delete',
                        post_id: post_id,
                        image_src: image_src,
                    }),
                    credentials: "same-origin",
                });

                if (!res.ok) throw new Error('Network response is not ok.');

                const data = await res.json();

                if (data.success) {
                    loadPosts();
                    Swal.fire({
                        title: "Deletion Successful",
                        text: "Post Deleted.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        title: "Deletion Unsuccessful",
                        text: "Post Deletion Failed.",
                        icon: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }

            } catch {

            } finally {

            }

        }
    </script>