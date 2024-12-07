<div class="container py-5">
    <h1 class="text-center fw-bold mb-4">Admin Dashboard</h1>
    
    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link <?= $section === 'users' ? 'active' : '' ?>" href="index.php?action=adminDashboard&section=users">Manage Users</a>
        <a class="nav-link <?= $section === 'blogs' ? 'active' : '' ?>" href="index.php?action=adminDashboard&section=blogs">Manage Blogs</a>
    </nav>
    
    <?php if ($section === 'users'): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">All Users</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="index.php?action=adminAction&action=update&type=user" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                        </form>
                                        <form method="POST" action="index.php?action=adminAction&action=delete&type=user" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Add New User</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=adminAction&action=add&type=user">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add User</button>
                </form>
            </div>
        </div>
    <?php elseif ($section === 'blogs'): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">All Blogs</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['blogs'] as $blog): ?>
                            <tr>
                                <td><?= $blog['id'] ?></td>
                                <td><?= htmlspecialchars($blog['title']) ?></td>
                                <td><?= htmlspecialchars($blog['category']) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="index.php?action=adminAction&action=update&type=blog" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                        </form>
                                        <form method="POST" action="index.php?action=adminAction&action=delete&type=blog" class="d-inline">
                                            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Add New Blog</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?action=adminAction&action=add&type=blog">
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="category" class="form-control" placeholder="Category" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="content" class="form-control" placeholder="Content" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add Blog</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
