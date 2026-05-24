<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Create New Post</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="postForm">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="postTitle">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Caption</label>
                        <textarea class="form-control" rows="4" name="postCaption" style="resize:none;"></textarea>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" id="postImage" name="postImage" class="form-control" accept="image/*">
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-3 border bg-dark rounded">
                        <img id="image_preview" src="" alt="Preview"
                            class="img-fluid mx-auto"
                            style="max-height: 300px; display: none;">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Drafted">Drafted</option>
                            <option value="Published">Published</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Post</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const postForm = document.getElementById("postForm");
        const image_preview = document.getElementById("image_preview");
        const createPostModal = bootstrap.Modal.getOrCreateInstance("#createPostModal");

        postForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const postFormData = new FormData(postForm);

            const res = await fetch(`./../backend/uploadPost.php`, {
                method: 'POST',
                body: postFormData,
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error('Network Response Error');

            const data = await res.json();
            console.log(data);


            if (!data.success) {
                Swal.fire({
                    title: "Oops",
                    text: "There was an error uploading your file",
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
                return;
            }

            loadPosts();
            createPostModal.hide();
            postForm.reset();
            image_preview.src = "";

            Swal.fire({
                title: "Upload Successful",
                text: "Your Post has been uploaded Successfuly.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });
            return;
        });
        return;
    });

    document.addEventListener('DOMContentLoaded', () => {
        const postForm = document.getElementById("postForm");
        const image_preview = document.getElementById("image_preview");
        const postImage = document.getElementById("postImage");
        const createPostModal = bootstrap.Modal.getOrCreateInstance("#createPostModal");

        // 🔥 IMAGE PREVIEW
        postImage.addEventListener("change", () => {
            const file = postImage.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    image_preview.src = e.target.result;
                    image_preview.style.display = "block";
                };

                reader.readAsDataURL(file);
            } else {
                image_preview.src = "";
                image_preview.style.display = "none";
            }
        });
    });
</script>