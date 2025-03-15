-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 02:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(57, 3, 131, 1),
(58, 3, 132, 1),
(59, 3, 130, 1),
(60, 3, 134, 1),
(61, 3, 133, 1),
(62, 3, 135, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `phone_number`, `location`, `payment_status`) VALUES
(27, 3, 2776.74, 'pending', '2025-03-12 11:32:08', '0716568609', 'kutus', 'paid'),
(28, 3, 682.12, 'pending', '2025-03-12 11:32:22', '0716568609', 'kutus', 'paid'),
(29, 3, 2251.64, 'pending', '2025-03-12 11:32:39', '0716568609', 'kutus', 'paid'),
(30, 3, 11020.21, 'pending', '2025-03-13 11:31:51', '0716568609', 'kutus', 'paid'),
(31, 3, 8400.00, 'pending', '2025-03-13 21:08:28', '0716568609', 'kutus', 'paid'),
(32, 10, 1200.00, 'pending', '2025-03-14 16:35:28', '0716568609', 'kutus', 'paid'),
(33, 10, 3500.00, 'pending', '2025-03-14 16:35:40', '0716568609', 'kutus', 'paid'),
(34, 10, 3500.00, 'pending', '2025-03-14 16:35:49', '0716568609', 'kutus', 'paid'),
(35, 10, 5000.00, 'pending', '2025-03-14 16:35:58', '0716568609', 'kutus', 'paid'),
(36, 10, 18600.00, 'pending', '2025-03-14 16:47:11', '0716568609', 'kutus', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(59, 31, 122, 7, 1200.00),
(60, 32, 122, 1, 1200.00),
(61, 33, 121, 1, 3500.00),
(62, 34, 121, 1, 3500.00),
(63, 35, 123, 1, 5000.00),
(64, 36, 123, 3, 5000.00),
(65, 36, 122, 3, 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `benefits` text NOT NULL,
  `targets` text NOT NULL,
  `clinical_effective_ingredients` text NOT NULL,
  `summary` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `stock`, `image_url`, `rating`, `created_at`, `benefits`, `targets`, `clinical_effective_ingredients`, `summary`, `brand`) VALUES
(121, 'Acne Control Set Salicylic Acid Cleanser Acne Spot Treatment Oil Free Moisturizer', '', 'A dermatologist-recommended 3-step acne treatment set designed to cleanse, treat, and hydrate acne-prone skin. The salicylic acid cleanser removes excess oil and unclogs pores, the spot treatment rapidly reduces breakouts, and the oil-free moisturizer keeps the skin hydrated without clogging pores.', 3500.00, 23, 'uploads/products/Acne_Control_Set_Salicylic_Acid_Cleanser_Acne_Spot_Treatment_Oil_Free_Moisturizer.jpg', 9.00, '2025-03-13 18:35:13', 'Reduces acne and blemishes, controls oil, prevents new breakouts, hydrates skin', 'Acne-prone skin, oily skin, breakouts', 'Salicylic Acid, Niacinamide, Hyaluronic Acid', 'A complete, clinically-proven acne solution for clear, healthy skin.', 'CeraVe, Neutrogena, La Roche-Posay'),
(122, 'Aloe Vera Soothing Gel', '', 'A lightweight and fast-absorbing aloe vera gel that instantly soothes and hydrates dry, irritated, or sunburned skin. Enriched with vitamin E, it helps reduce redness, calm inflammation, and accelerate skin healing.', 1200.00, 39, 'uploads/products/aloe_vera_soothing_gel.jpg', 8.00, '2025-03-13 18:35:13', 'Hydrates and soothes skin, reduces redness, promotes healing, cooling effect', 'All skin types, sunburned or sensitive skin', 'Aloe Vera Extract, Vitamin E', 'A natural, multi-purpose gel that calms and refreshes the skin.', 'Nature Republic'),
(123, 'Anti Aging Set Retinol Cream Eye Cream Vitamin C Serum', '', 'A powerful anti-aging skincare trio that targets fine lines, wrinkles, and skin dullness. The retinol cream smooths wrinkles and boosts collagen, the vitamin C serum brightens the skin and fades dark spots, and the eye cream reduces puffiness and under-eye circles.', 5000.00, 16, 'uploads/products/Anti_Aging_Set_Retinol_Cream_Eye_Cream_Vitamin_C_Serum.jpg', 9.00, '2025-03-13 18:35:13', 'Reduces fine lines and wrinkles, brightens skin, improves elasticity, hydrates', 'Mature skin, fine lines, dullness', 'Retinol, Vitamin C, Hyaluronic Acid', 'A clinically formulated anti-aging regimen for youthful, glowing skin.', 'Olay, Neutrogena, L’Oreal'),
(124, 'Argan Face Oil', '', 'A lightweight yet deeply nourishing facial oil packed with antioxidants and essential fatty acids. This 100% pure argan oil hydrates dry skin, strengthens the skin barrier, and provides long-lasting moisture without feeling greasy.', 1800.00, 30, 'uploads/products/argan_face_oil.jpg', 8.00, '2025-03-13 18:35:13', 'Deeply hydrates, restores skin barrier, provides antioxidants, non-greasy', 'Dry skin, sensitive skin, aging skin', 'Pure Argan Oil, Vitamin E', 'A premium facial oil that enhances skin hydration and elasticity.', 'The Ordinary'),
(125, 'CeraVe Acne Spot Treatment', '', 'A fast-acting acne spot treatment designed to reduce breakouts, redness, and inflammation. Formulated with benzoyl peroxide and niacinamide, it works deep within the pores to clear acne while keeping the skin calm and hydrated.', 1500.00, 40, 'uploads/products/cerave_acne_spot_treatment.jpg', 9.00, '2025-03-13 18:35:13', 'Clears acne, reduces redness, prevents future breakouts, gentle on skin', 'Acne-prone skin, oily skin', 'Benzoyl Peroxide, Niacinamide', 'A dermatologist-recommended spot treatment for stubborn acne.', 'CeraVe'),
(126, 'CeraVe Hyaluronic Acid Serum', '', 'An ultra-hydrating facial serum enriched with hyaluronic acid and ceramides. This lightweight, non-greasy formula deeply replenishes moisture, improves skin elasticity, and strengthens the skin barrier.', 2200.00, 35, 'uploads/products/cerave_hyaluronic_acid_serum.jpg', 9.00, '2025-03-13 18:35:13', 'Intensely hydrates, plumps skin, reduces dryness, restores moisture balance', 'Dry skin, dehydrated skin', 'Hyaluronic Acid, Ceramides', 'A scientifically formulated hydrating serum for smoother, plumper skin.', 'CeraVe'),
(127, 'CeraVe Hydrating Cleanser', '', 'A gentle, non-foaming face cleanser that effectively removes dirt, excess oil, and makeup without stripping the skin’s natural moisture. Infused with ceramides and hyaluronic acid, it helps maintain the skin barrier and keep the skin soft and hydrated.', 2500.00, 30, 'uploads/products/cerave_hydrating_cleanser.jpg', 9.99, '2025-03-13 18:35:13', 'Cleanses without drying, strengthens skin barrier, maintains hydration', 'Dry to normal skin, sensitive skin', 'Ceramides, Hyaluronic Acid', 'A dermatologist-developed hydrating cleanser for all-day comfort.', 'CeraVe'),
(128, 'CeraVe Sunscreen SPF 50', '', 'A lightweight, non-greasy broad-spectrum sunscreen that provides SPF 50 protection against UVA and UVB rays while keeping the skin hydrated. Formulated with zinc oxide and ceramides, it offers long-lasting sun defense and moisture.', 3000.00, 20, 'uploads/products/cerave_sunscreen_SPF_50.jpg', 9.00, '2025-03-13 18:35:13', 'Shields from UV damage, prevents sunburn, hydrating, non-comedogenic', 'All skin types, sun-exposed skin', 'Zinc Oxide, Titanium Dioxide', 'A dermatologist-tested sunscreen for superior sun protection.', 'CeraVe'),
(129, 'Cetaphil Moisturizing Day Cream SPF 30', '', 'A lightweight day cream with SPF 30 that hydrates while providing daily sun protection. It absorbs quickly, leaving the skin soft and nourished without feeling greasy.', 2700.00, 25, 'uploads/products/cetaphil_moisturizing_day_cream_SPF_30.jpg', 9.00, '2025-03-13 18:35:13', 'Moisturizes skin, protects from UV rays, non-comedogenic, lightweight', 'All skin types, sensitive skin', 'Glycerin, SPF 30', 'A dermatologist-approved moisturizer with built-in sun protection.', 'Cetaphil'),
(130, 'Garnier Clay Face Mask', '', 'A deep-cleansing clay mask infused with activated charcoal and kaolin clay to draw out impurities, absorb excess oil, and refine skin texture for a fresh, matte look.', 1500.00, 50, 'uploads/products/garnier_clay_face_mask.jpg', 8.00, '2025-03-13 18:35:13', 'Detoxifies skin, reduces oil, minimizes pores, smooths skin texture', 'Oily and combination skin', 'Charcoal, Kaolin Clay', 'A purifying clay mask that leaves the skin refreshed and glowing.', 'Garnier'),
(131, 'Garnier Exfoliating Face Scrub', '', 'A gentle yet effective exfoliating scrub made with fruit extracts and salicylic acid to remove dead skin cells, unclog pores, and promote a brighter complexion.', 1400.00, 40, 'uploads/products/garnier_exfoliating_face_scrub.jpg', 8.00, '2025-03-13 18:35:13', 'Exfoliates dead skin, unclogs pores, improves skin texture, brightens', 'Dull skin, rough skin', 'Salicylic Acid, Fruit Extracts', 'A revitalizing scrub for smooth, radiant skin.', 'Garnier'),
(132, 'Garnier Makeup Remover Micellar Water', '', 'A non-irritating micellar water that effectively removes makeup, dirt, and excess oil while keeping the skin hydrated. No rinsing required.', 1600.00, 60, 'uploads/products/garnier_makeup_remover_micellar_water.jpg', 9.00, '2025-03-13 18:35:13', 'Gently removes makeup, cleanses skin, hydrates, non-greasy', 'All skin types, including sensitive skin', 'Micelles, Glycerin', 'A gentle yet powerful micellar water for all-day freshness.', 'Garnier'),
(133, 'Garnier Vitamin C Serum', '', 'A powerful brightening serum infused with vitamin C to fade dark spots, even out skin tone, and boost overall radiance.', 2500.00, 30, 'uploads/products/garnier_vitamin_c_serum.jpg', 9.00, '2025-03-13 18:35:13', 'Fades dark spots, brightens complexion, reduces dullness, hydrates', 'Dull skin, uneven skin tone', 'Vitamin C, Hyaluronic Acid', 'A dermatologist-tested serum for a luminous, even-toned complexion.', 'Garnier'),
(134, 'Morning Routine Set Sunscreen Moisturizer Vitamin C Serum', '', 'A comprehensive morning skincare routine that includes a hydrating moisturizer, a broad-spectrum sunscreen, and a vitamin C serum to brighten and protect your skin throughout the day.', 4800.00, 18, 'uploads/products/Morning_Routine_Set_Sunscreen_Moisturizer_Vitamin_C_Serum.jpg', 9.00, '2025-03-13 18:39:32', 'Hydrates and nourishes skin, protects against UV damage, boosts radiance', 'All skin types, dull skin, sun-exposed skin', 'Vitamin C, SPF 50, Hyaluronic Acid', 'An all-in-one morning skincare set for glowing, protected skin.', 'CeraVe, Neutrogena, La Roche-Posay'),
(135, 'Nivea Lip Balm with SPF', '', 'A moisturizing lip balm infused with SPF to keep lips soft, hydrated, and protected from harmful UV rays.', 900.00, 60, 'uploads/products/nivea_lip_balm_with_SPF.jpg', 8.00, '2025-03-13 18:39:32', 'Prevents chapped lips, hydrates, protects against sun damage', 'Dry lips, sun-exposed lips', 'Shea Butter, SPF 15', 'A soothing lip balm that nourishes and protects.', 'Nivea'),
(136, 'Retinol Night Cream', '', 'An advanced night cream with retinol to combat signs of aging, promote skin renewal, and enhance elasticity for a youthful appearance.', 3200.00, 22, 'uploads/products/retinol_night_cream.jpg', 9.00, '2025-03-13 18:39:32', 'Reduces fine lines, improves skin texture, promotes cell turnover', 'Mature skin, wrinkles, dull skin', 'Retinol, Peptides, Hyaluronic Acid', 'A potent anti-aging night cream for firmer, smoother skin.', 'Olay, Neutrogena, L’Oreal'),
(137, 'Rose Water Toner', '', 'A refreshing and soothing toner enriched with pure rose water to balance, hydrate, and revitalize the skin.', 1600.00, 40, 'uploads/products/rose_water_toner.jpg', 8.50, '2025-03-13 18:39:32', 'Soothes irritation, tightens pores, restores skin’s pH balance', 'All skin types, sensitive skin, redness-prone skin', 'Pure Rose Water, Glycerin', 'A natural toner for refreshed, glowing skin.', 'Heritage Store, Mario Badescu'),
(138, 'Self Care Pamper Kit Clay Mask Hydrating Serum Face Mist', '', 'A luxurious self-care kit featuring a detoxifying clay mask, a deeply hydrating serum, and a refreshing face mist for the ultimate skincare experience.', 5200.00, 12, 'uploads/products/Self_Care_Pamper_Kit_Clay_Mask_Hydrating_Serum_Face_Mist.jpg', 9.00, '2025-03-13 18:39:32', 'Detoxifies and purifies, intensely hydrates, refreshes skin', 'All skin types, stressed skin, dull complexion', 'Kaolin Clay, Hyaluronic Acid, Aloe Vera', 'A premium skincare set for a spa-like pampering session.', 'Garnier, Neutrogena, The Body Shop'),
(139, 'Simple Anti-Aging Eye Cream', '', 'A gentle yet effective eye cream that reduces puffiness, smooths fine lines, and brightens the under-eye area.', 2300.00, 25, 'uploads/products/simple_anti_aging_eye_cream.jpg', 8.50, '2025-03-13 18:39:32', 'Reduces dark circles, minimizes fine lines, hydrates under-eye skin', 'Aging skin, tired eyes, sensitive skin', 'Peptides, Vitamin E, Hyaluronic Acid', 'A lightweight eye cream for youthful, refreshed eyes.', 'Simple, Olay, Neutrogena'),
(140, 'Garnier Exfoliating Face Scrub', '', 'An invigorating exfoliating scrub designed to deeply cleanse the skin, remove dead skin cells, and unclog pores for a smoother, more refined complexion. \r\n  Enriched with natural fruit extracts and salicylic acid, this scrub gently polishes away dullness while controlling excess oil production. \r\n  Its refreshing formula helps to reduce breakouts, even out skin texture, and leave your skin with a healthy, radiant glow. \r\n  Ideal for daily or bi-weekly use, it rejuvenates and preps the skin for better absorption of skincare products.', 1800.00, 30, 'uploads/products/garnier_exfoliating_face_scrub.jpg', 8.50, '2025-03-13 18:41:12', 'Exfoliates dead skin, deep cleans pores, brightens complexion, reduces breakouts', 'Oily skin, dull skin, rough texture, clogged pores', 'Salicylic Acid, Fruit Extracts, Vitamin C', 'A revitalizing exfoliating scrub that deeply cleanses and polishes for smoother, clearer skin.', 'Garnier');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` enum('Pending','On Route','Delivered') NOT NULL,
  `location` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking`
--

INSERT INTO `tracking` (`id`, `order_id`, `status`, `location`, `updated_at`) VALUES
(7, 27, 'Pending', '', '2025-03-12 11:32:13'),
(8, 28, 'Pending', '', '2025-03-12 11:32:25'),
(9, 29, 'Pending', '', '2025-03-12 11:32:43'),
(10, 30, 'Pending', '', '2025-03-13 11:33:30'),
(11, 31, 'Pending', '', '2025-03-13 21:08:33'),
(12, 32, 'Pending', '', '2025-03-14 16:35:32'),
(13, 33, 'Pending', '', '2025-03-14 16:35:43'),
(14, 34, 'Pending', '', '2025-03-14 16:35:52'),
(15, 35, 'Pending', '', '2025-03-14 16:36:02'),
(16, 36, 'Pending', '', '2025-03-14 16:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(15) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `phone_number`, `location`) VALUES
(3, 'cleopas', 'beyondreality4002@gmail.com', '$2y$10$sOtLt/eKSRfw0DkoEFKStePVF/VVwurQ76rSai45RLoIASVt8SUgS', '2025-03-06 09:33:02', '0716568609', 'Joska, Machakos'),
(4, 'cleopas', 'cleopasmmuchiri@gmail.com', '$2y$10$tCO1oDPAAgtJltKqIUCjt.08ZgG8rnV70b1qZcEUa0aJNXOD9Hgjq', '2025-03-06 09:42:44', '0789469989', 'Kutus, Kirinyaga'),
(5, 'aysha', 'aysha@gmail.com', '$2y$10$/0qvXMijPmycqODuBeOQqut2p7jIQLlrPAsW2QrHYJLulBZTu2/3W', '2025-03-06 10:06:32', '0701787100', 'Majengo, Mombasa'),
(6, 'swise', 'swise@gmail.com', '$2y$10$XtrLAuAy63qqZwp51kGS3OuLaDtJmFZb/m/H0VQCYb1Pf5R8D1.Nm', '2025-03-06 12:04:03', '0720498549', 'Taveta, Taita Taveta'),
(9, 'cleo', 'cleo@gmail.com', '$2y$10$6ADKnZVkynRDSlNu5yyUOuMiBnxPfUKSNnrA5FIzQxNv0SnSp4nFq', '2025-03-14 16:03:19', '0716568609', 'kutus'),
(10, 'cleopas', 'cleo1234@gmail.com', '$2y$10$sfLQDJV03H1cPQJw/82jFes3dHLGJ1ZoGi.oNjygv3VCRKhYMvABm', '2025-03-14 16:11:54', '0716568608', 'kutus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
