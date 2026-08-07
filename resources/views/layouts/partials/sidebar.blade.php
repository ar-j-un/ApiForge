<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand me-auto">
            <span class="fs-5 fw-semibold sidebar-brand-full">{{ config('app.name', 'ApiForge') }}</span>
            <span class="fs-5 fw-semibold sidebar-brand-narrow">AF</span>
        </div>
        <button class="btn-close d-lg-none" type="button" aria-label="Close"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
    </div>

    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="var(--ci-primary-color, currentcolor)" d="M425.706 142.294A240 240 0 0 0 16 312v88h144v-32H48v-56c0-114.691 93.309-208 208-208s208 93.309 208 208v56H352v32h144v-88a238.43 238.43 0 0 0-70.294-169.706" class="ci-primary" />
                    <path fill="var(--ci-primary-color, currentcolor)" d="M80 264h32v32H80zm160-136h32v32h-32zm-104 40h32v32h-32zm264 96h32v32h-32zm-102.778 71.1 69.2-144.173-28.85-13.848-69.183 144.135a64.141 64.141 0 1 0 28.833 13.886M256 416a32 32 0 1 1 32-32 32.036 32.036 0 0 1-32 32" class="ci-primary" />
                </svg>
                Home
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('applications.*') ? 'active' : '' }}" href="{{ route('applications.index') }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="var(--ci-primary-color, currentcolor)" d="M16 48v416h480V48Zm448 384H48v-96h416Zm0-128H48v-96h416ZM48 176V80h416v96Z" class="ci-primary" />
                    <path fill="var(--ci-primary-color, currentcolor)" d="M80 112h32v32H80zm0 128h32v32H80zm0 128h32v32H80z" class="ci-primary" />
                </svg>
                Applications
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">
                <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <rect width="288" height="32" x="112" y="152" fill="var(--ci-primary-color, currentcolor)" class="ci-primary" />
                    <rect width="288" height="32" x="112" y="240" fill="var(--ci-primary-color, currentcolor)" class="ci-primary" />
                    <rect width="152" height="32" x="112" y="328" fill="var(--ci-primary-color, currentcolor)" class="ci-primary" />
                    <path fill="var(--ci-primary-color, currentcolor)" d="M480,48H32V464H480ZM448,432H64V80H448Z" class="ci-primary" />
                </svg>
                Blogs
            </a>
        </li>
        
    </ul>

    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>







{{-- <li class="nav-title">Recipes</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('recipes.*') ? 'active' : '' }}" href="{{ route('recipes.index') }}">
                <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                All Recipes
            </a>
        </li> --}}

      {{-- <li class="nav-item">
            <a class="nav-link {{ request()->is('accordion') ? 'active' : '' }}" href="{{ route('api') }}">
                <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                Api
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('slideshow') ? 'active' : '' }}" href="{{ route('slideshow') }}">
                <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                Slideshow
            </a>
        </li> --}}