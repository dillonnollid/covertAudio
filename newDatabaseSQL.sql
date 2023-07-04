SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `covertAudio`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(5) NOT NULL,
  `genre` int(3) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8;

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `genre` int(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;

CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `playlistSongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `songs` (
`id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(5) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(3) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;


INSERT INTO `albums`
(`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Unknown', 100, 15, 'assets/images/artwork/unknown.jpg'),
(2, 'Chill Dance', 100, 2, 'assets/images/artwork/slowDance.jpg'),
(3, 'Heavy Dance', 100, 3, 'assets/images/artwork/heavyDance.jpg'),
(4, 'US Beats', 100, 1, 'assets/images/artwork/yandhiBlack.jpg'),
(5, 'UK Beats', 100, 1, 'assets/images/artwork/iridescence.jpg'),
(6, 'Other Rap', 100, 1, 'assets/images/artwork/mosQuest.jpg'),
(7, 'Focus', 100, 15, 'assets/images/artwork/focus.jpg'),
(8, 'Sleep', 100, 7, 'assets/images/artwork/sleep.jpg'),
(9, 'Mindful', 100, 15, 'assets/images/artwork/beatles.jpg'),
(10, 'Indescribable', 100, 7, 'assets/images/artwork/earl.jpg'),
(11, 'Glow In The Dark', 10, 1, 'assets/images/artwork/gitd.jpg');

INSERT INTO `artists` (`id`, `name`, `genre`) VALUES
(1, 'empe3', 5),
(2, 'Douvelle', 5),
(3, 'Kendrick', 4),
(4, 'DOOM', 4),
(5, 'Ye', 4),
(6, 'Cudi', 4),
(7, 'Meek', 4),
(8, 'Biggie', 4),
(9, 'Pac', 4),
(10, 'Freddie', 4),
(11, 'Don', 4),
(12, 'Denz', 4),
(13, 'Frank', 4),
(14, 'JPEG', 4),
(15, 'DMX', 4),
(16, 'Souls', 4),
(17, 'Nujab', 2),
(18, 'Joey', 4),
(19, 'Posty', 1),
(20, 'Isaiah', 4),
(21, 'L', 4),
(22, 'Erick', 4),
(23, 'Kings', 9),
(24, 'Melia', 9),
(25, 'Cookin', 4),
(100, 'Other', 10);

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rap'),
(2, 'Dance/House'),
(3, 'Trance/Techno'),
(4, 'Rock/Metal'),
(5, 'Popular'),
(6, 'Indie/Alt'),
(7, 'Chill/Sleep'),
(8, 'Meditation'),
(9, 'Instrumental'),
(10, 'Jazz/Soul'),
(11, 'Classical'),
(12, 'Country/Folk'),
(13, 'Comedy'),
(14, 'Podcasts'),
(15, 'Other');


ALTER TABLE `albums` ADD PRIMARY KEY (`id`);
ALTER TABLE `artists` ADD PRIMARY KEY (`id`);
ALTER TABLE `genres` ADD PRIMARY KEY (`id`);
ALTER TABLE `playlists` ADD PRIMARY KEY (`id`);
ALTER TABLE `playlistSongs` ADD PRIMARY KEY (`id`);
ALTER TABLE `songs` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `albums` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
ALTER TABLE `artists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
ALTER TABLE `genres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
ALTER TABLE `playlists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `playlistSongs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `songs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;