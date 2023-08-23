<style>
    #sidebar {
        -webkit-transition: all 300ms cubic-bezier(0, 0.77, 0.58, 1);
        transition: all 300ms cubic-bezier(0, 0.77, 0.58, 1);
    }

    #sidebar.show {
        transform: translateX(0);
    }
</style>

<!-- Navbar start -->
<nav id="navbar" class="sticky top-0 z-50 flex w-full flex-row justify-end bg-gray-200 px-4 sm:justify-between">
    <button id="btnSidebarToggler" type="button" class="py-4 text-2xl text-gray-600 hover:text-black">
        <svg id="navClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="h-8 w-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg id="navOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" class="hidden h-8 w-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</nav>
<!-- Navbar end -->

<!-- Sidebar start-->
<div id="containerSidebar" class="z-40">
    <div class="navbar-menu relative z-40">
        <nav id="sidebar"
             class="fixed left-0 bottom-0 flex w-3/4 -translate-x-full flex-col overflow-y-auto bg-gray-200 pt-6 pb-8 sm:max-w-xs lg:w-80">

            <div class="px-4 pb-6">
                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 pl-4 pr-6"
                        x-data
                        x-on:change="window.location.href = '/lang/' + $event.target.value">
                    <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>ES</option>
                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                </select>
            </div>

            <!-- one category / navigation group -->
            <div class="px-4 pb-6">
                <h3 class="mb-2 text-xs font-medium uppercase text-gray-600">Main</h3>
                <ul class="mb-8 text-sm font-medium">
                    <li>
                        <a class="active flex items-center rounded py-3 pl-3 pr-4 text-gray-800 hover:bg-gray-300" href="/">
                            <span class="select-none">Homepage</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- navigation group end-->

            <!-- example copies start -->
            <div class="px-4 pb-6">
                <h3 class="mb-2 text-xs font-medium uppercase text-gray-600">Game</h3>
                <ul class="mb-8 text-sm font-medium">
                    <li>
                        <a class="flex items-center rounded py-3 pl-3 pr-4 text-gray-800 hover:bg-gray-300" href="/codex">
                            <span class="select-none">Codex</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center rounded py-3 pl-3 pr-4 text-gray-800 hover:bg-gray-300" href="/skills">
                            <span class="select-none">Skills</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center rounded py-3 pl-3 pr-4 text-gray-800 hover:bg-gray-300" href="/cards">
                            <span class="select-none">Cards</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- example copies end -->

            <!-- example copies start -->
            <div class="px-4 pb-6">
                <h3 class="mb-2 text-xs font-medium uppercase text-gray-600">Tools</h3>
                <ul class="mb-8 text-sm font-medium">
                    <li>
                        <a class="flex items-center rounded py-3 pl-3 pr-4 text-gray-800 hover:bg-gray-300" href="/cards">
                            <span class="select-none">Card generator</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- example copies end -->

        </nav>
    </div>

    <div class="mx-auto lg:ml-80"></div>
</div>
<!-- Sidebar end -->

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        const navbar = document.getElementById("navbar");
        const sidebar = document.getElementById("sidebar");
        const btnSidebarToggler = document.getElementById("btnSidebarToggler");
        const navClosed = document.getElementById("navClosed");
        const navOpen = document.getElementById("navOpen");

        btnSidebarToggler.addEventListener("click", (e) => {
            e.preventDefault();
            sidebar.classList.toggle("show");
            navClosed.classList.toggle("hidden");
            navOpen.classList.toggle("hidden");
        });

        sidebar.style.top = parseInt(navbar.clientHeight) - 1 + "px";
    });
</script>
