<?php
include 'config.php';

$query = "SELECT 
             f.id,
             f.subject,
             COALESCE(f.name, u.username) AS display_name,
             f.feedback,
             f.response,
             f.submitted_at
          FROM feedbacks f
          LEFT JOIN users u ON f.user_id = u.id
          ORDER BY f.submitted_at DESC";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Feedback Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                <th>Subject</th>
                                <th>Feedback</th>
                                <th>Submitted At</th>
                                <th>Response</th>
                                <th>Reply</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <td class="text-nowrap"><?= htmlspecialchars($row['display_name']) ?></td>
                                    <td><?= htmlspecialchars($row['subject']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($row['feedback'])) ?></td>
                                    <td><?= date('M d, Y H:i', strtotime($row['submitted_at'])) ?></td>
                                    <td>
                                        <?php
                                            if ($row['response'] === 'Deleted') {
                                                echo '<span class="text-danger fst-italic">Deleted</span>';
                                            } elseif ($row['response']) {
                                                echo nl2br(htmlspecialchars($row['response']));
                                            } else {
                                                echo '<span class="text-muted fst-italic">No reply yet</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if (!$row['response']) : ?>
                                            <form method="POST" action="submit_reply.php" class="mb-2">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <textarea name="response" class="form-control form-control-sm mb-2" rows="2" required></textarea>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-success btn-sm">Send Reply</button>
                                            </form>
                                            <form method="POST" action="delete_feedback.php" class="delete-feedback-form">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
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

<script>
    document.querySelectorAll('.delete-feedback-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "This feedback will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

</body>
</html>