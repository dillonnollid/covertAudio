<?php include("includes/includedFiles.php");?>

<div class="container p-6 mx-auto grid h-full">

    <?php include("includes/nowPlayingBar.php");?>
    <br>
    <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Headin
    </h2>
    <br>

    <!-- CTA GOOD FOR LATER
    <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-blue-100 bg-blue-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-blue" href="https://github.com/estevanmaito/windmill-dashboard">
        <div class="flex items-center">
            <svg
                class="w-5 h-5 mr-2"
                fill="currentColor"
                viewBox="0 0 20 20">

                <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                </path>
            </svg>
            <span>Star this project on GitHub</span>
        </div>
        <span>View more &RightArrow;</span>
    </a>-->

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Card -->
        <!--<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
                    ></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total clients
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200" >
                    9000+
                </p>
            </div>
        </div>-->

        <!-- Card -->
        <!--<div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                            fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"
                    ></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Account balance
                </p>

                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    $ 46,760.89
                </p>
            </div>
        </div>-->

        <!-- Song Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                            fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd"
                    ></path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Songs
                </p>

                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <?php
                        //BEFORE PRINTING OUT COUNT TO SONGS, LOAD ALL SONG INFO FOR LATER USE
                        $songs = mysqli_query($con, "SELECT * FROM songs");
                        $amount = mysqli_num_rows($songs);
                        echo $amount;
                    ?>
                </p>
            </div>
        </div>

        <!-- Album Card -->
        <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path
                            fill-rule="evenodd"
                            d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                            clip-rule="evenodd">
                    </path>
                </svg>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Albums
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    <?php
                        //BEFORE PRINTING OUT COUNT TO SONGS, LOAD ALL SONG INFO FOR LATER USE
                        $albums = mysqli_query($con, "SELECT * FROM albums");
                        $albumCount = mysqli_num_rows($albums);
                        echo $albumCount;
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
                    while($row = mysqli_fetch_array($songs)) {
                       $tempArtist = new Artist($con, $row['artist']);
                       $tempAlbum = new Album($con, $row['album']);
                       $tempGenre = new Genre($con, $row['genre']);
                       ?>
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full" src="<?php echo $tempAlbum->getArtworkPath();?>" alt="" loading="lazy">
                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <a class="font-semibold" onclick="setTrack(<?php echo $row['id'] ?>, tempPlaylist, true)"><?php echo $row['title'] ?></a><br>
                                        <a class="text-xs text-gray-600 dark:text-gray-400"><?php echo $tempArtist->getName(); ?></a>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm"><a onclick='openPage("album.php?id=" + <?php echo $tempAlbum->getID();?>)'><?php echo $tempAlbum->getTitle(); ?></a></td>
                            <td class="px-4 py-3 text-xs"><span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"><?php echo $tempGenre->getName();?></span></td>
                            <td class="px-4 py-3 text-sm"><?php echo $row['duration'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
        >
            <span class="flex items-center col-span-3">
              Showing X-Y of <?php echo $amount;?>
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
              <nav aria-label="Table navigation">
                <ul class="inline-flex items-center">
                  <li>
                    <button
                            class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-blue"
                            aria-label="Previous"
                    >
                      <svg
                              aria-hidden="true"
                              class="w-4 h-4 fill-current"
                              viewBox="0 0 20 20"
                      >
                        <path
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                                fill-rule="evenodd"
                        ></path>
                      </svg>
                    </button>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
                      1
                    </button>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
                      2
                    </button>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 text-white transition-colors duration-150 bg-blue-600 border border-r-0 border-blue-600 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
                      3
                    </button>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
                      4
                    </button>
                  </li>
                  <li>
                    <span class="px-3 py-1">...</span>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
                      8
                    </button>
                  </li>
                  <li>
                    <button
                            class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-blue"
                    >
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
            </span>
        </div>
    </div>
</div>

