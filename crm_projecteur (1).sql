-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 20 août 2026 à 15:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `crm_projecteur`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent_product_commissions`
--

CREATE TABLE `agent_product_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `commission` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(5, 'projecteur Led', 'projecteur-led', NULL, '2026-08-07 15:26:59', '2026-08-07 15:26:59');

-- --------------------------------------------------------

--
-- Structure de la table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `paid_at` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `company_documents`
--

CREATE TABLE `company_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `company`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Café Fleur de Lys', '0699887766', 'contact@cafefleur.ma', 'Avenue Mohammed V, Appt 12, Rabat', 'Café Fleur S.A.R.L', 'Intéressé par projection extérieure rotative', NULL, '2026-07-26 15:17:59', '2026-07-26 15:17:59'),
(2, 'Hôtel Atlas Marrakech', '0522445566', 'front@atlasmarrakech.com', 'Hivernage, Boulevard El Yarmouk, Marrakech', 'Hotels Atlas Group', 'Demande de logo étanche IP67 haute luminosité', NULL, '2026-07-26 15:17:59', '2026-07-26 15:17:59'),
(3, 'Alpha Rentals', '0707407425', 'alpha_admin@rentals.com', 'hay sania rue bir chifa 167 tangier', 'alachioc', NULL, 1, '2026-07-26 22:53:57', '2026-07-26 22:53:57'),
(4, 'AYMANE', '5345345353', 'gfgd@ljhsd.com', 'fgsdgffsdf', NULL, NULL, 1, '2026-07-26 22:59:57', '2026-07-26 22:59:57'),
(5, 'حسن أمين', '0691493896', 'abdo.edawdi20@gmail.com', 'حي السلام شارع 25 الدار البيضاء', 'khayr parc', NULL, 4, '2026-08-11 14:02:56', '2026-08-18 23:18:55'),
(6, 'حسن امين', '0661342505', 'hassan.amine2013@gmail.com', 'شارع مسيرة الخضراء ايت ملول انزكان مركب خير بارك', 'khayr parc', NULL, 4, '2026-08-11 16:31:33', '2026-08-11 16:31:33');

-- --------------------------------------------------------

--
-- Structure de la table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `category`, `amount`, `date`, `description`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'Commission Agent - adam chabih (CMD-LCL1QZBN)', 'Commissions', 150.00, '2026-08-19', 'Règlement de commission pour la commande CMD-LCL1QZBN.', 1, '2026-08-18 23:33:14', '2026-08-18 23:33:14'),
(5, 'Commission Agent - adam chabih (CMD-7CWKNQUR)', 'Commissions', 150.00, '2026-08-19', 'Règlement global de commission. Commande: CMD-7CWKNQUR. Notes: Règlement global des commissions de l\'agent', 1, '2026-08-18 23:35:20', '2026-08-18 23:35:20'),
(6, 'Commission Agent - adam chabih (CMD-JVXOLZAM)', 'Commissions', 150.00, '2026-08-19', 'Règlement global de commission. Commande: CMD-JVXOLZAM. Notes: Règlement global des commissions de l\'agent', 1, '2026-08-18 23:35:20', '2026-08-18 23:35:20');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_26_155638_create_permission_tables', 1),
(5, '2026_07_26_155659_create_customers_table', 1),
(6, '2026_07_26_155703_create_products_table', 1),
(7, '2026_07_26_155707_create_orders_table', 1),
(8, '2026_07_26_155710_create_order_items_table', 1),
(9, '2026_07_26_155714_create_payments_table', 1),
(10, '2026_07_26_155721_create_commissions_table', 1),
(11, '2026_07_26_155725_create_expenses_table', 1),
(12, '2026_07_26_155728_create_prospect_files_table', 1),
(13, '2026_07_26_155732_create_prospects_table', 1),
(14, '2026_07_26_155737_create_trainings_table', 1),
(15, '2026_07_26_155740_create_supplier_orders_table', 1),
(16, '2026_07_26_155745_add_role_fields_to_users_table', 1),
(17, '2026_07_28_023000_add_prix_fournisseur_to_products_and_order_items', 2),
(18, '2026_07_28_024000_add_commission_agent_to_products_and_order_items', 3),
(19, '2026_07_28_025000_add_agent_fields_to_users_table', 4),
(20, '2026_07_28_013811_create_role_permissions_table', 5),
(21, '2026_07_28_030000_create_categories_table', 6),
(22, '2026_07_28_031000_add_category_id_to_products_table', 6),
(23, '2026_08_08_140000_add_fiche_technique_to_products_table', 7),
(24, '2026_08_08_143000_create_company_documents_table', 7),
(25, '2026_08_08_150000_split_cin_card_in_users_table', 7),
(26, '2026_08_08_160000_create_agent_product_commissions_table', 8),
(27, '2026_08_12_000000_add_media_buyer_role_permissions', 9),
(28, '2026_08_12_000001_add_supplier_default_permissions', 10);

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('draft','pending','confirmed','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_cash` decimal(10,2) NOT NULL DEFAULT 0.00,
  `advance_transfer` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining` decimal(10,2) NOT NULL DEFAULT 0.00,
  `logo_path` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `code`, `customer_id`, `agent_id`, `status`, `total`, `advance_cash`, `advance_transfer`, `remaining`, `logo_path`, `notes`, `delivery_date`, `created_at`, `updated_at`) VALUES
(8, 'CMD-U8X7ZRI9', 4, 1, 'delivered', 3600.00, 900.00, 0.00, 3420.00, 'logos/gQKLyInBJDu0eu3p5ngmU7xpqRuGZzqP5Rk7kPG6.jpg', 'gdfgdfgdgdfg', '2026-08-21', '2026-08-18 23:37:49', '2026-08-18 23:39:31');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `prix_fournisseur` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_agent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_code`, `quantity`, `unit_price`, `prix_fournisseur`, `commission_agent`, `total`, `description`, `created_at`, `updated_at`) VALUES
(8, 8, 5, 'projecteur 55W FIXE', 'P55F', 1, 3600.00, 1900.00, 150.00, 3600.00, NULL, '2026-08-18 23:37:49', '2026-08-18 23:37:49');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` enum('cash','transfer','cheque','other') NOT NULL DEFAULT 'cash',
  `payment_date` date NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `recorded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `prix_fournisseur` decimal(10,2) NOT NULL DEFAULT 0.00,
  `commission_agent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `fiche_technique` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `description`, `category`, `category_id`, `price`, `prix_fournisseur`, `commission_agent`, `stock`, `image`, `fiche_technique`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'P55F', 'projecteur 55W FIXE', 'Etanche IP65  durée 30000h  utilisation éxterieur interieur raccordement électrique  dimensions : 25*9*29cm. poids 2.75kg. temperature 6500K\r\ntempérature -20c  /  + 65c', 'projecteur Led', 5, 3600.00, 1900.00, 150.00, 79, 'products/zvagF62FwNfkDZEhFi6za17mx3d1JGfUeCwNVZ0J.jpg', NULL, 1, '2026-08-07 15:34:50', '2026-08-18 23:37:49'),
(6, 'P55R', 'projecteur 55W rotatif', 'Logo Rotatif avec télecommande  Etanche IP65  durée 30000h  utilisation éxterieur interieur raccordement électrique  dimensions : 25*9*29cm. poids 2.75kg. temperature 6500K\r\ntempérature -20c  /  + 65c', 'projecteur Led', 5, 3900.00, 2200.00, 150.00, 8, 'products/oT4vCy7IjJudSrlBF0XpRdm8tl3OCtRfIX7sbGGr.jpg', NULL, 1, '2026-08-07 15:46:37', '2026-08-18 23:36:39');

-- --------------------------------------------------------

--
-- Structure de la table `prospects`
--

CREATE TABLE `prospects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prospect_file_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `status` enum('pending','called','interested','not_interested','wrong_number') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prospects`
--

INSERT INTO `prospects` (`id`, `prospect_file_id`, `name`, `phone`, `status`, `notes`, `called_at`, `created_at`, `updated_at`) VALUES
(132, 22, '1;Bouzidi imade;666699344;Rabat;;;;;;;;;;;;;;;;;;;;', '1;Bouzidi imade;666699344;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(133, 22, '2;Nourdin;642575968;Kaalaat magona;;;;;;;;;;;;;;;;;;;;', '2;Nourdin;642575968;Kaalaat magona;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(134, 22, '3;FROM;640178080;Fes;;;;;;;;;;;;;;;;;;;;', '3;FROM;640178080;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(135, 22, '4;محمد;679555782;Tanger;;;;;;;;;;;;;;;;;;;;', '4;محمد;679555782;Tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(136, 22, '5;Ayoub;621999401;Midelt;;;;;;;;;;;;;;;;;;;;', '5;Ayoub;621999401;Midelt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(137, 22, '6;الحاض;639410979;للخميسات;;;;;;;;;;;;;;;;;;;;', '6;الحاض;639410979;للخميسات;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(138, 22, '7;LafdilOtmane;722887508;Garcif;;;;;;;;;;;;;;;;;;;;', '7;LafdilOtmane;722887508;Garcif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(139, 22, '8;Issa;638673841;Laayoune;;;;;;;;;;;;;;;;;;;;', '8;Issa;638673841;Laayoune;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(140, 22, '9;kaoutar;661244430;Guercif;;;;;;;;;;;;;;;;;;;;', '9;kaoutar;661244430;Guercif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(141, 22, '10;Mohamed hajji;612894139;Nador;;;;;;;;;;;;;;;;;;;;', '10;Mohamed hajji;612894139;Nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(142, 22, '11;Ahmed lebsir;626873922;Laayoune;;;;;;;;;;;;;;;;;;;;', '11;Ahmed lebsir;626873922;Laayoune;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(143, 22, '12;Ghita;661083665;Makhfiya 15', 'Rcif', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(144, 22, '13;Youness essalhi;660377420;تملالت;;;;;;;;;;;;;;;;;;;;', '13;Youness essalhi;660377420;تملالت;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(145, 22, '14;Zolati;661491538;Erachidiya;;;;;;;;;;;;;;;;;;;;', '14;Zolati;661491538;Erachidiya;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(146, 22, '15;zakaria Ziko shop;606061393;El jadida;;;;;;;;;;;;;;;;;;;;', '15;zakaria Ziko shop;606061393;El jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(147, 22, '16;Rachid;661229239;Rabat;;;;;;;;;;;;;;;;;;;;', '16;Rachid;661229239;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(148, 22, '17;Hemmouda;661360430;Meknes;;;;;;;;;;;;;;;;;;;;', '17;Hemmouda;661360430;Meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(149, 22, '18;Jamal;606947789;Bengrer;;;;;;;;;;;;;;;;;;;;', '18;Jamal;606947789;Bengrer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(150, 22, '19;Abdelhakim;609714949;Bengrer;;;;;;;;;;;;;;;;;;;;', '19;Abdelhakim;609714949;Bengrer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(151, 22, '20;Aziz;649215728;Beni mellal;;;;;;;;;;;;;;;;;;;;', '20;Aziz;649215728;Beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(152, 22, '21;Hamza;650810442;Beni mellal;;;;;;;;;;;;;;;;;;;;', '21;Hamza;650810442;Beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(153, 22, '22;yassine;614440471;سطات;;;;;;;;;;;;;;;;;;;;', '22;yassine;614440471;سطات;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(154, 22, '23;sophimeb;654842194;;;;;;;;;;;;;;;;;;;;;', '23;sophimeb;654842194;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(155, 22, '24;mourabit;661740423;nador;;;;;;;;;;;;;;;;;;;;', '24;mourabit;661740423;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(156, 22, '25;;698193017;;;;;;;;;;;;;;;;;;;;;', '25;;698193017;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(157, 22, '26;;688069630;Casa ( Snack);;;;;;;;;;;;;;;;;;;;', '26;;688069630;Casa ( Snack);;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(158, 22, '27;Adam imsak;778918312;azro;;;;;;;;;;;;;;;;;;;;', '27;Adam imsak;778918312;azro;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(159, 22, '28;-;607884207;-;;;;;;;;;;;;;;;;;;;;', '28;-;607884207;-;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(160, 22, '29;Faycel;606982541;khoribga;;;;;;;;;;;;;;;;;;;;', '29;Faycel;606982541;khoribga;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(161, 22, '30;Sofyan chenttouf;641774342;errachidia;;;;;;;;;;;;;;;;;;;;', '30;Sofyan chenttouf;641774342;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(162, 22, '31;Ayman;639001982;casa boulevard tah;;;;;;;;;;;;;;;;;;;;', '31;Ayman;639001982;casa boulevard tah;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(163, 22, '32;abdallah kounoz;666701605;Rabat;;;;;;;;;;;;;;;;;;;;', '32;abdallah kounoz;666701605;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(164, 22, '33;fatima jebari;627985603;sidi hotman;;;;;;;;;;;;;;;;;;;;', '33;fatima jebari;627985603;sidi hotman;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(165, 22, '34;dakhla;609060680;tirs;;;;;;;;;;;;;;;;;;;;', '34;dakhla;609060680;tirs;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(166, 22, '35;sanae;615652082;kenitra;;;;;;;;;;;;;;;;;;;;', '35;sanae;615652082;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(167, 22, '36;said;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', '36;said;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(168, 22, '37;eethuis souawni;641561397;imzouren;;;;;;;;;;;;;;;;;;;;', '37;eethuis souawni;641561397;imzouren;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(169, 22, '38;rachid bakcho;652953609;centre ville nafora kenitra;;;;;;;;;;;;;;;;;;;;', '38;rachid bakcho;652953609;centre ville nafora kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(170, 22, '39;-;693478509;-;;;;;;;;;;;;;;;;;;;;', '39;-;693478509;-;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(171, 22, '40;Ahmed Ben daoud;667577302;ouarzazat;;;;;;;;;;;;;;;;;;;;', '40;Ahmed Ben daoud;667577302;ouarzazat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(172, 22, '41;moulay;633086993;belvédère Casablanca;;;;;;;;;;;;;;;;;;;;', '41;moulay;633086993;belvédère Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(173, 22, '42;sabah;644716306;fes;;;;;;;;;;;;;;;;;;;;', '42;sabah;644716306;fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(174, 22, '43;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', '43;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(175, 22, '44;Ayman;660648202;kenitra;;;;;;;;;;;;;;;;;;;;', '44;Ayman;660648202;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(176, 22, '45;younes daoudi;701290679;meknes;;;;;;;;;;;;;;;;;;;;', '45;younes daoudi;701290679;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(177, 22, '46;abdelkarim;606663391;casa;;;;;;;;;;;;;;;;;;;;', '46;abdelkarim;606663391;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(178, 22, '47;abdessadak;610363121;driouech hay pam;;;;;;;;;;;;;;;;;;;;', '47;abdessadak;610363121;driouech hay pam;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(179, 22, '48;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', '48;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(180, 22, '49;abderrahim;665170407;rabat yaccoub mansour;;;;;;;;;;;;;;;;;;;;', '49;abderrahim;665170407;rabat yaccoub mansour;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(181, 22, '50;mohammed;720631755;merzouga;;;;;;;;;;;;;;;;;;;;', '50;mohammed;720631755;merzouga;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(182, 22, '51;mehdi;649264328;meknes;;;;;;;;;;;;;;;;;;;;', '51;mehdi;649264328;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(183, 22, '52;aoussar rachid;678062529;nador;;;;;;;;;;;;;;;;;;;;', '52;aoussar rachid;678062529;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(184, 22, '53;rachid cheddakh;664997881;agadir;;;;;;;;;;;;;;;;;;;;', '53;rachid cheddakh;664997881;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(185, 22, '54;;661349135;;;;;;;;;;;;;;;;;;;;;', '54;;661349135;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(186, 22, '55;bensouda;661891728;casa;;;;;;;;;;;;;;;;;;;;', '55;bensouda;661891728;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(187, 22, '56;Assia el alami;779420552;gueliz marrackech;;;;;;;;;;;;;;;;;;;;', '56;Assia el alami;779420552;gueliz marrackech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(188, 22, '57;mohammed;661896002;marrackech;;;;;;;;;;;;;;;;;;;;', '57;mohammed;661896002;marrackech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(189, 22, '58;hicham gadi;616290106;boulman;;;;;;;;;;;;;;;;;;;;', '58;hicham gadi;616290106;boulman;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(190, 22, '59;graid mehdi;660141638;qt dakhla rue maamoura 19 yousoufia;;;;;;;;;;;;;;;;;;;;', '59;graid mehdi;660141638;qt dakhla rue maamoura 19 yousoufia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(191, 22, '60;taoufik meskini;665885779;hay zitoune meknes;;;;;;;;;;;;;;;;;;;;', '60;taoufik meskini;665885779;hay zitoune meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(192, 22, '61;nova doss;661246588;tetouan;;;;;;;;;;;;;;;;;;;;', '61;nova doss;661246588;tetouan;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(193, 22, '62;ao;661191766;agadir;;;;;;;;;;;;;;;;;;;;', '62;ao;661191766;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(194, 22, '63;hamza soumaidi;661544295;tanger place mozar;;;;;;;;;;;;;;;;;;;;', '63;hamza soumaidi;661544295;tanger place mozar;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(195, 22, '64;ismail;600629860;boumalne dades;;;;;;;;;;;;;;;;;;;;', '64;ismail;600629860;boumalne dades;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(196, 22, '65;anas dib;699003217;tissa;;;;;;;;;;;;;;;;;;;;', '65;anas dib;699003217;tissa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(197, 22, '66;oualid taher;638454652;imzouren;;;;;;;;;;;;;;;;;;;;', '66;oualid taher;638454652;imzouren;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(198, 22, '67;nader;665091550;agadir;;;;;;;;;;;;;;;;;;;;', '67;nader;665091550;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(199, 22, '68;;713946515;;;;;;;;;;;;;;;;;;;;;', '68;;713946515;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(200, 22, '69;ayoub pocket club;642264003;meknes;;;;;;;;;;;;;;;;;;;;', '69;ayoub pocket club;642264003;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(201, 22, '70;rachid errachidia;662352044;errachidia;;;;;;;;;;;;;;;;;;;;', '70;rachid errachidia;662352044;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(202, 22, '71;yahya;673729292;hed soualem;;;;;;;;;;;;;;;;;;;;', '71;yahya;673729292;hed soualem;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(203, 22, '72;said babania;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', '72;said babania;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(204, 22, '73;ayman;672695841;;;;;;;;;;;;;;;;;;;;;', '73;ayman;672695841;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(205, 22, '74;mahfoud sallam;66888850;casablanca;;;;;;;;;;;;;;;;;;;;', '74;mahfoud sallam;66888850;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(206, 22, '75;requin bleu;661429581;sidi bouzid jadida;;;;;;;;;;;;;;;;;;;;', '75;requin bleu;661429581;sidi bouzid jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(207, 22, '76;hajar boukra;602703000;tanger;;;;;;;;;;;;;;;;;;;;', '76;hajar boukra;602703000;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(208, 22, '77;issam massaoudi;661610176;bd nasr zaio;;;;;;;;;;;;;;;;;;;;', '77;issam massaoudi;661610176;bd nasr zaio;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(209, 22, '78;mohamed bakkali;677880066;tanger;;;;;;;;;;;;;;;;;;;;', '78;mohamed bakkali;677880066;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(210, 22, '79;mazgour;661910096;rue de rif;;;;;;;;;;;;;;;;;;;;', '79;mazgour;661910096;rue de rif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(211, 22, '80;hadaji;661602276;kali3a saraghina;;;;;;;;;;;;;;;;;;;;', '80;hadaji;661602276;kali3a saraghina;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(212, 22, '81;nour amri;661322959;tanja marina bay;;;;;;;;;;;;;;;;;;;;', '81;nour amri;661322959;tanja marina bay;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(213, 22, '82;abdallah;666618359;casablanca;;;;;;;;;;;;;;;;;;;;', '82;abdallah;666618359;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(214, 22, '83;moja aberkan;667571458;nador;;;;;;;;;;;;;;;;;;;;', '83;moja aberkan;667571458;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(215, 22, '84;islame amine;779499908;massira 1 temara;;;;;;;;;;;;;;;;;;;;', '84;islame amine;779499908;massira 1 temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(216, 22, '85;simo;606865870;kenitra khobza;;;;;;;;;;;;;;;;;;;;', '85;simo;606865870;kenitra khobza;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(217, 22, '86;youssef;671411444;tanger;;;;;;;;;;;;;;;;;;;;', '86;youssef;671411444;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(218, 22, '87;a;631550544;;;;;;;;;;;;;;;;;;;;;', '87;a;631550544;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(219, 22, '88;b;661845586;;;;;;;;;;;;;;;;;;;;;', '88;b;661845586;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(220, 22, '89;c;619469811;Casablanca;;;;;;;;;;;;;;;;;;;;', '89;c;619469811;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(221, 22, '90;d;772454008;Casablanca;;;;;;;;;;;;;;;;;;;;', '90;d;772454008;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(222, 22, '91;e;661265660;;;;;;;;;;;;;;;;;;;;;', '91;e;661265660;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(223, 22, '92;f;661246588;;;;;;;;;;;;;;;;;;;;;', '92;f;661246588;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(224, 22, '93;g;660929073;Asfi;;;;;;;;;;;;;;;;;;;;', '93;g;660929073;Asfi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(225, 22, '94;h;677395320;;;;;;;;;;;;;;;;;;;;;', '94;h;677395320;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(226, 22, '95;i;662432487;;;;;;;;;;;;;;;;;;;;;', '95;i;662432487;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(227, 22, '96;j;619668782;;;;;;;;;;;;;;;;;;;;;', '96;j;619668782;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(228, 22, '97;Zakaria;700568966;;;;;;;;;;;;;;;;;;;;;', '97;Zakaria;700568966;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(229, 22, '98;Fadila;691200495;casablanca;;;;;;;;;;;;;;;;;;;;', '98;Fadila;691200495;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(230, 22, '99;k;699900908;;;;;;;;;;;;;;;;;;;;;', '99;k;699900908;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(231, 22, '100;driss;656535546;;;;;;;;;;;;;;;;;;;;;', '100;driss;656535546;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(232, 22, '101;m;680760326;;;;;;;;;;;;;;;;;;;;;', '101;m;680760326;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(233, 22, '102;Aziz ant;9666484148;;;;;;;;;;;;;;;;;;;;;', '102;Aziz ant;9666484148;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(234, 22, '103;Issam masoudi;661610176;;;;;;;;;;;;;;;;;;;;;', '103;Issam masoudi;661610176;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(235, 22, '104;Ilyes;681432052;Casablanca;;;;;;;;;;;;;;;;;;;;', '104;Ilyes;681432052;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(236, 22, '105;Anass;661197533;Agadir;;;;;;;;;;;;;;;;;;;;', '105;Anass;661197533;Agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(237, 22, '106;Atef;621952196;Fes;;;;;;;;;;;;;;;;;;;;', '106;Atef;621952196;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(238, 22, '107;Mounir Elkourdini;656544697;Bouskoura;;;;;;;;;;;;;;;;;;;;', '107;Mounir Elkourdini;656544697;Bouskoura;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(239, 22, '108;Amine hamitti;680129633;mohammadia;;;;;;;;;;;;;;;;;;;;', '108;Amine hamitti;680129633;mohammadia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(240, 22, '109;Fatima ezzaitouni;667894891;Masira 1 Marrakech;;;;;;;;;;;;;;;;;;;;', '109;Fatima ezzaitouni;667894891;Masira 1 Marrakech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(241, 22, '110;Fatima;602139682;ksar el kbir;;;;;;;;;;;;;;;;;;;;', '110;Fatima;602139682;ksar el kbir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(242, 22, '111;Mohammed azrare;661879370;Alhoceima;;;;;;;;;;;;;;;;;;;;', '111;Mohammed azrare;661879370;Alhoceima;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(243, 22, '112;Abdullah;699840512;agadir;;;;;;;;;;;;;;;;;;;;', '112;Abdullah;699840512;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(244, 22, '113;Hicham amri;644856115;Fes;;;;;;;;;;;;;;;;;;;;', '113;Hicham amri;644856115;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(245, 22, '114;Rachid;668759548;sok sbt;;;;;;;;;;;;;;;;;;;;', '114;Rachid;668759548;sok sbt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(246, 22, '115;Marouane;668593301;kebibat rabat;;;;;;;;;;;;;;;;;;;;', '115;Marouane;668593301;kebibat rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(247, 22, '116;Mohammed Elmortaji;661600940;Fkih ben salah;;;;;;;;;;;;;;;;;;;;', '116;Mohammed Elmortaji;661600940;Fkih ben salah;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(248, 22, '117;Ahmed benouazzani;670067414;;;;;;;;;;;;;;;;;;;;;', '117;Ahmed benouazzani;670067414;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(249, 22, '118;Moncif tlemcani;664719200;Fès;;;;;;;;;;;;;;;;;;;;', '118;Moncif tlemcani;664719200;Fès;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(250, 22, '119;Ttt;9998766;Ttt;;;;;;;;;;;;;;;;;;;;', '119;Ttt;9998766;Ttt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(251, 22, '120;Careclub;644180542;Elaissy2016@gmail.com;;;;;;;;;;;;;;;;;;;;', '120;Careclub;644180542;Elaissy2016@gmail.com;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(252, 22, '121;Anass;762811955;Yoga optique temara;;;;;;;;;;;;;;;;;;;;', '121;Anass;762811955;Yoga optique temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(253, 22, '122;Rali;657279831;Agadir;;;;;;;;;;;;;;;;;;;;', '122;Rali;657279831;Agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(254, 22, '123;mbarek;647274407;ksba Tadla;;;;;;;;;;;;;;;;;;;;', '123;mbarek;647274407;ksba Tadla;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(255, 22, '124;younes el bazi;610644264;martil;;;;;;;;;;;;;;;;;;;;', '124;younes el bazi;610644264;martil;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(256, 22, '125;zayd tahchi;708451033;tanger;;;;;;;;;;;;;;;;;;;;', '125;zayd tahchi;708451033;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(257, 22, '126;idriss abousraj;608515050;kenitra;;;;;;;;;;;;;;;;;;;;', '126;idriss abousraj;608515050;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(258, 22, '127;laila;679598006;ksar kbir;;;;;;;;;;;;;;;;;;;;', '127;laila;679598006;ksar kbir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(259, 22, '128;atef malak;613338632;fes;;;;;;;;;;;;;;;;;;;;', '128;atef malak;613338632;fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(260, 22, '129;hicham;681183859;andi tolifonat;;;;;;;;;;;;;;;;;;;;', '129;hicham;681183859;andi tolifonat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(261, 22, '130;mohammed belbachi;615716182;oujda ( route sidi yehya mosquée rayane );;;;;;;;;;;;;;;;;;;;', '130;mohammed belbachi;615716182;oujda ( route sidi yehya mosquée rayane );;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(262, 22, '131;aziz;677402899;ifrane;;;;;;;;;;;;;;;;;;;;', '131;aziz;677402899;ifrane;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(263, 22, '132;Abderahim;661305155;el oulfa casa;;;;;;;;;;;;;;;;;;;;', '132;Abderahim;661305155;el oulfa casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(264, 22, '133;mohammed;661783093;Restaurant maresco tanger rue Moulay Rachid;;;;;;;;;;;;;;;;;;;;', '133;mohammed;661783093;Restaurant maresco tanger rue Moulay Rachid;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(265, 22, '134;Mohammed amine;661639491;Erich;;;;;;;;;;;;;;;;;;;;', '134;Mohammed amine;661639491;Erich;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(266, 22, '135;Ayoub;661616511;Casa;;;;;;;;;;;;;;;;;;;;', '135;Ayoub;661616511;Casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(267, 22, '136;Soufiane amir;688212291;Meknes;;;;;;;;;;;;;;;;;;;;', '136;Soufiane amir;688212291;Meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(268, 22, '137;Doni tuning;714994726;Hay mohamadi;;;;;;;;;;;;;;;;;;;;', '137;Doni tuning;714994726;Hay mohamadi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(269, 22, '138;Moussa phone;601669177;Berrachid;;;;;;;;;;;;;;;;;;;;', '138;Moussa phone;601669177;Berrachid;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(270, 22, '139;Badr najroum;690181026;Kénitra;;;;;;;;;;;;;;;;;;;;', '139;Badr najroum;690181026;Kénitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(271, 22, '140;hamza asouki;638055848;mohammadia;;;;;;;;;;;;;;;;;;;;', '140;hamza asouki;638055848;mohammadia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(272, 22, '141;samir benkirane;629442158;kenitra;;;;;;;;;;;;;;;;;;;;', '141;samir benkirane;629442158;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(273, 22, '142;el harrak mohammed;659614897;larache;;;;;;;;;;;;;;;;;;;;', '142;el harrak mohammed;659614897;larache;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(274, 22, '143;fouad dik;614228399;casablanca;;;;;;;;;;;;;;;;;;;;', '143;fouad dik;614228399;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(275, 22, '144;mariam;640145730;assila;;;;;;;;;;;;;;;;;;;;', '144;mariam;640145730;assila;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(276, 22, '145;zakaria;665191559;dakhla;;;;;;;;;;;;;;;;;;;;', '145;zakaria;665191559;dakhla;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(277, 22, '146;Jamal;660462137;Fes;;;;;;;;;;;;;;;;;;;;', '146;Jamal;660462137;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(278, 22, '147;fatima zahrae;641450549;tanger;;;;;;;;;;;;;;;;;;;;', '147;fatima zahrae;641450549;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(279, 22, '148;brahim;678471138;casa;;;;;;;;;;;;;;;;;;;;', '148;brahim;678471138;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(280, 22, '149;aziz;607886299;temara;;;;;;;;;;;;;;;;;;;;', '149;aziz;607886299;temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(281, 22, '150;aznoun abderrazak;622854615;nador;;;;;;;;;;;;;;;;;;;;', '150;aznoun abderrazak;622854615;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(282, 22, '151;foad;634762334;nador;;;;;;;;;;;;;;;;;;;;', '151;foad;634762334;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(283, 22, '152;hayat;607072246;tanja 3awma;;;;;;;;;;;;;;;;;;;;', '152;hayat;607072246;tanja 3awma;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(284, 22, '153;brahim;681277454;kenitra;;;;;;;;;;;;;;;;;;;;', '153;brahim;681277454;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(285, 22, '154;kassimi mohammed;653506408;oujda;;;;;;;;;;;;;;;;;;;;', '154;kassimi mohammed;653506408;oujda;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(286, 22, '155;afafe zel;661384169;15 rue smara berkane;;;;;;;;;;;;;;;;;;;;', '155;afafe zel;661384169;15 rue smara berkane;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(287, 22, '156;;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', '156;;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(288, 22, '157;Hakim El Ghazi;661194820;dar bouazza;;;;;;;;;;;;;;;;;;;;', '157;Hakim El Ghazi;661194820;dar bouazza;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(289, 22, '158;hanae;664419948;settat;;;;;;;;;;;;;;;;;;;;', '158;hanae;664419948;settat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(290, 22, '159;abcesamad rekdi;695709998;errachidia;;;;;;;;;;;;;;;;;;;;', '159;abcesamad rekdi;695709998;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(291, 22, '160;hamza;699635508;el jadida;;;;;;;;;;;;;;;;;;;;', '160;hamza;699635508;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(292, 22, '161;amine;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', '161;amine;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(293, 22, '162;hassan;661342505;ait melloul;;;;;;;;;;;;;;;;;;;;', '162;hassan;661342505;ait melloul;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(294, 22, '163;mohamed bade chentouf;606205837;tanger;;;;;;;;;;;;;;;;;;;;', '163;mohamed bade chentouf;606205837;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(295, 22, '164;salma;609909921;khy;;;;;;;;;;;;;;;;;;;;', '164;salma;609909921;khy;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(296, 22, '165;ahmed;649208331;rabat;;;;;;;;;;;;;;;;;;;;', '165;ahmed;649208331;rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(297, 22, '166;abdou;624722614;megouna;;;;;;;;;;;;;;;;;;;;', '166;abdou;624722614;megouna;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(298, 22, '167;ismael;728020002;florida;;;;;;;;;;;;;;;;;;;;', '167;ismael;728020002;florida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(299, 22, '168;meghari;600600333;dakhla renove;;;;;;;;;;;;;;;;;;;;', '168;meghari;600600333;dakhla renove;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(300, 22, '169;yassine;691493896;vccc;;;;;;;;;;;;;;;;;;;;', '169;yassine;691493896;vccc;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(301, 22, '170;snack akram;767676355;targust;;;;;;;;;;;;;;;;;;;;', '170;snack akram;767676355;targust;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(302, 22, '171;elkotabi hamza;650810442;hay safa beni mellal;;;;;;;;;;;;;;;;;;;;', '171;elkotabi hamza;650810442;hay safa beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(303, 22, '172;abderazak;641749228;casablanca;;;;;;;;;;;;;;;;;;;;', '172;abderazak;641749228;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(304, 22, '173;chahyd abdellah;661364171;Fes;;;;;;;;;;;;;;;;;;;;', '173;chahyd abdellah;661364171;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(305, 22, '174;chimanto;663535747;extensino dakhla tamdid ou lhay mohamadi;;;;;;;;;;;;;;;;;;;;', '174;chimanto;663535747;extensino dakhla tamdid ou lhay mohamadi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(306, 22, '175;amigos;674664766;tetouan;;;;;;;;;;;;;;;;;;;;', '175;amigos;674664766;tetouan;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(307, 22, '176;oussama;630565478;khenifra;;;;;;;;;;;;;;;;;;;;', '176;oussama;630565478;khenifra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(308, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(309, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(310, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(311, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(312, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(313, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(314, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(315, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(316, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(317, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(318, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(319, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(320, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(321, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(322, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(323, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(324, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(325, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(326, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(327, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(328, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(329, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(330, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(331, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(332, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(333, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(334, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(335, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(336, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(337, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(338, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(339, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(340, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(341, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(342, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(343, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(344, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(345, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(346, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(347, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(348, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(349, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(350, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(351, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(352, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(353, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(354, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(355, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(356, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(357, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(358, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(359, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(360, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(361, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(362, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(363, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(364, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(365, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(366, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(367, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(368, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(369, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(370, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(371, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(372, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(373, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(374, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(375, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(376, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(377, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(378, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(379, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(380, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(381, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(382, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(383, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(384, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(385, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(386, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(387, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(388, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(389, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(390, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(391, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(392, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(393, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(394, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(395, 22, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(396, 23, '1;Bouzidi imade;666699344;Rabat;;;;;;;;;;;;;;;;;;;;', '1;Bouzidi imade;666699344;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(397, 23, '2;Nourdin;642575968;Kaalaat magona;;;;;;;;;;;;;;;;;;;;', '2;Nourdin;642575968;Kaalaat magona;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(398, 23, '3;FROM;640178080;Fes;;;;;;;;;;;;;;;;;;;;', '3;FROM;640178080;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(399, 23, '4;محمد;679555782;Tanger;;;;;;;;;;;;;;;;;;;;', '4;محمد;679555782;Tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(400, 23, '5;Ayoub;621999401;Midelt;;;;;;;;;;;;;;;;;;;;', '5;Ayoub;621999401;Midelt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(401, 23, '6;الحاض;639410979;للخميسات;;;;;;;;;;;;;;;;;;;;', '6;الحاض;639410979;للخميسات;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(402, 23, '7;LafdilOtmane;722887508;Garcif;;;;;;;;;;;;;;;;;;;;', '7;LafdilOtmane;722887508;Garcif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(403, 23, '8;Issa;638673841;Laayoune;;;;;;;;;;;;;;;;;;;;', '8;Issa;638673841;Laayoune;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(404, 23, '9;kaoutar;661244430;Guercif;;;;;;;;;;;;;;;;;;;;', '9;kaoutar;661244430;Guercif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(405, 23, '10;Mohamed hajji;612894139;Nador;;;;;;;;;;;;;;;;;;;;', '10;Mohamed hajji;612894139;Nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(406, 23, '11;Ahmed lebsir;626873922;Laayoune;;;;;;;;;;;;;;;;;;;;', '11;Ahmed lebsir;626873922;Laayoune;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(407, 23, '12;Ghita;661083665;Makhfiya 15', 'Rcif', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(408, 23, '13;Youness essalhi;660377420;تملالت;;;;;;;;;;;;;;;;;;;;', '13;Youness essalhi;660377420;تملالت;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(409, 23, '14;Zolati;661491538;Erachidiya;;;;;;;;;;;;;;;;;;;;', '14;Zolati;661491538;Erachidiya;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(410, 23, '15;zakaria Ziko shop;606061393;El jadida;;;;;;;;;;;;;;;;;;;;', '15;zakaria Ziko shop;606061393;El jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(411, 23, '16;Rachid;661229239;Rabat;;;;;;;;;;;;;;;;;;;;', '16;Rachid;661229239;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(412, 23, '17;Hemmouda;661360430;Meknes;;;;;;;;;;;;;;;;;;;;', '17;Hemmouda;661360430;Meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(413, 23, '18;Jamal;606947789;Bengrer;;;;;;;;;;;;;;;;;;;;', '18;Jamal;606947789;Bengrer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(414, 23, '19;Abdelhakim;609714949;Bengrer;;;;;;;;;;;;;;;;;;;;', '19;Abdelhakim;609714949;Bengrer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(415, 23, '20;Aziz;649215728;Beni mellal;;;;;;;;;;;;;;;;;;;;', '20;Aziz;649215728;Beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(416, 23, '21;Hamza;650810442;Beni mellal;;;;;;;;;;;;;;;;;;;;', '21;Hamza;650810442;Beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(417, 23, '22;yassine;614440471;سطات;;;;;;;;;;;;;;;;;;;;', '22;yassine;614440471;سطات;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(418, 23, '23;sophimeb;654842194;;;;;;;;;;;;;;;;;;;;;', '23;sophimeb;654842194;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(419, 23, '24;mourabit;661740423;nador;;;;;;;;;;;;;;;;;;;;', '24;mourabit;661740423;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(420, 23, '25;;698193017;;;;;;;;;;;;;;;;;;;;;', '25;;698193017;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(421, 23, '26;;688069630;Casa ( Snack);;;;;;;;;;;;;;;;;;;;', '26;;688069630;Casa ( Snack);;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(422, 23, '27;Adam imsak;778918312;azro;;;;;;;;;;;;;;;;;;;;', '27;Adam imsak;778918312;azro;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(423, 23, '28;-;607884207;-;;;;;;;;;;;;;;;;;;;;', '28;-;607884207;-;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54');
INSERT INTO `prospects` (`id`, `prospect_file_id`, `name`, `phone`, `status`, `notes`, `called_at`, `created_at`, `updated_at`) VALUES
(424, 23, '29;Faycel;606982541;khoribga;;;;;;;;;;;;;;;;;;;;', '29;Faycel;606982541;khoribga;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(425, 23, '30;Sofyan chenttouf;641774342;errachidia;;;;;;;;;;;;;;;;;;;;', '30;Sofyan chenttouf;641774342;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(426, 23, '31;Ayman;639001982;casa boulevard tah;;;;;;;;;;;;;;;;;;;;', '31;Ayman;639001982;casa boulevard tah;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(427, 23, '32;abdallah kounoz;666701605;Rabat;;;;;;;;;;;;;;;;;;;;', '32;abdallah kounoz;666701605;Rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(428, 23, '33;fatima jebari;627985603;sidi hotman;;;;;;;;;;;;;;;;;;;;', '33;fatima jebari;627985603;sidi hotman;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(429, 23, '34;dakhla;609060680;tirs;;;;;;;;;;;;;;;;;;;;', '34;dakhla;609060680;tirs;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(430, 23, '35;sanae;615652082;kenitra;;;;;;;;;;;;;;;;;;;;', '35;sanae;615652082;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(431, 23, '36;said;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', '36;said;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(432, 23, '37;eethuis souawni;641561397;imzouren;;;;;;;;;;;;;;;;;;;;', '37;eethuis souawni;641561397;imzouren;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(433, 23, '38;rachid bakcho;652953609;centre ville nafora kenitra;;;;;;;;;;;;;;;;;;;;', '38;rachid bakcho;652953609;centre ville nafora kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(434, 23, '39;-;693478509;-;;;;;;;;;;;;;;;;;;;;', '39;-;693478509;-;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(435, 23, '40;Ahmed Ben daoud;667577302;ouarzazat;;;;;;;;;;;;;;;;;;;;', '40;Ahmed Ben daoud;667577302;ouarzazat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(436, 23, '41;moulay;633086993;belvédère Casablanca;;;;;;;;;;;;;;;;;;;;', '41;moulay;633086993;belvédère Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(437, 23, '42;sabah;644716306;fes;;;;;;;;;;;;;;;;;;;;', '42;sabah;644716306;fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(438, 23, '43;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', '43;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(439, 23, '44;Ayman;660648202;kenitra;;;;;;;;;;;;;;;;;;;;', '44;Ayman;660648202;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(440, 23, '45;younes daoudi;701290679;meknes;;;;;;;;;;;;;;;;;;;;', '45;younes daoudi;701290679;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(441, 23, '46;abdelkarim;606663391;casa;;;;;;;;;;;;;;;;;;;;', '46;abdelkarim;606663391;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(442, 23, '47;abdessadak;610363121;driouech hay pam;;;;;;;;;;;;;;;;;;;;', '47;abdessadak;610363121;driouech hay pam;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(443, 23, '48;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', '48;sami;653711222;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(444, 23, '49;abderrahim;665170407;rabat yaccoub mansour;;;;;;;;;;;;;;;;;;;;', '49;abderrahim;665170407;rabat yaccoub mansour;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(445, 23, '50;mohammed;720631755;merzouga;;;;;;;;;;;;;;;;;;;;', '50;mohammed;720631755;merzouga;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(446, 23, '51;mehdi;649264328;meknes;;;;;;;;;;;;;;;;;;;;', '51;mehdi;649264328;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(447, 23, '52;aoussar rachid;678062529;nador;;;;;;;;;;;;;;;;;;;;', '52;aoussar rachid;678062529;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(448, 23, '53;rachid cheddakh;664997881;agadir;;;;;;;;;;;;;;;;;;;;', '53;rachid cheddakh;664997881;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(449, 23, '54;;661349135;;;;;;;;;;;;;;;;;;;;;', '54;;661349135;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(450, 23, '55;bensouda;661891728;casa;;;;;;;;;;;;;;;;;;;;', '55;bensouda;661891728;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(451, 23, '56;Assia el alami;779420552;gueliz marrackech;;;;;;;;;;;;;;;;;;;;', '56;Assia el alami;779420552;gueliz marrackech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(452, 23, '57;mohammed;661896002;marrackech;;;;;;;;;;;;;;;;;;;;', '57;mohammed;661896002;marrackech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(453, 23, '58;hicham gadi;616290106;boulman;;;;;;;;;;;;;;;;;;;;', '58;hicham gadi;616290106;boulman;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(454, 23, '59;graid mehdi;660141638;qt dakhla rue maamoura 19 yousoufia;;;;;;;;;;;;;;;;;;;;', '59;graid mehdi;660141638;qt dakhla rue maamoura 19 yousoufia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(455, 23, '60;taoufik meskini;665885779;hay zitoune meknes;;;;;;;;;;;;;;;;;;;;', '60;taoufik meskini;665885779;hay zitoune meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(456, 23, '61;nova doss;661246588;tetouan;;;;;;;;;;;;;;;;;;;;', '61;nova doss;661246588;tetouan;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(457, 23, '62;ao;661191766;agadir;;;;;;;;;;;;;;;;;;;;', '62;ao;661191766;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(458, 23, '63;hamza soumaidi;661544295;tanger place mozar;;;;;;;;;;;;;;;;;;;;', '63;hamza soumaidi;661544295;tanger place mozar;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(459, 23, '64;ismail;600629860;boumalne dades;;;;;;;;;;;;;;;;;;;;', '64;ismail;600629860;boumalne dades;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(460, 23, '65;anas dib;699003217;tissa;;;;;;;;;;;;;;;;;;;;', '65;anas dib;699003217;tissa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(461, 23, '66;oualid taher;638454652;imzouren;;;;;;;;;;;;;;;;;;;;', '66;oualid taher;638454652;imzouren;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(462, 23, '67;nader;665091550;agadir;;;;;;;;;;;;;;;;;;;;', '67;nader;665091550;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(463, 23, '68;;713946515;;;;;;;;;;;;;;;;;;;;;', '68;;713946515;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(464, 23, '69;ayoub pocket club;642264003;meknes;;;;;;;;;;;;;;;;;;;;', '69;ayoub pocket club;642264003;meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(465, 23, '70;rachid errachidia;662352044;errachidia;;;;;;;;;;;;;;;;;;;;', '70;rachid errachidia;662352044;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(466, 23, '71;yahya;673729292;hed soualem;;;;;;;;;;;;;;;;;;;;', '71;yahya;673729292;hed soualem;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(467, 23, '72;said babania;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', '72;said babania;667777214;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(468, 23, '73;ayman;672695841;;;;;;;;;;;;;;;;;;;;;', '73;ayman;672695841;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(469, 23, '74;mahfoud sallam;66888850;casablanca;;;;;;;;;;;;;;;;;;;;', '74;mahfoud sallam;66888850;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(470, 23, '75;requin bleu;661429581;sidi bouzid jadida;;;;;;;;;;;;;;;;;;;;', '75;requin bleu;661429581;sidi bouzid jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(471, 23, '76;hajar boukra;602703000;tanger;;;;;;;;;;;;;;;;;;;;', '76;hajar boukra;602703000;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(472, 23, '77;issam massaoudi;661610176;bd nasr zaio;;;;;;;;;;;;;;;;;;;;', '77;issam massaoudi;661610176;bd nasr zaio;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(473, 23, '78;mohamed bakkali;677880066;tanger;;;;;;;;;;;;;;;;;;;;', '78;mohamed bakkali;677880066;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(474, 23, '79;mazgour;661910096;rue de rif;;;;;;;;;;;;;;;;;;;;', '79;mazgour;661910096;rue de rif;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(475, 23, '80;hadaji;661602276;kali3a saraghina;;;;;;;;;;;;;;;;;;;;', '80;hadaji;661602276;kali3a saraghina;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(476, 23, '81;nour amri;661322959;tanja marina bay;;;;;;;;;;;;;;;;;;;;', '81;nour amri;661322959;tanja marina bay;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(477, 23, '82;abdallah;666618359;casablanca;;;;;;;;;;;;;;;;;;;;', '82;abdallah;666618359;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(478, 23, '83;moja aberkan;667571458;nador;;;;;;;;;;;;;;;;;;;;', '83;moja aberkan;667571458;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(479, 23, '84;islame amine;779499908;massira 1 temara;;;;;;;;;;;;;;;;;;;;', '84;islame amine;779499908;massira 1 temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(480, 23, '85;simo;606865870;kenitra khobza;;;;;;;;;;;;;;;;;;;;', '85;simo;606865870;kenitra khobza;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(481, 23, '86;youssef;671411444;tanger;;;;;;;;;;;;;;;;;;;;', '86;youssef;671411444;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(482, 23, '87;a;631550544;;;;;;;;;;;;;;;;;;;;;', '87;a;631550544;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(483, 23, '88;b;661845586;;;;;;;;;;;;;;;;;;;;;', '88;b;661845586;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(484, 23, '89;c;619469811;Casablanca;;;;;;;;;;;;;;;;;;;;', '89;c;619469811;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(485, 23, '90;d;772454008;Casablanca;;;;;;;;;;;;;;;;;;;;', '90;d;772454008;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(486, 23, '91;e;661265660;;;;;;;;;;;;;;;;;;;;;', '91;e;661265660;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(487, 23, '92;f;661246588;;;;;;;;;;;;;;;;;;;;;', '92;f;661246588;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(488, 23, '93;g;660929073;Asfi;;;;;;;;;;;;;;;;;;;;', '93;g;660929073;Asfi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(489, 23, '94;h;677395320;;;;;;;;;;;;;;;;;;;;;', '94;h;677395320;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(490, 23, '95;i;662432487;;;;;;;;;;;;;;;;;;;;;', '95;i;662432487;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(491, 23, '96;j;619668782;;;;;;;;;;;;;;;;;;;;;', '96;j;619668782;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(492, 23, '97;Zakaria;700568966;;;;;;;;;;;;;;;;;;;;;', '97;Zakaria;700568966;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(493, 23, '98;Fadila;691200495;casablanca;;;;;;;;;;;;;;;;;;;;', '98;Fadila;691200495;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(494, 23, '99;k;699900908;;;;;;;;;;;;;;;;;;;;;', '99;k;699900908;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(495, 23, '100;driss;656535546;;;;;;;;;;;;;;;;;;;;;', '100;driss;656535546;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(496, 23, '101;m;680760326;;;;;;;;;;;;;;;;;;;;;', '101;m;680760326;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(497, 23, '102;Aziz ant;9666484148;;;;;;;;;;;;;;;;;;;;;', '102;Aziz ant;9666484148;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(498, 23, '103;Issam masoudi;661610176;;;;;;;;;;;;;;;;;;;;;', '103;Issam masoudi;661610176;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(499, 23, '104;Ilyes;681432052;Casablanca;;;;;;;;;;;;;;;;;;;;', '104;Ilyes;681432052;Casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(500, 23, '105;Anass;661197533;Agadir;;;;;;;;;;;;;;;;;;;;', '105;Anass;661197533;Agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(501, 23, '106;Atef;621952196;Fes;;;;;;;;;;;;;;;;;;;;', '106;Atef;621952196;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(502, 23, '107;Mounir Elkourdini;656544697;Bouskoura;;;;;;;;;;;;;;;;;;;;', '107;Mounir Elkourdini;656544697;Bouskoura;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(503, 23, '108;Amine hamitti;680129633;mohammadia;;;;;;;;;;;;;;;;;;;;', '108;Amine hamitti;680129633;mohammadia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(504, 23, '109;Fatima ezzaitouni;667894891;Masira 1 Marrakech;;;;;;;;;;;;;;;;;;;;', '109;Fatima ezzaitouni;667894891;Masira 1 Marrakech;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(505, 23, '110;Fatima;602139682;ksar el kbir;;;;;;;;;;;;;;;;;;;;', '110;Fatima;602139682;ksar el kbir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(506, 23, '111;Mohammed azrare;661879370;Alhoceima;;;;;;;;;;;;;;;;;;;;', '111;Mohammed azrare;661879370;Alhoceima;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(507, 23, '112;Abdullah;699840512;agadir;;;;;;;;;;;;;;;;;;;;', '112;Abdullah;699840512;agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(508, 23, '113;Hicham amri;644856115;Fes;;;;;;;;;;;;;;;;;;;;', '113;Hicham amri;644856115;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(509, 23, '114;Rachid;668759548;sok sbt;;;;;;;;;;;;;;;;;;;;', '114;Rachid;668759548;sok sbt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(510, 23, '115;Marouane;668593301;kebibat rabat;;;;;;;;;;;;;;;;;;;;', '115;Marouane;668593301;kebibat rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(511, 23, '116;Mohammed Elmortaji;661600940;Fkih ben salah;;;;;;;;;;;;;;;;;;;;', '116;Mohammed Elmortaji;661600940;Fkih ben salah;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(512, 23, '117;Ahmed benouazzani;670067414;;;;;;;;;;;;;;;;;;;;;', '117;Ahmed benouazzani;670067414;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(513, 23, '118;Moncif tlemcani;664719200;Fès;;;;;;;;;;;;;;;;;;;;', '118;Moncif tlemcani;664719200;Fès;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(514, 23, '119;Ttt;9998766;Ttt;;;;;;;;;;;;;;;;;;;;', '119;Ttt;9998766;Ttt;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(515, 23, '120;Careclub;644180542;Elaissy2016@gmail.com;;;;;;;;;;;;;;;;;;;;', '120;Careclub;644180542;Elaissy2016@gmail.com;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(516, 23, '121;Anass;762811955;Yoga optique temara;;;;;;;;;;;;;;;;;;;;', '121;Anass;762811955;Yoga optique temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(517, 23, '122;Rali;657279831;Agadir;;;;;;;;;;;;;;;;;;;;', '122;Rali;657279831;Agadir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(518, 23, '123;mbarek;647274407;ksba Tadla;;;;;;;;;;;;;;;;;;;;', '123;mbarek;647274407;ksba Tadla;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(519, 23, '124;younes el bazi;610644264;martil;;;;;;;;;;;;;;;;;;;;', '124;younes el bazi;610644264;martil;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(520, 23, '125;zayd tahchi;708451033;tanger;;;;;;;;;;;;;;;;;;;;', '125;zayd tahchi;708451033;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(521, 23, '126;idriss abousraj;608515050;kenitra;;;;;;;;;;;;;;;;;;;;', '126;idriss abousraj;608515050;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(522, 23, '127;laila;679598006;ksar kbir;;;;;;;;;;;;;;;;;;;;', '127;laila;679598006;ksar kbir;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(523, 23, '128;atef malak;613338632;fes;;;;;;;;;;;;;;;;;;;;', '128;atef malak;613338632;fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(524, 23, '129;hicham;681183859;andi tolifonat;;;;;;;;;;;;;;;;;;;;', '129;hicham;681183859;andi tolifonat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(525, 23, '130;mohammed belbachi;615716182;oujda ( route sidi yehya mosquée rayane );;;;;;;;;;;;;;;;;;;;', '130;mohammed belbachi;615716182;oujda ( route sidi yehya mosquée rayane );;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(526, 23, '131;aziz;677402899;ifrane;;;;;;;;;;;;;;;;;;;;', '131;aziz;677402899;ifrane;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(527, 23, '132;Abderahim;661305155;el oulfa casa;;;;;;;;;;;;;;;;;;;;', '132;Abderahim;661305155;el oulfa casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(528, 23, '133;mohammed;661783093;Restaurant maresco tanger rue Moulay Rachid;;;;;;;;;;;;;;;;;;;;', '133;mohammed;661783093;Restaurant maresco tanger rue Moulay Rachid;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(529, 23, '134;Mohammed amine;661639491;Erich;;;;;;;;;;;;;;;;;;;;', '134;Mohammed amine;661639491;Erich;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(530, 23, '135;Ayoub;661616511;Casa;;;;;;;;;;;;;;;;;;;;', '135;Ayoub;661616511;Casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(531, 23, '136;Soufiane amir;688212291;Meknes;;;;;;;;;;;;;;;;;;;;', '136;Soufiane amir;688212291;Meknes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(532, 23, '137;Doni tuning;714994726;Hay mohamadi;;;;;;;;;;;;;;;;;;;;', '137;Doni tuning;714994726;Hay mohamadi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(533, 23, '138;Moussa phone;601669177;Berrachid;;;;;;;;;;;;;;;;;;;;', '138;Moussa phone;601669177;Berrachid;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(534, 23, '139;Badr najroum;690181026;Kénitra;;;;;;;;;;;;;;;;;;;;', '139;Badr najroum;690181026;Kénitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(535, 23, '140;hamza asouki;638055848;mohammadia;;;;;;;;;;;;;;;;;;;;', '140;hamza asouki;638055848;mohammadia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(536, 23, '141;samir benkirane;629442158;kenitra;;;;;;;;;;;;;;;;;;;;', '141;samir benkirane;629442158;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(537, 23, '142;el harrak mohammed;659614897;larache;;;;;;;;;;;;;;;;;;;;', '142;el harrak mohammed;659614897;larache;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(538, 23, '143;fouad dik;614228399;casablanca;;;;;;;;;;;;;;;;;;;;', '143;fouad dik;614228399;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(539, 23, '144;mariam;640145730;assila;;;;;;;;;;;;;;;;;;;;', '144;mariam;640145730;assila;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(540, 23, '145;zakaria;665191559;dakhla;;;;;;;;;;;;;;;;;;;;', '145;zakaria;665191559;dakhla;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(541, 23, '146;Jamal;660462137;Fes;;;;;;;;;;;;;;;;;;;;', '146;Jamal;660462137;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(542, 23, '147;fatima zahrae;641450549;tanger;;;;;;;;;;;;;;;;;;;;', '147;fatima zahrae;641450549;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(543, 23, '148;brahim;678471138;casa;;;;;;;;;;;;;;;;;;;;', '148;brahim;678471138;casa;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(544, 23, '149;aziz;607886299;temara;;;;;;;;;;;;;;;;;;;;', '149;aziz;607886299;temara;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(545, 23, '150;aznoun abderrazak;622854615;nador;;;;;;;;;;;;;;;;;;;;', '150;aznoun abderrazak;622854615;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(546, 23, '151;foad;634762334;nador;;;;;;;;;;;;;;;;;;;;', '151;foad;634762334;nador;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(547, 23, '152;hayat;607072246;tanja 3awma;;;;;;;;;;;;;;;;;;;;', '152;hayat;607072246;tanja 3awma;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(548, 23, '153;brahim;681277454;kenitra;;;;;;;;;;;;;;;;;;;;', '153;brahim;681277454;kenitra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(549, 23, '154;kassimi mohammed;653506408;oujda;;;;;;;;;;;;;;;;;;;;', '154;kassimi mohammed;653506408;oujda;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(550, 23, '155;afafe zel;661384169;15 rue smara berkane;;;;;;;;;;;;;;;;;;;;', '155;afafe zel;661384169;15 rue smara berkane;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(551, 23, '156;;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', '156;;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(552, 23, '157;Hakim El Ghazi;661194820;dar bouazza;;;;;;;;;;;;;;;;;;;;', '157;Hakim El Ghazi;661194820;dar bouazza;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(553, 23, '158;hanae;664419948;settat;;;;;;;;;;;;;;;;;;;;', '158;hanae;664419948;settat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(554, 23, '159;abcesamad rekdi;695709998;errachidia;;;;;;;;;;;;;;;;;;;;', '159;abcesamad rekdi;695709998;errachidia;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(555, 23, '160;hamza;699635508;el jadida;;;;;;;;;;;;;;;;;;;;', '160;hamza;699635508;el jadida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(556, 23, '161;amine;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', '161;amine;661320263;nouacer;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(557, 23, '162;hassan;661342505;ait melloul;;;;;;;;;;;;;;;;;;;;', '162;hassan;661342505;ait melloul;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(558, 23, '163;mohamed bade chentouf;606205837;tanger;;;;;;;;;;;;;;;;;;;;', '163;mohamed bade chentouf;606205837;tanger;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(559, 23, '164;salma;609909921;khy;;;;;;;;;;;;;;;;;;;;', '164;salma;609909921;khy;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(560, 23, '165;ahmed;649208331;rabat;;;;;;;;;;;;;;;;;;;;', '165;ahmed;649208331;rabat;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(561, 23, '166;abdou;624722614;megouna;;;;;;;;;;;;;;;;;;;;', '166;abdou;624722614;megouna;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(562, 23, '167;ismael;728020002;florida;;;;;;;;;;;;;;;;;;;;', '167;ismael;728020002;florida;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(563, 23, '168;meghari;600600333;dakhla renove;;;;;;;;;;;;;;;;;;;;', '168;meghari;600600333;dakhla renove;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(564, 23, '169;yassine;691493896;vccc;;;;;;;;;;;;;;;;;;;;', '169;yassine;691493896;vccc;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(565, 23, '170;snack akram;767676355;targust;;;;;;;;;;;;;;;;;;;;', '170;snack akram;767676355;targust;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(566, 23, '171;elkotabi hamza;650810442;hay safa beni mellal;;;;;;;;;;;;;;;;;;;;', '171;elkotabi hamza;650810442;hay safa beni mellal;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(567, 23, '172;abderazak;641749228;casablanca;;;;;;;;;;;;;;;;;;;;', '172;abderazak;641749228;casablanca;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(568, 23, '173;chahyd abdellah;661364171;Fes;;;;;;;;;;;;;;;;;;;;', '173;chahyd abdellah;661364171;Fes;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(569, 23, '174;chimanto;663535747;extensino dakhla tamdid ou lhay mohamadi;;;;;;;;;;;;;;;;;;;;', '174;chimanto;663535747;extensino dakhla tamdid ou lhay mohamadi;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(570, 23, '175;amigos;674664766;tetouan;;;;;;;;;;;;;;;;;;;;', '175;amigos;674664766;tetouan;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(571, 23, '176;oussama;630565478;khenifra;;;;;;;;;;;;;;;;;;;;', '176;oussama;630565478;khenifra;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(572, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(573, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(574, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(575, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(576, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(577, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(578, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(579, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(580, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(581, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(582, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(583, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(584, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(585, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(586, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(587, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(588, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(589, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(590, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(591, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(592, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(593, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(594, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(595, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(596, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(597, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(598, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(599, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(600, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(601, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(602, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(603, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(604, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(605, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(606, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(607, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(608, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(609, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(610, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(611, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(612, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(613, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(614, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(615, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(616, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(617, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(618, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(619, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(620, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(621, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(622, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(623, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(624, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(625, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(626, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(627, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(628, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(629, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(630, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(631, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(632, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(633, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(634, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(635, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(636, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(637, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(638, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(639, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(640, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(641, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(642, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(643, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(644, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(645, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(646, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(647, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(648, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(649, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(650, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(651, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(652, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(653, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(654, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(655, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(656, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(657, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(658, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(659, 23, ';;;;;;;;;;;;;;;;;;;;;;;', ';;;;;;;;;;;;;;;;;;;;;;;', 'pending', NULL, NULL, '2026-08-10 14:48:55', '2026-08-10 14:48:55'),
(660, 24, 'Oussama', 'Khenifra', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(661, 24, 'Abaar Soufiane', 'ZI had soualem', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(662, 24, 'Issmaeil', 'Casa', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(663, 24, 'Said elouahidi', 'Safi sauiraia lakdima cagi perla', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(664, 24, 'Abdlgha four hibaoui', 'Tan tan', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(665, 24, 'ayoub', 'berrchid', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(666, 24, 'زكرياء ايتوسي', 'مراكش المحاميد', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(667, 24, 'يونس', 'العيون', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(668, 24, 'Khalid', 'Rabat', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(669, 24, 'BRONO TRAVAUX', 'Casablanca', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(670, 24, 'Hassan Nadifi', 'Rabat', 'pending', NULL, NULL, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(671, 25, 'يوسف القصر الكبير', 'القصر الكبير', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(672, 25, 'Mohammed', 'Rabat', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(673, 25, 'Oui', 'Oui', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(674, 25, 'محمد الحمامرة', 'الدار البيضاء شارع عبد المؤمن مطعم الو بيروت', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(675, 25, 'Ibrahim amad', 'Gueliz', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(676, 25, 'Fakhr eddine enniouar', 'El jadida', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(677, 25, 'Blil Abdellatif', '18 bis  kennaria Marrakech', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(678, 25, 'Zakaria', 'casa sidi momn', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(679, 25, 'Ouidad adil', 'Meknes bab zougha lahdim', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(680, 25, 'Ayoub boukachab', 'berrchid', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(681, 25, 'med', '84', 'pending', NULL, NULL, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(682, 26, 'Ayoub', '0661616511', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(683, 26, 'سفيان امير', '0688-212291', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(684, 26, 'doni tuning', '0714994726', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(685, 26, 'Moussa phone', '0601669177', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(686, 26, 'BADR NAJROUM', '0690181026', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(687, 26, 'Hamza assouqi', '0638055848', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(688, 26, 'Samir Benkirane', '0629442158', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(689, 26, 'El harrak Mohammed', '0659614897', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(690, 26, 'FouadDik', '0614228399', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(691, 26, 'مريم', '0640145730', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(692, 26, 'Karim bnmsoud', '0636796691', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(693, 26, 'Zakaria', '0665191559', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(694, 26, 'Hamza Bentalha', '0676725695', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(695, 26, 'Mehdi arifi', '0618447796', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(696, 26, 'جمال الدرعاوي', '0660462137', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(697, 26, 'Fatima zahrae', '0641450549', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(698, 26, 'Brahim', '0678471138', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(699, 26, 'Aziz', '0607886299', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(700, 26, 'Aznoun abderrazak', '0622854615', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(701, 26, 'Foad', '0634762334', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(702, 26, 'Hayat', '0607072246', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(703, 26, 'Brahim', '0681277454', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(704, 26, 'Kassimi mohammed', '0653506408', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(705, 26, 'Aafafe zel', '0661384169', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(706, 26, 'Salam', '0662468722', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(707, 26, 'نورالدين ودقي', '0669910055', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(708, 26, 'Abdellh ouali', '06 34 09 74 11', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(709, 26, 'mohcin najih', '0674415750', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(710, 26, 'Soni lia', '0661145054', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(711, 26, 'Habili', '0762238862', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(712, 26, 'Walid', 'Ki', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(713, 26, 'زينب مستور', '0634069630', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(714, 26, 'El Mehdi selmaoui', '0767632033', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(715, 26, 'Moaad', '0657367593', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(716, 26, 'Hakim El Ghazi', '0661194820', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(717, 26, 'هناء', '0664419948', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(718, 26, 'Abde ssamad rekdi', '0695709998', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(719, 26, 'Hamza', '0699635508', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(720, 26, 'Mohamed bade chentouf', '0606205837', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(721, 26, '‏سلمى', '٠٦٠٩٩٠٩٩٢١', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(722, 26, 'Ahmed', 'Hhh', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(723, 26, 'Sir tqawd', '+212 691-520624', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(724, 26, 'Abd', '0624722614', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(725, 26, 'Chahl laabar li fih lichahr', '0663727728', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(726, 26, 'Hatim salhi', '0691913763', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(727, 26, 'سهيلة', '0772198316', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(728, 26, 'Imad', '0654455694', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(729, 26, 'Rachid tawrit', '0623642891', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(730, 26, 'Youssef ait', '0653854658', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(731, 26, 'Rsports.ma', '070 259 7070', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(732, 26, 'Lamia', '0661230954', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(733, 26, 'Ibrahim bensaddik', '0604248202', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(734, 26, 'Yassir jamali', '0620783056', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(735, 26, 'hicham boulghmane', '0680835407', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(736, 26, '0606205020', '0606205020', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(737, 26, 'الشارقة', '0680668176', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(738, 26, 'Mohamed bokhal', '0671442604', 'pending', NULL, NULL, '2026-08-16 23:28:48', '2026-08-16 23:28:48'),
(739, 26, 'Omar outaleb', '0762623125', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(740, 26, 'Rajae barka', '0658120367', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(741, 26, 'ayoub', '0690905213', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(742, 26, 'Habergor', '0715075854', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(743, 26, 'دريس', '0618675725', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(744, 26, 'Badr eddine', '0661945188', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(745, 26, '0661552900', '0661552900', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(746, 26, 'Roch di', '0649721405', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(747, 26, 'يوسف زويهر', '0666651743', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(748, 26, 'Sofftu liya nchouf', '0620187076', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(749, 26, 'سعيد بن الأشهب', '0661252811', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(750, 26, 'Salam', '0680822424', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(751, 26, 'Anass', '0649462417', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(752, 26, 'Hamza elouardi', '0695368599', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(753, 26, '..', '06 15 65 20 82', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(754, 26, 'Filali mohamed amine', '0610251025', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49');
INSERT INTO `prospects` (`id`, `prospect_file_id`, `name`, `phone`, `status`, `notes`, `called_at`, `created_at`, `updated_at`) VALUES
(755, 26, 'Cherif', '0661857799', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(756, 26, 'عصام', '0661356708', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(757, 26, 'Ismaël', '0728020002', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(758, 26, 'meghari', '0600600333', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(759, 26, 'Yassine', '0691493896', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(760, 26, 'snack akram', '0767676355', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(761, 26, 'Elkotabi hamza', '0650810442', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(762, 26, 'Abderazak', '0641749228', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(763, 26, 'chahyd Abdellah', '‏0661364171', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(764, 26, 'chimanto', '0663535747', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(765, 26, 'amigos viajes', '0674664766', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(766, 26, 'Oussama', '0630565478', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49'),
(767, 26, 'اشرف', '0663146410', 'pending', NULL, NULL, '2026-08-16 23:28:49', '2026-08-16 23:28:49');

-- --------------------------------------------------------

--
-- Structure de la table `prospect_files`
--

CREATE TABLE `prospect_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prospect_files`
--

INSERT INTO `prospect_files` (`id`, `name`, `file_path`, `agent_id`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(22, 'nouvelle compagne 10 08 2026', 'prospect_files/feRSgYt447eIv46s9sYc5P8IhM2Fy1an9WKiy3A0.txt', 4, 1, '2026-08-10 14:48:34', '2026-08-10 14:48:34'),
(23, 'fichier 10 08 2026', 'prospect_files/C9xqMsIdmvWm6pitFjFxiJvqaftDmkvS1PLTlOs8.txt', 2, 1, '2026-08-10 14:48:54', '2026-08-10 14:48:54'),
(24, '11/08/2026', 'prospect_files/Glhlg0KVbFipIpjbXViGzlsHMzZ1Bn0XWUImHbjv.csv', 4, 1, '2026-08-12 01:03:06', '2026-08-12 01:03:06'),
(25, '11/08/2026', 'prospect_files/7MS9cc37sH5mcyIZ8tRv6cyowXpSFVZzubsVyPBN.csv', 2, 1, '2026-08-12 01:03:29', '2026-08-12 01:03:29'),
(26, 'Alpha', 'prospect_files/o5yEbwYG7KDzZK4CDFm6XJqiEU7Y5affQXpQNGhT.csv', 4, 5, '2026-08-16 23:28:48', '2026-08-16 23:28:48');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `permission`, `created_at`, `updated_at`) VALUES
(120, 'agent', 'view_dashboard', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(121, 'agent', 'view_customers', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(122, 'agent', 'manage_customers', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(123, 'agent', 'view_products', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(124, 'agent', 'manage_products', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(125, 'agent', 'manage_categories', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(126, 'agent', 'view_orders', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(127, 'agent', 'update_order_status', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(128, 'agent', 'view_trainings', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(129, 'supplier', 'view_dashboard', '2026-08-12 01:50:22', '2026-08-12 01:50:22'),
(130, 'supplier', 'view_products', '2026-08-12 01:50:22', '2026-08-12 01:50:22'),
(131, 'supplier', 'manage_products', '2026-08-12 01:12:24', '2026-08-12 01:12:24'),
(132, 'media_buyer', 'view_dashboard', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(133, 'media_buyer', 'view_orders', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(134, 'media_buyer', 'manage_orders', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(135, 'media_buyer', 'view_customers', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(136, 'media_buyer', 'manage_customers', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(137, 'media_buyer', 'view_prospects', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(138, 'media_buyer', 'manage_prospects', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(139, 'media_buyer', 'view_products', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(140, 'media_buyer', 'view_trainings', '2026-08-12 02:38:17', '2026-08-12 02:38:17'),
(141, 'supplier', 'view_logistics', '2026-08-12 01:50:22', '2026-08-12 01:50:22'),
(142, 'supplier', 'view_orders', '2026-08-12 01:50:22', '2026-08-12 01:50:22');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BsrFbRsp5J8YdnBTtYXbG98J9olidX8ngeXPhB1W', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHFhQW1GZGxNakJQYjBuRTc5c1M3eGhKY2RnQWZSN2pNeWJsWXhOSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lcnMiO3M6NToicm91dGUiO3M6MTU6ImN1c3RvbWVycy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1787100151);

-- --------------------------------------------------------

--
-- Structure de la table `supplier_orders`
--

CREATE TABLE `supplier_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','preparing','shipped','completed') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `supplier_orders`
--

INSERT INTO `supplier_orders` (`id`, `order_id`, `supplier_id`, `status`, `notes`, `shipped_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(7, 8, 1, 'shipped', NULL, '2026-08-18 23:39:27', '2026-08-18 23:39:24', '2026-08-18 23:38:05', '2026-08-18 23:39:27');

-- --------------------------------------------------------

--
-- Structure de la table `trainings`
--

CREATE TABLE `trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trainings`
--

INSERT INTO `trainings` (`id`, `title`, `description`, `file_path`, `video_url`, `created_at`, `updated_at`) VALUES
(7, 'test liste', 'contact á appeler', 'training_docs/rhsaykFk7pOvplTan7Ru7HoYvZEQlzvH87nvDY4b.txt', 'https://www.youtube.com/watch?v=ix5P6RQhCuo&list=RDix5P6RQhCuo&index=2', '2026-08-07 16:07:00', '2026-08-07 16:07:00');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'agent',
  `cin` varchar(255) DEFAULT NULL,
  `cin_card_path` varchar(255) DEFAULT NULL,
  `cin_recto_path` varchar(255) DEFAULT NULL,
  `cin_verso_path` varchar(255) DEFAULT NULL,
  `engagement_letter_path` varchar(255) DEFAULT NULL,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `access_code` varchar(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `cin`, `cin_card_path`, `cin_recto_path`, `cin_verso_path`, `engagement_letter_path`, `commission_rate`, `phone`, `is_active`, `access_code`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Directeur Admin', 'admin@projecteur.com', 'admin', NULL, NULL, NULL, NULL, NULL, 0.00, '0611223344', 1, 'ADMIN01', NULL, '$2y$12$Qx8hpA3fLZUC3vQWegpznOXzWjPHkOnZcmXLIo5AMDYAVTZ1zk74e', 'WoJzZDVjAPGJKHWblxctNnTSOnonqfJSWow5e1ZIXO35wcvCxTuwvBADN0DY', '2026-07-26 15:17:59', '2026-07-26 15:17:59'),
(2, 'chahid mohammed', 'mohamedchahid2019@gmail.com', 'agent', 'GM179193', 'agent_docs/I5elNx8ikcBEeGD7djZfd8wa9QTnro0zKWQrpwIg.jpg', 'agent_docs/I5elNx8ikcBEeGD7djZfd8wa9QTnro0zKWQrpwIg.jpg', NULL, 'agent_docs/1BYw3N0CECwwNHCZ4MfLWu5NNUtb8qNCEbawWfkb.pdf', 0.00, '0608349505', 1, 'mentos01', NULL, '$2y$12$bshuLxpBnqhTrOrOtdwMsObjjNTJmSvPfs6uSc9Ts8QwuqPG1F2bK', 'mGN7Uo73vIrTB5YzBPMwGUZyd27lJHXR7bq6nNapVVgdFe2DdTgjoughSgx3', '2026-07-26 15:17:59', '2026-08-07 15:22:18'),
(3, 'Soufiane sentissi', 'uselec.ma@gmail.com', 'supplier', NULL, NULL, NULL, NULL, NULL, 0.00, '0663646492', 1, 'uselec26', NULL, '$2y$12$cBPlOVBm6VMeB1e2jRPPhOG3/iFb8isKWTXM97mXYcoFLW55K2WFC', '5brN1SNMCoaRbFbV6c5qF7lT69k9YOyjmaRewxPioIFOJb5dGv7kvsTcFbQ4', '2026-07-26 15:17:59', '2026-08-12 01:10:10'),
(4, 'adam chabih', 'adam123chabih@gmail.com', 'agent', 'F760564', 'agent_docs/fhMSwDatsUkPrbGnylF8YAN8ejmNDntHkWyzNvP6.pdf', 'agent_docs/fhMSwDatsUkPrbGnylF8YAN8ejmNDntHkWyzNvP6.pdf', NULL, 'agent_docs/bAqr0LPK6Og6DZl6KnolU0LKunjQ2uaKGZA3JAGZ.pdf', 0.00, '0675330732', 1, 'trident01', NULL, '$2y$12$bWg.V6kNb1AzxUlZuJwVIua/VEPCf.c.px8z5N8.XB7GEDhBKuJi6', '0MT3cEC6bzLdYc3cjMWIeKh9rhNO6HoRGXXgQrkXqWXe9k3JuTPM8PPgd4Qn', '2026-08-07 15:13:55', '2026-08-07 15:13:55'),
(5, 'a changer anas infos', 'satayman41@gmail.com', 'media_buyer', NULL, NULL, NULL, NULL, NULL, 0.00, '0707407425', 1, 'trident03', NULL, '$2y$12$alCtcjtb8hL8eeXcrx1LfePYEe1qwHZ0ooydUdurpg6d78ykoqa4W', NULL, '2026-08-12 02:39:20', '2026-08-16 23:25:18');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent_product_commissions`
--
ALTER TABLE `agent_product_commissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agent_product_commissions_product_id_agent_id_unique` (`product_id`,`agent_id`),
  ADD KEY `agent_product_commissions_agent_id_foreign` (`agent_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Index pour la table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commissions_agent_id_foreign` (`agent_id`),
  ADD KEY `commissions_order_id_foreign` (`order_id`);

--
-- Index pour la table `company_documents`
--
ALTER TABLE `company_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_documents_user_id_foreign` (`user_id`);

--
-- Index pour la table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_created_by_foreign` (`created_by`);

--
-- Index pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_created_by_foreign` (`created_by`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_code_unique` (`code`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_agent_id_foreign` (`agent_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_recorded_by_foreign` (`recorded_by`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Index pour la table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospects_prospect_file_id_foreign` (`prospect_file_id`);

--
-- Index pour la table `prospect_files`
--
ALTER TABLE `prospect_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospect_files_agent_id_foreign` (`agent_id`),
  ADD KEY `prospect_files_uploaded_by_foreign` (`uploaded_by`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_permissions_role_permission_unique` (`role`,`permission`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_orders_order_id_foreign` (`order_id`),
  ADD KEY `supplier_orders_supplier_id_foreign` (`supplier_id`);

--
-- Index pour la table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_access_code_unique` (`access_code`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agent_product_commissions`
--
ALTER TABLE `agent_product_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `company_documents`
--
ALTER TABLE `company_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=768;

--
-- AUTO_INCREMENT pour la table `prospect_files`
--
ALTER TABLE `prospect_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT pour la table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agent_product_commissions`
--
ALTER TABLE `agent_product_commissions`
  ADD CONSTRAINT `agent_product_commissions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `agent_product_commissions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `company_documents`
--
ALTER TABLE `company_documents`
  ADD CONSTRAINT `company_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `prospects`
--
ALTER TABLE `prospects`
  ADD CONSTRAINT `prospects_prospect_file_id_foreign` FOREIGN KEY (`prospect_file_id`) REFERENCES `prospect_files` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `prospect_files`
--
ALTER TABLE `prospect_files`
  ADD CONSTRAINT `prospect_files_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `prospect_files_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  ADD CONSTRAINT `supplier_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supplier_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
