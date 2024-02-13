-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 13 fév. 2024 à 21:21
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shop_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `product_id` int(20) NOT NULL,
  `price` float NOT NULL,
  `qty` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `number`, `message`, `created_at`) VALUES
(1, 'Harrabi Fadwa', 'fadwaharrabi58@gmail.com', '51730254', ' nothing', '2024-02-05 20:42:56'),
(2, 'Harrabi Fadwa', 'fadwaharrabi58@gmail.com', '51730254', ' nothing', '2024-02-05 20:48:25'),
(3, 'Harrabi Fadwa', 'fadwaharrabi58@gmail.com', '51730254', 'Fukamushi Sencha Tea is my favorite product in your shop.', '2024-02-05 20:50:05');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address_type` varchar(50) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `address`, `address_type`, `method`, `product_id`, `price`, `qty`, `date`, `status`) VALUES
(1, 0, 'Harrabi Fadwa', '1', 'fadwaharrabi58@gmail.com', 'Sidi Bouzid, Sfax, Sidi Bouzid , tunisie, 454464', 'home', 'cash on delivery', 3, 160.00, 1, '2024-01-22 20:07:33', 'shipped'),
(2, 0, 'Harrabi Fadwa', '2', 'fadwaharrabi58@gmail.com', 'Sidi Bouzid, Sfax, Sidi Bouzid , tunisie, 454464', 'home', 'cash on delivery', 14, 80.00, 1, '2024-01-23 15:59:17', 'canceled'),
(3, 123, 'Harrabi Fadwa', '8461', 'bilelharrabi@gmail.com', 'Sidi Bouzid, Sfax, Sidi Bouzid , tunisie, 298645', 'office', 'paypal', 3, 160.00, 1, '2024-02-03 23:08:25', 'rejected'),
(4, 0, 'zouhour bellamine', '5', 'zouhourbellamine@gmail.com', 'sfax, sfax, Monastir, Monastir, 12345', 'office', 'paypal', 4, 50.00, 1, '2024-02-05 14:24:07', 'Accept'),
(5, 0, 'imen souissi', '25366985', 'imen@gmail.com', 'Sfax, kerkenah, Sfax, cité ons, 7485', 'office', 'easypaisa', 3, 160.00, 1, '2024-02-07 21:15:32', 'canceled'),
(6, 0, 'imen souissi', '25366985', 'imen@gmail.com', 'Sfax, kerkenah, Sfax, cité ons, 7485', 'office', 'easypaisa', 6, 80.00, 1, '2024-02-07 21:15:32', 'shipped'),
(7, 0, 'imen souissi', '74859612', 'imen@gmail.com', 'Sfax, kerkenah, Monastir, Monastir, 298645', 'office', 'paypal', 2, 200.00, 5, '2024-02-07 21:18:17', 'shipped'),
(8, 0, 'ragheb', '98745632', 'raghebharrabi@gmail.com', 'Sidi Bouzid , Sidi Bouzid , Sidi Bouzid , Tataouin, 7412', 'office', 'paypal', 13, 70.00, 8, '2024-02-07 21:21:25', 'rejected'),
(9, 0, 'ghaith krifa', '25856545', 'ghaithkrifa@gmail.com', 'Monastir, Monastir, Sfax, tunisie, 75964', 'home', 'net banking', 4, 50.00, 1, '2024-02-07 21:29:08', '0');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_detail` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `product_detail`, `created_at`) VALUES
(2, 'Fukamushi Sencha Tea', 200.00, '65ac0c45941a0.jpg', '.', '2024-02-03 23:54:27'),
(3, 'Kabusecha Green Tea', 160.00, '65ac0c7d61ec3.jpg', '.', '2024-02-03 23:54:27'),
(4, 'Gykuro Green Tea', 50.00, '65ac0cbb0cc3e.jpg', '.', '2024-02-03 23:54:27'),
(6, 'Lemon Verbena Tea', 80.00, '65ac0d0c59ef4.jpg', '.', '2024-02-03 23:54:27'),
(8, 'Gunpowder Tea', 120.00, '65ac0d57d5a3c.jpg', '.', '2024-02-03 23:54:27'),
(9, 'Minty Lemon Iced Tea', 95.00, '65ac0d7d4e9bc.jpg', '.', '2024-02-03 23:54:27'),
(11, 'Lemon Green Tea', 123.00, '65ac1429e72d1.jpg', '.', '2024-02-03 23:54:27'),
(13, 'Longjing Tea', 70.00, '65ac1565441bc.jpg', '.', '2024-02-03 23:54:27'),
(14, 'Sweet Iced Lemon Tea', 80.00, '65ac168320524.jpg', '.', '2024-02-03 23:54:27'),
(15, 'Tea', 203.00, '20240204005516-1.webp', 'moringa', '2024-02-03 23:55:16');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `gender`) VALUES
('0123', 'admin', 'admin@gmail.com', 'admin123', 'admin', 'female'),
('aoNPugcpJDnkity4Vdhv', 'zouhour bellamine', 'zouhourbellamine@gmail.com', 'zouhour123', 'user', 'female'),
('Gjg9q0dCgs6IMLR1GJA8', 'Harrabi Ragheb', 'raghebharrabi@gmail.com', '753', 'user', 'male'),
('HiaEEduwqxo8XNteZNPr', 'Nourelhouda@gmail.co', 'nourelhouda2000@gmail.com', 'nour123', 'user', 'female'),
('L5UtBbi6aWbA8EObbjrk', 'Harrabi Fadwa', 'fadwaharrabi58@gmail.com', '1234', 'user', 'female'),
('pg1RxWig8vmPO2vQObTD', 'imen souissi', 'imen@gmail.com', 'imen123', 'user', 'female'),
('pZuEXgtNTkKccnGFTy6C', 'molka trabelsi', 'molka85@gmail.com', '74185', 'user', 'female'),
('qjr4nqtY9vHnYFbZ8qrl', 'Slimeni Anis', 'anisslimeni@gmail.com', '2525', 'user', 'male'),
('tE2NXu8Yr3QOyb2gcQsR', 'chouroukkedri', 'chouroukkedri@gmail.com', 'chourouk123', 'user', 'female'),
('u0oi0Byw5kQcBpEAEOat', 'ghaith krifa', 'ghaithkrifa@gmail.com', 'ghaith147', 'user', 'male'),
('u1MVeUAOylkW8aB7Ijns', 'Harrabi Bilel', 'bilelharrabi@gmail.com', '159', 'user', 'male');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` varchar(50) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(20,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `price`) VALUES
('20dnojdpebMii84YLZQZ', 'aoNPugcpJDnkity4Vdhv', 3, 160),
('2A2nak3CViXZIANuc11U', 'jquHY0MKrMdoNXxGU98X', 14, 80),
('880lUkvbD3w1r383k2P0', 'L5UtBbi6aWbA8EObbjrk', 9, 95),
('AeQnN89cJmy7hEGJtqwi', 'jquHY0MKrMdoNXxGU98X', 6, 80),
('dtXqYMMD5xSwMc2ezwgW', 'jquHY0MKrMdoNXxGU98X', 4, 50),
('EeV0HZTnbLZYsqFWZFaS', 'L5UtBbi6aWbA8EObbjrk', 13, 70),
('GZRqW6pwRmyU4FSZAUvb', 'aoNPugcpJDnkity4Vdhv', 4, 50),
('k7x0v4b4m2NdSDqkzoRd', 'L5UtBbi6aWbA8EObbjrk', 3, 160),
('kP8EOd9rAwAR8QZXOuNk', 'jquHY0MKrMdoNXxGU98X', 13, 70),
('M5sCyEJpsVmzylQ474aY', 'aoNPugcpJDnkity4Vdhv', 15, 203),
('Oswnhs9fy4bhtvARMpQ6', 'pg1RxWig8vmPO2vQObTD', 4, 50),
('OTk2MiwSHBLexi5TbPOZ', 'aoNPugcpJDnkity4Vdhv', 6, 80),
('SKcoBm4weDuUmbMmULr4', 'pg1RxWig8vmPO2vQObTD', 9, 95),
('WcVvLl5aJDtwFKhdtXVU', 'jquHY0MKrMdoNXxGU98X', 11, 123),
('xAfDq7fgjSBEgig1id4o', 'aoNPugcpJDnkity4Vdhv', 13, 70),
('YMo0r32LMpyeeFqKAV3y', 'aoNPugcpJDnkity4Vdhv', 9, 95);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
