<!-- Hamburger Backdrop -->
<div
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="hamburgerBackdrop">
</div>

<!-- Mobile sidebar -->
<aside
    class="mobileAside"
    x-show="isSideMenuOpen"
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20"
    @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">

    <div class="asideText">
        <a class="logoText" href="#">
            <span class="ml-4" role="link" tabindex="0" onclick="openPage('browse.php')">covertAudio</span>
        </a>

        <?php include("sideListItems.php");?>

    </div>
</aside>
<!-- END MOBILE SIDEBAR  -->