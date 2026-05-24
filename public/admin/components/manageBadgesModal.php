<div class="modal fade" id="manageBadgesModal" tabindex="-1" aria-labelledby="manageBadgesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageBadgesModalLabel">Manage Badges for <span id="badgeManagerStudentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="badgeManagerUserId" value="">

                <div class="mb-4">
                    <h6 class="mb-3">Assigned Badges</h6>
                    <div id="badgeList" class="d-flex flex-wrap gap-3"></div>
                    <div id="noBadgeMessage" class="text-muted">Loading badges...</div>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Badge Icon</label>
                        <input type="text" id="badge_icon" class="form-control" placeholder="bi-award-fill or 🏆">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date Given</label>
                        <input type="date" id="date_given" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Badge Description</label>
                        <input type="text" id="badge_description" class="form-control" placeholder="Dean's Lister">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="assignBadge()">Assign Badge</button>
            </div>
        </div>
    </div>
</div>