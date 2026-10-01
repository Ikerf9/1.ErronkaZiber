# Webgunea abiaraztea

Proiektua exekutatzeko, lehenengo terminala **proiektuaren karpetan** kokatu behar da.

Web zerbitzaria abiarazteko **bi aukera** daude:

## Laragon terminaletik

Laragon-en terminala erabiltzen bada, komando hau exekutatu:

```bash
C:\php\php.exe artisan serve
```

## Visual Studio Code terminaletik

Visual Studio Code-ko terminala erabiltzen bada, komando hau exekutatu:

```bash
php artisan serve
```

Dena ondo badago, Laravel zerbitzaria abiaraziko da eta normalean helbide honetan egongo da erabilgarri:

```text
http://127.0.0.1:8000
```

Ondoren, helbide hori nabigatzailean ireki webgunera sartzeko.

# Ikastetxea: webgunearen gida

Ikastetxea webguneak ikastaroak kontsultatzeko eta matrikulak kudeatzeko aukera ematen du. Gida honetan haren helburua, erabilera eta ezaugarri nagusiak azaltzen dira.

## 1. Webgunearen helburua

Webgunearen helburua ikastetxeko ikastaroen informazioa eta izen-ematea toki berean biltzea da. Ikasleek eskaintza ikusi eta interesatzen zaizkien ikastaroetan matrikula egin dezakete. Administratzaileak, berriz, ikasleen altak eta matrikulen egoera kudeatzen ditu.

Hiru erabiltzaile mota bereizten dira:

| Erabiltzailea | Aukerak |
| --- | --- |
| Bisitaria | Ikastaroak, datak eta plaza libreak kontsultatzea. |
| Ikaslea | Kontua aktibatzea, saioa hastea eta ikastaroetan matrikulatzea. |
| Administratzailea | Ikasleak gehitzea, erabiltzaileak kontsultatzea eta matrikulak kudeatzea. |

## 2. Webgunea erabiltzeko urratsak

### Ikastaroak kontsultatzea

Hasierako orrian ikastaroen eskaintza agertzen da. Ikastaro bakoitzak izena, azalpen laburra, hasiera- eta amaiera-datak eta plaza libreen kopurua erakusten ditu.

Informazio hori saioa hasi gabe ikus daiteke. Matrikulatzeko, ordea, ikasle-kontu aktiboa behar da.

### Kontua aktibatzea

Ikaslea erregistratu aurretik, administratzaileak haren izena, abizenak eta helbide elektronikoa gehitu behar ditu.

1. Sakatu **Erregistratu**.
2. Idatzi administratzaileari emandako helbide elektronikoa.
3. Aukeratu gutxienez zortzi karaktereko pasahitza eta errepikatu baieztatzeko.
4. Sakatu **Kontua aktibatu**.

Erregistroa osatu ondoren, ikasleak bere kontuarekin saioa has dezake.

### Saioa hastea eta matrikulatzea

1. Sakatu **Saioa hasi** eta sartu helbide elektronikoa eta pasahitza.
2. Aukeratu interesatzen zaizun ikastaroa.
3. Plaza libreak badaude, sakatu **Matrikulatu**.
4. Egiaztatu **Matrikulatuta zaude** mezua agertzen dela.

Ikasle batek hainbat ikastarotan eman dezake izena, baina ikastaro berean behin bakarrik. Ikastaro bakoitzak gehienez 30 plaza ditu.

**Plazak agortuta** agertzen bada, ezin da matrikula berririk egin. **Matrikula ez dago aktibo** agertzen bada, administratzailearekin harremanetan jarri behar da berraktibatzeko.

Erabilera amaitzean, sakatu **Saioa itxi**.

### Administrazio-panela erabiltzea

Administratzaileak saioa hastean kudeaketa-panelera sartzen da. Bertan erabiltzaileen zerrenda, ikasle berriak gehitzeko formularioa, estatistikak eta ikastaroetako matrikulak aurkituko ditu.

Ikasle bat gehitzeko, **Ikaslea gehitu** atalean haren datuak bete behar dira. Ondoren, ikasleak bere kontua aktiba dezake.

Matrikula bat eteteko, dagokion ikastaroan **Desaktibatu** sakatzen da. Horrek plaza bat askatzen du, ikaslearen kontua eta beste matrikulak mantenduz. **Aktibatu** botoiak matrikula berriz gaitzen du, ikaslearen kontua aktibo badago eta plaza libreak badaude.

Estatistikek ikasle kopurua, kontu aktiboak, matrikula aktiboak eta plaza libreak erakusten dituzte. Ikastaro bakoitzaren okupazioa ere ikus daiteke.

## 3. Antolaketa teknikoa eta lan-tresnak

Webgunea Laravel eta PHP erabiliz garatu da. Tresna horiek erabiltzaileen eskaerak, saioak eta matrikulazio-prozesua kudeatzen dituzte. Datuak gordetzeko, proiektuaren hasierako konfigurazioak SQLite erabiltzen du.

Pantailak HTML eta CSS bidez osatzen dira. Proiektuak JavaScript lantzeko tresnak ere prestatuta ditu, nahiz eta egungo funtzio nagusiak formularioen eta orrien kargaren bidez gauzatu.

Aplikazioaren barruan datuen kudeaketa, eragiketen logika eta pantailen aurkezpena bereizita daude. Antolaketa horrek aldaketak egitea eta mantentze-lanak errazten ditu.

## 4. Aplikazioaren oinarrizko funtzionamendua

Aplikazioaren oinarria ikastaroen katalogoa, ikasleen erregistroa, saio-hasiera eta administrazio-panela dira. Atal horiek elkarrekin lotuta daude, ikaslearen altatik matrikularaino prozesu osoa egiteko.

Erabiltzaileak formulario bat bidaltzen duenean, sistemak datuak eta baimenak egiaztatzen ditu. Matrikularen kasuan, plaza libreak dauden ere begiratzen du. Dena zuzena bada, aldaketa gordetzen da eta baieztapena erakusten da; bestela, arazoa azaltzen duen mezua agertzen da.

Webgunea martxan jartzeko, arduradun teknikoak beharrezko tresnak instalatu, ingurunea konfiguratu eta datu-basea prestatu behar ditu. Prest dagoenean, gainerako erabiltzaileek emandako helbidetik sar daitezke.

## 5. Ingurunearen konfigurazioa: .env

`.env` fitxategiak webgunea exekutatzeko ezarpenak gordetzen ditu, hala nola aplikazioaren helbidea, datu-basearen konexioa eta saioen konfigurazioa.

Instalazio bakoitzera egokitzen da, eta `.env.example` fitxategia erabiltzen da oinarri gisa. Informazio sentikorra izan dezakeenez, pribatua mantendu behar da. Eguneroko erabiltzaileek ez dute fitxategi hori aldatu behar; arduradun teknikoaren lana da.

Laravel proiektuaren konfigurazio nagusia **`.env`** fitxategian gordetzen da. Fitxategi horren bidez aplikazioaren izena, ingurunea, datu-basearen konexioa, saioak eta beste zerbitzu batzuk konfiguratzen dira.

`.env` fitxategia **ez da GitHub-era igo behar**, pasahitzak, datu-basearen erabiltzailea edo aplikazioaren gako pribatua bezalako informazio sentikorra izan dezakeelako.

Proiektu honetan erabiltzen diren aldagai garrantzitsuenak hauek dira:

### Aplikazioaren konfigurazioa

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
```

- **`APP_NAME`**: aplikazioaren izena adierazten du. Kasu honetan `Laravel` da.
- **`APP_ENV`**: aplikazioa zein ingurunetan exekutatzen den adierazten du. `local` balioak garapen-ingurune lokal batean gaudela esan nahi du.
- **`APP_DEBUG`**: `true` dagoenean, Laravel-ek erroreen informazio zehatza erakusten du. Garapenean erabilgarria da, baina produkzioan `false` jartzea gomendatzen da.
- **`APP_URL`**: aplikazioaren oinarrizko helbidea da. Lokalean `http://localhost` erabiltzen da.

---

### Aplikazioaren segurtasun-gakoa

```env
APP_KEY=base64:...
```

**`APP_KEY`** Laravel-ek aplikazioaren datu batzuk zifratzeko erabiltzen duen gako pribatua da.

Gako hau instalazio bakoitzean desberdina izan behar da eta ez da publikoki partekatu behar.

Beharrezkoa bada, Laravel-ek gako berri bat sor dezake komando honekin:

```bash
php artisan key:generate
```

---

### Hizkuntza-konfigurazioa

```env
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
```

- **`APP_LOCALE`**: aplikazioaren hizkuntza lehenetsia.
- **`APP_FALLBACK_LOCALE`**: itzulpen bat aurkitzen ez denean erabiltzen den ordezko hizkuntza.
- **`APP_FAKER_LOCALE`**: probetarako datu faltsuak sortzean erabiltzen den hizkuntza eta formatua.

Une honetan konfigurazioa ingelesez dago.

---

### Pasahitzen segurtasuna

```env
BCRYPT_ROUNDS=12
```

**`BCRYPT_ROUNDS`** pasahitzak hash bihurtzeko Bcrypt algoritmoak egiten duen lan-kopurua definitzen du.

Balio handiago batek pasahitzaren hash-a kalkulatzea motelago egiten du, baina segurtasuna ere handitzen du.

Proiektuan balioa **12** da.

---

## Datu-basearen konfigurazioa

Proiektuak **PostgreSQL** erabiltzen du eta datu-basea **pgAdmin** bidez kudeatzen da.

Konfigurazioa honakoa da:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=matriculas
DB_USERNAME=admin
DB_PASSWORD=********
```

Aldagai bakoitzaren funtzioa:

- **`DB_CONNECTION=pgsql`**: PostgreSQL erabiltzen dela adierazten du.
- **`DB_HOST=127.0.0.1`**: datu-basea ordenagailu lokalean dagoela adierazten du.
- **`DB_PORT=5432`**: PostgreSQL-ek lehenespenez erabiltzen duen portua.
- **`DB_DATABASE=matriculas`**: erabiliko den datu-basearen izena.
- **`DB_USERNAME=admin`**: PostgreSQL-era konektatzeko erabiltzailea.
- **`DB_PASSWORD`**: erabiltzaile horren pasahitza.

Aurretik SQLite erabiltzeko konfigurazioa zegoen, baina komentatuta dago:

```env
#DB_CONNECTION=sqlite
```

`#` ikurra duten lerroak ez dira exekutatzen. Horregatik, aplikazioak gaur egun **PostgreSQL** erabiltzen du.

---

## Saioen konfigurazioa

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

- **`SESSION_DRIVER=database`**: erabiltzaileen saioak datu-basean gordetzen dira.
- **`SESSION_LIFETIME=120`**: saioak 120 minutuko iraupena dauka.
- **`SESSION_ENCRYPT=false`**: saioaren edukia ez da konfigurazio honen bidez zifratzen.
- **`SESSION_PATH=/`**: saioa webgunearen bide guztietan erabil daiteke.
- **`SESSION_DOMAIN=null`**: ez da domeinu zehatz bat definitzen.

`SESSION_DRIVER=database` erabiltzen denez, Laravel-ek **`sessions`** taula erabiltzen du saioen informazioa gordetzeko.

---

## Cache eta Queue konfigurazioa

```env
QUEUE_CONNECTION=database
CACHE_STORE=database
```

- **`QUEUE_CONNECTION=database`**: Laravel-en ilaran exekutatzen diren lanak datu-basean gordetzen dira.
- **`CACHE_STORE=database`**: aplikazioaren cache-a datu-basean gordetzen da.

Horregatik agertzen dira pgAdmin-en Laravel-ek sortutako hainbat taula, adibidez:

- `jobs`
- `job_batches`
- `failed_jobs`
- `cache`
- `cache_locks`

---

## Log-en konfigurazioa

```env
LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=debug
```

Aldagai hauek Laravel-ek aplikazioaren erroreak eta gertakariak nola gordetzen dituen kontrolatzen dute.

- **`LOG_CHANNEL`**: erabiliko den log sistema definitzen du.
- **`LOG_STACK`**: erabiltzen diren log kanalak zehazten ditu.
- **`LOG_LEVEL=debug`**: garapenean informazio zehatza gordetzeko erabiltzen da.

Log fitxategiak normalean Laravel proiektuaren barruan aurki daitezke:

```text
storage/logs/
```

---

## Posta elektronikoaren konfigurazioa

```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

Une honetan aplikazioak ez ditu emailak benetako posta-zerbitzari batera bidaltzen.

**`MAIL_MAILER=log`** erabiltzean, Laravel-ek bidaliko lukeen posta log fitxategian gordetzen du.

Hori garapen-ingurunean erabilgarria da.

---

## Vite konfigurazioa

```env
VITE_APP_NAME="${APP_NAME}"
```

**`VITE_APP_NAME`** frontend-eko baliabideek aplikazioaren izena erabili ahal izateko erabiltzen da.

`${APP_NAME}` jartzean, goian definitutako `APP_NAME` aldagaiaren balioa erabiltzen da.

---

## Segurtasun-oharra

`.env` fitxategiak informazio sentikorra izan dezake, bereziki:

- `APP_KEY`
- `DB_USERNAME`
- `DB_PASSWORD`
- Posta-zerbitzarien pasahitzak
- AWS edo beste zerbitzu batzuen gakoak

Horregatik, **`.env` fitxategia ez da GitHub-era igo behar**.

GitHub-en edo proiektuarekin batera partekatzeko, Laravel-ek **`.env.example`** fitxategia erabiltzen du. Fitxategi horrek konfigurazioaren egitura erakusten du, baina ez ditu benetako pasahitzak edo gako pribatuak izan behar.

## 6. Datu-basea: PostgreSQL eta pgAdmin

Webgunearen datuak **PostgreSQL** datu-base batean gordetzen dira. Datu-basea **pgAdmin** tresnaren bidez kudeatzen da.

Proiektuan erabiltzen den datu-basearen izena:

```text
matriculas
```

Datu-basearen barruan webgunearen funtzionamendurako lau taula nagusi daude:

### Erabiltzaileak

**`erabiltzaileak`** taulan webguneko erabiltzaileen informazioa gordetzen da.

Taula honetan ikasleen eta administratzaileen datuak gordetzen dira, adibidez:

- Izena.
- Abizenak.
- Helbide elektronikoa.
- Pasahitza.
- Erabiltzailearen rola.
- Kontuaren egoera.

Erabiltzaile bakoitzak rol bat dauka, eta rol hori **`rolak`** taularekin lotuta dago.

---

### Rolak

**`rolak`** taulak sisteman dauden erabiltzaile motak gordetzen ditu.

Adibidez:

- **Ikaslea**
- **Irakaslea**
- **Administratzailea**

Taula hau erabiltzaileen baimenak eta webgunearen atal desberdinetarako sarbidea kontrolatzeko erabiltzen da.

Adibidez, administratzaile batek administrazio-panelera sarbidea dauka, baina ikasle batek ez.

---

### Ikastaroak

**`ikastaroak`** taulan ikastetxean eskaintzen diren ikastaroen informazioa gordetzen da.

Besteak beste, honako informazioa gorde daiteke:

- Ikastaroaren izena.
- Deskribapena.
- Hasiera-data.
- Amaiera-data.
- Plaza kopurua.

Webgunearen hasierako orrian agertzen diren ikastaroak taula honetatik lortzen dira.

---

### Matrikulak

**`matrikulak`** taulak ikasleen eta ikastaroen arteko erlazioa gordetzen du.

Ikasle bat ikastaro batean matrikulatzen denean, matrikula berri bat sortzen da taula honetan.

Matrikula bakoitzak gutxienez bi elementu lotzen ditu:

- **Erabiltzailea**
- **Ikastaroa**

Matrikularen egoera ere gordetzen da, matrikula aktibo edo desaktibo dagoen jakiteko.

Horri esker sistemak jakin dezake:

- Zein ikastarotan dagoen matrikulatuta ikasle bakoitza.
- Zein ikasle dauden ikastaro bakoitzean.
- Zenbat plaza dauden erabilita.
- Zenbat plaza libre geratzen diren.

---

### Taulen arteko erlazioa

Lau taula nagusien arteko erlazioa honela laburbil daiteke:

```text
ROLak
   |
   | 1
   |
   | N
ERABILTZAILEAK
   |
   | 1
   |
   | N
MATRIKULAK
   |
   | N
   |
   | 1
IKASTAROAK
```

Hau da:

- **Rol batek** hainbat erabiltzaile izan ditzake.
- **Erabiltzaile batek** hainbat matrikula izan ditzake.
- **Ikastaro batek** hainbat matrikula izan ditzake.
- **Matrikula bakoitzak** erabiltzaile bat eta ikastaro bat lotzen ditu.

Beraz, **`matrikulak`** taulak **`erabiltzaileak`** eta **`ikastaroak`** taulen arteko lotura egiten du.

---

### Laravel-ek sortutako beste taulak

pgAdmin-en lau taula nagusiez gain beste taula batzuk ere ikus daitezke, adibidez:

- `cache`
- `cache_locks`
- `failed_jobs`
- `job_batches`
- `jobs`
- `migrations`
- `sessions`

Taula horiek Laravel-ek aplikazioaren barne funtzionamendurako erabiltzen ditu.

Adibidez, **`sessions`** taulak erabiltzaileen saioei buruzko informazioa gordetzen du eta **`migrations`** taulak datu-basean exekutatu diren migrazioak kontrolatzen ditu.

Webgunearen datu nagusiak, ordea, honako lau tauletan daude:

**`erabiltzaileak`**, **`rolak`**, **`ikastaroak`** eta **`matrikulak`**.



## 7. Diseinua eta erabilera erosoa

Webguneak informazioa argi erakustea du helburu. Ikastaroak txarteletan aurkezten dira, eta administrazioan taulak eta estatistikak erabiltzen dira datuak kontsultatzeko.

Diseinua ordenagailu, tablet eta mugikorretako pantailetara egokitzen da. Botoiek ekintza adierazten dute, eta mezuek eragiketa ondo egin den edo zer zuzendu behar den azaltzen dute.

Animazio txikiek botoiak, ikastaro-txartelak eta gehitu berri den ikaslea nabarmentzen dituzte. Efektu horiek CSS bidez egiten dira, eta mugimendu murriztua nahi duten erabiltzaileen hobespena kontuan hartzen da.

JavaScript erabiltzeko oinarria prestatuta dago, baina egungo pantaila nagusiek ez dute haren beharrik matrikulak edo kontuen kudeaketa egiteko.

## 8. Arrisku nagusiak eta babesa

Webguneak erabiltzaileen datuak eta sarbideak babesteko neurriak ditu. Hala ere, konfigurazio egokia eta mantentzea ere beharrezkoak dira.

| Arriskua | Babesa edo kontuan hartu beharrekoa |
| --- | --- |
| Baimenik gabeko sarbidea | Administrazio-eragiketak administratzaileentzat mugatuta daude. |
| Pasahitzak asmatzeko saiakera errepikatuak | Sistemak saioa hasteko saiakerak mugatzen ditu. |
| Beste ikasle baten kontua aktibatzea | Aurretiko alta behar da, baina emailaren jabetza egiaztatzeko urratsa gehitzea hobekuntza bat litzateke. |
| Datu okerrak edo bikoiztuak sartzea | Formularioetako datuak egiaztatzen dira gorde aurretik. |
| Ikastaro baten edukiera gainditzea | Matrikula egitean eta berraktibatzean plaza libreak egiaztatzen dira. |
| Konfigurazio pribatua agerian uztea | `.env` fitxategia eta sarbide-datuak pribatu mantendu behar dira. |
| Informazioa galtzea | Aldizkako babeskopiak behar dira. |

Benetako erabilerarako, probako pasahitzak ordeztu eta konexio segurua erabili behar da. Erabiltzaileek ere beren pasahitza pribatu mantendu eta partekatutako gailuetan saioa itxi behar dute.

## 9. Kodearen kalitatea eta garapen-antolaketa

PHP kodea objektuetara zuzendutako programazioaren oinarriak jarraituz antolatzen da. Erabiltzaileak, ikastaroak, rolak eta matrikulak bereizita lantzen dira, bakoitzaren ardura argi mantentzeko.

Datuen kudeaketa eta pantailen aurkezpena bereizteak kodea ulertzea, berrerabiltzea eta zuzentzea errazten du. Erabiltzaileak bidalitako informazioa egiaztatzen da, eta pasahitzak ez dira testu arruntean gordetzen.

Proiektuak proba automatizatuak ere baditu, besteak beste sarbideak, erregistroa, matrikulak, plaza-mugak eta estatistikak egiaztatzeko.

## 10. Erabileran sor daitezkeen zalantzak

| Egoera | Zer egin? |
| --- | --- |
| Ezin dut erregistratu | Egiaztatu administratzaileak zure emaila aurrez gehitu duela eta ez duzula kontua dagoeneko aktibatu. |
| Ezin dut saioa hasi | Berrikusi helbide elektronikoa eta pasahitza. Saiakera gehiegi egin badituzu, itxaron adierazitako denbora. |
| Pasahitza ahaztu dut | Jarri harremanetan arduradunarekin; webguneak ez du berreskuratze automatikorik. |
| Ezin dut matrikulatu | Egiaztatu saioa hasita duzula, plaza libreak daudela eta ez zaudela aurretik matrikulatuta. |
| Nire matrikula ez dago aktibo | Eskatu administratzaileari egoera berrikusteko. |
| Datuak ez dira eguneratu | Freskatu orria azken informazioa ikusteko. |

## 11. Erasoen aurkako segurtasun-neurriak

Webguneak hainbat babes-neurri erabiltzen ditu baimenik gabeko sarbideak eta datuen manipulazioa zailtzeko. Babesa bai saioa hastean bai erabiltzaileak eragiketak egiten dituenean aplikatzen da.

- **Sarbideen kontrola:** administrazio-panela eta haren eragiketak administratzaileentzat mugatuta daude. Helbidea zuzenean idazteak ez du baimen hori saihesten.
- **Pasahitzen babesa:** pasahitzak hash moduan gordetzen dira, jatorrizko testua gorde gabe. Horrela, datu-basean ez dira zuzenean irakurtzeko moduan agertzen.
- **Saiakera errepikatuen muga:** saio-hasierako eta erregistroko saiakerak mugatzen dira, pasahitzak automatikoki probatzea eta gehiegizko eskaerak zailtzeko.
- **Formulario faltsuen aurkako babesa:** formularioek segurtasun-egiaztapen bat daramate, beste webgune batek erabiltzailearen saioa aprobetxatuz nahi gabeko eragiketak egitea eragozteko.
- **Sartutako datuen egiaztapena:** sistemak formularioetako informazioa berrikusten du gorde aurretik. Baimenak eta matrikulazio-arauak zerbitzarian egiaztatzen dira, erabiltzaileak nabigatzailean aldaketak egin arren.
- **Eduki kaltegarrien aurkako babesa:** erabiltzailearen datuak pantailan erakustean, testua kode exekutagarri gisa interpretatzea saihesteko neurriak aplikatzen dira.
- **Datu-baseko kontsulten babesa:** datuak kontsultetan modu kontrolatuan erabiltzen dira, formulario batean idatzitako testuak datu-basearen aginduak aldatzeko arriskua murrizteko.
- **Saioen kudeaketa:** saioa hastean haren identifikatzailea berritzen da, eta saioa ixtean baliogabetzen da, aurreko saioa berrerabiltzea zailtzeko.

Neurri horiek arriskua murrizten dute, baina ez dute eraso guztien aurkako bermerik ematen. Babesa mantentzeko, arduradunak aplikazioa eguneratuta eduki, pasahitz sendoak erabili eta argitaratutako webgunean HTTPS konexioa konfiguratu behar du.
