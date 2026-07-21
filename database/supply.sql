-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.46 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for forecasting_planning
CREATE DATABASE IF NOT EXISTS `forecasting_planning` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forecasting_planning`;

-- Dumping structure for table forecasting_planning.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.categories: ~5 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Graphics Card', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(2, 'Storage', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(3, 'Processor', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(4, 'Memory', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(5, 'Motherboard', '2026-07-18 08:49:46', '2026-07-18 08:49:46');

-- Dumping structure for table forecasting_planning.forecasts
CREATE TABLE IF NOT EXISTS `forecasts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `month` date NOT NULL,
  `current_sales` int unsigned NOT NULL DEFAULT '0',
  `forecast_units` int unsigned NOT NULL DEFAULT '0',
  `growth_percent` decimal(6,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recommendation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forecasts_product_id_month_unique` (`product_id`,`month`),
  CONSTRAINT `forecasts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.forecasts: ~6 rows (approximately)
INSERT INTO `forecasts` (`id`, `product_id`, `month`, `current_sales`, `forecast_units`, `growth_percent`, `status`, `recommendation`, `created_at`, `updated_at`) VALUES
	(1, 1, '2026-07-01', 325, 354, 8.92, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 2, '2026-07-01', 109, 119, 9.17, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 3, '2026-07-01', 240, 262, 9.17, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 6, '2026-07-01', 67, 73, 8.96, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 7, '2026-07-01', 195, 213, 9.23, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 9, '2026-07-01', 152, 166, 9.21, 'Stable Growth', 'Increase production by 10 units', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.inventories
CREATE TABLE IF NOT EXISTS `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `quantity_on_hand` int unsigned NOT NULL DEFAULT '0',
  `reorder_level` int unsigned NOT NULL DEFAULT '10',
  `status` enum('in_stock','restocked','low_stock','out_of_stock','reserved','overstock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_stock',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventories_product_id_unique` (`product_id`),
  CONSTRAINT `inventories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.inventories: ~12 rows (approximately)
INSERT INTO `inventories` (`id`, `product_id`, `quantity_on_hand`, `reorder_level`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 0, 10, 'out_of_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(2, 2, 42, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(3, 3, 8, 10, 'low_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(4, 4, 60, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(5, 5, 55, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(6, 6, 30, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(7, 7, 120, 10, 'overstock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(8, 8, 45, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(9, 9, 70, 10, 'restocked', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(10, 10, 65, 10, 'restocked', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(11, 11, 25, 10, 'in_stock', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(12, 12, 15, 10, 'reserved', '2026-07-18 08:49:46', '2026-07-18 08:49:46');

-- Dumping structure for table forecasting_planning.invoices
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.invoices: ~15 rows (approximately)
INSERT INTO `invoices` (`id`, `invoice_no`, `client`, `amount`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'INV-00001', 'Client 1', 68179.00, '2026-07-10', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(2, 'INV-00002', 'Client 2', 22701.00, '2026-08-10', 'Pending', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(3, 'INV-00003', 'Client 3', 13229.00, '2026-07-29', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(4, 'INV-00004', 'Client 4', 69902.00, '2026-07-04', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(5, 'INV-00005', 'Client 5', 20897.00, '2026-08-14', 'Pending', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(6, 'INV-00006', 'Client 6', 14897.00, '2026-07-17', 'Paid', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(7, 'INV-00007', 'Client 7', 24929.00, '2026-07-13', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(8, 'INV-00008', 'Client 8', 32540.00, '2026-08-12', 'Pending', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(9, 'INV-00009', 'Client 9', 43404.00, '2026-07-23', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(10, 'INV-00010', 'Client 10', 6554.00, '2026-07-08', 'Pending', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(11, 'INV-00011', 'Client 11', 38132.00, '2026-08-04', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(12, 'INV-00012', 'Client 12', 67970.00, '2026-08-08', 'Paid', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(13, 'INV-00013', 'Client 13', 38317.00, '2026-07-15', 'Overdue', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(14, 'INV-00014', 'Client 14', 52783.00, '2026-07-30', 'Pending', '2026-07-18 08:49:48', '2026-07-18 08:49:48'),
	(15, 'INV-00015', 'Client 15', 74434.00, '2026-07-04', 'Paid', '2026-07-18 08:49:48', '2026-07-18 08:49:48');

-- Dumping structure for table forecasting_planning.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.migrations: ~15 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2026_07_13_043016_create_categories_table', 1),
	(2, '2026_07_13_043023_create_products_table', 1),
	(3, '2026_07_13_043031_create_inventories_table', 1),
	(4, '2026_07_13_043043_create_sales_table', 1),
	(5, '2026_07_13_043051_create_forecasts_table', 1),
	(6, '2026_07_17_090219_create_suppliers_table', 1),
	(7, '2026_07_17_090354_create_purchase_orders_table', 1),
	(8, '2026_07_17_090429_create_shipments_table', 1),
	(9, '2026_07_17_090441_create_reports_table', 1),
	(10, '2026_07_17_090452_create_report_templates_table', 1),
	(11, '2026_07_17_090459_create_warehouses_table', 1),
	(12, '2026_07_17_090500_create_warehouse_zones_table', 1),
	(13, '2026_07_17_090506_create_invoices_table', 1),
	(14, '2026_07_17_091000_create_transfers_table', 1),
	(15, '2026_07_17_100152_add_inventory_fields_to_products_table', 1);

-- Dumping structure for table forecasting_planning.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `warehouse_id` bigint unsigned DEFAULT NULL,
  `unit_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` int NOT NULL DEFAULT '0',
  `reserved` int NOT NULL DEFAULT '0',
  `status` enum('Healthy','Low Stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Healthy',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_warehouse_id_foreign` (`warehouse_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.products: ~12 rows (approximately)
INSERT INTO `products` (`id`, `name`, `sku`, `category_id`, `warehouse_id`, `unit_price`, `stock`, `reserved`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'RTX 5070', 'GPU-RTX5070', 1, NULL, 32999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(2, 'RTX 4060', 'GPU-RTX4060', 1, NULL, 18999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(3, 'ADATA SSB 1TB', 'STG-ADATA1TB', 2, NULL, 3999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(4, 'ADATA 1TB LEGEND', 'STG-LEGEND1TB', 2, NULL, 4299.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(5, 'ADATA 15GB DDR4', 'MEM-ADATA15DDR4', 4, NULL, 1899.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(6, 'Samsung 990 Pro', 'STG-SAMSUNG990', 2, NULL, 5499.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(7, 'Ryzen 7', 'CPU-RYZEN7', 3, NULL, 14999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(8, 'AMD Ryzen™ 5', 'CPU-RYZEN5', 3, NULL, 9999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(9, 'Kingston DDR5', 'MEM-KINGSTONDDR5', 4, NULL, 2799.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(10, '16GB DDR5 RAM', 'MEM-16GBDDR5', 4, NULL, 2999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(11, 'PCX ASUS PRIME', 'MBD-ASUSPRIME', 5, NULL, 6999.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(12, 'DDR3 RAM', 'MEM-DDR3-GEN', 4, NULL, 899.00, 0, 0, 'Healthy', '2026-07-18 08:49:46', '2026-07-18 08:49:46');

-- Dumping structure for table forecasting_planning.purchase_orders
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `po_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `order_date` date NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` enum('Pending','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `grand_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.purchase_orders: ~15 rows (approximately)
INSERT INTO `purchase_orders` (`id`, `po_number`, `supplier_id`, `order_date`, `delivery_date`, `status`, `grand_total`, `created_at`, `updated_at`) VALUES
	(1, 'PO-38220', 1, '2026-06-11', '2026-06-14', 'Pending', 25613.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'PO-99840', 1, '2026-06-27', '2026-06-29', 'Pending', 120611.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'PO-18638', 1, '2026-05-28', '2026-06-02', 'Pending', 155757.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 'PO-93808', 2, '2026-05-26', '2026-06-03', 'Completed', 143674.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 'PO-71210', 2, '2026-06-11', '2026-06-17', 'Pending', 142516.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 'PO-93875', 2, '2026-07-05', '2026-07-07', 'Pending', 96575.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(7, 'PO-33772', 3, '2026-07-04', '2026-07-14', 'Pending', 61930.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(8, 'PO-88457', 3, '2026-05-30', '2026-06-02', 'Pending', 142722.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(9, 'PO-19072', 3, '2026-06-28', '2026-07-07', 'Completed', 167436.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(10, 'PO-57113', 4, '2026-07-05', '2026-07-10', 'Completed', 164534.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(11, 'PO-28077', 4, '2026-06-29', '2026-07-01', 'Pending', 142549.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(12, 'PO-57464', 4, '2026-07-01', '2026-07-06', 'Completed', 46621.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(13, 'PO-24845', 5, '2026-06-13', '2026-06-19', 'Completed', 66720.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(14, 'PO-89521', 5, '2026-06-21', '2026-06-30', 'Completed', 42619.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(15, 'PO-49354', 5, '2026-06-07', '2026-06-09', 'Completed', 60794.00, '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitted_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.reports: ~10 rows (approximately)
INSERT INTO `reports` (`id`, `type`, `submitted_by`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Inventory Report', 'Inventory Manager', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'Sales Report', 'Sales Manager', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'Forecast Report', 'Forecast Analyst', 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 'Transfer Report', 'Warehouse Supervisor', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 'Shipment Report', 'Logistics Manager', 'In Progress', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 'Procurement Report', 'Procurement Officer', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(7, 'Monthly Inventory Summary', 'Admin', 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(8, 'Warehouse Performance Report', 'Warehouse Manager', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(9, 'Supplier Performance Report', 'Procurement Manager', 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(10, 'Annual Forecast Report', 'Forecast Manager', 'In Progress', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.report_templates
CREATE TABLE IF NOT EXISTS `report_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.report_templates: ~8 rows (approximately)
INSERT INTO `report_templates` (`id`, `name`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Inventory Summary Report', 'System Administrator', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'Monthly Sales Report', 'Sales Manager', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'Forecast Analysis Report', 'Forecast Manager', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 'Warehouse Performance Report', 'Warehouse Supervisor', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 'Transfer Activity Report', 'Logistics Officer', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 'Supplier Purchase Report', 'Procurement Officer', 'Active', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(7, 'Financial Summary Report', 'Finance Department', 'Draft', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(8, 'Quarterly Executive Report', 'Operations Manager', 'Archived', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int unsigned NOT NULL,
  `revenue` decimal(12,2) NOT NULL,
  `sold_at` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_product_id_foreign` (`product_id`),
  KEY `sales_sold_at_index` (`sold_at`),
  CONSTRAINT `sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.sales: ~66 rows (approximately)
INSERT INTO `sales` (`id`, `product_id`, `quantity`, `revenue`, `sold_at`, `created_at`, `updated_at`) VALUES
	(1, 1, 135, 4454865.00, '2025-10-01', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(2, 3, 99, 395901.00, '2025-10-19', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(3, 7, 81, 1214919.00, '2025-10-07', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(4, 9, 63, 176337.00, '2025-10-14', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(5, 2, 45, 854955.00, '2025-10-11', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(6, 6, 27, 148473.00, '2025-10-19', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(7, 1, 156, 5147844.00, '2025-11-12', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(8, 3, 114, 455886.00, '2025-11-11', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(9, 7, 94, 1409906.00, '2025-11-18', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(10, 9, 73, 204327.00, '2025-11-06', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(11, 2, 52, 987948.00, '2025-11-06', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(12, 6, 31, 170469.00, '2025-11-09', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(13, 1, 174, 5741826.00, '2025-12-06', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(14, 3, 128, 511872.00, '2025-12-16', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(15, 7, 104, 1559896.00, '2025-12-18', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(16, 9, 81, 226719.00, '2025-12-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(17, 2, 58, 1101942.00, '2025-12-17', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(18, 6, 35, 192465.00, '2025-12-07', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(19, 1, 189, 6236811.00, '2026-01-12', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(20, 3, 139, 555861.00, '2026-01-21', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(21, 7, 113, 1694887.00, '2026-01-20', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(22, 9, 88, 246312.00, '2026-01-18', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(23, 2, 63, 1196937.00, '2026-01-06', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(24, 6, 38, 208962.00, '2026-01-01', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(25, 1, 213, 7028787.00, '2026-02-12', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(26, 3, 156, 623844.00, '2026-02-20', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(27, 7, 128, 1919872.00, '2026-02-09', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(28, 9, 99, 277101.00, '2026-02-04', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(29, 2, 71, 1348929.00, '2026-02-05', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(30, 6, 43, 236457.00, '2026-02-02', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(31, 1, 239, 7886761.00, '2026-03-04', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(32, 3, 175, 699825.00, '2026-03-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(33, 7, 143, 2144857.00, '2026-03-11', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(34, 9, 111, 310689.00, '2026-03-04', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(35, 2, 80, 1519920.00, '2026-03-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(36, 6, 48, 263952.00, '2026-03-16', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(37, 1, 243, 8018757.00, '2026-04-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(38, 3, 178, 711822.00, '2026-04-21', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(39, 7, 146, 2189854.00, '2026-04-21', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(40, 9, 113, 316287.00, '2026-04-01', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(41, 2, 81, 1538919.00, '2026-04-08', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(42, 6, 49, 269451.00, '2026-04-04', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(43, 1, 267, 8810733.00, '2026-05-03', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(44, 3, 196, 783804.00, '2026-05-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(45, 7, 160, 2399840.00, '2026-05-20', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(46, 9, 125, 349875.00, '2026-05-10', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(47, 2, 89, 1690911.00, '2026-05-07', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(48, 6, 53, 291447.00, '2026-05-19', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(49, 1, 270, 8909730.00, '2026-06-17', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(50, 3, 198, 791802.00, '2026-06-02', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(51, 7, 162, 2429838.00, '2026-06-06', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(52, 9, 126, 352674.00, '2026-06-10', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(53, 2, 90, 1709910.00, '2026-06-13', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(54, 6, 54, 296946.00, '2026-06-12', '2026-07-18 08:49:46', '2026-07-18 08:49:46'),
	(55, 1, 300, 9899700.00, '2026-07-01', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(56, 3, 220, 879780.00, '2026-07-18', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(57, 7, 180, 2699820.00, '2026-07-12', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(58, 9, 140, 391860.00, '2026-07-07', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(59, 2, 100, 1899900.00, '2026-07-13', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(60, 6, 60, 329940.00, '2026-07-05', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(61, 1, 25, 125000.00, '2026-07-18', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(62, 3, 20, 85000.00, '2026-07-17', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(63, 7, 15, 55000.00, '2026-07-16', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(64, 9, 12, 40000.00, '2026-07-15', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(65, 2, 9, 35000.00, '2026-07-14', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(66, 6, 7, 28000.00, '2026-07-13', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.shipments
CREATE TABLE IF NOT EXISTS `shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shipment_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_arrival` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `origin_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_cost` decimal(10,2) NOT NULL,
  `schedule_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shipments_shipment_code_unique` (`shipment_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.shipments: ~3 rows (approximately)
INSERT INTO `shipments` (`id`, `shipment_code`, `driver_name`, `route_path`, `estimated_arrival`, `status`, `meta_info`, `phone_number`, `origin_address`, `destination_address`, `cargo_details`, `quantity`, `payment_status`, `delivery_cost`, `schedule_category`, `created_at`, `updated_at`) VALUES
	(1, 'ABC-01234', 'Erich De Torres', 'Cavite - Laguna', 'Estimated 13 Sept 2026', 'En Route', '4h 22m left', '+63 912 575 4567', '2118 Ridge St. Cavite, 3564', '137 Gomez St, Brgy 2, Laguna City', 'Vertex [Mother Board] Ryzen-5', 10, 'Paid', 17000.00, 'paid', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'DEF-56789', 'Kristy Ann Paracale', 'Manila - Bulacan', 'Estimated 13 Sept 2026', 'En Route', '9h 52m left', '+63 911 200 4911', '742 Evergreen Terrace, Manila, 1000', '456 Oak St, AP 456, Manila City', 'Ryzen-9 Core Kit Combo', 2, 'COD', 5500.00, 'pendings', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'GHI-10111', 'Juliana Aquino', 'Pangasinan - Laguna', '13 Sept 2026', 'Delivered', '0h 00m left', '+63 923 104 2231', '456 Shaw Blvd, Mandaluyong, 1550', '789 Pine Blvd, Batangas City', 'Groceries Logistics Bundle', 5, 'Pending', 12350.00, 'cod', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.suppliers: ~5 rows (approximately)
INSERT INTO `suppliers` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'TechSource Trading', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'PC Express Philippines', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'Gigaware Solutions', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 'MicroHub Distribution', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 'Vertex Components', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.transfers
CREATE TABLE IF NOT EXISTS `transfers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `from_warehouse` bigint unsigned NOT NULL,
  `to_warehouse` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('Pending','In Transit','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_product_id_foreign` (`product_id`),
  KEY `transfers_from_warehouse_foreign` (`from_warehouse`),
  KEY `transfers_to_warehouse_foreign` (`to_warehouse`),
  CONSTRAINT `transfers_from_warehouse_foreign` FOREIGN KEY (`from_warehouse`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transfers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transfers_to_warehouse_foreign` FOREIGN KEY (`to_warehouse`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.transfers: ~15 rows (approximately)
INSERT INTO `transfers` (`id`, `product_id`, `from_warehouse`, `to_warehouse`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
	(1, 3, 2, 3, 131, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 12, 3, 4, 35, 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 5, 2, 1, 25, 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 8, 4, 2, 82, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 1, 4, 1, 23, 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 1, 2, 3, 135, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(7, 3, 3, 2, 148, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(8, 7, 4, 2, 102, 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(9, 6, 1, 3, 50, 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(10, 7, 4, 1, 144, 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(11, 7, 4, 2, 58, 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(12, 6, 2, 1, 26, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(13, 1, 2, 1, 123, 'Pending', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(14, 2, 1, 3, 24, 'Completed', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(15, 6, 1, 4, 120, 'In Transit', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.warehouses
CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.warehouses: ~4 rows (approximately)
INSERT INTO `warehouses` (`id`, `warehouse_name`, `location`, `created_at`, `updated_at`) VALUES
	(1, 'Warehouse A', 'Manila', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 'Warehouse B', 'Quezon City', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 'Warehouse C', 'Cebu', '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 'Warehouse D', 'Davao', '2026-07-18 08:49:47', '2026-07-18 08:49:47');

-- Dumping structure for table forecasting_planning.warehouse_zones
CREATE TABLE IF NOT EXISTS `warehouse_zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_id` bigint unsigned NOT NULL,
  `zone_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_zones_warehouse_id_foreign` (`warehouse_id`),
  CONSTRAINT `warehouse_zones_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table forecasting_planning.warehouse_zones: ~16 rows (approximately)
INSERT INTO `warehouse_zones` (`id`, `warehouse_id`, `zone_name`, `description`, `capacity`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Receiving Area', 'Incoming deliveries and inspection', 500, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(2, 1, 'Storage Area', 'Main storage for inventory', 3000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(3, 1, 'Picking Area', 'Order picking and packing', 1000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(4, 1, 'Dispatch Area', 'Outgoing shipments', 800, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(5, 2, 'Receiving Area', 'Incoming deliveries and inspection', 500, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(6, 2, 'Storage Area', 'Main storage for inventory', 3000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(7, 2, 'Picking Area', 'Order picking and packing', 1000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(8, 2, 'Dispatch Area', 'Outgoing shipments', 800, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(9, 3, 'Receiving Area', 'Incoming deliveries and inspection', 500, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(10, 3, 'Storage Area', 'Main storage for inventory', 3000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(11, 3, 'Picking Area', 'Order picking and packing', 1000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(12, 3, 'Dispatch Area', 'Outgoing shipments', 800, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(13, 4, 'Receiving Area', 'Incoming deliveries and inspection', 500, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(14, 4, 'Storage Area', 'Main storage for inventory', 3000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(15, 4, 'Picking Area', 'Order picking and packing', 1000, '2026-07-18 08:49:47', '2026-07-18 08:49:47'),
	(16, 4, 'Dispatch Area', 'Outgoing shipments', 800, '2026-07-18 08:49:47', '2026-07-18 08:49:47');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
