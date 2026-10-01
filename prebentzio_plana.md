# ERRONKA 1 — Prebentzio-plana
## Ikastetxea – Laravel Web Aplikazioa eta Bere Ingurune Osoa

| | |
|---|---|
| **Data** | 2026ko urriaren 1a |
| **Bertsioa** | 1.0 |
| **Esparrua** | Ikastetxea Laravel aplikazioa, PostgreSQL datu-basea eta garapen/produkzio ingurunea |
| **Erreferentziak** | OWASP Top 10 (2021) · CIS Benchmarks · DBEO / LOPDGDD · INCIBE |
| **Sailkapena** | Barne-erabilerarako |

---

## Dokumentuaren kontrola

| Bertsioa | Data | Aldaketak |
|---|---|---|
| 1.0 | 2026/10/01 | Lehen bertsioa, proiektuaren kode-auditoria egin ondoren |

**Hurrengo berrikuspena:** 2027/01/01 (hiru hilean behin, edo lehenago gorabehera bat edo aldaketa garrantzitsu bat gertatzen bada).

---

## Aurkibidea

1. [Sarrera](#1-sarrera)
2. [Ingurunearen deskribapena](#2-ingurunearen-deskribapena)
3. [Aktiboen inbentarioa](#3-aktiboen-inbentarioa)
4. [Arriskuen analisia](#4-arriskuen-analisia)
5. [Ezarritako prebentzio-neurriak](#5-ezarritako-prebentzio-neurriak)
6. [Ekintza-plana](#6-ekintza-plana)
7. [Politikak eta jardunbide egokiak](#7-politikak-eta-jardunbide-egokiak)
8. [Segurtasun-kopiak eta berreskuratzea](#8-segurtasun-kopiak-eta-berreskuratzea)
9. [Gorabeheren kudeaketa](#9-gorabeheren-kudeaketa)
10. [Prestakuntza eta sentsibilizazioa](#10-prestakuntza-eta-sentsibilizazioa)
11. [Mantentze-egutegia](#11-mantentze-egutegia)
12. [Adierazleak](#12-adierazleak)
13. [Rolak eta erantzukizunak](#13-rolak-eta-erantzukizunak)
- [A eranskina. Egiaztapen-komandoak](#a-eranskina-egiaztapen-komandoak)
- [B eranskina. Erreferentziak](#b-eranskina-erreferentziak)

---

## 1. Sarrera

### 1.1 Helburua

Plan honek jasotzen du zer egiten dugun Ikastetxearen web aplikazioaren segurtasun-gorabeherak gertatu aurretik saihesteko, eta zer egingo dugun, hala ere, gertatzen badira. Honetarako balio du:

- Zer babestu behar dugun (aktiboak) eta zeren aurka (arriskuak) jakiteko.
- Dagoeneko funtzionatzen duten neurriak eta nola egiaztatzen diren idatziz uzteko.
- Proiektuan aurkitutako ahultasun zehatzak dokumentatzeko eta konpontzeko plana izateko.
- Mantentze-egutegi bat eta gorabeheren aurrean prozedura argi bat izateko.

### 1.2 Irismena

- **Web aplikazioa (Ikastetxea):** Laravel 12 oinarritutako aplikazioa, ikasleen kudeaketa, ikastaroen katalogoa, matrikulak eta administrazio-panela barne.
- **Datu-basea:** PostgreSQL (`matriculas` datu-basea, `admin:Admin123` kredentzialak — **LARRIALDI GORRIA**).
- **Garapen ingurunea:** Windows garatzaile-makinak, `.env` fitxategia lokalean.
- **Biltegi-kodea:** GitHub biltegi pribatua (edo publikoa).
- **Datuak:** ikasleen izen-abizenak eta emailak, matrikulak, notak eta administrazio-kredentzialak.

### 1.3 Lotutako dokumentuak

- Proiektuaren biltegia: `web/` karpeta.
- Laravel egitura: `app/Http/`, `config/`, `routes/`, `database/`.
- Test fitxategiak: `tests/Feature/`.

---

## 2. Ingurunearen deskribapena

### 2.1 Aplikazioa eta bere zerbitzuak

Ikastetxearen web aplikazioak ikastetxearen kudeaketa-sistema ematen du. Hauek dira eskaintzen dituen zerbitzuak:

- **Web publikoa (`/index.php`):** ikastaroaren katalogoa eta ikasleentzako matrikula-aukera.
- **Saioa hastea (`/login.php`):** admin eta ikasleak sartzen dira sistema barrura.
- **Ikaslearen erregistroa (`/erregistratu.php`):** adminak aurrez gehitutako ikasleak bere kontua aktibatzen du.
- **Administrazio-panela (`/administrazioa.php`):** ikasleak gehitu/ezabatu, matrikulak kudeatu, estatistikak ikusi.
- **Matrikula-kudeaketa (`/matrikulak/{id}`):** adminak matrikulen egoera aldatu dezake.

### 2.2 Arkitektura teknikoa

| Osagaia | Xehetasuna |
|---|---|
| **Frameworka** | Laravel 12 (`laravel/framework: ^12.0`) |
| **PHP bertsioa** | ^8.2 |
| **Datu-basea** | PostgreSQL (`pgsql`) — `matriculas` datu-basea, `127.0.0.1:5432` |
| **Sesioak** | Datu-basean gordeta (`SESSION_DRIVER=database`) |
| **Cache** | Datu-basean gordeta (`CACHE_STORE=database`) |
| **Posta** | Log-era bakarrik (`MAIL_MAILER=log`) — **Produkzioan konfiguratzeke** |
| **Autentifikazioa** | Eloquent + Sessio — `Erabiltzailea` modeloa |
| **Baimena** | `AdminOnly` middleware — rol-oinarritutako sarbidea |
| **Iturburu-kodea** | GitHub biltegi (publikoa edo pribatua) |
| **APP_ENV** | `local` — **produkzioan aldatzeke** |
| **APP_DEBUG** | `true` — **produkzioan EZKUTU egin behar da** |

### 2.3 Datu-basearen egitura

```
rolak            → id_rola, rola_izena (admin / ikasleak), deskribapena
erabiltzaileak   → id_erabiltzailea, izena, abizenak, emaila, pasahitza (nullable), id_rola, aktibo
ikastaroak       → id_ikastaroa, izenburua, deskribapena, edukiera (max=30), hasiera_data, amaiera_data
matrikulak       → id_matrikula, id_erabiltzailea, id_ikastaroa, matrikula_data, egoera (aktibo/ez_aktibo)
sessions         → id, user_id, ip_address, user_agent, payload, last_activity
cache / jobs     → Laravel-en estandar taulak
```

---

## 3. Aktiboen inbentarioa

> **Kritikotasuna:** Altua = galtzeak edo filtratzeak zerbitzua geldiarazten badu edo datu pertsonalak agerian uzten baditu; Ertaina = arazoak sortzen baditu baina daturik galdu gabe berreskuratzen bada.

| Aktiboa | Zer duen edo zer egiten duen | Kritikotasuna | Arduraduna |
|---|---|---|---|
| **PostgreSQL datu-basea** | Erabiltzaile guztiak, matrikulak eta ikastaroak | Altua | Sistema-adm. |
| **`.env` fitxategia** | `APP_KEY`, DB pasahitza (`Admin123`), posta kredentzialak | **KRITIKOA** | Sistema-adm. |
| **`APP_KEY`** | Sesio eta datu zifratuak deszifratzeko gakoa | Altua | Sistema-adm. |
| **Administratzaile-kontua** | Ikasle, ikastaro eta matrikula guztietarako sarbidea | Altua | Segurtasun-ard. |
| **Ikasleen datu pertsonalak** | Izenak, emailak, matrikula-egoera | Altua | Datuak babesteko ard. |
| **GitHub biltegi-kodea** | Aplikazioaren iturburu-kode osoa | Ertaina | Garapen-ard. |
| **Garatzaileen makinak** | `.env` eta kodea daukaten Windows eramangarriak | Ertaina | Kide bakoitza |
| **TLS ziurtagiria (produkzioan)** | Webguneko trafikoa zifratzeko | Ertaina | Sistema-adm. |

---

## 4. Arriskuen analisia

### 4.1 Nola kalkulatzen den

Mehatxu bakoitzari probabilitate **(P)** eta inpaktu **(I)** bat ematen zaizkio, 1etik 3ra:

- **Maila = P × I**
- **Baxua:** 1–2 | **Ertaina:** 3–4 | **Altua:** 6–9

**Egoera:** `Arindua` (konponduta eta egiaztatuta) · `Partziala` (neurriak daude, baina zerbait falta da) · `Egiteke`

### 4.2 Identifikatutako arriskuak

| # | Mehatxua | Aktiboa / Jatorria | P | I | Maila | Egoera |
|---|---|---|---|---|---|---|
| **R1** | **`.env`-ko pasahitza agerian: `DB_PASSWORD=Admin123` testu garbitan** | `.env` fitxategia | 3 | 3 | **9 · Larria** | **Egiteke** |
| **R2** | **`APP_DEBUG=true` produkzioan: stack trace-ak agerian** | `.env` / `config/app.php` | 3 | 3 | **9 · Larria** | **Egiteke** |
| **R3** | **`APP_ENV=local` produkzioan: garapen-portaera produkzioan** | `.env` | 3 | 3 | **9 · Larria** | **Egiteke** |
| **R4** | **`SESSION_ENCRYPT=false`: saio-datuak zifratu gabe** | `.env` / `config/session.php` | 2 | 3 | **6 · Altua** | **Egiteke** |
| **R5** | **Pasahitz-gutxieneko luzera 8 karaktere bakarrik (erregistroan)** | `IkastaroController` | 2 | 2 | **4 · Ertaina** | **Egiteke** |
| **R6** | **Admin-seeder-ak pasahitz estatiko bat du: `Admin123`** | `AdminSeeder.php` | 3 | 3 | **9 · Larria** | **Egiteke** |
| **R7** | **`SESSION_SECURE_COOKIE` ez dago ezarrita HTTPS betearazteko** | `config/session.php` | 2 | 3 | **6 · Altua** | **Egiteke** |
| **R8** | **`MAIL_MAILER=log`: posta produkzioan ez da bidaltzen** | `.env` | 2 | 2 | **4 · Ertaina** | **Egiteke** |
| **R9** | **Administrazio-bistan rol-IDa agerian (`id_rola`)** | `administrazioa.php` (89. lerroa) | 1 | 2 | **2 · Baxua** | **Egiteke** |
| **R10** | **Rate limiting erregistroan IP soilik: proxy baten atzean saihesten da** | `IkastaroController` (60. lerroa) | 2 | 2 | **4 · Ertaina** | **Partziala** |
| **R11** | **CSRF babesa bai, baina `SameSite=lax` (ez `strict`)** | `config/session.php` | 1 | 2 | **2 · Baxua** | **Partziala** |
| **R12** | **Indar gordineko erasoa saio-hasieraren aurka** | `AdministrazioaController` | 2 | 2 | **4 · Ertaina** | **Arindua** |
| **R13** | **SQL injekzioa** | Kontroladoreak | 1 | 3 | **3 · Ertaina** | **Arindua** |
| **R14** | **XSS erasoa bistetan** | Blade/PHP bistetan | 1 | 3 | **3 · Ertaina** | **Arindua** |
| **R15** | **DBEO: ikasleen datu pertsonalen babes-politika ez dago definituta** | Aplikazioa | 2 | 3 | **6 · Altua** | **Egiteke** |
| **R16** | **Segurtasun-kopia estrategiarik ez** | Datu-basea | 2 | 3 | **6 · Altua** | **Egiteke** |
| **R17** | **Auditoria-erregistrorik ez administrazio-ekintzetan** | Administrazio-panela | 2 | 2 | **4 · Ertaina** | **Egiteke** |
| **R18** | **Ikaslearen ezabaketan datuak erabat ezabatzen dira (ez anonimizatzen)** | `AdministrazioaController` | 1 | 2 | **2 · Baxua** | **Partziala** |

> [!CAUTION]
> **R1, R2, R3 eta R6 arrisku kritikoak dira**: `APP_DEBUG=true` produkzioan eta `Admin123` pasahitz estatikoa berehalako konponketa eskatzen dute.

---

## 5. Ezarritako prebentzio-neurriak

Neurri hauek kode-azterketan egiaztatu dira.

### 5.1 Autentifikazioa eta baimena

| Neurria | Arriskuak | Egoera | Kokapena |
|---|---|---|---|
| Rate limiting saio-hasieran: 5 saiakera, 60 segundoko blokeo | R12 | ✅ Ezarrita | `AdministrazioaController::authenticate()` |
| Rate limiting erregistroan: 10 saiakera, 60 segundoko blokeo | R10 | ⚠️ Partziala | `IkastaroController::storeRegistration()` |
| Admin rol-egiaztapena middleware bidez | R13 | ✅ Ezarrita | `AdminOnly.php` |
| Saioa ixterakoan saio-token berregintza | R12 | ✅ Ezarrita | `AdministrazioaController::logout()` |
| Ikasle aurrez onartutakoak bakarrik erregistra daitezke | R13 | ✅ Ezarrita | `IkastaroController::storeRegistration()` |
| Admin-kontua bere buruari ezabatu ezin | R13 | ✅ Ezarrita | `AdministrazioaController::destroy()` |
| Erabiltzaile inaktiboak ezin du saioa hasi | R12 | ✅ Ezarrita | `authenticate()` - `aktibo: true` baldintza |

### 5.2 Datu-baliozkotzea eta injekzioen babesa

| Neurria | Arriskuak | Egoera | Kokapena |
|---|---|---|---|
| Laravel Eloquent ORM: SQL injekzioaren aurka | R13 | ✅ Ezarrita | Kontroladore guztiak |
| `e()` funtzioa bistan: XSS-aren aurka | R14 | ✅ Ezarrita | PHP bista guztietan |
| CSRF tokena inprimaki guztietan | R11 | ✅ Ezarrita | Bista guztietan |
| `max:255` muga eremu guztietan | R13 | ✅ Ezarrita | Baliozkotzeak |
| Emailaren normalizazioa (`mb_strtolower + trim`) | R13 | ✅ Ezarrita | Kontroladoreak |
| Edukiera-muga transaksio bidez (SQLite → PostgreSQL ere) | R13 | ✅ Ezarrita | `IkastaroController::enroll()` |
| Matrikula-egoera `in:aktibo,ez_aktibo` bakarrik onartzen | R13 | ✅ Ezarrita | `MatrikulaController::update()` |

### 5.3 Sesioak eta cookieak

| Neurria | Arriskuak | Egoera | Kokapena |
|---|---|---|---|
| `HttpOnly` cookieak (JavaScript-etik irisgoezin) | R14 | ✅ Ezarrita | `config/session.php` |
| `SameSite=lax` (CSRF babesa) | R11 | ⚠️ Partziala | `config/session.php` — `strict` hobea litzateke |
| Datu-basean gordetako sesioak | R12 | ✅ Ezarrita | `config/session.php` |
| `Cache-Control: no-store, private` administrazio-bistan | R12 | ✅ Ezarrita | `AdministrazioaController::index()` |
| Saio berregintza saioa hastean | R12 | ✅ Ezarrita | `authenticate()` |

### 5.4 Test automatikoak

| Neurria | Arriskuak | Egoera | Kokapena |
|---|---|---|---|
| 6 test-fitxategi, hainbat eszenatoki estaltzen | R12–R14 | ✅ Ezarrita | `tests/Feature/` |
| Erregistro-saiakeraren baliozkotzea testean | R10 | ✅ Ezarrita | `IkastetxeaTest.php` |
| Edukiera-muga testean egiaztatuta | R12 | ✅ Ezarrita | `CourseCapacityTest.php` |
| Admin-sarbidearen babesa testean | R12, R13 | ✅ Ezarrita | `AdministrazioaTest.php` |

---

## 6. Ekintza-plana

> [!IMPORTANT]
> Falta diren neurriak, lehentasunaren arabera ordenatuta. **Berehala** = gaur bertan konpondu.

| # | Neurria | Arriskuak | Lehentasuna | Arduraduna | Epea |
|---|---|---|---|---|---|
| **A1** | **`APP_DEBUG=false` ezarri produkzioan** | R2 | 🔴 Larria | Sistema-adm. | **Berehala** |
| **A2** | **`APP_ENV=production` ezarri produkzioan** | R3 | 🔴 Larria | Sistema-adm. | **Berehala** |
| **A3** | **`DB_PASSWORD` pasahitza aldatu (`Admin123` ez erabili inoiz)** | R1 | 🔴 Larria | Sistema-adm. | **Berehala** |
| **A4** | **`AdminSeeder`-eko `Admin123` pasahitz estatikoa ezabatu; `ADMIN_PASSWORD` ingurune-aldagaitik irakurri** | R6 | 🔴 Larria | Garapen-ard. | **Berehala** |
| **A5** | **`SESSION_ENCRYPT=true` ezarri** | R4 | 🟠 Altua | Sistema-adm. | Aste 1 |
| **A6** | **`SESSION_SECURE_COOKIE=true` ezarri HTTPS produkzioan** | R7 | 🟠 Altua | Sistema-adm. | Aste 1 |
| **A7** | **Pasahitzaren gutxieneko luzera 8→12 karakterera handitu erregistroan** | R5 | 🟠 Altua | Garapen-ard. | Aste 1 |
| **A8** | **Posta-konfigurazioa produkziorako ezarri (SMTP benetakoa)** | R8 | 🟠 Altua | Sistema-adm. | Aste 1 |
| **A9** | **Administrazio-bistan `id_rola` zutabea kendu** | R9 | 🟡 Ertaina | Garapen-ard. | 2 aste |
| **A10** | **Rate limiting hobetu: IP + email konbinatuta, 2FA aukera gehitu** | R10 | 🟡 Ertaina | Garapen-ard. | 2 aste |
| **A11** | **`SameSite=strict` ezarri saio-cookietan** | R11 | 🟡 Ertaina | Garapen-ard. | 2 aste |
| **A12** | **DBEO betetzeko: pribatutasun-politika eta baldintzak orria sortu** | R15 | 🟡 Ertaina | Garapen-ard. | Hilabete 1 |
| **A13** | **Segurtasun-kopia estrategia ezarri: eguneko kopia automatikoak** | R16 | 🟠 Altua | Sistema-adm. | 2 aste |
| **A14** | **Administrazio-ekintzen auditoria-erregistroa gehitu (nor, zer, noiz)** | R17 | 🟡 Ertaina | Garapen-ard. | Hilabete 1 |
| **A15** | **Composer audit eta npm audit egiaztatu, menpekotasunak eguneratu** | — | 🟡 Ertaina | Garapen-ard. | Hilabete 1 |

### 6.1 A4 ekintza: AdminSeeder segurtasun-adabakia

Egungo kodean `AdminSeeder.php` fitxategian pasahitz estatikoa dago:

```php
// ORAINGO EGOERA — ARRISKUTSUA
'pasahitza' => Hash::make('Admin123'),
```

Konponketa:

```php
// KONPONDUTA — .env fitxategitik irakurri
'pasahitza' => Hash::make(env('ADMIN_PASSWORD') 
    ?? throw new \RuntimeException('ADMIN_PASSWORD ez dago ezarrita .env fitxategian')),
```

`.env` fitxategian gehitu:
```
ADMIN_PASSWORD=Z3rb!tz@ri-Seguruag0-2026
```

### 6.2 A3 ekintza: Datu-basearen pasahitza aldatu

```sql
-- PostgreSQL-en exekutatu
ALTER USER admin WITH PASSWORD 'BerriPasahitz@2026!';
```

`.env` fitxategian eguneratu:
```
DB_PASSWORD=BerriPasahitz@2026!
```

---

## 7. Politikak eta jardunbide egokiak

### 7.1 Pasahitzak eta sarbideak

- Gutxienez **12 karaktere**, zerbitzu bakoitzerako desberdinak eta pasahitz-kudeatzaile batean gordeta.
- Ez dira inoiz kodean idazten, ez `Seeder`-etan eta ez `config/` fitxategietan testu garbitan.
- Akatsez partekatzen badira (adib. `Admin123` bezala), **egun berean aldatzen dira**.
- Pertsona bakoitzak bere kontua erabiltzen du, eta behar dituen baimenak bakarrik.

### 7.2 Sekretuak

- `.env` fitxategia **ez da inoiz Git-era igotzen**: `.gitignore`-n egiaztatu (✅ dagoeneko ezarrita).
- `APP_KEY` ez da inoiz beste nonbaitekin partekatzen; aldaketak larrialdi baten seinale dira.
- Ingurune bakoitzak (lokala, zerbitzaria) bere `APP_KEY` eta `DB_PASSWORD` ditu.
- Sekretu bat agerian geratzen bada: **baliogabetu eta ordezkatu**; kodea biltegitik ezabatzea ez da nahikoa.

### 7.3 Garapen segurua

- Aldaketak adar batean egiten dira, eta `main`-era pull request bidez iristen dira.
- Batu aurretik: `php artisan test` berdean. Hedatu aurretik: kode-berrikuspena.
- Zuzendutako ahultasun bakoitzak hura egiaztatzen duen test bat du, berriro ager ez dadin.
- `composer audit` eta `npm audit` erabiliz menpekotasunak berrikusi, gutxienez hilean behin.
- **Lokalean ez erabili benetako ikasleen daturik.**

### 7.4 Eguneratzeak

- **Laravel eta PHP menpekotasunak:** segurtasun-abisuak berrikusi gutxienez hilean behin (`composer audit`).
- **PostgreSQL:** eguneratze ofizialak jarraitu.
- **Node.js menpekotasunak:** `npm audit` hilean behin.

### 7.5 Lan-ekipoak

- Windows eguneratuta, Microsoft Defender aktibo.
- Ez ireki ustekabeko eranskinik edo estekarik; egiaztatu benetako igorlea.
- Email susmagarri oro segurtasun-arduradunari jakinarazten zaio.

### 7.6 Datuen babesa (DBEO eta LOPDGDD)

- Matrikulatzeko beharrezkoak diren datuak bakarrik eskatzen dira (**minimizazioa**): izena, abizenak, emaila.
- Administratzaileek bakarrik ikusten dituzte datu pertsonalak.
- Pribatutasun-politika eta baldintzak webgunean argitaratu behar dira (DBEO betetzeko — **A12 ekintza**).
- Datu pertsonalen segurtasun-urraketa bat **AEPDri jakinarazten zaio, gehienez 72 orduko epean**, eta, arriskua altua bada, eragindakoei ere bai.

---

## 8. Segurtasun-kopiak eta berreskuratzea

| Alderdia | Balioa / Egoera |
|---|---|
| **Zer kopiatzen den** | PostgreSQL `matriculas` datu-basea (pg_dump) eta `.env` fitxategia |
| **Noiz** | **Egunero 03:00etan** (automatikoki — ezartzeke, ikus A13) |
| **Non** | Zerbitzariko `/var/backups/ikastetxea` + kanpoko kopia (3-2-1 araua) |
| **Zenbat denboraz** | 30 egun |
| **Galera maximoa (RPO)** | 24 orduko datuak |
| **Berreskuratze-denbora (RTO)** | Helburua: ordubete baino gutxiago |

> [!WARNING]
> Oraingoz ez dago kopia-estrategiarik ezarrita. **A13 ekintza** lehentasunez gauzatu behar da.

### 8.1 PostgreSQL kopia-komandoak

```bash
# Kopia egitea
pg_dump -U admin -h 127.0.0.1 -p 5432 matriculas \
  | gzip > /var/backups/ikastetxea/matriculas-$(date +%Y%m%d).sql.gz

# Kopia leheneratzea
gunzip -c /var/backups/ikastetxea/matriculas-DATA.sql.gz \
  | psql -U admin -h 127.0.0.1 -p 5432 matriculas
```

### 8.2 Leheneratze-prozedura

1. Aplikazioa mantenantze-moduan jarri: `php artisan down`.
2. Kopia egokia aukeratu: `ls -lh /var/backups/ikastetxea`.
3. Datu-basea leheneratu (ikus goiko komandoa).
4. Aplikazioa berrabiarazi: `php artisan up`.
5. Egiaztatu webgunea kargatzen dela eta saioa has daitekeela.

---

## 9. Gorabeheren kudeaketa

### 9.1 Zer den gorabehera bat

Webgunearen edo datuen **konfidentzialtasuna, osotasuna edo erabilgarritasuna** arriskuan jartzen duen edozein gertaera. Adibidez:
- Webgunea erorita edo aldatuta.
- Inork ezagutzen ez duen sarbide bat ikasteko edo administratzeko.
- `.env` fitxategia, `APP_KEY` edo pasahitzak agerian.
- Filtratutako ikasleen datu pertsonalak.
- `Admin123` bezalako pasahitz ezaguna erabilita sartzeko saiakera.

### 9.2 Zer egin, urratsez urrats

| Fasea | Ekintzak |
|---|---|
| **1. Detektatu** | Segurtasun-arduradunari berehala abisatu. Ordua eta ikusitakoa idatzi. Laravel logak berrikusi (`storage/logs/`). |
| **2. Eutsi** | Datuak arriskuan badaude, webgunea lineatik kendu. Eragindako pasahitzak aldatu (`APP_KEY` barne). Datu-basearen berehalako kopia bat egin. |
| **3. Desagerrarazi** | Kausa aurkitu (ahultasuna, pasahitza, akatsa), zuzendu eta hura detektatuko duen test bat gehitu. |
| **4. Berreskuratu** | Aplikazioa berrabiarazi, behar izanez gero azken kopia ona leheneratu eta test osoa berriz pasatu. |
| **5. Ikasi** | Txostena 5 egunean: zer gertatu zen, nola detektatu zen, zer egin zen eta zer aldatzen den plan honetan. |

### 9.3 Kontaktuak

| Nor | Noiz eta nola |
|---|---|
| Segurtasun-arduraduna | Lehen abisua, edozein gorabeheraren aurrean |
| Sistema-administratzailea | Zerbitzaria eta datu-basea |
| INCIBE (laguntza-lerroa) | **017** telefonoa, doakoa eta konfidentziala |
| INCIBE-CERT | incidencias@incibe-cert.es — enpresen gorabeherak jakinarazteko |
| AEPD | Egoitza elektronikoa (sedeagpd.gob.es) — datu-urraketak, 72 ordu baino lehen |

### 9.4 Gorabeheren erregistroa

Gorabehera bakoitzean hau idazten da: data eta ordua, nork detektatu zuen, deskribapena, eragindako aktiboak eta datuak, egindako ekintzak, AEPDri jakinarazi zitzaion ala ez, kausa eta berriro gerta ez dadin hartutako neurriak.

---

## 10. Prestakuntza eta sentsibilizazioa

- **Taldean sartzean:** plan hau eta 7. ataleko politikak irakurtzea.
- **Hiruhileko bakoitzean:** saio labur bat phishingari, pasahitzei eta segurtasun-berritasunei buruz.
- **Seihileko bakoitzean:** gorabehera-simulakro bat (adibidez, *«adminaren pasahitza agerian geratu da GitHub-en»*), 9. atalari jarraituz.
- **Gorabehera bakoitzaren ondoren:** ikasitakoa talde osoarekin partekatzen da.

---

## 11. Mantentze-egutegia

| Maiztasuna | Zeregina | Arduraduna |
|---|---|---|
| **Egunero (automatikoa)** | Datu-basearen kopia eta log-en errotazioa | Zerbitzaria |
| **Astero** | Egiaztatu datu-basea martxan dagoela, eguneko kopia badagoela, diskoko lekua | Sistema-adm. |
| **Hilero** | `composer audit`, `npm audit`; menpekotasunak eguneratu; segurtasun-testak (`php artisan test`); erabiltzaileak eta sarbideak berrikusi | Sistema-adm. / Garapen-ard. |
| **Hiruhilero** | Leheneratze-proba; ekintza-plana berrikusi; taldearen prestakuntza | Segurtasun-ard. |
| **Seihilero** | Gorabehera-simulakroa; sarbide-arauak berrikusi | Segurtasun-ard. |
| **Urtero** | Planaren berrikuspen osoa eta kanpoko auditoria | Segurtasun-ard. |

---

## 12. Adierazleak

| Adierazlea | Helburua | Nola neurtzen den |
|---|---|---|
| Kritikalidade altuko arriskuak (R1–R6) | 0 — **berehalakoan konpondu** | Ekintza-planaren jarraipena |
| Egiteke dauden segurtasun-adabakiak | Bat ere ez 7 egun baino gehiagoz | `composer audit`, `npm audit` |
| Segurtasun-kopia zuzena duten egunak | %100 | `ls /var/backups/ikastetxea` |
| Leheneratze-probak | 1 hiruhileko bakoitzean, ordubete baino gutxiagoan | Probaren erregistroa |
| Test automatikoak | %100 berdean | `php artisan test` |
| Pasahitz-politika betetzea | %100 (inork ez du `Admin123` edo berdina erabiltzen) | Hileko berrikuspena |
| Detekziotik eusteraino igarotako denbora | Ordubete baino gutxiago | Gorabeheren erregistroa |

---

## 13. Rolak eta erantzukizunak

| Rola | Funtzioak | Pertsona |
|---|---|---|
| **Segurtasun-arduraduna** | Plan hau koordinatu eta berrikusten du; gorabeheren aurreko erantzuna eta prestakuntza zuzentzen ditu | [izena] |
| **Sistema-administratzailea** | Zerbitzaria, datu-basea, eguneratzeak, kopiak eta leheneratzeak | [izena] |
| **Garapen-arduraduna** | Kodea, pull requesten berrikuspenak, testak, menpekotasunak eta hedapenak | [izena] |
| **Datuak babesteko arduraduna** | DBEOa betetzea, ikasleen eskubideak eta urraketen jakinarazpena | [izena] |
| **Talde osoa** | 7. ataleko politikak betetzea eta edozein gorabeheraren berri ematea | Denak |

---

## A eranskina. Egiaztapen-komandoak

### Garapen ingurunean (proiektu-karpetatik)

```bash
# Test guztiak exekutatu
php artisan test

# Menpekotasunen segurtasun-arazoak egiaztatu
composer audit
npm audit

# Konfigurazio-cache garbitu eta egiaztatu
php artisan config:clear
php artisan config:cache

# Laravel logak ikusi
tail -f storage/logs/laravel.log

# Datu-basearen migrazioen egoera
php artisan migrate:status
```

### Segurtasun-egiaztapen zuzenak (kodea aztertu)

```bash
# APP_DEBUG produkzioan false dela egiaztatu
grep "APP_DEBUG" .env

# APP_ENV produkzioan production dela egiaztatu
grep "APP_ENV" .env

# .env Git-etik kanpo dagoela egiaztatu
git check-ignore -v .env

# Pasahitz ahulak bilatu kode-basean
grep -rn "Admin123\|password.*123\|secret.*123" --include="*.php" .
```

### Arrisku kritikoen egiaztapen-zerrenda

```
[ ] APP_DEBUG=false → config/app.php eta .env
[ ] APP_ENV=production → .env
[ ] DB_PASSWORD aldatuta (ez Admin123) → .env
[ ] ADMIN_PASSWORD .env-tik irakurtzen da AdminSeeder-en
[ ] SESSION_ENCRYPT=true → .env
[ ] SESSION_SECURE_COOKIE=true → .env (produkzioan HTTPS behar du)
[ ] php artisan test → dena berdean
[ ] composer audit → 0 ahultasun kritiko
[ ] .env ez dago Git-en → git status egiaztatu
```

---

## B eranskina. Erreferentziak

1. **OWASP Top 10 (2021):** web aplikazioen arrisku ohikoenak — [owasp.org/Top10](https://owasp.org/Top10/)
2. **CIS Benchmarks, Ubuntu Linux eta Docker-erako:** gotortze-gidak — [cisecurity.org](https://www.cisecurity.org/cis-benchmarks)
3. **Laravel Segurtasun-dokumentazioa:** [laravel.com/docs/security](https://laravel.com/docs/security)
4. **INCIBE, «Protege tu empresa»:** enpresentzako zibersegurtasun-gidak eta -tresnak — [incibe.es](https://www.incibe.es/empresas)
5. **Datuak Babesteko Erregelamendu Orokorra (DBEO, EB 2016/679)** eta **3/2018 Lege Organikoa (LOPDGDD)**
6. **AEPD (Agencia Española de Protección de Datos):** [aepd.es](https://www.aepd.es)
7. **Composer Audit:** [getcomposer.org/doc/03-cli.md#audit](https://getcomposer.org/doc/03-cli.md#audit)
8. **NIST Password Guidelines (SP 800-63B):** pasahitz-politikarako erreferentzia

---

*Dokumentu hau 2026ko urriaren 1ean sortua da. Hurrengo berrikuspena: 2027ko urtarrilaren 1a.*
