-- =============================================================================
-- Seed: 4 Panini con categorie, immagini e metadati ACF
-- Da importare DOPO il backup-database.sql
-- =============================================================================
-- IDs utilizzati:
--   wp_posts: 32-45
--   wp_postmeta: 242+
--   wp_terms: 4-5
--   wp_term_taxonomy: 4-5
--   wp_termmeta: 5+
-- =============================================================================

-- ---------------------------------------------------------------------------
-- 1. Categorie Panino: Classici e Speciali
-- ---------------------------------------------------------------------------

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(4, 'Classici', 'classici', 0),
(5, 'Speciali', 'speciali', 0);

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(4, 4, 'categoria_panino', 'I grandi classici della tradizione bolognese', 0, 2),
(5, 5, 'categoria_panino', 'Le nostre creazioni speciali e ricercate', 0, 2);

-- Metadati ACF per le categorie (colore + immagine)
INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(5, 4, 'colore_categoria', '#C8102E'),
(6, 4, '_colore_categoria', 'field_categoria_panino_colore'),
(7, 4, 'immagine_categoria', '40'),
(8, 4, '_immagine_categoria', 'field_categoria_panino_immagine'),
(9, 5, 'colore_categoria', '#D4A017'),
(10, 5, '_colore_categoria', 'field_categoria_panino_colore'),
(11, 5, 'immagine_categoria', '41'),
(12, 5, '_immagine_categoria', 'field_categoria_panino_immagine');

-- ---------------------------------------------------------------------------
-- 2. Attachment: Immagini panini (senza sfondo) - IDs 32-35
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(32, 1, '2026-03-28 10:00:00', '2026-03-28 09:00:00', '', 'la-mortadella-panino-nobg', '', 'inherit', 'open', 'closed', '', 'la-mortadella-panino-nobg', '', '', '2026-03-28 10:00:00', '2026-03-28 09:00:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/la-mortadella-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(33, 1, '2026-03-28 10:01:00', '2026-03-28 09:01:00', '', 'il-bolognese-panino-nobg', '', 'inherit', 'open', 'closed', '', 'il-bolognese-panino-nobg', '', '', '2026-03-28 10:01:00', '2026-03-28 09:01:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/il-bolognese-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(34, 1, '2026-03-28 10:02:00', '2026-03-28 09:02:00', '', 'lo-sfizioso-panino-nobg', '', 'inherit', 'open', 'closed', '', 'lo-sfizioso-panino-nobg', '', '', '2026-03-28 10:02:00', '2026-03-28 09:02:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/lo-sfizioso-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(35, 1, '2026-03-28 10:03:00', '2026-03-28 09:03:00', '', 'il-tartufato-panino-nobg', '', 'inherit', 'open', 'closed', '', 'il-tartufato-panino-nobg', '', '', '2026-03-28 10:03:00', '2026-03-28 09:03:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/il-tartufato-panino-nobg.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 3. Attachment: Logo panini - IDs 36-39
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(36, 1, '2026-03-28 10:04:00', '2026-03-28 09:04:00', '', 'la-mortadella-logo', '', 'inherit', 'open', 'closed', '', 'la-mortadella-logo', '', '', '2026-03-28 10:04:00', '2026-03-28 09:04:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/la-mortadella-logo.png', 0, 'attachment', 'image/png', 0),
(37, 1, '2026-03-28 10:05:00', '2026-03-28 09:05:00', '', 'il-bolognese-logo', '', 'inherit', 'open', 'closed', '', 'il-bolognese-logo', '', '', '2026-03-28 10:05:00', '2026-03-28 09:05:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/il-bolognese-logo.png', 0, 'attachment', 'image/png', 0),
(38, 1, '2026-03-28 10:06:00', '2026-03-28 09:06:00', '', 'lo-sfizioso-logo', '', 'inherit', 'open', 'closed', '', 'lo-sfizioso-logo', '', '', '2026-03-28 10:06:00', '2026-03-28 09:06:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/lo-sfizioso-logo.png', 0, 'attachment', 'image/png', 0),
(39, 1, '2026-03-28 10:07:00', '2026-03-28 09:07:00', '', 'il-tartufato-logo', '', 'inherit', 'open', 'closed', '', 'il-tartufato-logo', '', '', '2026-03-28 10:07:00', '2026-03-28 09:07:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/il-tartufato-logo.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 4. Attachment: Immagini categorie - IDs 40-41
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(40, 1, '2026-03-28 10:08:00', '2026-03-28 09:08:00', '', 'categoria-classici-cover', '', 'inherit', 'open', 'closed', '', 'categoria-classici-cover', '', '', '2026-03-28 10:08:00', '2026-03-28 09:08:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/categoria-classici-cover.png', 0, 'attachment', 'image/png', 0),
(41, 1, '2026-03-28 10:09:00', '2026-03-28 09:09:00', '', 'categoria-speciali-cover', '', 'inherit', 'open', 'closed', '', 'categoria-speciali-cover', '', '', '2026-03-28 10:09:00', '2026-03-28 09:09:00', '', 0, 'http://localhost:8080/wp-content/uploads/2026/03/categoria-speciali-cover.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 5. Metadati attachment (file path + metadata immagine)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
-- Immagini panini senza sfondo
(242, 32, '_wp_attached_file', '2026/03/la-mortadella-panino-nobg.png'),
(243, 32, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:39:\"2026/03/la-mortadella-panino-nobg.png\";s:8:\"filesize\";i:185420;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:39:\"la-mortadella-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:42150;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:39:\"la-mortadella-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:15230;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(244, 33, '_wp_attached_file', '2026/03/il-bolognese-panino-nobg.png'),
(245, 33, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:38:\"2026/03/il-bolognese-panino-nobg.png\";s:8:\"filesize\";i:192340;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"il-bolognese-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:45620;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"il-bolognese-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:16780;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(246, 34, '_wp_attached_file', '2026/03/lo-sfizioso-panino-nobg.png'),
(247, 34, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:37:\"2026/03/lo-sfizioso-panino-nobg.png\";s:8:\"filesize\";i:178950;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:37:\"lo-sfizioso-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:39870;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:37:\"lo-sfizioso-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:14520;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(248, 35, '_wp_attached_file', '2026/03/il-tartufato-panino-nobg.png'),
(249, 35, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:38:\"2026/03/il-tartufato-panino-nobg.png\";s:8:\"filesize\";i:201780;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"il-tartufato-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:48230;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"il-tartufato-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:17640;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),

-- Logo panini
(250, 36, '_wp_attached_file', '2026/03/la-mortadella-logo.png'),
(251, 36, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:31:\"2026/03/la-mortadella-logo.png\";s:8:\"filesize\";i:32450;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:31:\"la-mortadella-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:18720;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:31:\"la-mortadella-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:9830;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(252, 37, '_wp_attached_file', '2026/03/il-bolognese-logo.png'),
(253, 37, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:30:\"2026/03/il-bolognese-logo.png\";s:8:\"filesize\";i:29870;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:30:\"il-bolognese-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:17340;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:30:\"il-bolognese-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:8920;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(254, 38, '_wp_attached_file', '2026/03/lo-sfizioso-logo.png'),
(255, 38, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:29:\"2026/03/lo-sfizioso-logo.png\";s:8:\"filesize\";i:27640;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:29:\"lo-sfizioso-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:16280;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:29:\"lo-sfizioso-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:8450;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(256, 39, '_wp_attached_file', '2026/03/il-tartufato-logo.png'),
(257, 39, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:30:\"2026/03/il-tartufato-logo.png\";s:8:\"filesize\";i:31250;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:30:\"il-tartufato-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:18100;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:30:\"il-tartufato-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:9240;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),

-- Immagini categorie
(258, 40, '_wp_attached_file', '2026/03/categoria-classici-cover.png'),
(259, 40, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:600;s:6:\"height\";i:400;s:4:\"file\";s:38:\"2026/03/categoria-classici-cover.png\";s:8:\"filesize\";i:95430;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"categoria-classici-cover-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:28650;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"categoria-classici-cover-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:12340;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(260, 41, '_wp_attached_file', '2026/03/categoria-speciali-cover.png'),
(261, 41, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:600;s:6:\"height\";i:400;s:4:\"file\";s:38:\"2026/03/categoria-speciali-cover.png\";s:8:\"filesize\";i:102870;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"categoria-speciali-cover-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:31420;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"categoria-speciali-cover-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:13870;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}');

-- ---------------------------------------------------------------------------
-- 6. Post Panini - IDs 42-45
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(42, 1, '2026-03-28 10:10:00', '2026-03-28 09:10:00', '<!-- wp:paragraph -->\n<p>Il nostro panino iconico: generose fette di mortadella Bologna IGP adagiate su pane fragrante, con squacquerone di Romagna DOP e un letto di rucola fresca. Il gusto autentico dell\'Emilia-Romagna in un solo morso.</p>\n<!-- /wp:paragraph -->', 'La Mortadella', 'Mortadella Bologna IGP, squacquerone di Romagna DOP, rucola fresca', 'publish', 'closed', 'closed', '', 'la-mortadella', '', '', '2026-03-28 10:10:00', '2026-03-28 09:10:00', '', 0, 'http://localhost:8080/?post_type=panino&#038;p=42', 0, 'panino', '', 0),
(43, 1, '2026-03-28 10:11:00', '2026-03-28 09:11:00', '<!-- wp:paragraph -->\n<p>Un omaggio alla cucina bolognese: ragu preparato secondo la ricetta tradizionale depositata alla Camera di Commercio di Bologna, con scaglie di Parmigiano Reggiano 24 mesi e basilico fresco. Il sapore di Bologna racchiuso nel pane.</p>\n<!-- /wp:paragraph -->', 'Il Bolognese', 'Ragu alla bolognese, Parmigiano Reggiano 24 mesi, basilico fresco', 'publish', 'closed', 'closed', '', 'il-bolognese', '', '', '2026-03-28 10:11:00', '2026-03-28 09:11:00', '', 0, 'http://localhost:8080/?post_type=panino&#038;p=43', 0, 'panino', '', 0),
(44, 1, '2026-03-28 10:12:00', '2026-03-28 09:12:00', '<!-- wp:paragraph -->\n<p>Per chi cerca qualcosa in piu: porchetta artigianale cotta a legna, crema di carciofi romani e provola affumicata dei Monti Lattari. Un equilibrio perfetto tra sapidita e delicatezza.</p>\n<!-- /wp:paragraph -->', 'Lo Sfizioso', 'Porchetta artigianale, crema di carciofi, provola affumicata', 'publish', 'closed', 'closed', '', 'lo-sfizioso', '', '', '2026-03-28 10:12:00', '2026-03-28 09:12:00', '', 0, 'http://localhost:8080/?post_type=panino&#038;p=44', 0, 'panino', '', 0),
(45, 1, '2026-03-28 10:13:00', '2026-03-28 09:13:00', '<!-- wp:paragraph -->\n<p>La nostra proposta gourmet: bresaola della Valtellina IGP, crema di tartufo nero estivo, rucola selvatica e scaglie di Parmigiano Reggiano 36 mesi. Un panino raffinato per palati esigenti.</p>\n<!-- /wp:paragraph -->', 'Il Tartufato', 'Bresaola della Valtellina IGP, crema di tartufo nero, rucola selvatica, Parmigiano Reggiano 36 mesi', 'publish', 'closed', 'closed', '', 'il-tartufato', '', '', '2026-03-28 10:13:00', '2026-03-28 09:13:00', '', 0, 'http://localhost:8080/?post_type=panino&#038;p=45', 0, 'panino', '', 0);

-- ---------------------------------------------------------------------------
-- 7. Postmeta ACF per i panini
-- ---------------------------------------------------------------------------

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
-- La Mortadella (post 42)
(262, 42, 'immagine_panino_senza_sfondo', '32'),
(263, 42, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(264, 42, 'logo_panino', '36'),
(265, 42, '_logo_panino', 'field_panino_logo'),
(266, 42, 'posizione_label_nome', 'bottom-left'),
(267, 42, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Il Bolognese (post 43)
(268, 43, 'immagine_panino_senza_sfondo', '33'),
(269, 43, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(270, 43, 'logo_panino', '37'),
(271, 43, '_logo_panino', 'field_panino_logo'),
(272, 43, 'posizione_label_nome', 'bottom-right'),
(273, 43, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Lo Sfizioso (post 44)
(274, 44, 'immagine_panino_senza_sfondo', '34'),
(275, 44, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(276, 44, 'logo_panino', '38'),
(277, 44, '_logo_panino', 'field_panino_logo'),
(278, 44, 'posizione_label_nome', 'top-right'),
(279, 44, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Il Tartufato (post 45)
(280, 45, 'immagine_panino_senza_sfondo', '35'),
(281, 45, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(282, 45, 'logo_panino', '39'),
(283, 45, '_logo_panino', 'field_panino_logo'),
(284, 45, 'posizione_label_nome', 'top-left'),
(285, 45, '_posizione_label_nome', 'field_panino_posizione_label_nome');

-- ---------------------------------------------------------------------------
-- 8. Relazioni panini <-> categorie
-- ---------------------------------------------------------------------------

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(42, 4, 0),  -- La Mortadella -> Classici
(43, 4, 0),  -- Il Bolognese  -> Classici
(44, 5, 0),  -- Lo Sfizioso   -> Speciali
(45, 5, 0);  -- Il Tartufato  -> Speciali
