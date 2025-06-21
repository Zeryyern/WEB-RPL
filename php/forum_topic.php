<?php
session_start();
include 'config.php';

// Validate topic ID
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($topic_id <= 0) {
    echo "<div class='alert alert-danger m-4'>Invalid topic ID.</div>";
    exit;
}

// Fetch topic using prepared statement
$stmt = $conn->prepare("SELECT * FROM forum_topics WHERE id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();

if (!$topic) {
    echo "<div class='alert alert-warning m-4'>Topic not found.</div>";
    exit;
}

// Fetch replies using prepared statement
$stmt = $conn->prepare("SELECT * FROM forum_replies WHERE topic_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$replies = $stmt->get_result();

// CSRF token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($topic['title']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    .reply-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .card-reply {
        border-left: 4px solid #0d6efd;
    }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="mb-4">
            <h2 class="fw-bold"><?= htmlspecialchars($topic['title']) ?></h2>
            <p class="text-muted"><?= htmlspecialchars($topic['description']) ?></p>
        </div>

        <!-- Reply Form -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Add a Reply</div>
            <div class="card-body">
                <?php if (isset($_SESSION['username'])): ?>
                <form action="post_reply.php" method="post">
                    <input type="hidden" name="topic_id" value="<?= $topic_id ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Enter your reply..."
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Post Reply</button>
                </form>
                <?php else: ?>
                <div class="alert alert-info mb-0">
                    Please <a href="../login.php">login</a> to post a reply.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Replies List -->
        <h5 class="mb-3">Replies</h5>
        <?php if ($replies->num_rows > 0): ?>
        <?php while ($reply = $replies->fetch_assoc()): ?>
        <div class="card mb-3 card-reply shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="../assets/avatar_placeholder.png" alt="avatar" class="reply-avatar" loading="lazy">
                        <div>
                            <strong><?= htmlspecialchars($reply['username']) ?></strong>
                            <small
                                class="text-muted ms-2"><?= date('M d, Y H:i', strtotime($reply['created_at'])) ?></small>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" aria-label="Reply options"><i
                                class="bi bi-three-dots"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="edit_reply.php?id=<?= $reply['id'] ?>">Edit</a></li>
                            <li><a class="dropdown-item text-danger"
                                    href="delete_reply.php?id=<?= $reply['id'] ?>&csrf_token=<?= $csrf_token ?>"
                                    onclick="return confirm('Delete this reply?')">Delete</a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <p class="mt-3 mb-0"><?= nl2br(htmlspecialchars($reply['content'])) ?></p>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="alert alert-secondary">No replies yet. Be the first to reply!</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>