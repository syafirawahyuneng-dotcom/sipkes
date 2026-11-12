<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Profile;
use App\Models\Feature;
use App\Models\Advantage;
use App\Models\PricingPlan;
use App\Models\SupportService;
use App\Models\GalleryCategory;
use App\Models\Gallery;
use App\Models\ContactInfo;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Models\TargetFacility;
use App\Models\Banner;

class DumpMysqlSeeder extends Seeder
{
    public function run(): void
    {
        $out = "-- ========================================================\n";
        $out .= "-- DATABASE DUMP: sip_kes\n";
        $out .= "-- Target RDBMS: MySQL 5.7+ / MariaDB 10.3+\n";
        $out .= "-- Generated for Portal SIP-Kes TeFa Inovasi Kesehatan Polije\n";
        $out .= "-- ========================================================\n\n";
        $out .= "CREATE DATABASE IF NOT EXISTS `sip_kes` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        $out .= "USE `sip_kes`;\n\n";
        $out .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

        // 1. Admins
        $out .= "-- ----------------------------\n-- Table structure for admins\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `admins`;\n";
        $out .= "CREATE TABLE `admins` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `email` varchar(255) NOT NULL UNIQUE,\n";
        $out .= "  `password` varchar(255) NOT NULL,\n";
        $out .= "  `remember_token` varchar(100) DEFAULT NULL,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Admin::all() as $a) {
            $out .= sprintf(
                "INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, NOW(), NOW());\n",
                $a->id,
                DB::getPdo()->quote($a->name),
                DB::getPdo()->quote($a->email),
                DB::getPdo()->quote($a->password)
            );
        }
        $out .= "\n";

        // 2. Profiles
        $out .= "-- ----------------------------\n-- Table structure for profiles\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `profiles`;\n";
        $out .= "CREATE TABLE `profiles` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `institution` varchar(255) NOT NULL,\n";
        $out .= "  `tagline` varchar(255) DEFAULT NULL,\n";
        $out .= "  `about_tefa` text DEFAULT NULL,\n";
        $out .= "  `about_sipkes` text DEFAULT NULL,\n";
        $out .= "  `vision` text DEFAULT NULL,\n";
        $out .= "  `mission` text DEFAULT NULL,\n";
        $out .= "  `goals` text DEFAULT NULL,\n";
        $out .= "  `background` text DEFAULT NULL,\n";
        $out .= "  `image` varchar(255) DEFAULT NULL,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Profile::all() as $p) {
            $out .= sprintf(
                "INSERT INTO `profiles` (`id`, `name`, `institution`, `tagline`, `about_tefa`, `about_sipkes`, `vision`, `mission`, `goals`, `background`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), NOW());\n",
                $p->id,
                DB::getPdo()->quote($p->name),
                DB::getPdo()->quote($p->institution),
                DB::getPdo()->quote($p->tagline),
                DB::getPdo()->quote($p->about_tefa),
                DB::getPdo()->quote($p->about_sipkes),
                DB::getPdo()->quote($p->vision),
                DB::getPdo()->quote($p->mission),
                DB::getPdo()->quote($p->goals),
                DB::getPdo()->quote($p->background)
            );
        }
        $out .= "\n";

        // 3. Features
        $out .= "-- ----------------------------\n-- Table structure for features\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `features`;\n";
        $out .= "CREATE TABLE `features` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `category` varchar(100) DEFAULT NULL,\n";
        $out .= "  `icon` varchar(100) DEFAULT NULL,\n";
        $out .= "  `description` text NOT NULL,\n";
        $out .= "  `is_featured` tinyint(1) NOT NULL DEFAULT 0,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Feature::all() as $f) {
            $out .= sprintf(
                "INSERT INTO `features` (`id`, `name`, `category`, `icon`, `description`, `is_featured`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %d, %d, NOW(), NOW());\n",
                $f->id,
                DB::getPdo()->quote($f->name),
                DB::getPdo()->quote($f->category),
                DB::getPdo()->quote($f->icon),
                DB::getPdo()->quote($f->description),
                $f->is_featured ? 1 : 0,
                $f->order
            );
        }
        $out .= "\n";

        // 4. Advantages
        $out .= "-- ----------------------------\n-- Table structure for advantages\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `advantages`;\n";
        $out .= "CREATE TABLE `advantages` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `title` varchar(255) NOT NULL,\n";
        $out .= "  `icon` varchar(100) DEFAULT NULL,\n";
        $out .= "  `description` text NOT NULL,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Advantage::all() as $adv) {
            $out .= sprintf(
                "INSERT INTO `advantages` (`id`, `title`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %d, NOW(), NOW());\n",
                $adv->id,
                DB::getPdo()->quote($adv->title),
                DB::getPdo()->quote($adv->icon),
                DB::getPdo()->quote($adv->description),
                $adv->order
            );
        }
        $out .= "\n";

        // 5. Pricing Plans
        $out .= "-- ----------------------------\n-- Table structure for pricing_plans\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `pricing_plans`;\n";
        $out .= "CREATE TABLE `pricing_plans` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `slug` varchar(255) NOT NULL UNIQUE,\n";
        $out .= "  `price` decimal(12,2) NOT NULL,\n";
        $out .= "  `period` varchar(50) NOT NULL DEFAULT 'bulan',\n";
        $out .= "  `badge` varchar(100) DEFAULT NULL,\n";
        $out .= "  `description` text DEFAULT NULL,\n";
        $out .= "  `features_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features_list`)),\n";
        $out .= "  `terms` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`terms`)),\n";
        $out .= "  `is_active` tinyint(1) NOT NULL DEFAULT 1,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (PricingPlan::all() as $pp) {
            $out .= sprintf(
                "INSERT INTO `pricing_plans` (`id`, `name`, `slug`, `price`, `period`, `badge`, `description`, `features_list`, `terms`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %d, %d, NOW(), NOW());\n",
                $pp->id,
                DB::getPdo()->quote($pp->name),
                DB::getPdo()->quote($pp->slug),
                $pp->price,
                DB::getPdo()->quote($pp->period),
                DB::getPdo()->quote($pp->badge),
                DB::getPdo()->quote($pp->description),
                DB::getPdo()->quote(json_encode($pp->features_list)),
                DB::getPdo()->quote(json_encode($pp->terms)),
                $pp->is_active ? 1 : 0,
                $pp->order
            );
        }
        $out .= "\n";

        // 6. Support Services
        $out .= "-- ----------------------------\n-- Table structure for support_services\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `support_services`;\n";
        $out .= "CREATE TABLE `support_services` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `title` varchar(255) NOT NULL,\n";
        $out .= "  `icon` varchar(100) DEFAULT NULL,\n";
        $out .= "  `summary` text DEFAULT NULL,\n";
        $out .= "  `description` longtext NOT NULL,\n";
        $out .= "  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits`)),\n";
        $out .= "  `image` varchar(255) DEFAULT NULL,\n";
        $out .= "  `is_active` tinyint(1) NOT NULL DEFAULT 1,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (SupportService::all() as $ss) {
            $out .= sprintf(
                "INSERT INTO `support_services` (`id`, `title`, `icon`, `summary`, `description`, `benefits`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %d, %d, NOW(), NOW());\n",
                $ss->id,
                DB::getPdo()->quote($ss->title),
                DB::getPdo()->quote($ss->icon),
                DB::getPdo()->quote($ss->summary),
                DB::getPdo()->quote($ss->description),
                DB::getPdo()->quote(json_encode($ss->benefits)),
                $ss->is_active ? 1 : 0,
                $ss->order
            );
        }
        $out .= "\n";

        // 7. Galleries & Categories
        $out .= "-- ----------------------------\n-- Table structure for gallery_categories\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `gallery_categories`;\n";
        $out .= "CREATE TABLE `gallery_categories` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `slug` varchar(255) NOT NULL UNIQUE,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (GalleryCategory::all() as $gc) {
            $out .= sprintf(
                "INSERT INTO `gallery_categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES (%d, %s, %s, NOW(), NOW());\n",
                $gc->id,
                DB::getPdo()->quote($gc->name),
                DB::getPdo()->quote($gc->slug)
            );
        }
        $out .= "\n";

        $out .= "-- ----------------------------\n-- Table structure for galleries\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `galleries`;\n";
        $out .= "CREATE TABLE `galleries` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `category_id` bigint(20) unsigned DEFAULT NULL,\n";
        $out .= "  `title` varchar(255) NOT NULL,\n";
        $out .= "  `description` text DEFAULT NULL,\n";
        $out .= "  `image` varchar(255) NOT NULL,\n";
        $out .= "  `date` date DEFAULT NULL,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`),\n";
        $out .= "  KEY `galleries_category_id_foreign` (`category_id`),\n";
        $out .= "  CONSTRAINT `galleries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `gallery_categories` (`id`) ON DELETE SET NULL\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Gallery::all() as $g) {
            $out .= sprintf(
                "INSERT INTO `galleries` (`id`, `category_id`, `title`, `description`, `image`, `date`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %d, NOW(), NOW());\n",
                $g->id,
                $g->category_id ? $g->category_id : 'NULL',
                DB::getPdo()->quote($g->title),
                DB::getPdo()->quote($g->description),
                DB::getPdo()->quote($g->image),
                $g->date ? DB::getPdo()->quote($g->date->format('Y-m-d')) : 'NULL',
                $g->order
            );
        }
        $out .= "\n";

        // 8. Contact Info & Messages
        $out .= "-- ----------------------------\n-- Table structure for contact_info\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `contact_info`;\n";
        $out .= "CREATE TABLE `contact_info` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `phone` varchar(255) NOT NULL DEFAULT '0813-3551-2803',\n";
        $out .= "  `whatsapp` varchar(255) NOT NULL DEFAULT '6281335512803',\n";
        $out .= "  `email` varchar(255) NOT NULL DEFAULT 'vkes@polije.ac.id',\n";
        $out .= "  `instagram` varchar(255) NOT NULL DEFAULT '@sipkes.co.id',\n";
        $out .= "  `instagram_url` varchar(255) NOT NULL DEFAULT 'https://instagram.com/sipkes.co.id',\n";
        $out .= "  `address` text NOT NULL,\n";
        $out .= "  `maps_embed` text DEFAULT NULL,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (ContactInfo::all() as $ci) {
            $out .= sprintf(
                "INSERT INTO `contact_info` (`id`, `phone`, `whatsapp`, `email`, `instagram`, `instagram_url`, `address`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %s, NOW(), NOW());\n",
                $ci->id,
                DB::getPdo()->quote($ci->phone),
                DB::getPdo()->quote($ci->whatsapp),
                DB::getPdo()->quote($ci->email),
                DB::getPdo()->quote($ci->instagram),
                DB::getPdo()->quote($ci->instagram_url),
                DB::getPdo()->quote($ci->address)
            );
        }
        $out .= "\n";

        $out .= "-- ----------------------------\n-- Table structure for contact_messages\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `contact_messages`;\n";
        $out .= "CREATE TABLE `contact_messages` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `email` varchar(255) NOT NULL,\n";
        $out .= "  `phone` varchar(50) DEFAULT NULL,\n";
        $out .= "  `faskes_name` varchar(255) DEFAULT NULL,\n";
        $out .= "  `subject` varchar(255) NOT NULL,\n";
        $out .= "  `message` text NOT NULL,\n";
        $out .= "  `is_read` tinyint(1) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        // 9. Banners, Settings, Facilities
        $out .= "-- ----------------------------\n-- Table structure for banners\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `banners`;\n";
        $out .= "CREATE TABLE `banners` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `badge` varchar(255) DEFAULT NULL,\n";
        $out .= "  `title` varchar(255) NOT NULL,\n";
        $out .= "  `subtitle` text DEFAULT NULL,\n";
        $out .= "  `primary_btn_text` varchar(255) NOT NULL DEFAULT 'Lihat Fitur & Demo',\n";
        $out .= "  `primary_btn_url` varchar(255) NOT NULL DEFAULT '#fitur',\n";
        $out .= "  `secondary_btn_text` varchar(255) NOT NULL DEFAULT 'Hubungi Kami',\n";
        $out .= "  `secondary_btn_url` varchar(255) NOT NULL DEFAULT '#kontak',\n";
        $out .= "  `image` varchar(255) DEFAULT NULL,\n";
        $out .= "  `is_active` tinyint(1) NOT NULL DEFAULT 1,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (Banner::all() as $b) {
            $out .= sprintf(
                "INSERT INTO `banners` (`id`, `badge`, `title`, `subtitle`, `primary_btn_text`, `primary_btn_url`, `secondary_btn_text`, `secondary_btn_url`, `is_active`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %d, %d, NOW(), NOW());\n",
                $b->id,
                DB::getPdo()->quote($b->badge),
                DB::getPdo()->quote($b->title),
                DB::getPdo()->quote($b->subtitle),
                DB::getPdo()->quote($b->primary_btn_text),
                DB::getPdo()->quote($b->primary_btn_url),
                DB::getPdo()->quote($b->secondary_btn_text),
                DB::getPdo()->quote($b->secondary_btn_url),
                $b->is_active ? 1 : 0,
                $b->order
            );
        }
        $out .= "\n";

        $out .= "-- ----------------------------\n-- Table structure for target_facilities\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `target_facilities`;\n";
        $out .= "CREATE TABLE `target_facilities` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `name` varchar(255) NOT NULL,\n";
        $out .= "  `icon` varchar(100) DEFAULT NULL,\n";
        $out .= "  `description` text DEFAULT NULL,\n";
        $out .= "  `order` int(11) NOT NULL DEFAULT 0,\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (TargetFacility::all() as $tf) {
            $out .= sprintf(
                "INSERT INTO `target_facilities` (`id`, `name`, `icon`, `description`, `order`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, %d, NOW(), NOW());\n",
                $tf->id,
                DB::getPdo()->quote($tf->name),
                DB::getPdo()->quote($tf->icon),
                DB::getPdo()->quote($tf->description),
                $tf->order
            );
        }
        $out .= "\n";

        $out .= "-- ----------------------------\n-- Table structure for site_settings\n-- ----------------------------\n";
        $out .= "DROP TABLE IF EXISTS `site_settings`;\n";
        $out .= "CREATE TABLE `site_settings` (\n";
        $out .= "  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,\n";
        $out .= "  `key` varchar(255) NOT NULL UNIQUE,\n";
        $out .= "  `value` longtext DEFAULT NULL,\n";
        $out .= "  `group` varchar(100) NOT NULL DEFAULT 'general',\n";
        $out .= "  `created_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  `updated_at` timestamp NULL DEFAULT NULL,\n";
        $out .= "  PRIMARY KEY (`id`)\n";
        $out .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

        foreach (SiteSetting::all() as $st) {
            $out .= sprintf(
                "INSERT INTO `site_settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES (%d, %s, %s, %s, NOW(), NOW());\n",
                $st->id,
                DB::getPdo()->quote($st->key),
                DB::getPdo()->quote($st->value),
                DB::getPdo()->quote($st->group)
            );
        }
        $out .= "\nSET FOREIGN_KEY_CHECKS = 1;\n";

        file_put_contents(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sip_kes_database.sql', $out);
    }
}

