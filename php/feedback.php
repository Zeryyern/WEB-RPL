<?php
include 'config.php';

$query = "SELECT f.id, u.username, f.feedback, f.response, f.submitted_at
          FROM feedbacks f
          JOIN users u ON f.user_id = u.id
          ORDER BY f.submitted_at DESC";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Feedback Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    textarea {
        resize: vertical;
    }
    </style>
</head>

<body>

    <div class="container my-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">User Feedback Management</h4>
            </div>
            <div class="card-body">
                <?php if ($result->num_rows === 0): ?>
                <div class="alert alert-info text-center">
                    No feedback entries found.
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>User</th>
                                <th>Feedback</th>
                                <th>Submitted At</th>
                                <th>Response</th>
                                <th>Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td class="text-nowrap"><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['feedback'])) ?></td>
                                <td><?= date('M d, Y H:i', strtotime($row['submitted_at'])) ?></td>
                                <td>
                                    <?= $row['response'] ? nl2br(htmlspecialchars($row['response'])) : '<span class="text-muted fst-italic">No reply yet</span>' ?>
                                </td>
                                <td>
                                    <?php if (!$row['response']) : ?>
                                    <form method="POST" action="submit_reply.php">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <textarea name="response" class="form-control form-control-sm mb-2" rows="2"
                                            required></textarea>
                                        <button type="submit" class="btn btn-success btn-sm">Send Reply</button>
                                        <button type="submit" class="btn btn-success btn-sm">delete Reply</button>
                                    </form>
                                    <?php else : ?>
                                    <span class="badge bg-success">Replied</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>

</html