<div class="container py-5">
    <!-- Blog Post -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><?= htmlspecialchars($post['title']) ?></h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                <i class="fas fa-user"></i> <strong><?= htmlspecialchars($author['username']) ?></strong> 
                <span class="ms-2"><i class="fas fa-calendar-alt"></i> <?= date('F j, Y', strtotime($post['created_at'])) ?></span>
            </p>
            <div class="post-content" style="line-height: 1.8; font-size: 1.1rem;">
                <?= nl2br(htmlspecialchars($post['content'])) ?>
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0">Comments</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-1">
                                    <strong><?= htmlspecialchars($comment['username']) ?></strong> 
                                    <span class="text-muted" style="font-size: 0.9rem;">
                                        on <?= date('F j, Y', strtotime($comment['created_at'])) ?>
                                    </span>
                                </p>
                                <p class="mb-0" style="line-height: 1.6;">
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No comments yet. Be the first to comment!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Comment Form -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Leave a Comment</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=addComment&post_id=<?= $post['id'] ?>">
                    <div class="mb-3">
                        <label for="comment" class="form-label">Your Comment</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your comment here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Post Comment</button>
                </form>
            </div>
        </div>
    </div>
</div>
