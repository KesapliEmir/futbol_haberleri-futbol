-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Eki 2025, 10:47:19
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
(3, 'osman', 'osman28@admin.com', 'osman_28', '2025-10-15 18:22:30'),
(0, 'yakup', 'yakup@gmail.com', 'yakup_28', '2025-10-19 01:27:40'),
(0, 'yakupp', 'yakup@admin.com', 'yakup_1', '2025-10-19 01:29:23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gunun_haberleri`
--

CREATE TABLE `gunun_haberleri` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `aciklama` text DEFAULT NULL,
  `detay` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gunun_haberleri`
--

INSERT INTO `gunun_haberleri` (`id`, `baslik`, `aciklama`, `detay`, `resim`, `tarih`) VALUES
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
(1, 'Fenerbahçe', 'Maç Öncesi Yorumu', 'Takım güçlü görünüyor ve önümüzdeki maçlarda kazanacaklarına dair büyük bir güven veriyor. Fenerbahçe, sahaya çıktığı her maçta disiplinli ve organize bir oyun sergileyerek hem hücumda hem savunmada etkili performans gösteriyor.', 'assets/img/yorum_68ef5200360c1.jpg', '2025-10-14 20:41:03'),
(2, 'Galatasaray', 'Maç Sonrası Yorumu', 'Oyun mükemmeldi ve üç puanı almayı başardık. Galatasaray, sahaya çıktığı maçta gösterdiği organize ve etkili futbol ile rakiplerini adeta sahada ezdi.', 'assets/img/yorum_68ef520925fa9.png', '2025-10-14 20:41:03'),
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
(6, 'Arsenal Galibiyeti', 'Premier Lig’de Kritik Zafer', 'Arsenal, ligdeki son maçında rakibini 2-0 mağlup ederek üst sıralara tırmandı. Maç boyunca disiplinli bir oyun sergileyen İngiliz ekibi, hem savunmada sağlam durdu hem de hücumda etkili ataklar gerçekleştirdi. İlk gol, takımın oyundaki üstünlüğünü pekiştirirken, ikinci gol ise galibiyeti perçinledi. Taraftarlar, maç boyunca oyuncularını coşkuyla destekleyerek, Emirates Stadı’nda unutulmaz bir atmosfer yarattı.', 'uploads/haber_68ef6528dd396.jpg', '2025-10-10 19:00:00'),
(7, 'Barcelona - Real Madrid', 'El Clasico', 'Barcelona ve Real Madrid arasındaki El Clasico maçında Barcelona sahadan 2-2 berabere ayrıldı. Taraftarlar coşkulu bir atmosfer yarattı.', 'uploads/haber_68ef653563db4.jpg', '2025-10-09 21:00:00'),
(8, 'Dortmund Stadı Tribünleri', 'Almanya Bundesliga', 'Dortmund tribünleri dolup taşarken taraftarlar unutulmaz bir atmosfer yarattı. Sarı-siyahlı taraftarlar, maç boyunca tezahüratları ve coşkularıyla takımlarına büyük destek verdi. Tribünlerden yükselen ritimler, oyuncuların motivasyonunu artırırken, stadın adeta bir futbol şölenine dönüşmesini sağladı. Maç boyunca ortaya koyulan etkileyici oyun, taraftarların heyecanını daha da artırdı.', 'uploads/haber_68ef653e9d761.jpg', '2025-10-08 18:00:00'),
(9, 'Sergen Yalçın ile Röportaj', 'Futbol Dünyasının Yıldızı', 'Sergen Yalçın, kariyerindeki başarılarını ve geleceğe dair hedeflerini anlattığı röportajında, genç oyunculara tavsiyelerde bulundu. Futbolculuk ve teknik direktörlük hayatının zorluklarını samimi bir şekilde paylaşan Yalçın, disiplin, azim ve sürekli öğrenmenin önemine vurgu yaptı. Kendi tecrübelerinden örnekler vererek, genç oyuncuların sadece yetenekli olmalarının yeterli olmadığını, aynı zamanda sahada ve saha dışında doğru kararlar almayı öğrenmeleri gerektiğini belirtti.', 'uploads/haber_68ef6549a9add.jpg', '2025-10-07 16:30:00');

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
(3, 'emirhan kaplan', 'emirhan28@gmail.com', 'Site Hakkında', 'Siteniz daha fazla geliştirilip daha iyi hale getirebilirsiniz.', '2025-10-15 20:17:06'),
(0, 'emirhan kaplan', 'emirhan28@gmail.com', 'emo', 'emo', '2025-10-19 01:04:44');

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
(2, 'Galatasaray', 'assets/img/logo_68f4a51b76221.png', 22, '', 3),
(3, 'Göztepe', 'assets/img/logo_68f4a5490362b.jpg', 16, '', 4),
(4, 'Fenerbahçe', 'assets/img/logo_68ef52d3962f9.jpg', 16, '', 5),
(5, 'Gaziantep FK', 'assets/img/logo_68ef52da1a8b6.jpg', 14, '', 6),
(6, 'Beşiktaş', 'assets/img/logo_68ef52e53ccb7.jpg', 13, '', 7),
(7, 'Samsunspor', 'assets/img/logo_68ef52ec3ae21.jpg', 13, '', 8),
(8, 'Konyaspor', 'assets/img/logo_68ef52f588903.jpg', 11, '', 9),
(9, 'Alanyaspor', 'assets/img/logo_68ef52ff024e7.jpg', 10, '', 10),
(10, 'Antalyaspor', 'assets/img/logo_68ef530bde530.jpg', 10, '', 11),
(11, 'Kasımpaşa', 'assets/img/logo_68ef53158483e.jpg', 9, '', 12),
(12, 'Rizespor', 'assets/img/logo_68ef531e81518.jpg', 8, '', 13),
(13, 'Başakşehir', 'assets/img/logo_68ef5329620cd.jpg', 6, '', 14),
(14, 'Gençlerbirliği', 'assets/img/logo_68ef533466d57.jpg', 5, '', 15),
(15, 'Kocaelispor', 'assets/img/logo_68ef533c47192.jpg', 5, '', 16),
(16, 'Eyüpspor', 'assets/img/logo_68ef53455058c.jpg', 5, '', 17),
(17, 'Kayserispor', 'assets/img/logo_68ef534d3d201.jpg', 5, '', 18),
(18, 'Karagümrük', 'assets/img/logo_68ef535a81594.jpg', 5, '', 19);

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
(1, 'Transfer Haberleri', 'Fenerbahçe İsmail Yüksek ile Anlaşmadı', 'Fenerbahçe, 2025 Eylül ayında orta saha oyuncusu İsmail Yüksek ile sözleşme yenileme kararı almadı. Sarı-lacivertli yönetim, oyuncunun mevcut performansını ve takımın uzun vadeli planlarını değerlendirerek bu kararı verdi. Teknik direktör ve yönetim, kadroda yapılacak değişiklikler ve transfer planları doğrultusunda İsmail Yüksek’in geleceği hakkında net bir karar aldı.Bu gelişme, hem taraftarlar hem de futbol çevreleri arasında geniş yankı uyandırdı. Oyuncu ve temsilcileriyle yapılan görüşmelerde anlaşmaya varılamaması, Fenerbahçe’nin önümüzdeki dönemde orta saha transferlerine öncelik vereceğini gösteriyor. Kulüp, mevcut kadroda genç ve deneyimli oyuncuların dengeli bir şekilde sahada yer almasını hedeflerken, yönetimin bu kararı takımın mali ve sportif planlaması açısından stratejik bir adım olarak değerlendiriliyor.', '2025-09-10 12:00:00'),
(2, 'Transfer Haberleri', 'Galatasaray Genç Oyuncuyu Kadrosuna Kattı', 'Galatasaray, altyapısından gelecek vaat eden genç bir oyuncuyu kadrosuna kattı. 3 yıllık profesyonel sözleşmeye imza atan oyuncu, sarı-kırmızılı ekipte geleceğe dönük önemli bir yatırım olarak değerlendiriliyor. Teknik ekip, genç oyuncunun yeteneklerini geliştirmek ve takıma en kısa sürede katkı sağlamasını amaçlıyor.Genç oyuncu, altyapıda gösterdiği performans ve potansiyeliyle dikkat çekmiş ve profesyonel sözleşmeyle ödüllendirilmiş oldu. Taraftarlar, bu transferin Galatasaray’ın uzun vadeli planları açısından önemini vurgularken, kulüp de genç yeteneklere verdiği önemi bir kez daha göstermiş oldu. 3 yıllık sözleşme, hem oyuncuya güven aşılamak hem de takımın geleceğini şekillendirmek adına stratejik bir adım olarak öne çıkıyor.', '2025-09-15 15:30:00'),
(3, 'Transfer Haberleri', 'Beşiktaş Yabancı Forvet Arayışında', 'Beşiktaş yönetimi, takımın hücum hattını güçlendirmek amacıyla yabancı bir forvet ile anlaşma yapabilmek için girişimlerini hızlandırdı. Siyah-beyazlı ekip, sezonun ilk haftalarındaki performansı ve gol yollarındaki eksiklikleri göz önünde bulundurarak transfer çalışmalarını yoğunlaştırdı. Yönetim, teknik direktör ve scout ekibiyle birlikte, potansiyel adayları yakından takip ediyor ve takıma en uygun oyuncuyu kadroya kazandırmak için çeşitli temaslarda bulunuyor.', '2025-10-01 10:45:00'),
(4, 'Maç Sonuçları', 'Fenerbahçe – Antalyaspor: 2-0', 'Fenerbahçe, 18 Ekim 2025’te oynadığı maçta Antalyaspor’u 2-0 mağlup ederek kritik 3 puanı hanesine yazdırdı. Maç boyunca sahada disiplinli ve etkili bir oyun sergileyen sarı-lacivertli ekip, rakip kalede gösterdiği üstün performansla galibiyeti garantiledi. İlk golün gelmesiyle birlikte taraftarlar tribünlerde coşku yaşarken, ikinci gol maçın kontrolünü tamamen Fenerbahçe’ye verdi.', '2025-09-28 20:00:00'),
(5, 'Maç Sonuçları', 'Gençlerbirliği – Beşiktaş:', 'Beşiktaş deplasmanda sürpriz bir yenilgiye uğradı. Karşılaşmada Gençlerbirliği, sahada etkili ve organize bir oyun sergileyerek rakibini 2-1 mağlup etmeyi başardı. Maç boyunca hızlı hücumlarla ve kontrollü paslaşmalarla üstünlüğü ele geçiren Gençlerbirliği, attığı gollerle galibiyeti garantiledi. Beşiktaş ise beklenen performansı sahaya yansıtamayarak özellikle savunmada yaptığı hatalar nedeniyle mağlubiyetten kurtulamadı.', '2025-10-05 17:00:00'),
(6, 'Maç Sonuçları', 'Galatasaray Evinde Fark Attı', 'Galatasaray, 5 Ekim 2025’te evinde oynadığı maçta rakibini 3-1 mağlup ederek taraftarlarına büyük bir sevinç yaşattı. Sarı-kırmızılı ekip, maç boyunca sahada üstün bir performans sergileyerek hem hücumda hem savunmada etkili bir oyun ortaya koydu. İlk golün gelmesiyle tribünlerde coşku doruğa çıktı ve takımın motivasyonu arttı. Maçın ilerleyen dakikalarında atılan ikinci ve üçüncü goller, Galatasaray’ın sahadaki üstünlüğünü pekiştirdi ve galibiyetin garantilenmesini sağladı.', '2025-10-05 20:00:00'),
(7, 'Günün Manşeti', 'Süper Lig’de Avantaj Galatasaray’da', '2025 Ekim başı itibarıyla ligde liderlik koltuğuna Galatasaray oturdu. Sarı-kırmızılı ekip, sahada gösterdiği istikrarlı performans ve etkili oyunuyla rakiplerini geride bırakarak puan tablosunun zirvesine yerleşti. Evinde ve deplasmanda aldığı galibiyetlerle hem taraftarlarını sevindiren hem de rakip takımlar üzerinde psikolojik üstünlük kuran Galatasaray, sezonun ilk aylarında dikkat çeken bir grafik çizdi.', '2025-10-02 09:00:00'),
(8, 'Günün Manşeti', 'VAR Kararları Tartışılıyor', 'Haftanın maçlarında verilen VAR kararları geniş tartışmalara neden oldu. Maçların kritik anlarında devreye giren Video Yardımcı Hakem sistemi, bazı pozisyonlarda tartışmalı kararlara yol açtı ve hem teknik direktörler hem de taraftarlar arasında yoğun tepkilere neden oldu. Ofsayt, penaltı ve faul gibi kararların yorumlanması, sosyal medyada ve spor programlarında gün boyu gündem oldu.', '2025-10-06 13:00:00'),
(9, 'Günün Manşeti', 'Genç Oyuncular Öne Çıkıyor', '2025 sezonunun ilk aylarında birçok genç futbolcu performanslarıyla dikkat çekti. Sahaya çıktıkları maçlarda sergiledikleri özgüvenli oyun, hızlı adaptasyonları ve teknik yetenekleriyle hem taraftarların hem de teknik direktörlerin beğenisini kazandılar. Özellikle orta saha ve hücum bölgelerinde ortaya koydukları etkili paslaşmalar, hızlı koşular ve yaratıcı oyun anlayışı, takımlarının başarısında belirleyici oldu.', '2025-10-07 11:00:00'),
(10, 'Süper Lig', 'Trabzonspor Son Dakika Golüyle Kazandı', 'Trabzonspor, 12 Ekim 2025’te deplasmanda oynadığı kritik maçta attığı golle sahadan galip ayrıldı. Maç boyunca dengeli bir oyun sergileyen Karadeniz ekibi, rakip kalede etkili ataklar gerçekleştirdi ve maçın tek golünü kaydederek önemli bir üç puan elde etti. Deplasmanda kazanmanın verdiği avantajla takımın morali yükselirken, teknik direktörün sahadaki taktiksel hamleleri galibiyette belirleyici oldu.', '2025-10-12 18:30:00'),
(11, 'Süper Lig', 'Beşiktaş Evinde Mağlup Oldu', 'Beşiktaş, 11 Ekim 2025’te evinde oynadığı maçta sürpriz bir mağlubiyet aldı. Siyah-beyazlı ekip, sahaya üstünlük kurma hedefiyle çıksa da beklenmedik hatalar ve rakip takımın etkili oyun planı nedeniyle mağlubiyetten kurtulamadı. Maç boyunca topladığı pozisyonları değerlendiremeyen Beşiktaş, özellikle savunmada yaptığı ufak hatalarla rakibe gol şansı tanıdı ve maçtan 1-0 veya 2-1 gibi skorlarla sahadan mağlup ayrıldı.', '2025-10-11 20:00:00'),
(12, 'Süper Lig', 'Kocaelispor Maçtan Galip Ayrıldı', 'Kocaelispor, 18 Ekim 2025’te oynadığı maçta rakibini mağlup ederek önemli bir galibiyet elde etti. Maç boyunca sahada disiplinli ve organize bir oyun sergileyen ekip, rakip takımın baskısına rağmen kontrollü ve etkili bir futbol ortaya koydu. İlk golün gelmesiyle birlikte Kocaelispor’un motivasyonu yükseldi ve maçın ilerleyen dakikalarında rakip savunmayı zorlayarak galibiyeti pekiştirdi.', '2025-09-30 14:00:00'),
(13, '1. Lig', 'Manisa FK Kritik Maçtan Galip Ayrıldı', 'Manisa FK, 9 Ekim 2025’te oynadığı kritik maçta rakibini 2-0 mağlup ederek önemli bir galibiyet elde etti. Maç boyunca disiplinli ve organize bir oyun sergileyen ekip, sahadaki üstünlüğünü ilk dakikalardan itibaren hissettirdi. Oyuncuların sahadaki uyumu ve teknik direktörün taktiksel hamleleri, farkı açarak galibiyetin garantilenmesini sağladı.', '2025-10-09 18:00:00'),
(14, '1. Lig', 'Bandırmaspor Evinde Farklı Kazandı', 'Bandırmaspor, 12 Ekim 2025’te evinde oynadığı maçta rakibini 4-1 mağlup ederek taraftarlarına büyük bir sevinç yaşattı. Maç boyunca etkili bir oyun sergileyen ev sahibi ekip, hızlı hücumları ve organizasyonlu savunmasıyla rakip takım üzerinde baskı kurdu. İlk golün gelmesiyle tribünlerde coşku doruğa çıktı ve takımın motivasyonu artarak oyunu domine etmeye başladı.', '2025-10-12 20:00:00'),
(15, '1. Lig', 'Bursaspor Kritik Maçı Kazandı', 'Bursaspor, 14 Ekim 2025’te oynadığı kritik maçta rakibini 2-1 mağlup ederek büyük bir sevinç yaşadı. Maç boyunca taraftarların desteğiyle sahada enerjik bir performans sergileyen yeşil-beyazlı ekip, karşılaşmanın ilk dakikalarından itibaren üstünlüğü ele aldı. Oyuncuların saha içindeki uyumu ve teknik direktörün yaptığı taktiksel hamleler, galibiyetin temel nedenleri arasında yer aldı.', '2025-10-14 16:00:00');

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
(4, 9, 'Sergen Yalçın ile Röportaj', 10, 'emirhan kaplan', 'emirhan28@gmail.com', 'adsffdsa', '2025-10-15 20:24:26'),
(0, 9, 'Sergen Yalçın ile Röportaj', 10, 'emirhan kaplan', 'emirhan28@gmail.com', 'beşiktaş', '2025-10-19 00:58:20'),
(0, 9, 'Sergen Yalçın ile Röportaj', 4, 'yakup', 'yakup@gmail.com', 'sergen hoca', '2025-10-19 01:33:49');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
