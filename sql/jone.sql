-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 12 2015 г., 16:36
-- Версия сервера: 5.5.35-log
-- Версия PHP: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `jone`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `tbl_comment`
--

INSERT INTO `tbl_comment` (`id`, `content`, `status`, `create_time`, `author`, `email`, `url`, `post_id`) VALUES
(1, 'Комментирую', 2, 1399001369, 'zopasti', 'hfh@hf.ru', '', 28),
(2, 'комментарии', 2, 1399003773, 'bard', 'bvc@gh.pk', '', 27),
(3, 'Новый коммент', 2, 1399010579, 'Федя', 'gfgfg@kj.ru', '', 15),
(4, 'Оставляю комментарий', 2, 1399012284, 'Дыня', 'tytty@iu.ru', '', 27),
(5, 'снова коммент', 2, 1399346831, 'Автор', 'tti@oi.ru', 'http://www.ru.ru', 14);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_lookup`
--

CREATE TABLE IF NOT EXISTS `tbl_lookup` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` int(16) NOT NULL,
  `type` varchar(255) NOT NULL,
  `position` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `tbl_lookup`
--

INSERT INTO `tbl_lookup` (`id`, `name`, `code`, `type`, `position`) VALUES
(1, 'Черновик', 1, 'PostStatus', 1),
(2, 'Опубликовано', 2, 'PostStatus', 2),
(3, 'Архив', 3, 'PostStatus', 3),
(4, 'Pending Approval', 1, 'CommentStatus', 1),
(5, 'Approved', 2, 'CommentStatus', 2),
(6, '+6', 1, 'AdultCens', 1),
(7, '+12', 2, 'AdultCens', 2),
(8, '+18', 3, 'AdultCens', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_post`
--

CREATE TABLE IF NOT EXISTS `tbl_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `like` int(11) NOT NULL,
  `adult` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `click` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `tbl_post`
--

INSERT INTO `tbl_post` (`id`, `title`, `content`, `tags`, `status`, `create_time`, `update_time`, `author_id`, `like`, `adult`, `source`, `click`) VALUES
(14, 'Высказывание проигравшего тренера', 'Проще купить судью, чем 11 нормальных футболистов...', 'судья, футболист', 2, 1398252999, 1403512279, 1, 48, '+6', '', 1),
(15, 'Из дневника юнги', 'Смотри в оба! - сказал капитан, выдав пару биноклей...', 'капитан, юнга, бинокль', 2, 1398414102, 1403487800, 7, 28, '+6', '', 0),
(16, 'Заявление', 'Прошу поощрения! ', 'поощрение', 2, 1398415788, 1403488028, 1, 0, '+6', '', 1),
(17, 'Удивительное рядом ходит', 'Какой-то жуткий симбиоз спортсмена и алкоголика, примерного семьянина и бабника...', 'алкоголик, спортсмен, семьянин, бабник', 1, 1398416306, 1399366387, 1, 1, '+6', '', 0),
(18, 'Добрый человек', ' 16 августа 1933 года — Лидер немецких нацистов Герман Геринг запретил в Пруссии вивисекцию (операции на живых животных)', 'нацист, вивисекция, добрый', 2, 1398417085, 1403487747, 1, 12, '+18', 'Википедия', 0),
(19, 'Референдум не нужен', '19 августа 1687 года В Березове Олонецкого уезда России более тысячи человек сожгли себя в знак протеста против перехода на трёхперстное крещение', 'референдум, трёхперстное крещение, самоубийство', 1, 1398418162, 1399369859, 1, 8, '+6', '', 0),
(20, 'Восточная глупость', 'Если гора не идёт к Магомеду, значит это не гора, а его ленивый слон...', 'Магомед, гора, слон', 2, 1398481147, 1399378743, 1, 2, '+6', '', 0),
(21, 'Не растерялся', '- Чтож ты растерялся?<br/>\r\n- Я не раз терялся, но каждый раз родители находили меня в капусте...\r\n', 'Находить в капусте, растеряться', 2, 1398481850, 1399371555, 8, 5, '+6', '', 0),
(25, 'Чем думать?', 'Как правило безбашенность приводит к тому, что ты и действительно оказываешься с головой в разных кустах.', 'безбашенность', 2, 1398483952, 1403488030, 1, 36, '+12', '', 1),
(26, 'Тактика бравирующих трусов', 'Грязный танк в бою не видно - лишь огромный холм говна...', 'танк, гора, бой, война', 2, 1398662031, 1403488033, 1, 6, '+18', '', 1),
(27, 'Живот, но вот...', 'Стоит буржуй на перекрестке <br />\r\n И в воротник упрятал нос<br />\r\n А рядом жмется шерстью жесткой <br />\r\n Поджавший хвост паршивый пес.', 'буржуй, пёс, собака', 2, 1398756022, 1403488032, 1, 3, '+6', 'Александр Блок - "Двенадцать"', 1),
(28, 'Кафе "Угарика"', '- Не видели Виталька, мужики?<br />\r\n - Да он пошёл на шашлыки... <br />\r\nТы не смотри в кастрюли наши <br />\r\nА то за ним пойдёшь туда же<br />\r\n', 'шашлык, повар, кафе', 2, 1398760919, 1399282035, 1, 5, '+6', 'Бард, который перевернул ЗИЛ - "Как я это делал"', 0),
(29, 'После выступления нахального клоуна зрители попросили вернуть деньги', 'Падал на публику <br />\r\nЗа дырку от бублика', 'комик, дырка от бублика', 2, 1398764251, 1399370555, 1, 4, '+12', '', 0),
(30, 'Большое лицо', 'Я тогда принялся соображать и обмозговал дельцо одно, да такое, что надо за решением к большому лицу идти. А он человек внове, да, говорят, злой-презлой, ежели насчёт взятки заикнёшся – прямо в зубы бокс!', 'взятка, злой, бокс', 2, 1398764985, 1403529002, 1, 4, '+12', 'Вячеслав Шишков – «Сужет»', 1),
(31, 'Вавантюрились', 'После рептилий одна линия животных развивалась, усовершенствуя прежний тип, и дошла до птиц, а другая — более «авантюрная» - приобрела новую кору и дошла до млекопитающих.Таким образом, с чисто филогенетической точки зрения птицы воплощают в себе логическое завершение традиционного развития мозга, а млекопитающие представляют собой отклонение, поскольку они не имеют в своей родословной птиц.', 'птицы. млекопитающие', 1, 1399347808, 1399347808, 1, 0, '+6', 'http://www.bababaobaba.ru', 0),
(32, 'Силовое решение', 'Проблеммы все свои решил Бик <br />\r\nЗа несколько мнгновений я    <br />\r\nВ руке синицу задушил     <br />\r\nИ сбил ей в небе журавля...  <br />', '', 1, 1399438125, 1399438125, 1, 0, '+6', 'Бард, который перевернул ЗИЛ - "Как я это делал"', 0),
(33, 'Машина', '<p>\r\n	llll<img alt="" /><img alt="машина" height="200" src="/upload/userfiles/images/e1fc53e56d031613cdfca9a7837ceffe.jpg" width="300" /> Машина</p>\r\n', 'машина', 2, 1399719231, 1411999190, 1, 0, '+6', '', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo'),
(6, 'Фамилий такой', 'Бард, который перевернул ЗИЛ'),
(7, 'Беляшов', 'Бард, который перевернул ЗИЛ'),
(8, 'Шиша', 'Миша'),
(9, 'Пупкин', 'Федя'),
(10, 'Ластов', 'Пор'),
(11, 'Xtg', 'Hjg');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_segtemp`
--

CREATE TABLE IF NOT EXISTS `tbl_segtemp` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `g2013` varchar(255) NOT NULL,
  `g2000` varchar(255) NOT NULL,
  `g2001` varchar(255) NOT NULL,
  `g2002` varchar(255) NOT NULL,
  `g2003` varchar(255) NOT NULL,
  `g2004` varchar(255) NOT NULL,
  `g2005` varchar(255) NOT NULL,
  `g2006` varchar(255) NOT NULL,
  `g2007` varchar(255) NOT NULL,
  `g2008` varchar(255) NOT NULL,
  `g2009` varchar(255) NOT NULL,
  `g2010` varchar(255) NOT NULL,
  `g2011` varchar(255) NOT NULL,
  `g2012` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=23 ;

--
-- Дамп данных таблицы `tbl_segtemp`
--

INSERT INTO `tbl_segtemp` (`id`, `date`, `g2013`, `g2000`, `g2001`, `g2002`, `g2003`, `g2004`, `g2005`, `g2006`, `g2007`, `g2008`, `g2009`, `g2010`, `g2011`, `g2012`) VALUES
(1, '2014-04-02', '-6 +8', '-5 +5', '-2 +1', '0 +2', '-4 +3', '+4 +6', '-6 -4', '-10 -1', '+4 +16', '-2 +9', '0 +10', '-1 +5', '+3 +6', '+2 +10'),
(2, '2014-04-03', '-6 +8', '-5 +5', '-2 +1', '0 +2', '-4 +3', '+4 +6', '-6 -4', '-10 -1', '+4 +16', '-2 +9', '0 +10', '-1 +5', '+3 +6', '+2 +10'),
(3, '2014-04-04', '-5 +5', '-2 +5', '+2', '-8 -15', '0 +2', '-3 +4', '0 -8', '0 -4', '-3 +4', '+1 +8', '+5 +13', '-1 -7', '-4 +6', '+3 +15'),
(4, '2014-04-05', '-1 +8', '+5', '0 +2', '-8 -5', '-2 +5', '-1 +10', '-4 +1', '-10 -5', '+1 +10', '-5 +3', '+2 +13', '+1 +5', '-1 +6', '+3 +15'),
(5, '2014-04-06', '-5 +8', '-5 +5', '0 +2', '-8 -2', '-2 +6', '+3 +5', '-7 -3', '-10 -4', '-1 +12', '-10 -4', '0 +13', '-8 +5', '-1 +5', '-5 +8'),
(6, '2014-04-07', '-5 +10', '-5 -3', '-10 -6', '-3 +3', '-1 +7', '0 +5', '-9 -3', '-11 -6', '-4 +10', '-10 0', '-1 +5', '-13 +5', '+2 +5', '+3 +10'),
(7, '2014-04-08', '+2 +15', '+3 +8', '-8 -2', '-6 +6', '-1 +7', '+1 +5', '+1 +2', '-5 -1', '+4 +9', '-2    0', '-2 +9', '-10 +2', '+2 +13', '+3 +15'),
(8, '2014-04-09', '+2 +15', '+3 +8', '-8 -2', '-6 +6', '-1 +7', '+1 +5', '+1 +2', '-5 -1', '+4 +9', '-2    0', '-2 +9', '-10 +2', '+2 +13', '+3 +15'),
(9, '2014-04-10', '+2 +15', '+3 +8', '-8 -2', '-6 +6', '-1 +7', '+1 +5', '+1 +2', '-5 -1', '+4 +9', '-2    0', '-2 +9', '-10 +2', '+2 +13', '+3 +15'),
(10, '2014-04-11', '+2 +15', '-1 +10', '0 +5', '+3 +10', '+2 +5', '-7 +1', '-4', '-13 -2', '+5 +15', '-7  +5', '-4 +5', '-10 +5', '+6 +17', '+2 +18'),
(11, '2014-04-12', '+2 +15', '+10', '-1 +15', '-10 +3', '+3 +8', '-1 +4', '0 +9', '-15 -1', '0 +9', '+7 +13', '0 +9', '-1 +15', '+8 +20', '+2 +15'),
(12, '2014-04-13', '+2 +15', '+10', '-1 +15', '-10 +3', '+3 +8', '-1 +4', '0 +9', '-15 -1', '0 +9', '+7 +13', '0 +9', '-1 +15', '+8 +20', '+2 +15'),
(13, '2014-04-14', '-1 +18', '+5 +15', '+7 +15', '-1 +3 ', '-15 -9', '+2 +4', '+6 +8', '-5 +5', '+5 +12', '+9 +15', '0  +10', '-2 +13', '+9 +18', '-1 +18'),
(14, '2014-04-15', '-3 +15', '+5 +15', '+5 +12', '-2 +8', '-7 -2', '+4 +7', '+1 +3', '-1 +6', '+5 +12', '-1 +5', '-1 +8', '0  +16', '+6 +20', '+4 +17'),
(15, '2014-04-16', '-5 +13', '+5 +15', '0  +2', '-1 +8', '-7 -2', '-2  0', '+3 +5', '-1 +6', '+5 +12', '-5 +1', '0 +12', '+2 +6', '+9 +25', '+5 +17'),
(16, '2014-04-17', '0  +17', '+5 +15', '-4 +4', '+1 +10', '-7 +4', '-5 +5', '+3 +5', '+2 ', '+8 +12', '-7 -3', '+3 +11', '0  +10', '+8  +15', '+5 +18'),
(17, '2014-04-18', '-1 +6', '+5 +10', '-2 +12', '+2 +5', '-4 +6', '-8 +6', '-1 +9', '+6 +8', '+2 +7', '-10 -3', '+5 +15', '+1 +12', '+5 +17', '+1 +16'),
(18, '2014-04-19', '-1 +15', '+10 +15', '-2 +15', '-5 +2', '0  +8', '0  +6', '+5 +12', '+2 ', '+3 +12', '-6 +6', '-1 +5', '+3 +13', '+6 +20', '+2 +20'),
(19, '2014-04-20', '0  +15', '+3 +16', '+5 +15', '-2 +5', '+2 +5', '-1 +8', '+4 +15', '-5 +5', '+1 +12', '+1 +10', '-3 +12', '+5 +17', '+11 +21', '+8 +20'),
(20, '2014-04-21', '-2 +12', '+10', '+2 +15', '-2 +10', '+2 +5', '+3', '+7 +13', '+2 +10', '+5 +15', '+3 +18', '0 +16', '+6 19', '+8 +22', '-1 +12'),
(21, '2014-04-22', '+5 +20', '+12', '+9 +15', '-2 +10', '+3 +7', '0  +3', '+4 +18', '+5 +12', '+8 +20', '+5 +19', '+5 +17', '+5 +15', '+13 +25', '-1 +15'),
(22, '2014-04-23', '+7 +22', '+12', '+5 +17', '+2 +13', '-2 +2', '-3 +3', '+18 +24', '+5 +7', '+10 +18', '+10 +22', '+1 +15', '+4 +17', '+8 +13', '-5 +15');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_tag`
--

CREATE TABLE IF NOT EXISTS `tbl_tag` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `frequency` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `tbl_tag`
--

INSERT INTO `tbl_tag` (`id`, `name`, `frequency`) VALUES
(9, 'капитан', 1),
(10, 'юнга', 1),
(11, 'бинокль', 1),
(12, 'поощрение', 1),
(13, 'алкоголик', 1),
(14, 'спортсмен', 1),
(15, 'семьянин', 1),
(16, 'бабник', 1),
(17, 'нацист', 1),
(18, 'вивисекция', 1),
(19, 'добрый', 1),
(20, 'референдум', 1),
(21, 'трёхперстное крещение', 1),
(22, 'самоубийство', 1),
(23, 'Магомед', 1),
(24, 'гора', 2),
(25, 'слон', 1),
(26, 'Находить в капусте', 1),
(27, 'растеряться', 1),
(31, 'безбашенность', 1),
(32, 'танк', 1),
(33, 'бой', 1),
(34, 'война', 1),
(35, 'буржуй', 1),
(36, 'пёс', 1),
(37, 'собака', 1),
(38, 'шашлык', 1),
(39, 'повар', 1),
(40, 'кафе', 1),
(41, 'комик', 1),
(42, 'дырка от бублика', 1),
(43, 'взятка', 1),
(44, 'злой', 1),
(45, 'бокс', 1),
(46, 'птицы. млекопитающие', 1),
(47, 'машина', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`) VALUES
(1, 'admin', 'd80cb069cfb958884ce2a867f99bff57', 'webmaster@example.com', 'c764b26fba15c635a982f833a24cbdc0', '2014-04-23 02:33:21', '2014-09-29 10:59:39', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'demo@example.com', '099f825543f7850cc038b90aaff39fac', '2014-04-23 02:33:21', '2014-04-25 09:54:31', 0, 1),
(6, 'bard5', '802cf7f213631e703e5c138e2ed4ea6d', 'bb@jjh.ru', '8694018b3da813debfdd6480208ba3e4', '2014-04-23 06:47:04', '0000-00-00 00:00:00', 0, 1),
(7, 'bard2', '21232f297a57a5a743894a0e4a801fc3', 'hurman@ngs.ru', 'f9f4f0a3507d5802e3c647c88a41c8ab', '2014-04-23 09:45:40', '2014-04-26 00:53:21', 0, 1),
(8, 'misha_el', '064ec5eda2d815e52d13ea001c85e73e', 'uu@yy.ru', '40d780f4d4068fff98ccffa9a626a9ab', '2014-04-26 01:49:49', '2014-05-09 00:36:47', 0, 1),
(9, 'dynia', '35456b7af4312258bdceead2323e6ea4', 'hhhh@rt.ru', '96f31f2016ef36e51010b6f4b212a780', '2014-05-02 06:36:45', '0000-00-00 00:00:00', 0, 1),
(10, 'gett', '65a0732781ddd635a44c1b9b8d1aa3e3', 'uyuuy@iui.ru', 'e9a857c2f91ffa61f976d695a922286d', '2014-05-02 06:44:34', '0000-00-00 00:00:00', 0, 1),
(11, 'add', '44d9dbb60b6c2c24922cd62d249412f9', 'sd@sd.ru', 'd7c5e8adc90b7c610c27357f9493de8d', '2014-08-07 02:44:12', '2014-08-06 23:45:32', 0, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `tbl_post` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD CONSTRAINT `tbl_post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
