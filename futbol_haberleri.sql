-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 15 Eki 2025, 19:24:50
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `futbol_haberleri`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `adminler`
--

CREATE TABLE `adminler` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `adminler`
--

INSERT INTO `adminler` (`id`, `username`, `email`, `password`, `tarih`) VALUES
(1, 'emirhan', 'emirhan41@admin.com', 'emo_55', '2025-10-14 20:50:44'),
(2, 'emir', 'emir41@admin.com', 'emir_41', '2025-10-15 09:34:30'),
(3, 'osman', 'osman28@admin.com', 'osman_28', '2025-10-15 18:22:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gunun_mansetleri`
--

CREATE TABLE `gunun_mansetleri` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `detay` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gunun_mansetleri`
--

INSERT INTO `gunun_mansetleri` (`id`, `baslik`, `aciklama`, `detay`, `resim`, `tarih`) VALUES
(3, 'Beşiktaş 2025 Yaz Transfer Döneminde Kadrosunu Güçlendirdi', '25 Oyuncu ile Yollar Ayrıldı, Yeni Yıldızlar Transfer Edildi  Açıklama:', 'Beşiktaş, 2025 yaz transfer döneminde kadrosunda köklü değişiklikler yaptı. Toplamda 25 oyuncu ile yollarını ayıran siyah-beyazlılar, yeni sezon için önemli takviyeler gerçekleştirdi. Taraftarlar yeni transferlerden oldukça memnun. Takımın teknik direktörü oyuncuların adaptasyon sürecine büyük önem veriyor.', 'assets/img/haber_68ef4b5366268.jpg', '2025-10-14 21:31:42'),
(4, 'Fenerbahçe Göz Kamaştırıyor', 'Fenerbahçe formda oyunuyla dikkat çekiyor.', 'Fenerbahçe, son haftalarda sergilediği etkileyici performansla üst sıralara tırmanıyor. Teknik direktör Okan Buruk oyuncularını motive etmeye devam ediyor. Taraftarlar maçlara yoğun ilgi gösteriyor ve takımın moralini yüksek tutuyor. Özellikle genç oyuncuların performansı göz dolduruyor.', 'assets/img/haber_68ef4bda60148.jpg', '2025-10-14 21:31:42'),
(5, 'Arsenal Avrupa’da', 'Arsenal Şampiyonlar Ligi’nde iddialı.', 'Arsenal, Avrupa kupalarında başarılı bir sezon geçiriyor. Takımın genç yıldızları özellikle dikkat çekiyor ve taraftarları heyecanlandırıyor. Teknik kadro, gençlerin potansiyelini en iyi şekilde kullanıyor ve takımın oyun planı oldukça etkili. Ayrıca son maçlarda defans hattı da büyük bir dayanıklılık gösterdi.', 'assets/img/haber_68ef4c9488502.jpg', '2025-10-14 21:31:42'),
(6, 'Barcelona Yeniden Zirvede', 'Barcelona ligde yükselişe geçti.', 'Barcelona, İspanya La Liga\'da oynadığı son maçlarda önemli puanlar alarak liderlik yarışına geri döndü. Teknik direktör Sergen Yalçın, takımı motive ediyor. Taraftarlar stadyumları dolduruyor ve oyuncuların performansı büyük alkış alıyor. Ayrıca genç yetenekler ilk kez A takımla forma şansı buldu.', 'assets/img/haber_68ef4cd34ee96.jpg', '2025-10-14 21:31:42'),
(7, 'Juventus’un Yeni Hedefi', 'Juventus Serie A’da iddialı.', 'Juventus, Serie A\'da şampiyonluk mücadelesine devam ediyor. Takımın yıldız oyuncuları formda ve yönetim yeni transferlerle güçlenmeyi planlıyor. Taraftarlar kulübün yeni stratejilerini heyecanla takip ediyor. Ayrıca altyapıdan yetişen oyuncular ilk 11’de önemli rol oynuyor.', 'assets/img/haber_68ef4cf34f9ee.png', '2025-10-14 21:31:42'),
(8, 'Sergen Yalçın Röportaj', 'Sergen Yalçın futbol üzerine konuştu.', 'Sergen Yalçın, futbol ve taktikler hakkında detaylı bir röportaj verdi. Genç oyunculara tavsiyelerde bulundu ve gelecek planlarından bahsetti. Ayrıca antrenman metodları ve takım içi motivasyon teknikleri hakkında da bilgiler paylaştı. Taraftarlar bu açıklamaları sosyal medyada büyük ilgiyle karşıladı.', 'assets/img/haber_68ef4cfc1c6db.jpg', '2025-10-14 21:31:42'),
(9, 'Galatasaray\'da Gol Yağmuru', 'Forvetler formda', 'Galatasaray\'ın hücum hattı son maçlarda inanılmaz bir performans sergiliyor. Kerem Aktürkoğlu, Mostafa Mohamed ve diğer oyuncular takımın skor yükünü başarıyla çekiyor. Takımın orta saha oyuncuları da oyunu oldukça iyi yönlendiriyor. Taraftarlar maçlarda coşkuyla takımı desteklemeye devam ediyor.', 'assets/img/haber_68ef4c47a7120.jpg', '2025-10-14 21:31:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gunun_yorumu`
--

CREATE TABLE `gunun_yorumu` (
  `id` int(11) NOT NULL,
  `takim_adi` varchar(255) NOT NULL,
  `baslik` varchar(255) DEFAULT NULL,
  `yorum` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gunun_yorumu`
--

INSERT INTO `gunun_yorumu` (`id`, `takim_adi`, `baslik`, `yorum`, `resim`, `tarih`) VALUES
(1, 'Fenerbahçe', 'Maç Öncesi Yorumu', 'Takım güçlü görünüyor, kazanacaklar.', 'assets/img/yorum_68ef5200360c1.jpg', '2025-10-14 20:41:03'),
(2, 'Galatasaray', 'Maç Sonrası Yorumu', 'Oyun mükemmeldi, üç puanı aldık.', 'assets/img/yorum_68ef520925fa9.png', '2025-10-14 20:41:03'),
(5, 'Arsenal', 'Arsenal Avrupa Liginde Öne Çıkıyor', 'Arsenal, 2025 sezonunda genç oyuncularıyla dikkat çekiyor. Ligde üst sıraları zorlayan takım, yeni transferlerle gücünü artırdı.', 'assets/img/yorum_68ef51c30b194.jpg', '2025-10-14 22:04:53'),
(6, 'Barcelona', 'Barcelona\'da Yeni Dönem', 'Barcelona, 2025 sezonunda genç kadrosu ve teknik ekibiyle yeni bir döneme başlıyor. Taraftarlar heyecanla sezonu bekliyor.', 'assets/img/yorum_68ef51cb6b290.png', '2025-10-14 22:04:53'),
(7, 'Fatih Tekke', 'Fatih Tekke Futbol Dünyasında', 'Eski milli futbolcu ve teknik direktör Fatih Tekke, 2025 sezonunda farklı kulüplerde aktif rol alıyor ve genç yetenekleri yönlendiriyor.', 'assets/img/yorum_68ef51d7bfaae.jpg', '2025-10-14 22:04:53'),
(9, 'Recep Durul', 'Futbol Analisti Recep Durul\'dan Kritik Yorumlar', 'Recep Durul, futbol dünyasındaki gelişmeleri 2025 sezonu özelinde analiz ediyor ve genç oyunculara dair görüşlerini paylaşıyor.', 'assets/img/yorum_68ef51f8cff6f.jpg', '2025-10-14 22:04:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haberler`
--

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `alt_baslik` varchar(255) DEFAULT NULL,
  `icerik` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `haberler`
--

INSERT INTO `haberler` (`id`, `baslik`, `alt_baslik`, `icerik`, `resim`, `tarih`) VALUES
(1, 'Ajax - Feyenoord Maçı', 'Kuzey Hollanda Derbisi', 'Ajax ve Feyenoord takımları arasında oynanan derbi maçta Ajax rakibini 2-1 mağlup etti.', 'uploads/haber_68ef64f690bcd.jpg', '2025-10-15 20:00:00'),
(2, 'Bilbao - Getafe Maçı', 'La Liga Karşılaşması', 'Athletic Bilbao evinde Getafe’yi 3-0 mağlup etti. Bilbao taraftarları tribünlerde coşkulu bir atmosfer oluşturdu.', 'uploads/haber_68ef64ff5834a.jpeg', '2025-10-14 18:30:00'),
(3, 'Arsenal - Manchester United', 'Premier Lig Mücadelesi', 'Arsenal, Emirates Stadı’nda Manchester United’ı 2-0 yenerek ligde kritik bir galibiyet aldı.', 'uploads/haber_68ef650835b7b.jpg', '2025-10-13 21:00:00'),
(4, 'Samsunspor - Göztepe Maçı', '1. Lig Karşılaşması', 'Samsunspor, Göztepe karşısında evinde 3-1 galip geldi ve puanını 25’e çıkardı.', 'uploads/haber_68ef65104ea16.jpg', '2025-10-12 17:30:00'),
(5, 'Başakşehir Galibiyeti', 'Süper Lig Mücadelesi', 'Başakşehir, deplasmanda oynadığı maçta rakibini 2-1 mağlup ederek önemli bir galibiyet elde etti.', 'uploads/haber_68ef652121dec.jpg', '2025-10-11 20:00:00'),
(6, 'Arsenal Galibiyeti', 'Premier Lig’de Kritik Zafer', 'Arsenal, ligdeki son maçında rakibini 3-1 mağlup ederek üst sıralara tırmandı.', 'uploads/haber_68ef6528dd396.jpg', '2025-10-10 19:00:00'),
(7, 'Barcelona - Real Madrid', 'El Clasico', 'Barcelona ve Real Madrid arasındaki El Clasico maçında Barcelona sahadan 2-2 berabere ayrıldı. Taraftarlar coşkulu bir atmosfer yarattı.', 'uploads/haber_68ef653563db4.jpg', '2025-10-09 21:00:00'),
(8, 'Dortmund Stadı Tribünleri', 'Almanya Bundesliga', 'Dortmund tribünleri dolup taşarken taraftarlar unutulmaz bir atmosfer yarattı. Takım sahadan 4-1 galip ayrıldı.', 'uploads/haber_68ef653e9d761.jpg', '2025-10-08 18:00:00'),
(9, 'Sergen Yalçın ile Röportaj', 'Futbol Dünyasının Yıldızı', 'Sergen Yalçın, kariyerindeki başarılarını ve geleceğe dair hedeflerini anlattığı röportajında, genç oyunculara tavsiyelerde bulundu.', 'uploads/haber_68ef6549a9add.jpg', '2025-10-07 16:30:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `maclar`
--

CREATE TABLE `maclar` (
  `id` int(11) NOT NULL,
  `takimlar` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `kanal` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `maclar`
--

INSERT INTO `maclar` (`id`, `takimlar`, `aciklama`, `resim`, `kanal`, `tarih`) VALUES
(3, 'Konyaspor - Kocaelispor', 'Konyaspor ve Kocaelispor 18/10 Cmt 14:30 karşılaşması', 'assets/img/mac_68ef49b0d9def.png', 'BEİN SPORST 1', '2025-10-18 14:30:00'),
(4, 'Beşiktaş - Gençlerbirliği', 'Beşiktaş ve Gençlerbirliği 18/10 Cmt 17:00 karşılaşması', 'assets/img/mac_68ef498ce670c.png', 'BEİN SPORST 3', '2025-10-18 17:00:00'),
(5, 'Rizespor - Trabzonspor', 'Rizespor ve Trabzonspor 18/10 Cmt 17:00 karşılaşması', 'assets/img/mac_68ef4996c2ec9.png', 'BEİN SPORST 4', '2025-10-18 17:00:00'),
(6, 'Başakşehir - Galatasaray', 'Başakşehir ve Galatasaray 18/10 Cmt 20:00 karşılaşması', 'assets/img/mac_68ef497c8eaf7.png', 'BEİN SPORST 2', '2025-10-18 20:00:00'),
(7, 'Kayserispor - Samsunspor', 'Kayserispor ve Samsunspor 19/10 Paz 14:30 karşılaşması', 'assets/img/mac_68ef496c58031.png', 'BEİN SPORST 1', '2025-10-19 14:30:00'),
(8, 'Alanyaspor - Göztepe', 'Alanyaspor ve Göztepe 19/10 Paz 17:00 karşılaşması', 'assets/img/mac_68ef494eb9dcb.png', 'BEİN SPORST 3', '2025-10-19 17:00:00'),
(9, 'Gaziantep FK - Antalyaspor', 'Gaziantep FK ve Antalyaspor 19/10 Paz 17:00 karşılaşması', 'assets/img/mac_68ef495b5bb2c.png', 'BEİN SPORST 4', '2025-10-19 17:00:00'),
(10, 'Fenerbahçe - Karagümrük', 'Fenerbahçe ve Karagümrük 19/10 Paz 20:00 karşılaşması', 'assets/img/mac_68ef49329e96a.png', 'BEİN SPORST 2', '2025-10-19 20:00:00'),
(11, 'Eyüpspor - Kasımpaşa', 'Eyüpspor ve Kasımpaşa 20/10 Pzt 20:00 karşılaşması', 'assets/img/mac_68ef494150c6c.jpeg', 'BEİN SPORST 1', '2025-10-20 20:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mesajlar`
--

CREATE TABLE `mesajlar` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `konu` varchar(255) NOT NULL,
  `mesaj` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `mesajlar`
--

INSERT INTO `mesajlar` (`id`, `isim`, `email`, `konu`, `mesaj`, `tarih`) VALUES
(1, 'emirhan', 'emirhan41@gmail.com', 'adsfdasf', 'afsdfdas', '2025-10-15 19:31:03'),
(2, 'emirhan', 'emirhan41@gmail.com', 'dasdas', 'adsdas', '2025-10-15 19:32:36'),
(3, 'emirhan', 'emirhan41@gmail.com', 'asddas', 'dasdas', '2025-10-15 19:36:50'),
(4, 'kartal', 'kartal03@gmail.com', 'afddfas', 'sdaffds', '2025-10-15 19:38:54'),
(5, 'kartal', 'kartal03@gmail.com', 'oşjlk', 'jşlk', '2025-10-15 19:39:32'),
(6, 'kartal', 'kartal03@gmail.com', 'adsf', 'afds', '2025-10-15 19:42:23'),
(7, 'kartal', 'kartal03@gmail.com', 'das', 'das', '2025-10-15 19:43:47'),
(8, 'kartal', 'kartal03@gmail.com', 'afds', 'afds', '2025-10-15 19:47:20'),
(14, 'emirhan kaplan', 'emirhan28@gmail.com', 'Site Hakkında', 'Siteniz daha fazla geliştirilip daha iyi hale getirebilirsiniz.', '2025-10-15 20:17:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `puan_tablosu`
--

CREATE TABLE `puan_tablosu` (
  `id` int(11) NOT NULL,
  `takim_adi` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `puan` int(11) DEFAULT 0,
  `renk` varchar(20) DEFAULT NULL,
  `sira` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `puan_tablosu`
--

INSERT INTO `puan_tablosu` (`id`, `takim_adi`, `logo`, `puan`, `renk`, `sira`) VALUES
(1, 'Galatasaray', 'assets/img/logo_68ef52b6e1d6e.png', 22, '', 1),
(2, 'Trabzonspor', 'assets/img/logo_68ef52c0b2b12.jpg', 17, '', 2),
(3, 'Göztepe', 'assets/img/logo_68ef52cac3204.jpg', 16, '', 3),
(4, 'Fenerbahçe', 'assets/img/logo_68ef52d3962f9.jpg', 16, '', 4),
(5, 'Gaziantep FK', 'assets/img/logo_68ef52da1a8b6.jpg', 14, '', 5),
(6, 'Beşiktaş', 'assets/img/logo_68ef52e53ccb7.jpg', 13, '', 6),
(7, 'Samsunspor', 'assets/img/logo_68ef52ec3ae21.jpg', 13, '', 7),
(8, 'Konyaspor', 'assets/img/logo_68ef52f588903.jpg', 11, '', 8),
(9, 'Alanyaspor', 'assets/img/logo_68ef52ff024e7.jpg', 10, '', 9),
(10, 'Antalyaspor', 'assets/img/logo_68ef530bde530.jpg', 10, '', 10),
(11, 'Kasımpaşa', 'assets/img/logo_68ef53158483e.jpg', 9, '', 11),
(12, 'Rizespor', 'assets/img/logo_68ef531e81518.jpg', 8, '', 12),
(13, 'Başakşehir', 'assets/img/logo_68ef5329620cd.jpg', 6, '', 13),
(14, 'Gençlerbirliği', 'assets/img/logo_68ef533466d57.jpg', 5, '', 14),
(15, 'Kocaelispor', 'assets/img/logo_68ef533c47192.jpg', 5, '', 15),
(16, 'Eyüpspor', 'assets/img/logo_68ef53455058c.jpg', 5, '', 16),
(17, 'Kayserispor', 'assets/img/logo_68ef534d3d201.jpg', 5, '', 17),
(18, 'Karagümrük', 'assets/img/logo_68ef535a81594.jpg', 5, '', 18);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `son_dakika_haberleri`
--

CREATE TABLE `son_dakika_haberleri` (
  `id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `detay` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `son_dakika_haberleri`
--

INSERT INTO `son_dakika_haberleri` (`id`, `kategori`, `baslik`, `detay`, `tarih`) VALUES
(1, 'Transfer Haberleri', 'Fenerbahçe İsmail Yüksek ile Anlaşmadı', 'Fenerbahçe, 2025 Eylül ayında İsmail Yüksek ile sözleşme yenileme kararı almadı.', '2025-09-10 12:00:00'),
(2, 'Transfer Haberleri', 'Galatasaray Genç Oyuncuyu Kadrosuna Kattı', 'Galatasaray, altyapıdan gelecek vaadedeni kadrosuna kattı. Genç oyuncu 3 yıllık sözleşmeye imza attı.', '2025-09-15 15:30:00'),
(3, 'Transfer Haberleri', 'Beşiktaş Yabancı Forvet Arayışında', 'Beşiktaş yönetimi, yabancı bir forvet ile anlaşma yapabilmek için girişimlerini hızlandırdı.', '2025-10-01 10:45:00'),
(4, 'Maç Sonuçları', 'Fenerbahçe – Antalyaspor: 2-0', 'Fenerbahçe, 28 Eylül 2025’teki maçta Antalyaspor’u 2-0 mağlup etti ve kritik 3 puanı aldı.', '2025-09-28 20:00:00'),
(5, 'Maç Sonuçları', 'Karagümrük – Beşiktaş: 1-0', 'Beşiktaş deplasman da yenilgiye uğradı,Karagümrük iyi oyun sergileyerek 1-0\'lık sonuçla galibiyet aldı.', '2025-10-05 17:00:00'),
(6, 'Maç Sonuçları', 'Galatasaray Evinde Fark Attı', 'Galatasaray, 5 Ekim 2025’te evinde oynadığı maçta rakibini 3-1 mağlup etti.', '2025-10-05 20:00:00'),
(7, 'Günün Manşeti', 'Süper Lig’de Avantaj Galatasaray’da', '2025 Ekim başı itibarıyla lider Galatasaray oldu.', '2025-10-02 09:00:00'),
(8, 'Günün Manşeti', 'VAR Kararları Tartışılıyor', 'Haftanın maçlarında verilen VAR kararları geniş tartışmalara neden oldu.', '2025-10-06 13:00:00'),
(9, 'Günün Manşeti', 'Genç Oyuncular Öne Çıkıyor', '2025 sezonunun ilk aylarında birçok genç futbolcu performanslarıyla dikkat çekti.', '2025-10-07 11:00:00'),
(10, 'Süper Lig', 'Trabzonspor Son Dakika Golüyle Kazandı', 'Trabzonspor, 12 Ekim 2025’te deplasmanda attığı golle maçtan galip ayrıldı.', '2025-10-12 18:30:00'),
(11, 'Süper Lig', 'Beşiktaş Evinde Mağlup Oldu', 'Beşiktaş, 11 Ekim 2025’te evinde oynadığı maçta sürpriz bir mağlubiyet aldı.', '2025-10-11 20:00:00'),
(12, 'Süper Lig', 'Kocaelispor Maçtan Galip Ayrıldı', 'Kocaelispor, 30 Eylül 2025’te oynadığı maçta rakibini mağlup etti.', '2025-09-30 14:00:00'),
(13, '1. Lig', 'Manisa FK Kritik Maçtan Galip Ayrıldı', 'Manisa FK, 9 Ekim 2025’te oynadığı kritik maçta rakibini 2-0 mağlup etti.', '2025-10-09 18:00:00'),
(14, '1. Lig', 'Bandırmaspor Evinde Farklı Kazandı', 'Bandırmaspor, 12 Ekim 2025’te evinde oynadığı maçta rakibini 4-1 mağlup etti.', '2025-10-12 20:00:00'),
(15, '1. Lig', 'Bursaspor Kritik Maçı Kazandı', 'Bursaspor, 14 Ekim 2025’te kritik maçta rakibini 2-1 mağlup etti.', '2025-10-14 16:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye`
--

CREATE TABLE `uye` (
  `id` int(10) UNSIGNED NOT NULL,
  `isim` varchar(100) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `uye`
--

INSERT INTO `uye` (`id`, `isim`, `mail`, `sifre`, `created_at`) VALUES
(4, 'yakup', 'yakup@gmail.com', 'yakup_41', '2025-10-15 13:54:24'),
(5, 'asd', 'asd21@gmail.com', 'asd_21', '2025-10-15 15:08:03'),
(6, 'asdt99@gmail.com', 'asdt28@gmail.com', 'asd_41', '2025-10-15 15:12:37'),
(7, 'emir', 'emir28@gmail.com', '$2y$10$DesucZoTs0OjxMDu072huuI7FTpOBxDa7ryDzCIirVaOO5puNYfDG', '2025-10-15 18:14:21'),
(8, 'yakup', 'yakup288@gmail.com', 'yakup_28', '2025-10-15 18:18:48'),
(9, 'kartal', 'kartal03@gmail.com', 'kartal_03', '2025-10-15 19:38:32'),
(10, 'emirhan kaplan', 'emirhan28@gmail.com', 'emirhan_28', '2025-10-15 20:06:56');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `haber_id` int(11) NOT NULL,
  `haber_baslik` varchar(255) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `uye_isim` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `haber_id`, `haber_baslik`, `uye_id`, `uye_isim`, `email`, `yorum`, `tarih`) VALUES
(1, 8, 'Dortmund Stadı Tribünleri', 9, 'kartal', 'kartal03@gmail.com', 'afdsadfsafdsadfs', '2025-10-15 20:04:29'),
(2, 3, 'Arsenal - Manchester United', 10, 'emirhan kaplan', 'emirhan28@gmail.com', 'asdffasdfdas', '2025-10-15 20:13:30'),
(3, 4, 'Samsunspor - Göztepe Maçı', 10, 'emirhan kaplan', 'emirhan28@gmail.com', 'samsunspor çok iyi oynadı', '2025-10-15 20:17:18'),
(4, 9, 'Sergen Yalçın ile Röportaj', 10, 'emirhan kaplan', 'emirhan28@gmail.com', 'adsffdsa', '2025-10-15 20:24:26');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `adminler`
--
ALTER TABLE `adminler`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `gunun_mansetleri`
--
ALTER TABLE `gunun_mansetleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gunun_yorumu`
--
ALTER TABLE `gunun_yorumu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haberler`
--
ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `maclar`
--
ALTER TABLE `maclar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `mesajlar`
--
ALTER TABLE `mesajlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `puan_tablosu`
--
ALTER TABLE `puan_tablosu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `son_dakika_haberleri`
--
ALTER TABLE `son_dakika_haberleri`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uye`
--
ALTER TABLE `uye`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_mail` (`mail`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `adminler`
--
ALTER TABLE `adminler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `gunun_mansetleri`
--
ALTER TABLE `gunun_mansetleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `gunun_yorumu`
--
ALTER TABLE `gunun_yorumu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `maclar`
--
ALTER TABLE `maclar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `mesajlar`
--
ALTER TABLE `mesajlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `puan_tablosu`
--
ALTER TABLE `puan_tablosu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `son_dakika_haberleri`
--
ALTER TABLE `son_dakika_haberleri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `uye`
--
ALTER TABLE `uye`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
