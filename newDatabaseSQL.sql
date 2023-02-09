SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `covertAudio`
--

CREATE TABLE IF NOT EXISTS `albums` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `artists` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `genres` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `playlists` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `playlistSongs` (
`id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


INSERT INTO `albums`
(`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Unknown', 100, 15, 'assets/images/artwork/unknown.jpg'),
(2, 'Chill Dance', 100, 2, 'assets/images/artwork/slowDance.jpg'),
(3, 'Heavy Dance', 100, 3, 'assets/images/artwork/heavyDance.jpg'),
(4, 'US Rap/Hip-Hop', 100, 1, 'assets/images/artwork/yandhiBlack.jpg'),
(5, 'UK Rap/Hip-Hop', 100, 1, 'assets/images/artwork/iridescence.jpg'),
(6, 'Other Rap/Hip-Hop', 100, 1, 'assets/images/artwork/mosQuest.jpg'),
(7, 'Focus Tunes', 100, 15, 'assets/images/artwork/focus.jpg'),
(8, 'Sleep Tunes', 100, 7, 'assets/images/artwork/sleep.jpg'),
(9, 'Mindfulness', 100, 15, 'assets/images/artwork/beatles.jpg'),
(10, 'Indescribable', 100, 7, 'assets/images/artwork/earl.jpg'),
(11, 'Glow In The Dark Tour', 10, 1, 'assets/images/artwork/gitd.jpg');

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Brock'),
(2, 'Kendrick'),
(3, 'Travis'),
(4, 'DOOM'),
(5, 'Ye'),
(6, 'Cudi'),
(7, 'Drake'),
(8, 'Don'),
(9, 'Biggie'),
(10, 'Freddie'),
(11, 'Playboi'),
(12, 'Denz'),
(13, 'Frank'),
(14, 'JPEG'),
(15, 'Meek'),
(16, 'Pac'),
(17, 'DMX'),
(18, 'Souls Of Mischief'),
(19, 'Nujabes'),
(20, 'Joey'),
(21, 'Nas'),
(22, 'Posty'),
(23, 'Isaiah'),
(24, 'XXX'),
(25, 'empe3'),
(26, 'KNXWLEDGE'),
(27, 'Erick The Architect'),
(28, 'Kings Of Leon'),
(29, 'Melia'),
(30, 'Cookin Soul'),
(31, 'Big L'),
(100, 'Other');

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


ALTER TABLE `albums` ADD PRIMARY KEY (`id`);
ALTER TABLE `artists` ADD PRIMARY KEY (`id`);
ALTER TABLE `genres` ADD PRIMARY KEY (`id`);
ALTER TABLE `playlists` ADD PRIMARY KEY (`id`);
ALTER TABLE `playlistSongs` ADD PRIMARY KEY (`id`);
ALTER TABLE `Songs` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `albums` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
ALTER TABLE `artists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
ALTER TABLE `genres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
ALTER TABLE `playlists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `playlistSongs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `Songs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;