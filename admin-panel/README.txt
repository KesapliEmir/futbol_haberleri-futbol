ADMIN PANEL (ZIP)
-----------------
Klasör: admin-panel/

Nasıl kurulur:
1) admin-panel klasörünü sunucunuzdaki site köküne koyun (örnek: /var/www/html/futbol_haberleri/admin-panel).
2) Eğer zaten ana sitede db.php varsa admin dosyalarında 'require "db.php"' satırını '../db.php' ile değiştirin.
   - Bu ZIP içindeki dosyalar local admin-panel/db.php kullanır. Eğer ana site ile paylaşmak isterseniz
     admin dosyalarındaki require 'db.php' -> require '../db.php' olarak güncelleyin.
3) uploads/ klasörüne yazma izni verin (chmod 755 veya 775).
4) Veritabanı adınız 'futbol_haberleri' olmalı ve aşağıdaki tablolar mevcut olmalı:
   - kullanıcılar (id, username, email, password, created_at)
   - haberler (id, baslik, icerik, resim, tarih)
   - mesajlar (id, isim, email, konu, mesaj, tarih)
   Eğer eksikse create scripts (puan_tablosu, hakkinda) otomatik oluşturulur.
5) Admin oluşturmak için iki yol:
   a) create_admin.php dosyasını tarayıcıda bir kere çalıştırın (http://your-site/admin-panel/create_admin.php) sonra silin.
   b) veya admin-login.php'de admin yoksa görünen 'Admin Kaydı Oluştur' formunu kullanın.
6) Giriş yaptıktan sonra admin-panel.php üzerinden haber ekleyebilir, düzenleyebilir, silebilir, mesajları görebilirsiniz.

Not: Güvenlik için create_admin.php çalıştıktan sonra dosyayı silin ve admin klasörüne erişimi koruyun.
