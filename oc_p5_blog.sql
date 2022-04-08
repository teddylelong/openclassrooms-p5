-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 08 avr. 2022 à 18:19
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `oc_p5_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `pk_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fk_user_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`pk_id`, `title`, `excerpt`, `content`, `created_at`, `fk_user_id`, `updated_at`) VALUES
(144, 'Lorem ipsum, dolor sit amet', 'sit amet ultricies tellus euismod rutrum. Vivamus id arcu tempor, auctor magna eget, lobortis orci', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer porttitor sapien non tempus sagittis. Praesent lacinia sit amet elit sit amet pretium. Aliquam a lacus eu magna consectetur luctus et eget arcu. In ut interdum libero, aliquam ullamcorper massa. Sed ultricies mollis interdum. Proin dolor felis, dapibus id neque sed, tempus imperdiet ipsum. Nullam suscipit neque vitae sapien vestibulum sollicitudin. Mauris nunc velit, convallis malesuada viverra non, elementum a dolor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n\r\nPellentesque placerat nulla est, sit amet ultricies tellus euismod rutrum. Vivamus id arcu tempor, auctor magna eget, lobortis orci. Nullam lectus erat, fermentum sed ante ut, interdum euismod tellus. Aliquam erat volutpat. Curabitur neque mi, condimentum in commodo sed, fringilla et nibh. Nullam imperdiet luctus lectus, in suscipit nibh accumsan quis. Sed nec orci lorem. Praesent feugiat ex at arcu condimentum, at lacinia nibh varius. Donec erat nunc, commodo bibendum neque quis, faucibus sollicitudin ante. Proin auctor est porttitor, tempus dui a, faucibus diam. ', '2022-02-17 18:23:15', 20, '2022-04-08 18:11:19'),
(145, 'Tellus sodales', 'Morbi vel est dictum, dictum mauris vitae, sagittis elit. Donec venenatis nisi ut quam tristique, et vulputate tellus sodales', 'Vestibulum nisl quam, suscipit vel cursus eu, hendrerit quis augue. In hac habitasse platea dictumst. Fusce neque dui, porttitor sed nibh in, placerat lobortis purus. Etiam arcu mi, fermentum sit amet mauris quis, rhoncus varius ex. Integer mattis suscipit odio sit amet varius. Etiam sed odio mi. Vivamus venenatis enim ut eleifend blandit. Vestibulum nulla eros, auctor id consequat in, congue et ligula. Phasellus egestas lacinia tortor, mollis mollis diam ultricies in. Etiam auctor libero aliquet sem placerat venenatis. Etiam sed massa cursus neque vehicula tincidunt non vitae sem. Fusce ut bibendum ligula, sit amet commodo nunc. Proin consequat ante a velit fringilla rhoncus. Pellentesque lorem metus, feugiat id neque ac, maximus mattis enim. Sed molestie ipsum a est lobortis aliquet.\r\n\r\nPhasellus in sagittis orci, eget auctor neque. Pellentesque feugiat eros vitae tortor cursus viverra. Aliquam tincidunt commodo orci vitae hendrerit. Nunc efficitur ut purus sit amet tristique. Curabitur ultricies dapibus purus ac sagittis. Nullam commodo odio a dui commodo viverra. Vestibulum quis ligula vel leo varius condimentum. In odio enim, cursus at arcu ut, porta tincidunt lectus. Mauris ut est leo. Sed ornare auctor consectetur. Nam tristique tincidunt lacinia. Nullam consectetur lorem ac nisl egestas tincidunt. Aliquam in ultricies nunc. Morbi vel est dictum, dictum mauris vitae, sagittis elit. Donec venenatis nisi ut quam tristique, et vulputate tellus sodales. ', '2022-02-17 18:23:56', 20, '2022-03-17 13:04:29'),
(162, 'Intégration du Markdown', 'Cet article utilise le ** markdown ** !', '## titre secondaire\r\n\r\n- Test\r\n- Test\r\n\r\nVisitez notre [site web](https://www.google.com \"Google\") !', '2022-03-18 20:08:23', 20, '2022-04-06 06:53:26'),
(168, 'Vivamus venenatis enim', 'Etiam sed massa cursus neque vehicula tincidunt non vitae sem.', 'Vestibulum nisl quam, suscipit vel cursus eu, hendrerit quis augue. In hac habitasse platea dictumst. Fusce neque dui, porttitor sed nibh in, placerat lobortis purus. Etiam arcu mi, fermentum sit amet mauris quis, rhoncus varius ex. Integer mattis suscipit odio sit amet varius. Etiam sed odio mi. Vivamus venenatis enim ut eleifend blandit. Vestibulum nulla eros, auctor id consequat in, congue et ligula. Phasellus egestas lacinia tortor, mollis mollis diam ultricies in. Etiam auctor libero aliquet sem placerat venenatis. Etiam sed massa cursus neque vehicula tincidunt non vitae sem. Fusce ut bibendum ligula, sit amet commodo nunc. Proin consequat ante a velit fringilla rhoncus. Pellentesque lorem metus, feugiat id neque ac, maximus mattis enim. Sed molestie ipsum a est lobortis aliquet.\r\n\r\nPhasellus in sagittis orci, eget auctor neque. Pellentesque feugiat eros vitae tortor cursus viverra. Aliquam tincidunt commodo orci vitae hendrerit. Nunc efficitur ut purus sit amet tristique. Curabitur ultricies dapibus purus ac sagittis. Nullam commodo odio a dui commodo viverra. Vestibulum quis ligula vel leo varius condimentum. In odio enim, cursus at arcu ut, porta tincidunt lectus. Mauris ut est leo. Sed ornare auctor consectetur. Nam tristique tincidunt lacinia. Nullam consectetur lorem ac nisl egestas tincidunt. Aliquam in ultricies nunc. Morbi vel est dictum, dictum mauris vitae, sagittis elit. Donec venenatis nisi ut quam tristique, et vulputate tellus sodales. ', '2022-02-03 18:13:56', 20, NULL),
(169, 'Donec a metus feugiat metus', 'Suspendisse potenti. In orci dui, rutrum ut pretium a, ornare ut dui. In sodales lorem in nibh faucibus imperdiet. Donec egestas tempor ex vel suscipit.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a metus feugiat metus condimentum lobortis eget quis dui. Sed et magna tristique, aliquet odio vitae, consectetur dui. Duis faucibus ligula sapien, sed posuere nulla tincidunt sed. Nam malesuada nisi id enim hendrerit feugiat. Nam tincidunt velit nec nunc laoreet euismod. Fusce auctor enim ut elementum tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris vitae diam tincidunt, mattis ligula id, hendrerit eros. Morbi convallis hendrerit quam in volutpat. Donec non quam vitae libero scelerisque sodales. Vestibulum ultricies vulputate lorem vel vehicula. Suspendisse potenti. In orci dui, rutrum ut pretium a, ornare ut dui. In sodales lorem in nibh faucibus imperdiet. Donec egestas tempor ex vel suscipit. Nulla tempor condimentum nunc, eget consectetur sapien malesuada ac.\r\n\r\nEtiam ex nibh, dignissim ut ultrices quis, varius sit amet justo. Donec velit metus, maximus vel dui nec, ultrices congue nisl. Donec sed efficitur mauris. Etiam dictum lacus id tellus varius laoreet. Ut in tempor metus, id sagittis libero. Vivamus pharetra, urna nec vestibulum elementum, lectus metus tempus ante, a facilisis lacus purus sit amet orci. Aenean posuere libero eu mollis porttitor. Maecenas sodales lacus vel nibh dapibus hendrerit. Pellentesque ultricies convallis est, ut aliquam justo lobortis ac. In ullamcorper massa a varius ultricies. \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a metus feugiat metus condimentum lobortis eget quis dui. Sed et magna tristique, aliquet odio vitae, consectetur dui. Duis faucibus ligula sapien, sed posuere nulla tincidunt sed. Nam malesuada nisi id enim hendrerit feugiat. Nam tincidunt velit nec nunc laoreet euismod. Fusce auctor enim ut elementum tincidunt. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris vitae diam tincidunt, mattis ligula id, hendrerit eros. Morbi convallis hendrerit quam in volutpat. Donec non quam vitae libero scelerisque sodales. Vestibulum ultricies vulputate lorem vel vehicula. Suspendisse potenti. In orci dui, rutrum ut pretium a, ornare ut dui. In sodales lorem in nibh faucibus imperdiet. Donec egestas tempor ex vel suscipit. Nulla tempor condimentum nunc, eget consectetur sapien malesuada ac.\r\n\r\nEtiam ex nibh, dignissim ut ultrices quis, varius sit amet justo. Donec velit metus, maximus vel dui nec, ultrices congue nisl. Donec sed efficitur mauris. Etiam dictum lacus id tellus varius laoreet. Ut in tempor metus, id sagittis libero. Vivamus pharetra, urna nec vestibulum elementum, lectus metus tempus ante, a facilisis lacus purus sit amet orci. Aenean posuere libero eu mollis porttitor. Maecenas sodales lacus vel nibh dapibus hendrerit. Pellentesque ultricies convallis est, ut aliquam justo lobortis ac. In ullamcorper massa a varius ultricies. ', '2022-04-08 12:25:14', 20, NULL),
(170, 'Pellentesque feugiat eros vitae', 'Etiam arcu mi, fermentum sit amet mauris quis, rhoncus varius ex. Integer mattis suscipit odio sit amet varius. Etiam sed odio mi. Vivamus venenatis enim ut eleifend blandit. ', 'Vestibulum nisl quam, suscipit vel cursus eu, hendrerit quis augue. In hac habitasse platea dictumst. Fusce neque dui, porttitor sed nibh in, placerat lobortis purus. Etiam arcu mi, fermentum sit amet mauris quis, rhoncus varius ex. Integer mattis suscipit odio sit amet varius. Etiam sed odio mi. Vivamus venenatis enim ut eleifend blandit. Vestibulum nulla eros, auctor id consequat in, congue et ligula. Phasellus egestas lacinia tortor, mollis mollis diam ultricies in. Etiam auctor libero aliquet sem placerat venenatis. Etiam sed massa cursus neque vehicula tincidunt non vitae sem. Fusce ut bibendum ligula, sit amet commodo nunc. Proin consequat ante a velit fringilla rhoncus. Pellentesque lorem metus, feugiat id neque ac, maximus mattis enim. Sed molestie ipsum a est lobortis aliquet.\r\n\r\nPhasellus in sagittis orci, eget auctor neque. Pellentesque feugiat eros vitae tortor cursus viverra. Aliquam tincidunt commodo orci vitae hendrerit. Nunc efficitur ut purus sit amet tristique. Curabitur ultricies dapibus purus ac sagittis. Nullam commodo odio a dui commodo viverra. Vestibulum quis ligula vel leo varius condimentum. In odio enim, cursus at arcu ut, porta tincidunt lectus. Mauris ut est leo. Sed ornare auctor consectetur. Nam tristique tincidunt lacinia. Nullam consectetur lorem ac nisl egestas tincidunt. Aliquam in ultricies nunc. Morbi vel est dictum, dictum mauris vitae, sagittis elit. Donec venenatis nisi ut quam tristique, et vulputate tellus sodales. ', '2022-04-07 14:23:56', 20, '2022-03-17 13:04:29');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `pk_id` int(11) NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_approved` enum('pending','approved','disapproved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`pk_id`, `author`, `email`, `content`, `created_at`, `is_approved`, `article_id`) VALUES
(50, 'Daniel', 'dan@email.com', 'Superbe article, merci ! 😁', '2022-04-05 07:32:29', 'approved', 144),
(51, 'Mathieu', 'matt@example.com', 'Génial, merci pour l\'info 😎', '2022-04-05 07:34:29', 'approved', 145),
(52, 'Teddy (admin)', 'teddy.lelong@gmail.com', 'Avec plaisir !', '2022-04-05 07:35:11', 'approved', 144);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `pk_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `pk_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`pk_id`, `name`, `permissions`) VALUES
(1, 'administrateur', 'article.create, article.index, article.update, article.delete, comment.create, comment.manage, comment.delete, user.index, user.create, user.update, user.delete'),
(2, 'modérateur', 'article.create, article.index, comment.manage, comment.create, user.index');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `pk_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fk_role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pk_id`, `firstname`, `lastname`, `email`, `password`, `created_at`, `fk_role_id`) VALUES
(20, 'Teddy', 'Lelong', 'teddy.lelong@gmail.com', '$2y$10$gOl7o7YFotcr0gYOpbgVWO/dSViJzg3ViLRsb.bQRbbcOkcWonfnm', '2022-03-15 20:02:24', 1),
(26, 'Admin', 'Test', 'admin@test.com', '$2y$10$i4mcP19DsbSgOod78.CfB.4tWJ5DNe3xYoKgrQ2gXUiWZqm2bm87S', '2022-04-05 07:09:33', 1),
(27, 'Modo', 'Test', 'modo@test.fr', '$2y$10$wnjFUiTkbV5jhvFk79bkcODiPJHCXdxlqs2iLf.84Q0YQ0EhxSTKa', '2022-04-08 17:14:15', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`pk_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `FK_ARTICLES` (`article_id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`pk_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`pk_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `fk_role_id` (`fk_role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `article_delete` FOREIGN KEY (`article_id`) REFERENCES `articles` (`pk_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_role_id`) REFERENCES `role` (`pk_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
