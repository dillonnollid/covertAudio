
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `covert`
--

-- --------------------------------------------------------
--
-- Table structure for table `albums`
--
CREATE TABLE IF NOT EXISTS `albums` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
--
-- Dumping data for table `albums`
--
INSERT INTO `albums` 
(`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Unknown', 100, 15, 'assets/images/artwork/clearday.jpg'),
(2, 'Chill Dance', 100, 2, 'assets/images/artwork/energy.jpg'),
(3, 'Heavy Dance', 100, 3, 'assets/images/artwork/goinghigher.jpg'),
(4, 'US Rap/Hip-Hop', 100, 1, 'assets/images/artwork/funkyelement.jpg'),
(5, 'UK Rap/Hip-Hop', 100, 1, 'assets/images/artwork/popdance.jpg'),
(6, 'Other Rap/Hip-Hop', 100, 1, 'assets/images/artwork/ukulele.jpg'),
(7, 'Focus Tunes', 100, 15, 'assets/images/artwork/sweet.jpg'),
(8, 'Sleep Tunes', 100, 7, 'assets/images/artwork/sweet.jpg'),
(9, 'Off the Rocker', 100, 15, 'assets/images/artwork/sweet.jpg'),
(10, 'Dont have a fuckin clue!', 100, 7, 'assets/images/artwork/sweet.jpg'),
(11, 'Glow In The Dark Tour', 10, 1, 'assets/images/artwork/gitd.jpg');
-- --------------------------------------------------------
--
-- Table structure for table `artists`
--
CREATE TABLE IF NOT EXISTS `artists` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
--
-- Dumping data for table `artists`
--
INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Kanye West'),
(2, 'Kendrick Lamar'),
(3, 'Travis Scott'),
(4, 'Don Toliver'),
(5, 'BROCKHAMPTON'),
(6, 'Kid Cudi'),
(7, 'Drake'),
(8, 'MF DOOM'),
(9, 'Biggie Smalls'),
(10, 'Freddie Gibbs'),
(10, 'Big L'),
(11, 'Playboi Carti'),
(12, 'Denzel Curry'),
(13, 'Frank Ocean'),
(14, 'JPEGMAFIA'),
(15, 'Meek Mill'),
(16, 'Tupac'),
(17, 'DMX'),
(18, 'Souls Of Mischief'),
(19, 'Nujabes'),
(20, 'Joey Badass'),
(21, 'Nas'),
(22, 'Post Malone'),
(23, 'Isaiah Rashad'),
(24, 'XXXTentacion'),
(25, 'S.T.E.E.L'),
(26, 'KNXWLEDGE'),
(27, 'Erick The Architect'),
(28, 'Kings Of Leon'),
(29, 'Melia'),
(30, 'Cookin Soul'),
(100, 'Other');
-- --------------------------------------------------------
--
-- Table structure for table `genres`
--
CREATE TABLE IF NOT EXISTS `genres` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
--
-- Dumping data for table `genres`
--
INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rap/Hip-Hop'),
(2, 'Dance/House/Electonic'),
(3, 'Trance/Techno/Heavy'),
(4, 'Rock/Metal'),
(5, 'Popular'),
(6, 'Indie/Alternative'),
(7, 'Chill/Sleep'),
(8, 'Meditation'),
(9, 'Instrumental'),
(10, 'Jazz/Soul'),
(11, 'Classical'),
(12, 'Country/Folk'),
(13, 'Audiobooks'),
(14, 'Podcasts'),
(15, 'Other');
-- --------------------------------------------------------
--
-- Table structure for table `playlists`
--
CREATE TABLE IF NOT EXISTS `playlists` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table structure for table `playlistSongs`
--
CREATE TABLE IF NOT EXISTS `playlistSongs` (
`id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- Table structure for table `Songs`
--
CREATE TABLE IF NOT EXISTS `Songs` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;


-- Dumping data for table `Songs`
--

INSERT INTO `Songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`) VALUES
(32, 'Flashing Lights (GITD VERSION)', 1, 11, 4, '4:43', 'assets/music/flashing.mp3', 4, 0),
(33, 'Good Life (GITD VERSION)', 1, 11, 4, '4:30', 'assets/music/goodlife.mp3 ', 3, 0),
(34, 'I Wonder/Heard Em Say (GITD VERSION)', 1, 11, 4, '4:30', 'assets/music/wonder.mp3 ', 2, 0),
(35, 'Stronger (GITD VERSION)', 1, 11, 4, '6:17', 'assets/music/stronger.mp3 ', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(1, 'dillo', 'Dillo', 'Kello', 'dillonnollid@gmail.com', 'XX', '2022-02-02 00:00:00', 'assets/images/profile-pics/head_emerald.png'),
(2, 'donkey-kong', 'Donkey', 'Kong', 'Dk@yahoo.com', '7c6a180b36896a0a8c02787eeafb0e4c', '2017-06-28 00:00:00', 'assets/images/profile-pics/head_emerald.png');


--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistSongs`
--
ALTER TABLE `playlistSongs` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Songs`
--
ALTER TABLE `Songs` ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlistSongs`
--
ALTER TABLE `playlistSongs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Songs`
--
ALTER TABLE `Songs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
