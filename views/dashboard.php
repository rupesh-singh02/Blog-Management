<?php
// Retrieve the messages from the URL parameter (if available)
$messages = isset($_GET['messages']) ? unserialize(urldecode($_GET['messages'])) : [];
?>

<?php if (!empty($messages)): ?>
    <div class="container py-2">
        <div class="alert <?= isset($messages['success']) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show"
            role="alert">
            <?=
                isset($messages['success']) ? $messages['success'] :
                (isset($messages['formErrors']) ? ($messages['formErrors']['username']) : $messages['error'])
                ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['section']) && $_GET['section'] === 'blogs'): ?>
    <div class="container py-3">
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
                    action="index.php?action=userAction&task=<?= isset($data['blog']) ? 'update' : 'add' ?>&section=blogs">

                    <?php if (isset($data['blog'])): ?>
                        <input type="hidden" name="id" value="<?= $data['blog']['id'] ?>">
                    <?php endif; ?>


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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data['blogs']) && !empty($data['blogs'])): ?>
                        <?php foreach ($data['blogs'] as $blog): ?>
                            <tr>
                                <td><?= $blog['id'] ?></td>
                                <td><?= htmlspecialchars($blog['title']) ?></td>
                                <td><?= htmlspecialchars($blog['category_name']) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="GET" action="index.php" class="d-inline">
                                            <input type="hidden" name="action" value="dashboard">
                                            <input type="hidden" name="section" value="blogs">
                                            <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                        </form>
                                        <form method="POST" action="index.php?action=userAction&task=delete&section=blogs"
                                            class="d-inline ms-3">
                                            <input type="hidden" name="id" value="<?= $blog['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No blogs found.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

<?php else: ?>

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner px-5">
            <div class="carousel-item active px-5">
                <div class="d-flex justify-content-center align-items-center pb-5 px-5">
                    <div class="card rounded-0 m-5 border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex justify-content-center flex-column ps-5">
                                    <p class="card-text text-muted">EDITOR'S PICK</p>
                                    <h5 class="card-title heading fs-3">News Needs to Meet Its Audiences Where They Are</h5>
                                    <p class="card-text text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Voluptate
                                        vero obcaecati natus adipisci necessitatibus eius, enim vel sit ad reiciendis. Enim
                                        praesentium magni delectus cum, tempore deserunt aliquid quaerat culpa nemo
                                        veritatis, iste adipisci excepturi consectetur doloribus aliquam accusantium beatae?
                                    </p>
                                    <p class="card-text mt-5">
                                        <span class="text-muted">Jun 14 • 3 min read</span>
                                        <span class="ms-1">
                                            <i class="fas fa-star text-muted"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item px-5">
                <div class="d-flex justify-content-center align-items-center pb-5 px-5">
                    <div class="card m-5 rounded-0 border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex justify-content-center flex-column ps-5">
                                    <p class="card-text text-muted">EDITOR'S PICK</p>

                                    <h5 class="card-title heading fs-3">News Needs to Meet Its Audiences Where They Are</h5>
                                    <p class="card-text text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Voluptate
                                        vero obcaecati natus adipisci necessitatibus eius, enim vel sit ad reiciendis. Enim
                                        praesentium magni delectus cum, tempore deserunt aliquid quaerat culpa nemo
                                        veritatis, iste adipisci excepturi consectetur doloribus aliquam accusantium beatae?
                                    </p>
                                    <p class="card-text mt-5">
                                        <span class="text-muted">Jun 14 • 3 min read</span>
                                        <span class="ms-1">
                                            <i class="fas fa-star text-muted"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item px-5">
                <div class="d-flex justify-content-center align-items-center pb-5 px-5">
                    <div class="card m-5 rounded-0 border-0">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body h-100 d-flex justify-content-center flex-column ps-5">
                                    <p class="card-text text-muted">EDITOR'S PICK</p>

                                    <h5 class="card-title heading fs-3">News Needs to Meet Its Audiences Where They Are</h5>
                                    <p class="card-text text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Voluptate
                                        vero obcaecati natus adipisci necessitatibus eius, enim vel sit ad reiciendis. Enim
                                        praesentium magni delectus cum, tempore deserunt aliquid quaerat culpa nemo
                                        veritatis, iste adipisci excepturi consectetur doloribus aliquam accusantium beatae?
                                    </p>
                                    <p class="card-text mt-5">
                                        <span class="text-muted">Jun 14 • 3 min read</span>
                                        <span class="ms-1">
                                            <i class="fas fa-star text-muted"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <i class="fas fa-chevron-left" aria-hidden="true"></i>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
            <span class="visually-hidden">Next</span>
        </button>

    </div>

    <div class="px-5 mt-5">
        <div class="row mx-5 px-5 mb-5">

            <div class="col-9">
                <!-- Tab Navigation -->
                <ul class="nav nav-pills justify-content-center" id="categoryTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab-all" data-bs-toggle="tab" href="#category-all" role="tab"
                            aria-controls="category-all" aria-selected="true" onclick="loadPosts('all')">All</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="tab-<?= $category['id'] ?>" data-bs-toggle="tab"
                                href="#category-<?= $category['id'] ?>" role="tab"
                                aria-controls="category-<?= $category['id'] ?>" aria-selected="false"
                                onclick="loadPosts(<?= $category['id'] ?>)">
                                <?= htmlspecialchars($category['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="categoryContent">
                    <div class="tab-pane fade show active" id="category-all" role="tabpanel">
                        <!-- Posts will be populated dynamically here -->
                    </div>
                    <?php foreach ($categories as $category): ?>
                        <div class="tab-pane fade" id="category-<?= $category['id'] ?>" role="tabpanel">
                            <!-- Posts for this category will be populated here -->
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-3">
                <div class="d-flex">
                    <h4 class="position-relative pb-1 fw-bold">Trending</h4>
                </div>

                <div class="mt-3 tending-cards">

                    <?php if (!empty($topCommentedPosts)): ?>
                        <?php foreach ($topCommentedPosts as $index => $post): ?>
                            <div class="card bg-transparent border-0 mb-4">
                                <div class="card-body p-0">
                                    <div class="row g-2">
                                        <div class="col-md-3 text-center">
                                            <h2 class="card-index text-muted"><?= str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                                            </h2>
                                        </div>
                                        <div class="col-md-9">
                                            <h5 class="card-title">
                                                <a href="index.php?action=singlePost&post_id=<?= htmlspecialchars($post['id']); ?>"
                                                    class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h5>
                                            <p class="card-text mb-1 text-muted">
                                                <?= htmlspecialchars($post['author_name']); ?> in
                                                <?= htmlspecialchars($post['category_name']); ?>
                                            </p>
                                            <p class="card-text text-muted">
                                                <span><?= date('M j • g:i A', strtotime($post['created_at'])); ?></span>
                                                <span class="ms-2">
                                                    <i class="fas fa-comments text-muted"></i>
                                                    <?= htmlspecialchars($post['comment_count']); ?> Comments
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No top-commented posts available.</p>
                    <?php endif; ?>


                </div>
            </div>
        </div>

        <div class="mx-5 px-5 mb-4 recent-update">

            <div class="d-flex">
                <h4 class="fw-bold position-relative pb-1">Recent Updates</h4>
            </div>

            <div class="mt-3 row g-3 gx-3">
                <?php if (!empty($recentPosts)): ?>
                    <?php foreach ($recentPosts as $post): ?>
                        <div class="col-12 col-lg-6">
                            <!-- Card -->
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-9 d-flex justify-content-between flex-column">
                                            <h5 class="card-title">
                                                <a href="index.php?action=singlePost&post_id=<?= htmlspecialchars($post['id']); ?>"
                                                    class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h5>
                                            <p class="card-content mb-1">
                                                <?= htmlspecialchars(substr($post['content'], 0, 100)); ?>...
                                            </p>
                                            <p class="card-text mb-1">
                                                <?= htmlspecialchars($post['author_name']); ?> in
                                                <?= htmlspecialchars($post['category_name']); ?>
                                            </p>
                                            <p class="card-text">
                                                <span
                                                    class="text-muted"><?= date('M j • g:i A', strtotime($post['created_at'])); ?></span>
                                                <span class="ms-1">
                                                    <i class="fas fa-star text-muted"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <img src="<?= !empty($post['image_url']) ? htmlspecialchars($post['image_url']) : '../public/assets/images/carousel-1.jpg'; ?>"
                                                class="img-fluid rounded-start" alt="<?= htmlspecialchars($post['title']); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No recent posts available.</p>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <div class="newsletter-section container-fluid py-5 mt-5">
        <div class="text-center row py-5">
            <div class="col-6 d-flex justify-content-center flex-column">
                <h3 class="fw-bold text-dark fs-4 mb-2">Subscribe to Our Newsletter</h3>
                <p class="text-muted fs-6 mb-0">Get the latest updates and news delivered to your inbox.</p>
            </div>
            <div class="col-6">
                <form class="">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4">
                            <input type="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="col-md-3 col-lg-2 mt-3 mt-md-0">
                            <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadPosts(categoryId) {
            console.log('Category selected:', categoryId);  // Add this for debugging

            var category = (categoryId === 'all') ? 'all' : categoryId;

            // Fetch posts based on category
            fetch(`./index.php?page=1&category=${category}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    return response.text();  // Get the response as text for debugging
                })
                .then(text => {
                    console.log('Response received:', text); // Log the response body

                    try {
                        const data = JSON.parse(text);
                        console.log('Received data:', data);

                        // Populate the posts in the appropriate category
                        const postsContainer = document.getElementById(`category-${category}`);
                        postsContainer.innerHTML = '';

                        if (data.posts && data.posts.length > 0) {
                            // Create a row for posts
                            const row = document.createElement('div');
                            row.classList.add('row', 'g-4', 'mt-4'); // Added Bootstrap gutter class for spacing
                            postsContainer.appendChild(row);

                            data.posts.forEach(post => {
                                const postCard = document.createElement('div');
                                postCard.classList.add('col-12', 'col-lg-6'); // Added column classes for responsiveness
                                postCard.innerHTML = `
                                                            <a href="index.php?action=singlePost&post_id=${post.id}" class="text-decoration-none">
                                                                <div class="card post-card p-2 border-0">
                                                                    <div class="card-body row g-3 p-0">
                                                                        <!-- Text Content -->
                                                                        <div class="col-9 content px-3 d-flex flex-column justify-content-center">
                                                                            <h5 class="card-title text-dark fw-bold fs-5">${post.title}</h5>
                                                                            <p class="card-text text-muted mt-1">${post.content.substring(0, 100)}...</p>
                                                                            <p class="card-text mt-3">
                                                                                <span class="text-muted">${new Date(post.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span>
                                                                                <span class="ms-1">
                                                                                    <i class="fas fa-star text-muted"></i>
                                                                                </span>
                                                                            </p>
                                                                        </div>
                                                                        <!-- Image Content -->
                                                                        <div class="col-3 image">
                                                                            <img src="${post.image_url || '../public/assets/images/carousel-1.jpg'}" alt="${post.title}" class="img-fluid rounded">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        `;

                                row.appendChild(postCard); // Append the card to the row
                            });
                        } else {
                            postsContainer.innerHTML = '<p>No posts available in this category.</p>';
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                    }
                })
                .catch(error => {
                    console.error('Error loading posts:', error);
                });
        }
        loadPosts('all');
    </script>

<?php endif; ?>