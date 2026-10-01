# Ikastetxea: webgunearen erabilera eta mantentze gida

Dokumentu honek ikastaroak eta matrikulak kudeatzeko webgunea azaltzen du, lehen aldiz erabiltzen duen pertsona batentzat. Lehen ataletan eguneroko erabilera azaltzen da; ondoren, instalazioa, konfigurazioa eta barneko funtzionamendua.

## Aurkibidea

1. [Proiektuaren helburua eta erabiltzaileak](#1-proiektuaren-helburua-eta-erabiltzaileak)
2. [Lehen urratsak pantailaz pantaila](#2-lehen-urratsak-pantailaz-pantaila)
3. [Webgunearen barruko antolaketa eta teknologiak](#3-webgunearen-barruko-antolaketa-eta-teknologiak)
4. [Aplikazioaren oinarria eta abiaraztea](#4-aplikazioaren-oinarria-eta-abiaraztea)
5. [Ingurunearen doikuntzak: .env fitxategia](#5-ingurunearen-doikuntzak-env-fitxategia)
6. [Informazioa gordetzeko egitura eta mantentzea](#6-informazioa-gordetzeko-egitura-eta-mantentzea)
7. [Itxura, erabilerraztasuna eta mugimendua](#7-itxura-erabilerraztasuna-eta-mugimendua)
8. [Mehatxuak, ondorioak eta babes-neurriak](#8-mehatxuak-ondorioak-eta-babes-neurriak)
9. [PHP kodearen antolaketa eta objektuen erabilera](#9-php-kodearen-antolaketa-eta-objektuen-erabilera)
10. [Egiaztapenak eta ohiko arazoen konponbideak](#10-egiaztapenak-eta-ohiko-arazoen-konponbideak)

## 1. Proiektuaren helburua eta erabiltzaileak

**Ikastetxea** ikastetxe bateko ikastaroak erakusteko, ikasleen sarbidea antolatzeko eta matrikulak kudeatzeko aplikazioa da. Ikasleak ikastaro batean izena eman dezake, eta administratzaileak erabiltzaileak, matrikulak eta plaza libreak kontsulta ditzake.

Webgune bat nabigatzaile baten bidez erabiltzen da, adibidez Firefox, Chrome edo Edge erabiliz. Erabiltzaileak helbide bat irekitzen du, informazioa irakurtzen du eta botoiak edo formularioak erabiltzen ditu. Instalazioa beste norbaitek egin badu, erabiltzaileak webgunearen helbidea besterik ez du behar; ez du programatzen jakin behar.

| Erabiltzailea | Zer egin dezake? |
| --- | --- |
| Bisitaria, saiorik hasi gabe | Ikastaroen izenak, azalpenak, datak eta plaza libreak ikusi. |
| Ikaslea | Aurrez onartutako kontua aktibatu, saioa hasi eta plaza duten ikastaroetan matrikulatu. |
| Administratzailea | Ikasleak aurrez gehitu, erabiltzaileak ikusi, estatistikak kontsultatu eta matrikulak aktibatu edo desaktibatu. |

**Kontua eta matrikula ez dira gauza bera.** Kontuak pertsona identifikatzen du. Matrikulak pertsona hori ikastaro jakin batekin lotzen du. Ikastaro bateko matrikula desaktibatzeak ez du kontua ezabatzen, ezta beste ikastaroetako matrikularik aldatzen ere.

Aplikazio honetan ez dago ikastaroetako edukiak ikasteko plataforma, ordainketa-sistema edo pasahitza automatikoki berreskuratzeko pantailarik. Ez dago ikastaroak sortzeko edo ezabatzeko formulariorik ere; hasierako ikastaroak datuak prestatzeko kodearen bidez sartzen dira.

## 2. Lehen urratsak pantailaz pantaila

### 2.1. Ikastaroak ezagutzea

1. Ireki arduradunak emandako helbidea nabigatzailean.
2. Hasierako orrian, sakatu **Ikastaroak arakatu** edo joan beherantz.
3. Ikastaro bakoitzaren txartelean irakurri izenburua, deskribapena, hasiera-data eta amaiera-data.
4. Begiratu **Plaza libreak** eremua. Adibidez, `12 / 30` agertzeak 30 plazatik 12 libre daudela esan nahi du.
5. Izena emateko, saioa hasi behar da.

### 2.2. Ikasle-kontua lehen aldiz aktibatzea

Erregistroa ez da edonorentzako alta librea: **administratzaileak zure helbide elektronikoa aurrez gehitu behar du**.

1. Eskatu administratzaileari ikasle gisa gehitzeko.
2. Sakatu **Erregistratu**.
3. Idatzi administratzaileari emandako helbide elektroniko bera.
4. Aukeratu gutxienez 8 karaktereko pasahitza.
5. Idatzi pasahitz bera baieztapen-eremuan.
6. Sakatu **Kontua aktibatu**.
7. Erregistroa ondo amaitzen bada, joan saioa hasteko pantailara.

Administratzaileak sortutako ikaslea hasieran ez dago aktibo eta ez du pasahitzik. Erregistroa osatzean aktibatzen da. Dagoeneko erregistratuta dagoen kontu batek ezin du formulario hau erabili pasahitza aldatzeko.

### 2.3. Saioa hastea eta ikastaro batean matrikulatzea

1. Sakatu **Saioa hasi**.
2. Idatzi helbide elektronikoa eta pasahitza.
3. Saioa hasi ondoren, ikaslea ikastaroen orrira iristen da.
4. Aukeratu ikastaro bat eta sakatu **Matrikulatu**.
5. Eragiketa ondo badoa, baieztapen-mezua eta **Matrikulatuta zaude** etiketa agertuko dira.

| Pantailako mezua | Esanahia eta hurrengo urratsa |
| --- | --- |
| Matrikulatuta zaude | Dagoeneko matrikula aktiboa duzu; ez duzu berriro izena eman behar. |
| Plazak agortuta | Ez dago plaza librerik une horretan. |
| Matrikula ez dago aktibo | Administratzailearekin harremanetan jarri behar duzu berriz aktibatzeko. |
| Hasi saioa matrikulatzeko | Identifikatu behar duzu matrikula egin aurretik. |

Ikasle batek hainbat ikastarotan eman dezake izena, baina ezin du ikastaro berean bi matrikula izan. Ikastaro bakoitzeko gehieneko edukiera 30 da; gordetako edukiera txikiagoa bada, aplikazioak muga txikiagoa erabiltzen du.

Amaitzean sakatu **Saioa itxi**, batez ere ordenagailua beste pertsona batzuekin partekatzen baduzu.

### 2.4. Administratzailearen lana

Administratzaileak saioa hasten duenean administrazio-panelera sartzen da.

**Ikasle berria gehitzeko:**

1. Sakatu **Ikaslea gehitu**.
2. Bete izena, abizenak eta helbide elektronikoa.
3. Sakatu formularioko **Ikaslea gehitu** botoia.
4. Jakinarazi ikasleari bere helbidearekin erregistra daitekeela. Uneko aplikazioak ez du gonbidapen-mezu automatikorik bidaltzen.

**Matrikula kudeatzeko:**

1. Joan **Ikastaroak eta ikasleak** atalera.
2. Bilatu ikastaroa eta dagokion ikaslea.
3. Sakatu **Desaktibatu** plaza askatzeko.
4. Sakatu **Aktibatu** matrikula berriz indarrean jartzeko.

Berraktibatzeko, ikaslearen kontuak aktibo egon behar du eta ikastaroak plaza libre bat izan behar du. Matrikula desaktibatuta ere, jatorrizko matrikula-data gordetzen da.

**Estatistikak ulertzeko:**

| Adierazlea | Zer zenbatzen du? |
| --- | --- |
| Ikasleak guztira | Ikasle rola duten erabiltzaileak, administratzaileak kontatu gabe. |
| Ikasle aktiboak | Aktibo dauden ikasle-kontuak. |
| Matrikula aktiboak | Ikastaro guztietako matrikula aktiboak; pertsona batek bat baino gehiago izan ditzake. |
| Plaza libreak | Ikastaroetako edukieraren eta matrikula aktiboen arteko aldea. |
| Ikastaroen okupazioa | Ikastaro bakoitzeko plaza beteak, edukiera eta ehunekoa. |

Datuak orria kargatzean kalkulatzen dira. Beste pertsona batek aldaketak egin baditu, freskatu orria datu berriak ikusteko.

## 3. Webgunearen barruko antolaketa eta teknologiak

Erabiltzaileak ikusten duen zatia **nabigatzailean** dago. Eskaerak prozesatzen dituen zatia **zerbitzarian** exekutatzen da. Datu iraunkorrak **datu-basean** gordetzen dira.

```text
Nabigatzailea: erabiltzaileak "Matrikulatu" sakatzen du
    |
Laravel ibilbidea: eskaera dagokion kontrolatzailera bideratzen du
    |
Sarbide-kontrola eta kontrolatzailea: baimenak eta plaza libreak egiaztatzen ditu
    |
Eloquent modeloa eta datu-basea: matrikula gordetzen dute
    |
PHP ikuspegia: emaitza erakusten du nabigatzailean
```

Proiektuak MVC antolaketa erabiltzen du: **modeloak** datuekin aritzen dira, **ikuspegiek** pantailak sortzen dituzte eta **kontrolatzaileek** eskaerak koordinatzen dituzte.

Bertsio hauek proiektuko `composer.json` eta `package.json` fitxategietako eskakizunak dira.

| Tresna | Eginkizuna |
| --- | --- |
| PHP `^8.2` | Zerbitzariko programazio-lengoaia. |
| Laravel `^12.0` | Ibilbideak, saioak, baliozkotzea, datu-sarbidea eta aplikazioaren egitura. |
| Eloquent | PHP modeloen bidez datu-baseko taulak eta erlazioak erabiltzea. |
| SQLite | `.env.example` fitxategian proposatutako datu-basea; fitxategi batean gordetzen ditu datuak. |
| HTML eta CSS | Pantailen edukia, diseinua, egokitzapena eta animazioak. |
| Composer | PHP mendekotasunak instalatzea. |
| Vite `^7.0.7` eta npm | Garapenerako CSS eta JavaScript baliabideak prestatzea. |
| Tailwind CSS `^4.0.0` | Baliabideak eraikitzeko konfigurazioan dagoen CSS tresna. |
| Axios `^1.11.0` | JavaScript bidez HTTP eskaerak egiteko prestatutako liburutegia. |
| PHPUnit `^11.5.50` | Proba automatizatuak. |
| Laravel Pint | PHP kodearen estiloa egiaztatzeko tresna. |

Uneko pantaila nagusiek `public/css/administrazioa.css` zuzenean kargatzen dute. Vite, Tailwind eta Axios proiektuan konfiguratuta egoteak ez du esan nahi pantaila horiek tresna guztiak erabiltzen dituztenik.

### Fitxategi nagusiak

| Kokapena | Edukia |
| --- | --- |
| `routes/web.php` | Web helbideak eta eskaerak prozesatzeko loturak. |
| `app/Http/Controllers/` | Saioa, erregistroa, ikasleak, ikastaroak eta matrikulak kudeatzeko logika. |
| `app/Http/Middleware/AdminOnly.php` | Administrazio-eragiketen sarbide-kontrola. |
| `app/Models/` | Erabiltzailea, Rola, Ikastaroa eta Matrikula modeloak. |
| `resources/views/` | Pantailen PHP txantiloiak eta partekatutako osagaiak. |
| `public/css/administrazioa.css` | Webgunearen estilo nagusia. |
| `resources/js/` eta `resources/css/` | Viterako JavaScript eta CSS sarrerak. |
| `database/migrations/` | Taulak eta haien aldaketak definitzen dituen kodea. |
| `database/seeders/` | Hasierako adibide-datuak sortzeko kodea. |
| `config/ikastetxea.php` | Ikastetxearen izena eta kontaktu-datuen konfigurazioa. |
| `tests/Feature/` | Funtzionamenduaren proba automatizatuak. |
| `.env.example` | Ingurunearen konfiguraziorako eredua, kopiatzeko prestatua. |

`/login.php` bezalako helbideak Laravelek kudeatutako ibilbideak dira. Ez dira erabiltzaileak zuzenean ireki behar dituen disko lokaleko PHP fitxategiak.

## 4. Aplikazioaren oinarria eta abiaraztea

Atal hau webgunea ordenagailuan prestatu behar duen pertsonarentzat da. Dagoeneko martxan dagoen webgunea erabiltzeko, ez da instalazio hau egin behar.

### 4.1. Aurretik behar dena

Prestatu PHP 8.2 edo proiektuaren mendekotasunekin bateragarria den bertsioa, Composer eta SQLite erabiltzeko PHP hedapenak, bereziki `pdo_sqlite` eta `sqlite3`. Viteren baliabideak landu behar badira, Node.js eta npm ere behar dira; Node bertsioak instalatutako Viteren eskakizunak bete behar ditu.

**Terminala** komandoak idazteko leihoa da; Windowsen PowerShell erabil daiteke. Ireki terminala proiektuaren `web` karpetan, `artisan` eta `composer.json` dauden tokian. Exekutatu komandoak banan-banan.

### 4.2. PHP mendekotasunak instalatzea

```powershell
composer install
```

Komandoak proiektuak behar dituen PHP paketeak `vendor` karpetan instalatzen ditu.

### 4.3. Konfigurazioa eta datu-basea prestatzea

Lehen instalazioan, sortu `.env` fitxategia eredutik, lehendik badago gainidatzi gabe:

```powershell
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
```

Egiaztatu `.env` fitxategian `DB_CONNECTION=sqlite` dagoela. Jarraibide hauek SQLite erabiltzen dute.

Sortu datu-basearen fitxategia falta bada:

```powershell
if (-not (Test-Path database/database.sqlite)) { New-Item -ItemType File -Path database/database.sqlite }
```

Instalazio berrian, `APP_KEY` hutsik badago, sortu aplikazioaren gakoa:

```powershell
php artisan key:generate
```

Ondoren, sortu taulak eta adibide-datuak:

```powershell
php artisan migrate --seed
```

Migrazioek taulen egitura prestatzen dute. Seederrak hasierako datuak gehitzen ditu: administratzaile bat, sei ikasle eta lau ikastaro. Ikasleen adibide-kontuek ez dute hasierako pasahitzik; erregistroa osatu behar dute.

### 4.4. Webgunea irekitzea

```powershell
php artisan serve
```

Ireki terminalak erakusten duen helbidea; normalean `http://127.0.0.1:8000` da. Utzi terminala martxan webgunea erabiltzen duzun bitartean. Gelditzeko, sakatu `Ctrl+C`.

Adibide-datuak sortu berri badira, administratzailearen sarbidea hau da:

| Eremua | Garapeneko adibide-balioa |
| --- | --- |
| Helbide elektronikoa | `admin@example.com` |
| Pasahitza | `Admin123` |

Datu horiek `AdminSeeder.php` fitxategiko proba-balio publikoak dira, ez `.env` fitxategitik hartutako sekretuak. Benetako zerbitzu batean, administratzaile-kontu hori pasahitz propio batekin prestatu behar da. Seederra berriz exekutatzeak ez du lehendik dagoen kontuaren pasahitza aldatzen.

### 4.5. CSS eta JavaScript baliabideak lantzea

Viteren baliabideekin lan egiteko:

```powershell
npm install
npm run build
```

Garapenean, `npm run dev` exekuta daiteke beste terminal batean. Uneko pantaila nagusiek CSS publikoa zuzenean erabiltzen dutenez, haien oinarrizko erabilerak ez du Vite martxan edukitzea eskatzen.

### 4.6. Oinarrizko aplikazioaren piezak

Aplikazioaren funtzionamendua urrats hauetan oinarritzen da: taulak migrazioekin definitzea, modeloen erlazioak ezartzea, kontrolatzaileetan arauak aplikatzea, ibilbideak lotzea eta ikuspegietan emaitza erakustea.

| Ibilbidea | Eginkizuna |
| --- | --- |
| `GET /` eta `GET /index.php` | Ikastaroen katalogoa. |
| `GET /login.php` eta `POST /login.php` | Saio-hasierako formularioa eta egiaztapena. |
| `GET /erregistratu.php` eta `POST /erregistratu.php` | Aurrez gehitutako ikaslearen kontua aktibatzea. |
| `GET /administrazioa.php` | Administrazio-panela; administratzaileentzat. |
| `POST /ikasleak` | Ikaslea aurrez gehitzea; administratzaileentzat. |
| `POST /ikastaroak/{ikastaroa}/matrikulatu` | Saioa hasita duen ikasle aktiboa matrikulatzea. |
| `PATCH /matrikulak/{matrikula}` | Matrikula aktibatzea edo desaktibatzea; administratzaileentzat. |
| `POST /irten` | Saioa ixtea. |
| `GET /nagusia.php` | Administrazio-ibilbidera birbideratzea. |

`GET` informazioa eskatzeko erabiltzen da; `POST`, datuak bidaltzeko; eta `PATCH`, dagoen datu bat aldatzeko. Erabiltzaileak botoiak sakatzen ditu, eta formularioek eskaera horiek prestatzen dituzte.

## 5. Ingurunearen doikuntzak: .env fitxategia

`.env` proiektuaren erroan dagoen testu-fitxategia da. Ordenagailu edo zerbitzari bakoitzaren ezarpenak gordetzen ditu: aplikazioaren helbidea, datu-basea, saioen konfigurazioa eta gakoak.

Lerro bakoitzak `IZENA=balioa` itxura du. Zuriuneak dituzten testuak komatxo artean jarri behar dira. `#` ikurrarekin hasten den lerroa iruzkina da.

`.env.example` partekatzeko eredua da; `.env`, berriz, instalazio bakoitzaren konfigurazioa. Proiektuko `.gitignore` fitxategiak `.env` baztertzen du Git-en ohiko jarraipenetik. Ez partekatu bere edukia pasahitzak edo gakoak baditu; aurrez Git-en gordetako sekretuak ez dira desagertzen `.gitignore` gehitze hutsarekin.

### 5.1. Tokiko konfigurazioaren adibidea

Hurrengoa adibide bat da, ez instalazio honetako `.env` fitxategiaren kopia. Lehendik dagoen fitxategian dagokion lerroa editatu; ez sortu aldagai beraren kopia anitz.

```dotenv
APP_NAME=Ikastetxea
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

`APP_KEY` hutsik agertzen da adibidean, baina instalazioan `php artisan key:generate` komandoak bete behar du. Ez hustu edo aldatu dagoeneko erabiltzen ari den aplikazio baten gakoa.

| Aldagaia | Zertarako da? |
| --- | --- |
| `APP_NAME` | Aplikazioaren konfigurazioko izena. Ez ditu txantiloietako testu finko guztiak automatikoki aldatzen. |
| `APP_ENV` | Ingurunea identifikatzen du: adibidez, `local` edo `production`. |
| `APP_KEY` | Laravelen zifratze-eragiketetarako gakoa. |
| `APP_DEBUG` | Erroreen xehetasun teknikoak erakusten ditu `true` denean. Argitaratutako zerbitzuan `false` izan behar du. |
| `APP_URL` | Aplikazioaren oinarrizko helbidea; ez du zerbitzaria berez abiarazten. |
| `DB_CONNECTION` | Erabiliko den datu-base mota. Gida honetan `sqlite`. |
| `DB_DATABASE` | SQLite fitxategiaren bidea, lehenetsitakoa aldatu behar bada. |
| `SESSION_DRIVER` | Saioa non gordetzen den; `database` balioarekin `sessions` taulan. |
| `SESSION_LIFETIME` | Saioaren jarduerarik gabeko iraupena, minututan. |
| `SESSION_ENCRYPT` | Gordetako saioaren edukia zifratzeko aukera; adibidean desgaituta dago. |
| `CACHE_STORE` | Aldi baterako datuen eta saiakera-mugen biltegia. |
| `QUEUE_CONNECTION` | Atzeko planoko lanen biltegia; oinarrizko matrikulazioak ez du ilara-langilerik behar. |
| `MAIL_MAILER` | Posta bidaltzeko modua. `log` balioak erregistroan idazten du, benetako posta bidali gabe. |
| `APP_LOCALE` | Laravelen hizkuntza lehenetsia. Uneko pantailen testu gehienak euskaraz idatzita daude txantiloietan. |

`DB_DATABASE` zehazten ez bada, proiektuaren konfigurazioak `database/database.sqlite` erabiltzen du. MySQL aukeratuz gero, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` eta `DB_PASSWORD` konfiguratu eta datu-basea prestatu behar dira. Halako aldaketak aparte egiaztatu behar dira, matrikulazioaren konkurrentzia-kodean SQLite kontuan hartu baita.

### 5.2. Ikastetxearen kontaktu-datuak

`config/ikastetxea.php` fitxategiak aldagai hauek irakurtzen ditu. Ez daude guztiak jatorrizko `.env.example` fitxategian; behar izanez gero `.env` fitxategian gehi daitezke.

```dotenv
SCHOOL_NAME=Ikastetxea
SCHOOL_ADDRESS="Ikaskuntza kalea 12, 20600 Eibar, Gipuzkoa"
SCHOOL_EMAIL=uni@example.com
SCHOOL_DEMO_CONTACT=true
SCHOOL_INSTAGRAM=https://example.com/instagram
SCHOOL_LINKEDIN=https://example.com/linkedin
SCHOOL_FACEBOOK=https://example.com/facebook
```

Balio horiek orri-oineko izena, helbidea, posta eta sare sozialen estekak kontrolatzen dituzte. `SCHOOL_DEMO_CONTACT=true` balioak datuak adibidezkoak direla adierazten duen oharra erakusten du. Benetako kontaktuak jarri ondoren, `false` erabil daiteke.

Sare sozialen esteketan HTTP edo HTTPS helbide baliozkoak soilik erakusten dira. Orri-oineko izena aldatzeak ez du goiburuko `IKASTETXEA` testu finkoa automatikoki aldatzen.

### 5.3. Aldaketak aplikatzea

Konfigurazioa aldatu ondoren, garapen-ingurunean exekutatu:

```powershell
php artisan config:clear
```

Behar izanez gero berrabiarazi garapen-zerbitzaria. `.env.example` fitxategian Redis edo AWS aldagaiak agertzeak ez du esan nahi zerbitzu horiek oinarrizko webgunea erabiltzeko behar direnik.

## 6. Informazioa gordetzeko egitura eta mantentzea

Datu-basea informazioa antolatuta gordetzen duen biltegia da. **Taula** antzeko datuen multzoa da; **errenkada** elementu bat da; eta **IDa** elementua bereizteko identifikatzailea.

| Taula | Gordetzen duen informazioa |
| --- | --- |
| `rolak` | Rolaren IDa, izena eta azalpena; adibidez, `admin` eta `ikasleak`. |
| `erabiltzaileak` | Izena, abizenak, email bakarra, pasahitzaren hash-a, rola eta kontuaren egoera. |
| `ikastaroak` | Izenburua, deskribapena, edukiera eta hasiera- eta amaiera-datak. |
| `matrikulak` | Ikaslearen IDa, ikastaroaren IDa, matrikula-data eta egoera. |
| `sessions` | Erabiltzaileen saioen informazioa. |
| `cache` eta `cache_locks` | Aldi baterako datuak eta cache-blokeoak. |
| `jobs`, `job_batches` eta `failed_jobs` | Atzeko planoko lanen azpiegitura. |

Erlazioak honela ulertzen dira: rol batek erabiltzaile asko izan ditzake; erabiltzaile batek matrikula asko; eta ikastaro batek matrikula asko. `matrikulak` taulak ikaslea eta ikastaroa lotzen ditu.

**Osotasuna zaintzeko arauak:**

- Email bera ezin da bi erabiltzaile desberdinetan errepikatu.
- Ikasle eta ikastaro bikote bakoitzeko matrikula bakarra onartzen da.
- Kanpoko gakoek matrikularen erabiltzailea eta ikastaroa existitzen direla kontrolatzen dute.
- Erabiltzaile edo ikastaro bat datu-basean ezabatuz gero, lotutako matrikulak ere ezabatzen dira. Web interfazeak ez du ezabaketa hori eskaintzen.
- Matrikula berria edo berraktibazioa transakzio batean kudeatzen da: lotutako egiaztapenak eta aldaketak eragiketa bateratu gisa egiten dira.
- Plaza-kontaketak matrikula aktiboak soilik hartzen ditu kontuan.

### Mantentzeko komandoak

```powershell
php artisan migrate:status
php artisan migrate
```

Lehen komandoak aplikatutako migrazioak erakusten ditu; bigarrenak falta direnak aplikatzen ditu. Adibide-datuak gehitzeko `php artisan db:seed` erabil daiteke garapen-ingurunean. Uneko seederrek dauden adibide-erregistroak bilatzen dituzte, bikoiztu edo ikasleen pasahitzak berridatzi gabe.

Ez erabili `php artisan migrate:fresh` datuak mantendu behar diren instalazio batean: taulak ezabatzen ditu.

SQLite-ren babeskopia egiteko, gelditu idazketak eta itxi datu-basearen konexioak fitxategia kopiatu aurretik, edo erabili SQLite-rekin bateragarria den babeskopia-tresna. Gorde kopia beste kokapen batean. `.env` eta aplikazioaren gakoa ere modu pribatuan gorde behar dira berreskuratze oso baterako.

## 7. Itxura, erabilerraztasuna eta mugimendua

**UI** erabiltzaileak ikusten duen interfazea da: botoiak, testuak, taulak eta koloreak. **UX** erabiltzeko esperientzia da: hurrengo urratsa ulertzea, akatsak zuzentzea eta egindako ekintzaren emaitza ezagutzea.

### Diseinua eta irisgarritasuna

- Ikastaroak txarteletan agertzen dira, informazioa erraz alderatzeko.
- Administrazio-panelak erabiltzaile-taula, estatistikak eta okupazio-barrak ditu.
- Diseinua pantailaren zabalerara egokitzen da, bereziki 850 eta 600 pixeleko CSS arauen bidez.
- Taula luzeek korritze-eremua eta ikusgai mantentzen diren zutabe-goiburuak dituzte.
- Formularioek etiketak eta euskarazko errore-mezuak dituzte.
- Egoerak testuz azaltzen dira, koloreaz gain.
- `role="alert"`, `role="status"` eta `aria-label` atributuek laguntza-teknologiei informazioa ematen diete.

Neurri horiek kodean daude, baina ez dira irisgarritasun-auditoria oso baten baliokide.

### Animazioak

`public/css/administrazioa.css` fitxategiak botoien trantsizioak, ikastaro-txartelen mugimendu txikia eta ikasle berria gehitzean agertzen den nabarmentzea definitzen ditu.

Taularen sarrera-animazioak 0,45 segundo irauten du; ikasle berriaren errenkadaren nabarmentzeak, 3 segundo. Sistemaren mugimendu murriztuaren hobespena aktibatuta badago, `prefers-reduced-motion` arauek animazio horiek desgaitzen dituzte.

### JavaScript-en benetako erabilera

`resources/js/app.js` fitxategiak `bootstrap.js` inportatzen du, eta azken horrek Axios prestatzen du. Hala ere, uneko katalogo-, saio-, erregistro- eta administrazio-pantailek ez dute JavaScript sorta hori kargatzen.

Matrikulak eta formularioak zerbitzarira bidaltzen dira, eta emaitza orria berriz kargatuta erakusten da. Animazioak CSS bidez egiten dira. Etorkizunean JavaScript bidez bilaketa edo iragazkiak gehitu litezke, baina ez dira egungo funtzioak.

## 8. Mehatxuak, ondorioak eta babes-neurriak

Ondoko taula kodearen irakurketan oinarritutako arriskuen orientazioa da, ez segurtasun-auditoria formal bat. Lehentasunak orientagarriak dira.

| Arriskua | Lehentasuna | Balizko ondorioa | Uneko babesa edo egiteke dagoena |
| --- | --- | --- | --- |
| Aurrez gehitutako ikaslearen kontua beste norbaitek aktibatzea | Handia | Beste pertsona batek ikaslearen nortasuna erabiltzea. | Aurretiko alta behar da, baina ez dago emailaren jabetza egiaztatzeko estekarik. Egiaztapen hori gehitzea hobekuntza garrantzitsua da. |
| Adibideko administratzaile-pasahitza mantentzea | Handia | Administrazioan baimenik gabe sartzea. | Seederreko sarbidea publikoa da; benetako instalazioan ordeztu behar da. |
| Administrazio-eragiketak baimenik gabe egitea | Handia | Ikasleen datuak ikustea edo matrikulak aldatzea. | `AdminOnly` middlewareak administratzaile-rola egiaztatzen du. |
| Pasahitzak asmatzeko saiakera errepikatuak | Ertaina | Kontu batera sartzea. | Saio-hasierak email/IP konbinazioaren araberako muga du: bost huts egindako saiakera eta 60 segundoko muga-leihoa. Erregistroak ere IP bidezko muga du. |
| Beste webgune batetik formulario faltsuak bidaltzea, CSRF | Handia | Erabiltzailearen saioarekin nahi gabeko aldaketak egitea. | Formularioek CSRF tokena daramate eta web middlewarearen babesa erabiltzen dute. |
| Sartutako testua kode gisa exekutatzea, XSS | Handia | Nabigatzaileko edukia manipulatzea. | Ikuspegiek datu dinamikoak `e()` bidez ihes egiten dituzte; kontaktu-estekak iragazten dira. |
| SQL kontsultak manipulatzea | Handia | Datuak irakurtzea edo aldatzea. | Eloquent eta Query Builder erabiltzen dira parametroekin; dagoen SQL adierazpen gordina konstantea da. |
| Azken plaza aldi berean bi pertsonari ematea | Ertaina | Edukiera gainditzea. | Transakzioak, SQLite-rako idazketa-blokeoa eta zerbitzariko plaza-egiaztapena erabiltzen dira. |
| `.env` edo erroreen xehetasunak publikoki erakustea | Handia | Gakoak edo barneko informazioa zabaltzea. | `.env` Git-etik baztertuta dago; argitaratzean `APP_DEBUG=false` eta web erroa `public/` izan behar dira. |
| Datu-basea galtzea | Handia | Kontuak eta matrikulak galtzea. | Kanpoko babeskopiak behar dira; proiektuan ez da babeskopia automatizaturik definitzen. |
| Konexioa edo partekatutako saioa behar bezala ez babestea | Handia | Kontuko informazioa agerian geratzea. | Saioa hastean saio-IDa berritzen da eta irtetean saioa baliogabetzen da; argitalpenak HTTPS behar du. |

Ikasleak administrazio-helbidera sartzen saiatzen badira, uneko middlewareak saioa ixten du eta saio-hasierara bidaltzen ditu. Ez da nahikoa administrazio-botoia ezkutatzea: baimena zerbitzarian egiaztatzen da.

## 9. PHP kodearen antolaketa eta objektuen erabilera

**Objektuetara zuzendutako programazioak (OZP)** datuak eta haien portaera klaseen bidez antolatzen ditu. Klasea molde bat da; objektua, molde horretatik lortutako elementu zehatza. Adibidez, `Ikastaroa` klaseak ikastaroen eredua ematen du, eta datu-baseko ikastaro zehatz bat haren objektu bat da.

### Proiektuko adibideak

| Oinarria | Nola agertzen da kodean? |
| --- | --- |
| Klaseak | `Erabiltzailea`, `Ikastaroa`, `Matrikula` eta `Rola` klaseek arloko kontzeptuak adierazten dituzte. |
| Herentzia | Modeloek Laravelen `Model` edo `Authenticatable` klaseak hedatzen dituzte. |
| Kapsulatzea | `protected` propietateek taula, eremu betegarriak eta ezkutuko datuak definitzen dituzte. |
| Abstrakzioa | Eloquent erabilita ez da eragiketa bakoitzerako SQL eskuz idatzi behar. |
| Metodoak eta erlazioak | `rola()`, `matrikulak()` edo `ikastaroa()` metodoek objektuen arteko loturak adierazten dituzte. |
| Portaera egokitzea | `getAuthPasswordName()` metodoak autentifikazioa `pasahitza` zutabera egokitzen du. |
| Arduren banaketa | Kontrolatzaileek eskaerak kudeatzen dituzte; modeloek datuak; ikuspegiek aurkezpena; middlewareak sarbidea. |

`Ikastaroa::MAX_CAPACITY` konstanteak 30eko gehieneko edukiera zentralizatzen du. Horrela, arau bera hainbat tokitan zenbaki solte gisa errepikatzea saihesten da.

### Kodean aplikatutako praktikak

- Erabiltzailearen datuak zerbitzarian baliozkotzen dira, nabigatzaileko egiaztapenez gain.
- Emailak normalizatzen dira: inguruko zuriuneak kentzen dira eta letra xehez gordetzen dira.
- Pasahitzak `Hash::make()` bidez hash bihurtzen dira; ez dira testu arruntean gordetzen.
- `$fillable` zerrendek modeloak multzoka bete ditzakeen eremuak mugatzen dituzte; horrek ez du baliozkotzea ordezten.
- `$hidden` propietateak pasahitza modeloaren array/JSON irteeran ezkutatzen du.
- `bootstrap/app.php` fitxategiak pasahitz-eremuak baliozkotze-akatsen ondorengo aldi baterako sarreratik baztertzen ditu.
- Erlazioak aurrez kargatzen dira behar denean, adibidez `with('matrikulak.erabiltzailea')` bidez.
- Baimenak eta plaza libreak kontrolatzaileetan edo middlewarean egiaztatzen dira, ikuspegiko botoiez aparte.

Proiektuan `User.php` ereduzko modeloa ere badago, baina `config/auth.php` fitxategiak lehenespenez `Erabiltzailea` hautatzen du autentifikaziorako. Dokumentazioak benetan erabiltzen den eredu hori azaltzen du.

Egitura horrek mantentzea errazten du; ez du esan nahi kodea hobetu ezin denik. Adibidez, baliozkotze-arauak handituz gero, eskaera-klase bereizietan antola litezke.

## 10. Egiaztapenak eta ohiko arazoen konponbideak

### Funtzionamendua eskuz egiaztatzea

1. Ireki katalogoa saiorik hasi gabe: ikastaroak ikusi behar dira.
2. Hasi saioa administratzaile gisa eta gehitu probako ikasle bat.
3. Itxi saioa eta aktibatu ikaslearen kontua erregistro-pantailan.
4. Hasi saioa ikasle gisa eta matrikulatu ikastaro batean.
5. Egiaztatu baieztapena agertzen dela eta plaza libreak bat gutxitu direla.
6. Sartu berriz administratzaile gisa eta desaktibatu matrikula.
7. Egiaztatu plaza berreskuratu dela eta ikaslearen kontua mantentzen dela.

### Proba automatizatuak

Proiektuko probak exekutatzeko:

```powershell
php artisan test
```

`phpunit.xml` fitxategiak memoriako SQLite datu-basea konfiguratzen du probetarako. Probak sarbideak, erregistroa, matrikulen egoerak, 30 plazako muga, estatistikak eta orri-oina egiaztatzeko daude.

PHP estiloa fitxategiak aldatu gabe egiaztatzeko:

```powershell
vendor/bin/pint --test
```

Komando horiek mantentze-lanetarako jarraibideak dira; gida honek ez du probak azken exekuzioan gainditu direla ziurtatzen.

### Arazo arruntak

| Arazoa | Zer egin? |
| --- | --- |
| Webgunearen helbidea ez da irekitzen | Egiaztatu zerbitzaria martxan dagoela eta terminalak adierazitako helbidea erabiltzen ari zarela. |
| `php` edo `composer` ez da ezagutzen | Egiaztatu tresna instalatuta dagoela eta terminalaren PATH konfigurazioan dagoela. |
| `vendor/autoload.php` falta da | Exekutatu `composer install` proiektuaren karpetan. |
| Aplikazioaren gakoa falta da | Instalazio berrian, sortu `.env` eta exekutatu `php artisan key:generate`. |
| `could not find driver` | Egiaztatu PHPk SQLite-rako behar dituen hedapenak aktibatuta dituela. |
| `no such table` | Egiaztatu datu-basearen bidea eta aplikatu migrazioak. |
| Erregistroa ezin da osatu | Egiaztatu administratzaileak email hori gehitu duela eta kontua ez dagoela aurretik erregistratuta. |
| Pasahitza ahaztu da | Jarri harremanetan arduradunarekin; ez dago berreskuratze automatikoko pantailarik. |
| Saiakera gehiegi egin dira | Itxaron pantailako mezuak adierazitako denbora eta berriz saiatu. |
| 419 errorea edo iraungitako formularioa | Freskatu orria eta hasi saioa berriro beharrezkoa bada. |
| `.env` aldatu arren ez da emaitza ikusten | Exekutatu `php artisan config:clear` eta, beharrezkoa bada, berrabiarazi zerbitzaria. |
| Matrikula ezin da berraktibatu | Egiaztatu ikaslearen kontua aktibo dagoela eta plaza libreak daudela. |

Xehetasun teknikoak behar direnean, arduradunak `storage/logs/laravel.log` azter dezake, lehenetsitako log konfigurazioa erabiltzen bada. Ez argitaratu erregistro osoa datu pertsonalak edo barneko informazioa berrikusi gabe.
