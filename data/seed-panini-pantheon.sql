-- =============================================================================
-- Seed Pantheon Dev: 4 Panini con categorie, immagini e metadati ACF
-- Basato su max IDs: posts=32, postmeta=257, terms=4, term_taxonomy=4, termmeta=8
-- =============================================================================

-- ---------------------------------------------------------------------------
-- 1. Categorie Panino: Classici e Speciali
-- ---------------------------------------------------------------------------

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(5, 'Classici', 'classici', 0),
(6, 'Speciali', 'speciali', 0);

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(5, 5, 'categoria_panino', 'I grandi classici della tradizione bolognese', 0, 2),
(6, 6, 'categoria_panino', 'Le nostre creazioni speciali e ricercate', 0, 2);

INSERT INTO `wp_termmeta` (`meta_id`, `term_id`, `meta_key`, `meta_value`) VALUES
(9, 5, 'colore_categoria', '#C8102E'),
(10, 5, '_colore_categoria', 'field_categoria_panino_colore'),
(11, 5, 'immagine_categoria', '43'),
(12, 5, '_immagine_categoria', 'field_categoria_panino_immagine'),
(13, 6, 'colore_categoria', '#D4A017'),
(14, 6, '_colore_categoria', 'field_categoria_panino_colore'),
(15, 6, 'immagine_categoria', '44'),
(16, 6, '_immagine_categoria', 'field_categoria_panino_immagine');

-- ---------------------------------------------------------------------------
-- 2. Attachment: Immagini panini senza sfondo (IDs 33-36)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(33, 1, '2026-03-28 10:00:00', '2026-03-28 09:00:00', '', 'la-mortadella-panino-nobg', '', 'inherit', 'open', 'closed', '', 'la-mortadella-panino-nobg', '', '', '2026-03-28 10:00:00', '2026-03-28 09:00:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/la-mortadella-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(34, 1, '2026-03-28 10:01:00', '2026-03-28 09:01:00', '', 'il-bolognese-panino-nobg', '', 'inherit', 'open', 'closed', '', 'il-bolognese-panino-nobg', '', '', '2026-03-28 10:01:00', '2026-03-28 09:01:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/il-bolognese-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(35, 1, '2026-03-28 10:02:00', '2026-03-28 09:02:00', '', 'lo-sfizioso-panino-nobg', '', 'inherit', 'open', 'closed', '', 'lo-sfizioso-panino-nobg', '', '', '2026-03-28 10:02:00', '2026-03-28 09:02:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/lo-sfizioso-panino-nobg.png', 0, 'attachment', 'image/png', 0),
(36, 1, '2026-03-28 10:03:00', '2026-03-28 09:03:00', '', 'il-tartufato-panino-nobg', '', 'inherit', 'open', 'closed', '', 'il-tartufato-panino-nobg', '', '', '2026-03-28 10:03:00', '2026-03-28 09:03:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/il-tartufato-panino-nobg.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 3. Attachment: Logo panini (IDs 37-40)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(37, 1, '2026-03-28 10:04:00', '2026-03-28 09:04:00', '', 'la-mortadella-logo', '', 'inherit', 'open', 'closed', '', 'la-mortadella-logo', '', '', '2026-03-28 10:04:00', '2026-03-28 09:04:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/la-mortadella-logo.png', 0, 'attachment', 'image/png', 0),
(38, 1, '2026-03-28 10:05:00', '2026-03-28 09:05:00', '', 'il-bolognese-logo', '', 'inherit', 'open', 'closed', '', 'il-bolognese-logo', '', '', '2026-03-28 10:05:00', '2026-03-28 09:05:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/il-bolognese-logo.png', 0, 'attachment', 'image/png', 0),
(39, 1, '2026-03-28 10:06:00', '2026-03-28 09:06:00', '', 'lo-sfizioso-logo', '', 'inherit', 'open', 'closed', '', 'lo-sfizioso-logo', '', '', '2026-03-28 10:06:00', '2026-03-28 09:06:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/lo-sfizioso-logo.png', 0, 'attachment', 'image/png', 0),
(40, 1, '2026-03-28 10:07:00', '2026-03-28 09:07:00', '', 'il-tartufato-logo', '', 'inherit', 'open', 'closed', '', 'il-tartufato-logo', '', '', '2026-03-28 10:07:00', '2026-03-28 09:07:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/il-tartufato-logo.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 4. Attachment: Immagini categorie (IDs 41-42) -- NOTA: non usate se non servono
-- ---------------------------------------------------------------------------

-- ---------------------------------------------------------------------------
-- 5. Attachment: Immagini categorie (IDs 43-44)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(43, 1, '2026-03-28 10:08:00', '2026-03-28 09:08:00', '', 'categoria-classici-cover', '', 'inherit', 'open', 'closed', '', 'categoria-classici-cover', '', '', '2026-03-28 10:08:00', '2026-03-28 09:08:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/categoria-classici-cover.png', 0, 'attachment', 'image/png', 0),
(44, 1, '2026-03-28 10:09:00', '2026-03-28 09:09:00', '', 'categoria-speciali-cover', '', 'inherit', 'open', 'closed', '', 'categoria-speciali-cover', '', '', '2026-03-28 10:09:00', '2026-03-28 09:09:00', '', 0, 'http://dev-il-panino.pantheonsite.io/wp-content/uploads/2026/03/categoria-speciali-cover.png', 0, 'attachment', 'image/png', 0);

-- ---------------------------------------------------------------------------
-- 6. Metadati attachment (file path + metadata)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(258, 33, '_wp_attached_file', '2026/03/la-mortadella-panino-nobg.png'),
(259, 33, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:39:\"2026/03/la-mortadella-panino-nobg.png\";s:8:\"filesize\";i:185420;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:39:\"la-mortadella-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:42150;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:39:\"la-mortadella-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:15230;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(260, 34, '_wp_attached_file', '2026/03/il-bolognese-panino-nobg.png'),
(261, 34, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:38:\"2026/03/il-bolognese-panino-nobg.png\";s:8:\"filesize\";i:192340;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"il-bolognese-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:45620;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"il-bolognese-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:16780;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(262, 35, '_wp_attached_file', '2026/03/lo-sfizioso-panino-nobg.png'),
(263, 35, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:37:\"2026/03/lo-sfizioso-panino-nobg.png\";s:8:\"filesize\";i:178950;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:37:\"lo-sfizioso-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:39870;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:37:\"lo-sfizioso-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:14520;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(264, 36, '_wp_attached_file', '2026/03/il-tartufato-panino-nobg.png'),
(265, 36, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:800;s:6:\"height\";i:800;s:4:\"file\";s:38:\"2026/03/il-tartufato-panino-nobg.png\";s:8:\"filesize\";i:201780;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"il-tartufato-panino-nobg-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:48230;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"il-tartufato-panino-nobg-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:17640;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(266, 37, '_wp_attached_file', '2026/03/la-mortadella-logo.png'),
(267, 37, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:31:\"2026/03/la-mortadella-logo.png\";s:8:\"filesize\";i:32450;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:31:\"la-mortadella-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:18720;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:31:\"la-mortadella-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:9830;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(268, 38, '_wp_attached_file', '2026/03/il-bolognese-logo.png'),
(269, 38, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:30:\"2026/03/il-bolognese-logo.png\";s:8:\"filesize\";i:29870;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:30:\"il-bolognese-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:17340;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:30:\"il-bolognese-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:8920;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(270, 39, '_wp_attached_file', '2026/03/lo-sfizioso-logo.png'),
(271, 39, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:29:\"2026/03/lo-sfizioso-logo.png\";s:8:\"filesize\";i:27640;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:29:\"lo-sfizioso-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:16280;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:29:\"lo-sfizioso-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:8450;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(272, 40, '_wp_attached_file', '2026/03/il-tartufato-logo.png'),
(273, 40, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:400;s:6:\"height\";i:200;s:4:\"file\";s:30:\"2026/03/il-tartufato-logo.png\";s:8:\"filesize\";i:31250;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:30:\"il-tartufato-logo-300x150.png\";s:5:\"width\";i:300;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:18100;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:30:\"il-tartufato-logo-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:9240;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(274, 43, '_wp_attached_file', '2026/03/categoria-classici-cover.png'),
(275, 43, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:600;s:6:\"height\";i:400;s:4:\"file\";s:38:\"2026/03/categoria-classici-cover.png\";s:8:\"filesize\";i:95430;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"categoria-classici-cover-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:28650;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"categoria-classici-cover-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:12340;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(276, 44, '_wp_attached_file', '2026/03/categoria-speciali-cover.png'),
(277, 44, '_wp_attachment_metadata', 'a:6:{s:5:\"width\";i:600;s:6:\"height\";i:400;s:4:\"file\";s:38:\"2026/03/categoria-speciali-cover.png\";s:8:\"filesize\";i:102870;s:5:\"sizes\";a:2:{s:6:\"medium\";a:5:{s:4:\"file\";s:38:\"categoria-speciali-cover-300x200.png\";s:5:\"width\";i:300;s:6:\"height\";i:200;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:31420;}s:9:\"thumbnail\";a:5:{s:4:\"file\";s:38:\"categoria-speciali-cover-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";s:8:\"filesize\";i:13870;}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}');

-- ---------------------------------------------------------------------------
-- 7. Post Panini (IDs 45-48)
-- ---------------------------------------------------------------------------

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(45, 1, '2026-03-28 10:10:00', '2026-03-28 09:10:00', '<!-- wp:paragraph -->\n<p>Il nostro panino iconico: generose fette di mortadella Bologna IGP adagiate su pane fragrante, con squacquerone di Romagna DOP e un letto di rucola fresca. Il gusto autentico dell\'Emilia-Romagna in un solo morso.</p>\n<!-- /wp:paragraph -->', 'La Mortadella', 'Mortadella Bologna IGP, squacquerone di Romagna DOP, rucola fresca', 'publish', 'closed', 'closed', '', 'la-mortadella', '', '', '2026-03-28 10:10:00', '2026-03-28 09:10:00', '', 0, 'http://dev-il-panino.pantheonsite.io/?post_type=panino&#038;p=45', 0, 'panino', '', 0),
(46, 1, '2026-03-28 10:11:00', '2026-03-28 09:11:00', '<!-- wp:paragraph -->\n<p>Un omaggio alla cucina bolognese: ragu preparato secondo la ricetta tradizionale depositata alla Camera di Commercio di Bologna, con scaglie di Parmigiano Reggiano 24 mesi e basilico fresco. Il sapore di Bologna racchiuso nel pane.</p>\n<!-- /wp:paragraph -->', 'Il Bolognese', 'Ragu alla bolognese, Parmigiano Reggiano 24 mesi, basilico fresco', 'publish', 'closed', 'closed', '', 'il-bolognese', '', '', '2026-03-28 10:11:00', '2026-03-28 09:11:00', '', 0, 'http://dev-il-panino.pantheonsite.io/?post_type=panino&#038;p=46', 0, 'panino', '', 0),
(47, 1, '2026-03-28 10:12:00', '2026-03-28 09:12:00', '<!-- wp:paragraph -->\n<p>Per chi cerca qualcosa in piu: porchetta artigianale cotta a legna, crema di carciofi romani e provola affumicata dei Monti Lattari. Un equilibrio perfetto tra sapidita e delicatezza.</p>\n<!-- /wp:paragraph -->', 'Lo Sfizioso', 'Porchetta artigianale, crema di carciofi, provola affumicata', 'publish', 'closed', 'closed', '', 'lo-sfizioso', '', '', '2026-03-28 10:12:00', '2026-03-28 09:12:00', '', 0, 'http://dev-il-panino.pantheonsite.io/?post_type=panino&#038;p=47', 0, 'panino', '', 0),
(48, 1, '2026-03-28 10:13:00', '2026-03-28 09:13:00', '<!-- wp:paragraph -->\n<p>La nostra proposta gourmet: bresaola della Valtellina IGP, crema di tartufo nero estivo, rucola selvatica e scaglie di Parmigiano Reggiano 36 mesi. Un panino raffinato per palati esigenti.</p>\n<!-- /wp:paragraph -->', 'Il Tartufato', 'Bresaola della Valtellina IGP, crema di tartufo nero, rucola selvatica, Parmigiano Reggiano 36 mesi', 'publish', 'closed', 'closed', '', 'il-tartufato', '', '', '2026-03-28 10:13:00', '2026-03-28 09:13:00', '', 0, 'http://dev-il-panino.pantheonsite.io/?post_type=panino&#038;p=48', 0, 'panino', '', 0);

-- ---------------------------------------------------------------------------
-- 8. Postmeta ACF per i panini
-- ---------------------------------------------------------------------------

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
-- La Mortadella (post 45)
(278, 45, 'immagine_panino_senza_sfondo', '33'),
(279, 45, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(280, 45, 'logo_panino', '37'),
(281, 45, '_logo_panino', 'field_panino_logo'),
(282, 45, 'posizione_label_nome', 'bottom-left'),
(283, 45, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Il Bolognese (post 46)
(284, 46, 'immagine_panino_senza_sfondo', '34'),
(285, 46, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(286, 46, 'logo_panino', '38'),
(287, 46, '_logo_panino', 'field_panino_logo'),
(288, 46, 'posizione_label_nome', 'bottom-right'),
(289, 46, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Lo Sfizioso (post 47)
(290, 47, 'immagine_panino_senza_sfondo', '35'),
(291, 47, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(292, 47, 'logo_panino', '39'),
(293, 47, '_logo_panino', 'field_panino_logo'),
(294, 47, 'posizione_label_nome', 'top-right'),
(295, 47, '_posizione_label_nome', 'field_panino_posizione_label_nome'),

-- Il Tartufato (post 48)
(296, 48, 'immagine_panino_senza_sfondo', '36'),
(297, 48, '_immagine_panino_senza_sfondo', 'field_panino_immagine_senza_sfondo'),
(298, 48, 'logo_panino', '40'),
(299, 48, '_logo_panino', 'field_panino_logo'),
(300, 48, 'posizione_label_nome', 'top-left'),
(301, 48, '_posizione_label_nome', 'field_panino_posizione_label_nome');

-- ---------------------------------------------------------------------------
-- 9. Relazioni panini <-> categorie
-- ---------------------------------------------------------------------------

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(45, 5, 0),
(46, 5, 0),
(47, 6, 0),
(48, 6, 0);
