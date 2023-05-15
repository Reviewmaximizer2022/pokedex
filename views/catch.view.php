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
            <div class="container-xxl flex-grow-1">
                <div class="row">
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Welcome back <?= auth()['name'] ?>! 🎉</h5>
                                        <p class="mb-4">
                                            ϞϞ〈๑⚈ ․̫⚈๑〉⋔
                                            ᕦ(⪧︹⪦)ᕤ
                                        </p>

                                        <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if(is_array($pokemons)): ?>
                            <div class="row">
                                <?php foreach($pokemons as $pokemon): ?>
                                <div class="col-4">
                                    <form action="/pokemon/catch/try" method="POST">
                                        <input type="hidden" name="pokemon_id" value="<?= $pokemon['id'] ?>">
                                        <input type="hidden" name="capture_rate" value="<?= $pokemon['capture_rate'] ?>">
                                        <input type="hidden" name="catch_rate" value="<?= $pokemon['catch_rate'] ?>">
                                        <input type="hidden" name="experience" value="<?= $pokemon['base_experience'] ?>">

                                        <button type="submit" class="btn btn-transparent col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <img src="<?= $pokemon['image'] ?>" alt="" class="w-25">
                                                    <?= $pokemon['name'] ?>

                                                    <?= xpToLevel($pokemon['base_experience']) ?>

                                                    <div class="progress mt-4" role="progressbar" aria-label="Example with label" aria-valuenow="<?= $pokemon['capture_rate'] ?>" aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar overflow-visible text-dark text-white fw-bold" style="width: <?= $pokemon['capture_rate'] ?>%">
                                                            <?= $pokemon['capture_rate'] ?> / 100 %
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                                <div class="alert alert-danger my-auto text-center">You have no points anymore, come back tomorrow!</div>
                            <?php endif; ?>
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

<?php include 'layout/footer.php' ?>
