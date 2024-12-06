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

                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="card-index">01</h2>
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="card-index">02</h2>
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="card-index">03</h2>
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="card-index">04</h2>
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-transparent border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="card-index">05</h2>
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
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
    </div>

    <div class="mx-5 px-5 mb-4 recent-update">

        <div class="d-flex">
            <h4 class="fw-bold position-relative pb-1">Recent Updates</h4>
        </div>

        <div class="mt-3 row g-3 gx-3">

            <div class="col-12 col-lg-6">
                <!-- Card 1 -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-content mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Eligendi temporibus praesentium neque, voluptatum quam quibusdam.
                                </p>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Card 2 -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-content mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Eligendi temporibus praesentium neque, voluptatum quam quibusdam.
                                </p>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Card 1 -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-content mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Eligendi temporibus praesentium neque, voluptatum quam quibusdam.
                                </p>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <!-- Card 2 -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-content mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Eligendi temporibus praesentium neque, voluptatum quam quibusdam.
                                </p>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <!-- Card 2 -->
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-title">
                                    News Needs to Meet Its Audiences Where They Are
                                </h5>
                                <p class="card-content mb-1">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Eligendi temporibus praesentium neque, voluptatum quam quibusdam.
                                </p>
                                <p class="card-text mb-1">Dave Rogers in News</p>
                                <p class="card-text">
                                    <span class="text-muted">Jun 14 • 3 min read</span>
                                    <span class="ms-1">
                                        <i class="fas fa-star text-muted"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="../public/assets/images/carousel-1.jpg" class="img-fluid rounded-start"
                                    alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <div class="card post-card p-2 border-0">
                                    <div class="card-body row g-3 p-0">
                                        <div class="col-9 content px-3 d-flex justify-content-center flex-column">
                                            <h5 class="card-title text-dark fw-bold fs-5">${post.title}</h5>
                                            <p class="card-text text-muted mt-1">${post.content}</p>
                                            <p class="card-text mt-3">
                                                <span class="text-muted">Jun 14 • 3 min read</span>
                                                <span class="ms-1">
                                                    <i class="fas fa-star text-muted"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col-3 image">
                                            <img src="${post.image_url ? post.image_url : '../public/assets/images/carousel-1.jpg'}" alt="${post.title}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
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