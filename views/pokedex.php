<?php include 'layout/header.php'; ?>
    <div class="layout-container">
        <?php include 'layout/sidenav.php' ?>

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            <nav
                class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar"
            >
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input
                                type="text"
                                class="form-control border-0 shadow-none"
                                placeholder="Search..."
                                aria-label="Search..."
                            />
                        </div>
                    </div>
                    <!-- /Search -->

                    <ul class="navbar-nav flex-row align-items-center ms-auto">
                        <!-- User -->
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    <img src="../public/layout/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar avatar-online">
                                                    <img src="../public/layout/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="fw-semibold d-block"><?= auth()['name'] ?></span>
                                                <small class="text-muted"></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bx bx-cog me-2"></i>
                                        <span class="align-middle">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/logout">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!--/ User -->
                    </ul>
                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-8 mb-4 order-0">
                            <div class="card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-7">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Pokedex of <?= auth()['name'] ?>! 🎉</h5>
                                            <p class="mb-4">
                                                ϞϞ〈๑⚈ ․̫⚈๑〉⋔
                                                ᕦ(⪧︹⪦)ᕤ
                                            </p>

                                            <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 text-center text-sm-left">
                                        <div class="card-body pb-0 px-0 px-md-4">
                                            <img
                                                src="../public/layout/img/illustrations/man-with-laptop-light.png"
                                                height="140"
                                                alt="View Badge User"
                                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                data-app-light-img="illustrations/man-with-laptop-light.png"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card overflow-scroll" style="height: 400px;">
                            <div class="d-flex align-items-end row">
                                <div class="card-body pokemons">
                                    <h5 class="card-title text-primary">My pokemon</h5>
                                        <?php foreach($pokemons as $key => $pokemon): ?>

                                        <?php if($key % 3 === 0): ?>
                                            <div class="row">
                                        <?php endif; ?>
                                            <div class="col-4">
                                                <div class="card card-custom shadow-sm my-2 card-bg-<?= $pokemon['types'][0]['name'] ?>">
                                                    <div class="card-body d-flex justify-content-between">
                                                        <section class="col-6">
                                                            <div class="d-flex">
                                                                <h5><?= $pokemon['name'] ?></h5>
                                                                <span>#<?= str_pad($pokemon['card_id'], 3, '0',STR_PAD_LEFT) ?></span>
                                                            </div>
                                                            <div class="mb-2">
                                                                Level: <?= xpToLevel($pokemon['experience']) ?>
                                                            </div>
                                                            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?= calculatePercentageLeft($pokemon) ?>" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar overflow-visible text-dark text-white fw-bold" style="width: <?= calculatePercentageLeft($pokemon) ?>%">
                                                                    <?= $pokemon['experience'] ?> / <?= totalXpUntilNextLevel($pokemon) ?> xp
                                                                </div>
                                                            </div>

                                                            <div class="mt-3">
                                                                <?php foreach($pokemon['types'] as $type): ?>
                                                                    <span class="badge rounded-pill text-bg-<?= $type['name'] ?>"><?= $type['name'] ?></span>
                                                                <?php endforeach; ?>
                                                            </div>

                                                        </section>
                                                        <section class="col-4 my-auto">
                                                            <img src="<?= $pokemon['image'] ?? 'https://m.media-amazon.com/images/I/71WkWKFRSWL.png' ?>" alt="" class="w-75">
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php if($key % 3 === 2): ?>
                                                </div>
                                            <?php endif; ?>

                                        <?php endforeach; ?>


                                    <button class="btn btn-sm btn-outline-primary col-6 mx-auto mt-3" id="loadMore">Load more</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by
                            <a href="#" target="_blank" class="footer-link fw-bolder">Pokedex</a>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

<!-- TODO: loadMore button -->
<!--    <script>-->
<!--        const loadMore = document.querySelector('#loadMore')-->
<!--        const currentCards = document.querySelectorAll('.pokemons .card').length-->
<!---->
<!--        loadMore.addEventListener('click', () => {-->
<!--            const form = new FormData()-->
<!--            form.append('limit', currentCards + 2)-->
<!---->
<!--            fetch('/pokedex', {-->
<!--                method: "POST",-->
<!--                // headers: {-->
<!--                //     'Content-Type': 'application/json',-->
<!--                //     'Accept': 'application/json'-->
<!--                // },-->
<!--                body: form-->
<!--            }).then(response => response.text())-->
<!--            .then((data) => console.log(data))-->
<!--        });-->
<!--    </script>-->

<?php include 'layout/footer.php' ?>