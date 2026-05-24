<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class=" modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Comment on - "<span id="post_title">Loading...</span>"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" style="height: 100%;">

                    <!-- IMAGE PREVIEW -->
                    <div class="col-md-7">
                        <div class="">
                            <img src=""
                                alt="image_preview"
                                style="width:100%;"
                                class="mb-1 rounded"
                                id="image_src">
                        </div>
                        <hr style="width: 50%;" class="mx-auto">
                        <div class="overflow-y-auto" style="height: 205px;">
                            <p id="post_caption">Loading...</p>
                        </div>
                    </div>

                    <!-- COMMENTS -->
                    <div class="col-md-5 d-flex flex-column">

                        <h6 class="text-center">
                            Comments<small class="ms-2 text-muted" id="totalComments">0</small>
                        </h6>

                        <div id="comment_section" style="max-height:715px;" class="overflow-y-auto">
                            <!-- DYNAMIC COMMENTS -->
                        </div>

                        <form id="commentForm" class="mt-auto d-flex flex-column">
                            <input type="hidden" id="post_id" name="post_id"> <!--POST ID-->

                            <textarea type="text" name="comment" id="comment" class="border border-secondary rounded mb-2 form-control" required></textarea>

                            <div class="d-flex">

                                <div class="btn-group dropup">
                                    <ul class="dropdown-menu border border-success row" id="emoji-menu">
                                        <div class="d-flex">
                                            <li onclick="addEmojiToCommentBox('&#128077')" class="me-2 emoji">&#128077</li>
                                            <li onclick="addEmojiToCommentBox('&#128151')" class="me-2 emoji">&#128151</li>
                                            <li onclick="addEmojiToCommentBox('&#128514')" class="me-2 emoji">&#128514</li>
                                            <li onclick="addEmojiToCommentBox('&#128559')" class="me-2 emoji">&#128559</li>
                                            <li onclick="addEmojiToCommentBox('&#128546')" class="me-2 emoji">&#128546</li>
                                            <li onclick="addEmojiToCommentBox('&#128545')" class="me-2 emoji">&#128545</li>
                                            <li onclick="addEmojiToCommentBox('&#128293')" class="me-2 emoji">&#128293</li>
                                            <li onclick="addEmojiToCommentBox('&#127881')" class="me-2 emoji">&#127881</li>
                                        </div>
                                    </ul>

                                    <button type="button" class="btn me-5 dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#emoji-menu"><i class="bi bi-emoji-smile h4 text-success"></i></button>
                                </div>

                                <button type="submit" id="post_commentBtn" class="btn btn-md bg-success text-light ms-auto">Post Comment</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => { // POST COMMENNT FUNCTION

        const commentForm = document.getElementById("commentForm");
        const comment_textarea = document.getElementById("comment");
        const post_commentBtn = document.getElementById("post_commentBtn");

        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const commentFormData = new FormData(commentForm);
            const post_id = document.getElementById("post_id").value;

            post_commentBtn.disabled = true;
            post_commentBtn.innerHTML = `<div class="spinner-border spinner-border-sm text-light" role="status">
                                         <span class="visually-hidden">Loading...</span>
                                         </div>`;

            try {
                const res = await fetch(`./../../public/backend/comment.php`, {
                    method: 'POST',
                    body: commentFormData,
                    credentials: 'same-origin',
                });

                if (!res.ok) throw new Error('Network Response Error.');

                const data = await res.json();

                if (data.success) {
                    loadComments(post_id);
                } else {}

            } catch (err) {
                console.error("Error:", err);
            } finally {
                comment_textarea.value = "";
                post_commentBtn.disabled = false;
                post_commentBtn.innerHTML = `Submit`;
            }

        });

    });

    // LIVE COMMENTS POLLING
    let commentsInterval = null;

    const commentModal = document.getElementById('commentModal');

    commentModal.addEventListener('shown.bs.modal', () => {
        const post_id = document.getElementById("post_id").value;

        // Poll every 5 seconds while modal is open
        commentsInterval = setInterval(() => {
            const current_post_id = document.getElementById("post_id").value;
            if (current_post_id) {
                loadComments(current_post_id);
            }
        }, 2000);
    });

    commentModal.addEventListener('hidden.bs.modal', () => {
        // Stop polling when modal closes
        clearInterval(commentsInterval);
        commentsInterval = null;
    });

    function addEmojiToCommentBox(dec) {
        const comment_textArea = document.getElementById("comment");
        let comment = document.getElementById("comment").value;

        const result = comment += dec;

        comment_textArea.value = result;

    }

    //! MAKE THE COMMENTS LIVE WHEN THE COMMENT MODAL IS OPENED
    async function loadComments(post_id) { // LOAD COMMENTS WHEN COMMENT MODAL OPENS

        const comment_section = document.getElementById("comment_section");
        const totalComments = document.getElementById("totalComments");

        if (!comment_section.children.length) {
            comment_section.innerHTML = `
        <div class="d-flex flex-column justify-content-center align-items-center text-center h-100 py-5 text-muted">
    
        <div class="mb-3">
            <i class="bi bi-chat-dots fs-1 opacity-50"></i>
        </div>

        <h5 class="fw-semibold text-dark mb-1">No comments yet</h5>
        <p class="mb-2 small">Be the first to start the conversation.</p>

        </div>
        `;
        }

        try {
            const res = await fetch(`./../../public/backend/comment.php?post_id=${post_id}`, {
                credentials: 'same-origin',
            });

            if (!res.ok) throw new Error('Network response Error.');

            const data = await res.json();
            let total_comments = Object.keys(data).length;

            if (!data.length) {
                comment_section.innerHTML = `
                <div class="d-flex flex-column justify-content-center align-items-center text-center h-100 py-5 text-muted">
            
                <div class="mb-3">
                    <i class="bi bi-chat-dots fs-1 opacity-50"></i>
                </div>

                <h5 class="fw-semibold text-dark mb-1">No comments yet</h5>
                <p class="mb-2 small">Be the first to start the conversation.</p>

                </div>
        `;
                return;
            }

            const comments = data.map(data => {

                const time_now = Math.floor(new Date().getTime() / 1000);
                const comment_time = data.comment_unix;
                const time_difference = (time_now - comment_time);
                const time_ago = getTimeAgo(time_difference);

                function getTimeAgo(time_difference) {
                    if (time_difference < 10) {
                        return "Just now";

                    } else if (time_difference < 60) {
                        return time_difference + " seconds ago";

                    } else if (time_difference < 3600) {
                        const mins = Math.floor(time_difference / 60);
                        return mins + (mins === 1 ? " minute ago" : " minutes ago");

                    } else if (time_difference < 86400) {
                        const hrs = Math.floor(time_difference / 3600);
                        return hrs + (hrs === 1 ? " hour ago" : " hours ago");

                    } else if (time_difference < 604800) {
                        const days = Math.floor(time_difference / 86400);
                        return days + (days === 1 ? " day ago" : " days ago");

                    } else if (time_difference < 2629800) {
                        const weeks = Math.floor(time_difference / 604800);
                        return weeks + (weeks === 1 ? " week ago" : " weeks ago");

                    } else if (time_difference < 31557600) {
                        const months = Math.floor(time_difference / 2629800);
                        return months + (months === 1 ? " month ago" : " months ago");

                    } else {
                        const years = Math.floor(time_difference / 31557600);
                        return years + (years === 1 ? " year ago" : " years ago");
                    }
                }

                let roleIcons = {
                    Teacher: `
                     <span class="badge me-1">
                        <i class="bi bi-eyeglasses text-success h5"></i>
                    </span>
                    `,
                    Student: `
                    <span class="badge me-1">
                        <i class="bi bi-person text-success h5"></i>
                    </span>
                    `,
                    Alumni: `
                    <span class="badge me-1">
                        <i class="bi bi-mortarboard text-primary h5"></i>
                    </span>
                    `,
                    Admin: `
                    <span class="badge me-1">
                        <i class="bi bi-shield text-info h5"></i>
                    </span>
                    `,
                };

                let roleIcon = roleIcons[data.role];

                return `
                                <!-- Comment -->
                                <div class="d-flex mb-3">

                                     <img src="${data.profile_picture}"
                                        class="rounded-circle me-2 mt-2"
                                        width="40"
                                        height="40"
                                        style="
                                        border-radius: 50%;
                                        object-fit: cover;"
                                        >

                                    <div class="flex-grow-1">

                                        <!-- Name + Date -->
                                        <div class="d-flex align-items-center">
                                            <strong class="me-2">${data.account_username}</strong>

                                             ${roleIcon}

                                            <small class="text-muted ms-auto">${time_ago}</small>
                                        </div>

                                        <!-- Comment Text -->
                                        <div>
                                            ${data.comment}
                                        </div>

                                    </div>

                                </div>
                `;
            }).join('');

            comment_section.innerHTML = comments;
            totalComments.innerHTML = total_comments;

        } catch {

        } finally {

        }

    }

    function populatePostInformationModal(data) { // POPULATE IMAGE PREVIEW AND CAPTION IN THE COMMENT MODAL

        document.getElementById("post_id").value = data.post_id;

        Object.keys(data).forEach(key => {

            const element = document.getElementById(key);

            if (!element) {
                return;
            }

            if (element.tagName === 'IMG') {
                element.src = data[key];
            } else {
                element.textContent = data[key];
            }

        });

        loadComments(data.post_id);
    }

    async function getPostContent(post_id) { // GET POST INFORMATION FROM THE DATABASE
        try {
            const res = await fetch(`./../../api/getPostContent.php`, {
                method: 'POST',
                body: new URLSearchParams({
                    post_id: post_id,
                }),
                credentials: 'same-origin'
            });

            if (!res.ok) throw new Error('Network response error');

            const data = await res.json();
            populatePostInformationModal(data);

        } catch {

        } finally {

        }
    }
</script>