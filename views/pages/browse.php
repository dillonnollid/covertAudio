<?php 
require(__DIR__ . '/../../includes/includedFiles.php');

use controllers\MusicController;
use controllers\UserController;

$musicController = new MusicController();
$userController = UserController::getInstance();
?>

<div class="container p-6 mx-auto grid h-full">
    <?php 
        require_once(__DIR__ . '/../components/errorMessages.php');
        require_once(__DIR__ . '/../components/nowPlayingBar.php');        
    ?>
    <br>

    <div class="infoCardContainer">
        <!-- Song Card -->
        <div class="infoCard">
            <div class="infoContent">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </div>
            <div>
                <p class="themeText">
                    Total Songs
                </p>
                <p class="themeText">
                    <?php
                        $songCount = $musicController->getTotalSongCount();
                        echo $songCount;
                    ?>
                </p>
            </div>
        </div>

        <!-- Album Card -->
        <div class="infoCard">
            <div class="infoContent">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </div>
            <div>
                <p class="themeText">
                    Total Albums
                </p>
                <p class="themeText">
                    <?php
                        echo $musicController->getTotalAlbumCount();
                    ?>
                </p>
            </div>
        </div>

        <!-- Genre Card -->
        <div class="infoCard">
            <div class="infoContent">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </div>
            <div>
                <p class="themeText">
                    Total Genres
                </p>
                <p class="themeText">
                    <?php
                        echo $musicController->getTotalGenreCount();
                    ?>
                </p>
            </div>
        </div>

        <!-- User Card -->
        <div class="infoCard">
            <div class="infoContent">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </div>
            <div>
                <p class="themeText">
                    Total Users
                </p>
                <p class="themeText">
                    <?php
                        echo $userController->getTotalUserCount();
                    ?>
                </p>
            </div>
        </div>

    </div>

    <!-- Song Table -->
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Album</th>
                    <th class="px-4 py-3">Genre</th>
                    <th class="px-4 py-3">Runtime</th>
                </tr>
                </thead>

                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <?php
                    $songs = $musicController->getAllSongs();
                    foreach ($songs as $song) {
                       $tempArtist = $song->getArtist();
                       $tempAlbum = $song->getAlbum();
                       $tempGenre = $song->getGenre();
                       ?>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full" src="<?php echo $tempAlbum->getArtworkPath();?>" alt="" loading="lazy">
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <div class="font-semibold cursor-pointer" onclick="setTrack(<?php echo $song->getId() ?>, tempPlaylist, true)"><?php echo $song->getName() ?></div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 cursor-pointer" onclick='openPage("artistView.php?id=" + <?php echo $tempArtist->getID();?>)'><?php echo $tempArtist->getName(); ?></div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm cursor-pointer"><div onclick='openPage("albumView.php?id=" + <?php echo $tempAlbum->getID();?>)'><?php echo $tempAlbum->getName();?></td>
                            <td class="px-4 py-3 text-xs"><span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-purple-700 dark:text-purple-100"><?php echo $tempGenre->getName();?></span></td>
                            <td class="px-4 py-3 text-sm"><?php echo $song->getDuration() ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                Displaying <?php echo $songCount;?> Songs (All)
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <!--<span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
              <nav aria-label="Table navigation">
                <ul class="inline-flex items-center">
                  <li>
                    <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue" aria-label="Previous">
                      <svg
                              aria-hidden="true"
                              class="w-4 h-4 fill-current"
                              viewBox="0 0 20 20">
                        <path
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                                fill-rule="evenodd">
                        </path>
                      </svg>
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                      1
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                      2
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 text-white transition-colors duration-150 bg-blue-600 border border-r-0 border-blue-600 rounded-md focus:outline-none focus:shadow-outline-blue">
                      3
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                      4
                    </button>
                  </li>
                  <li>
                    <span class="px-3 py-1">...</span>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                      8
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue">
                      9
                    </button>
                  </li>
                  <li>
                    <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-blue" aria-label="Next">
                      <svg
                          class="w-4 h-4 fill-current"
                          aria-hidden="true"
                          viewBox="0 0 20 20">
                          <path
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd">
                          </path>
                      </svg>
                    </button>
                  </li>
                </ul>
              </nav>
            </span>-->
        </div>
    </div>
</div>

