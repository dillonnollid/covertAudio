<!-- Insert desktop and mobile aside -->
<?php
include_once("desktopAside.php");
include_once("mobileAside.php");
?>

<!-- DIV OUTSIDE HEADER -->
<div class="outsideHeader">
    <header class="mainHeader">
        <div class="subHeader">
            <!-- Mobile hamburger -->
            <button
                class="hamburger"
                @click="toggleSideMenu"
                aria-label="Menu">
                <svg
                    class="w-6 h-6"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            
            <!-- Search input NOT YET CONFIGURED WITH TW-->
            <div class="searchContainer">
                <div class="searchBox">
                    <!-- Search Icon Container -->
                    <div class="searchIcon">
                        <svg
                            class="w-4 h-4"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    <input
                        class="searchInput pl-8 pr-2"
                        type="text"
                        placeholder="Search for stuff"
                        aria-label="Search"
                    />
                </div>
            </div>

            <!-- Header Button List -->
            <ul class="headerButtonList">
                <!-- Theme toggler -->
                <li class="flex">
                    <button
                        class="headerButton"
                        @click="toggleTheme"
                        aria-label="Toggle color mode">

                        <template x-if="!dark">
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                </path>
                            </svg>
                        </template>
                        <template x-if="dark">
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd">
                                </path>
                            </svg>
                        </template>
                    </button>
                </li>
                <!-- Notifications menu -->
                <!--<li class="relative">
                    <button
                        class="headerButton relative align-middle"
                        @click="toggleNotificationsMenu"
                        @keydown.escape="closeNotificationsMenu"
                        aria-label="Notifications"
                        aria-haspopup="true">
                        <svg
                            class="w-5 h-5"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>

                        <span
                            aria-hidden="true"
                            class="notifBadge">
                        </span>
                    </button>
                    <template x-if="isNotificationsMenuOpen">
                        <ul
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @click.away="closeNotificationsMenu"
                            @keydown.escape="closeNotificationsMenu"
                            class="notifMenu">

                            <li class="flex">
                                <div class="notifOption" href="#">
                                    <span onclick="openPage('messages.php')">Messages</span>
                                    <span class="notifNumber">
                                ?
                                </span>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="notifOption" href="#">
                                    <span onclick="openPage('requests.php')" >Requests</span>
                                    <span class="notifNumber">
                                        ?
                                    </span>
                                </div>
                            </li>
                            <li class="flex">
                                <div class="notifOption" href="#">
                                    <span onclick="openPage('alerts.php')">Alerts</span>
                                </div>
                            </li>
                        </ul>
                    </template>
                </li>-->

                <!-- Profile menu -->
                <li class="relative">
                    <button
                        class="headerButton align-middle"
                        @click="toggleProfileMenu"
                        @keydown.escape="closeProfileMenu"
                        aria-label="Account"
                        aria-haspopup="true">
                        <img
                            class="profilePhoto"
                            src="./<?php echo $userLoggedIn->getProfilePhotoPath();?>"
                            alt=""
                            aria-hidden="true"/>
                    </button>
                    <?php //echo $userLoggedIn->getName();?>
                    <template x-if="isProfileMenuOpen">
                        <ul
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            @click.away="closeProfileMenu"
                            @keydown.escape="closeProfileMenu"
                            class="profileMenu"
                            aria-label="submenu">

                            <!--<li class="flex">
                                <div class="notifOption">
                                    <svg
                                        class="w-4 h-4 mr-3"
                                        aria-hidden="true"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span role="link" tabindex="0" onclick="openPage('updateDetails.php')">Profile</span>
                                </div>
                            </li>-->
                            <li class="flex">
                                <div class="notifOption" onclick="openPage('settings.php')">
                                    <svg
                                        class="w-4 h-4 mr-3"
                                        aria-hidden="true"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span role="link" tabindex="0" onclick="openPage('settings.php')">Settings</span>
                                </div>
                            </li>
                            <li class="flex">
                                <a href="includes/handlers/logout-handler.php" class="notifOption">
                                    <svg
                                        class="w-4 h-4 mr-3"
                                        aria-hidden="true"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Log out</span>
                                </a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        </div>
    </header>
<!--</div>-->

