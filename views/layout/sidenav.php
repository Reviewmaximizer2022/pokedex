<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand mt-3">
        <a href="/home" class="app-brand-link">
              <span class="app-brand-logo">
                <img src="../public/images/pokeapi.svg" alt="" class="w-50 p-5">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item <?php if(route('/home')): ?> active <?php endif; ?>">
            <a href="/home" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
<!--        <li class="menu-item">-->
<!--            <a href="javascript:void(0);" class="menu-link menu-toggle">-->
<!--                <i class="menu-icon tf-icons bx bx-layout"></i>-->
<!--                <div data-i18n="Layouts">Layouts</div>-->
<!--            </a>-->
<!---->
<!--            <ul class="menu-sub">-->
<!--                <li class="menu-item">-->
<!--                    <a href="layouts-without-menu.html" class="menu-link">-->
<!--                        <div data-i18n="Without menu">Without menu</div>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="menu-item">-->
<!--                    <a href="layouts-without-navbar.html" class="menu-link">-->
<!--                        <div data-i18n="Without navbar">Without navbar</div>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="menu-item">-->
<!--                    <a href="layouts-container.html" class="menu-link">-->
<!--                        <div data-i18n="Container">Container</div>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="menu-item">-->
<!--                    <a href="layouts-fluid.html" class="menu-link">-->
<!--                        <div data-i18n="Fluid">Fluid</div>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="menu-item">-->
<!--                    <a href="layouts-blank.html" class="menu-link">-->
<!--                        <div data-i18n="Blank">Blank</div>-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </li>-->
    </ul>
</aside>
<!-- / Menu -->