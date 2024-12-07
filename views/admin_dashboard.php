<div class="container py-5">

    <nav class="nav nav-pills justify-content-center mb-4">
        <a class="nav-link <?= $section === 'users' ? 'active' : '' ?>"
            href="index.php?action=adminDashboard&section=users">Manage Users</a>
        <a class="nav-link <?= $section === 'blogs' ? 'active' : '' ?>"
            href="index.php?action=adminDashboard&section=blogs">Manage Blogs</a>
    </nav>

    <?php
    // Retrieve the messages from the URL parameter (if available)
    $messages = isset($_GET['messages']) ? unserialize(urldecode($_GET['messages'])) : [];
    ?>

    <?php if (!empty($messages)): ?>
        <!-- Display success or error alert message -->
        <div class="alert <?= isset($messages['success']) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show"
            role="alert">
            <?=
                isset($messages['success']) ? $messages['success'] :
                (isset($messages['formErrors']) ? ($messages['formErrors']['username']) : $messages['error'])
                ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($section === 'users'): ?>
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <?php if (isset($data['user'])): ?>
                    <h3 class="mb-0">Edit User</h3>
                <?php else: ?>
                    <h3 class="mb-0">Add User</h3>
                <?php endif; ?>
            </div>
            <div class="card-body">

                <form method="POST"
                    action="index.php?action=adminAction&task=<?= isset($data['user']) ? 'update' : 'add' ?>&type=user">
                    <?php if (isset($data['user'])): ?>
                        <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username"
                            value="<?= isset($data['user']) ? htmlspecialchars($data['user']['username']) : '' ?>" required>
                        <?php if (isset($formErrors['username'])): ?>
                            <div class="text-danger small"><?= $formErrors['username'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="<?= isset($data['user']) ? htmlspecialchars($data['user']['email']) : '' ?>" required>
                        <?php if (isset($formErrors['email'])): ?>
                            <div class="text-danger small"><?= $formErrors['email'] ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if (!isset($data['user'])): ?>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password"
                                value="<?= isset($data['user']) ? '' : '' ?>" <?= isset($data['user']) ? '' : 'required' ?>>
                            <?php if (isset($formErrors['password'])): ?>
                                <div class="text-danger small"><?= $formErrors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <button type="submit"
                        class="btn btn-primary w-100"><?= isset($data['user']) ? 'Update User' : 'Add User' ?></button>
                </form>

                <?php unset($_SESSION['formErrors']); ?>

            </div>
        </div>

        <div class="mt-4">
            <table class="table table-striped table-hover rounded-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['users'] as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <?php if ($user['is_active'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="btn-group d-flex justify-content-center" role="group">
                                    <form method="GET" action="index.php" class="me-2">
                                        <input type="hidden" name="action" value="adminDashboard">
                                        <input type="hidden" name="section" value="users">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <form method="POST" action="index.php?action=adminAction&task=delete&type=user"
                                        class="d-inline">
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

    <?php elseif ($section === 'blogs'): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <?php if (isset($data['blog'])): ?>
                    <h3 class="mb-0">Edit Blog</h3>
                <?php else: ?>
                    <h3 class="mb-0">Add Blog</h3>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form method="POST"
                    action="index.php?action=adminAction&task=<?= isset($data['blog']) ? 'update' : 'add' ?>&type=blog">
                    <?php if (isset($data['blog'])): ?>
                        <input type="hidden" name="id" value="<?= $data['blog']['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <select name="user_id" class="form-control" required>
                            <option value="" disabled selected>Select User</option>
                            <?php foreach ($data['users'] as $user): ?>
                                <option value="<?= htmlspecialchars($user['id']) ?>" <?= isset($data['blog']) && $data['blog']['author_id'] == $user['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['username']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($formErrors['user_id'])): ?>
                            <div class="text-danger small"><?= $formErrors['user_id'] ?></div>
                        <?php endif; ?>
                    </div>


                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Title"
                            value="<?= isset($data['blog']) ? htmlspecialchars($data['blog']['title']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <select name="category" class="form-control" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php foreach ($data['categories'] as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>" <?= isset($data['blog']) && $data['blog']['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($formErrors['category'])): ?>
                            <div class="text-danger small"><?= $formErrors['category'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <textarea name="content" class="form-control" placeholder="Content" rows="4"
                            required><?= isset($data['blog']) ? htmlspecialchars($data['blog']['content']) : '' ?></textarea>
                    </div>

                    <button type="submit"
                        class="btn btn-primary w-100"><?= isset($data['blog']) ? 'Update Blog' : 'Add Blog' ?></button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['blogs'] as $blog): ?>
                        <tr>
                            <td><?= $blog['id'] ?></td>
                            <td><?= htmlspecialchars($blog['title']) ?></td>
                            <td><?= htmlspecialchars($blog['category_name']) ?></td>
                            <td><?= htmlspecialchars($blog['author_name']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form method="GET" action="index.php" class="d-inline">
                                        <input type="hidden" name="action" value="adminDashboard">
                                        <input type="hidden" name="section" value="blogs">
                                        <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <form method="POST" action="index.php?action=adminAction&task=delete&type=blog"
                                        class="d-inline ms-3">
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
    <?php endif; ?>






</div>