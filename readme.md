# Zibersegurtasun Kontzientziazio Plana
## Ikastetxea – Web Kudeaketa Plataforma

| | |
|---|---|
| **Data** | 2026ko urriaren 1a |
| **Bertsioa** | 1.0 |
| **Esparrua** | Ikastetxea Laravel plataforma eta bere erabiltzaile-komunitate osoa |
| **Erreferentziak** | DBEO (EB 2016/679) · LOPDGDD · ENS (RD 311/2022) · OWASP Top 10 (2021) · INCIBE · Cyberzaintza |
| **Sailkapena** | Barne-erabilerarako |

---

## Aurkibidea

1. [Sarrera](#1-sarrera)
2. [Testuinguru Orokorra](#2-testuinguru-orokorra)
3. [Lan-ildoak](#3-lan-ildoak)

---

## 1. Sarrera

### 1.1. Helburua

Hezkuntza-inguruneak gero eta digitalagoak dira, eta plataforma digitalek funtsezko zeregina betetzen dute ikasleen, irakasleen eta administrazio-langileen arteko harremanetan. Ikastetxearen kudeaketa-plataformak — Laravel 12 eta PostgreSQL oinarriak dituenak — ikasleen datu pertsonalak, matrikulazioak eta administrazio-kredentzialak kudeatzen ditu egunero.

Sistemak segurtasun-neurri tekniko sendoak ditu: erabiltzaileen baimenetan oinarritutako sarbide-kontrola (`AdminOnly` middleware bidez), sarrerako datuen balidazioa (`IkastaroController` eta `AdministrazioaController`-en), rate limiting saio-hasieraren aurka (5 saiakeratik gorako blokeo automatikoa), CSRF babesa formulario guztietan eta saio-datuak datu-basean gordetzen dira, ez cookie arruntetan.

Hala ere, segurtasun-sistema sendoenak ere huts egin dezake erabiltzaile batek bere pasahitza mezu faltsu bati erantzunez ematen badu, edo gela-ordenagailu batean saioa irekita uzten badu. **Teknologiak babes asko ematen du, baina azken erabakia beti pertsona baten eskuetan dago.**

Kontzientziazio Plan honen helburua da Ikastetxeako komunitate digitalean zibersegurtasunaren kultura sustatzea: arriskuak garaiz identifikatzea, jardun seguruak ohitura bihurtzea eta gorabeherak beldurrik gabe jakinaraztea.

### 1.2. Esparru Arautzailea

Plan hau ondorengo arau eta estandarretan oinarritzen da:

- **DBEO (EB 2016/679):** Datu pertsonalen osotasuna, konfidentzialtasuna eta erabilgarritasuna bermatzeko erregelamendua.
- **3/2018 Lege Organikoa (LOPDGDD):** Datu Pertsonalak Babesteko eta Eskubide Digitalak Bermatzeko legea.
- **ENS – Segurtasun Eskema Nazionala (RD 311/2022):** Hezkuntza-zerbitzuetan informazioaren segurtasuna bermatzeko printzipio eta neurriak.
- **OWASP Top 10 (2021):** Web aplikazioen arrisku ohikoenak saihesteko erreferentzia teknikoa.
- **INCIBE eta Cyberzaintza:** Hezkuntza-inguruneetarako jardunbide egokiak eta kontzientziazio-baliabideak.

### 1.3. Planaren Helburu Nagusiak

- **Ezagutza handitzea:** Komunitate osoaren kide bakoitzak — ikasleek, administratzaileek eta garatzaileek — bere jardunak dakartzan arrisku digitalak ulertzea.
- **Ohitura seguruak errotzea:** Pasahitzen erabilera egokia, saio-itxiera arduratsua eta komunikazio-kanal instituzionalak erabiltzea eguneroko praktiketara txertatuz.
- **Gizarte-ingeniaritzaren aurrean erresistentea izatea:** Phishing mezuak, esteka susmagarriak eta identitate faltsutzeak azkar identifikatzeko gaitasuna garatzea.
- **Jakinarazpen-kultura sustatzea:** Edozein anomalia edo akats segurtasun-arduradunari beldurrik gabe jakinarazteko kultura ez-zigortzaile bat eraikitzea.

---

## 2. Testuinguru Orokorra

### 2.1. Plataformaren Deskribapena

Ikastetxearen kudeaketa-plataformak ikastetxeko bizitza digital osoa biltzen du. Hiru eremu nagusi ditu:

- **Eremu Publikoa (`/index.php`):** Ikastaroen katalogoa ikusteko, matrikulazioa eskatzeko eta informazio instituzionala kontsultatzeko eremurik irekiena. Ez da autentifikazio beharrik, baina edozein erabiltzaile sar daiteke.
- **Ikasleen Eremua:** Emailaren bidezko kontu-aktibazioa (administratzaileak aurretik onartu ondoren), ikastaroetan matrikulatzea, norbere profilera sartzea eta matrikula-historia ikustea. `ikasleak` rolak mugatzen du sarbidea.
- **Administrazio-panela (`/administrazioa.php`):** Ikasleen alta, baja eta datuak kudeatzeko, ikastaroen edukiera eta matrikulak kontrolatzeko eta sistemaren estatistikak ikusteko gunea. `admin` rolak soilik du sarbidea, `AdminOnly` middleware-aren bidez.

### 2.2. Babestu Beharreko Informazio-Aktiboak

Plataformak aktibo digital garrantzitsuak kudeatzen ditu:

- **Datu pertsonal identifikagarriak:** Ikasleen izen-abizenak, helbide elektronikoak eta kontu-egoera.
- **Datu akademikoak:** Ikastaroetan matrikulazioak, matrikula-datak eta egoera (aktibo / ez_aktibo).
- **Autentifikazio-kredentzialak:** Datu-basean gordetako pasahitz-hash-ak (bcrypt), saio-tokenak eta saioa hasteko formularioko datuak.
- **Azpiegitura-konfigurazioa:** `.env` fitxategia (`APP_KEY`, `DB_PASSWORD`), PostgreSQL datu-basea eta aplikazioaren erregistroak.
- **Administrazio-sarbidea:** `admin` kontua, ikasle, ikastaro eta matrikula guztietarako sarbide osoa duena.

### 2.3. Xede-Taldeak eta Eragileen Profilak

Kontzientziazio-jarduerak hiru talderi zuzenduta daude, bakoitzak arriskuak eta erantzukizun desberdinak baititu:

| Taldea | Plataformako Rola eta Baimenak | Arrisku Nagusiak |
|---|---|---|
| **Administratzaileak** | Administrazio-panel osora sarbidea (`/administrazioa.php`), ikasle-datuak kudeatu, matrikulak onartu, ikasleak gehitu eta ezabatu. | Kredentzial-lapurreta, phishing bidezko manipulazioa, pasahitz ahulak, saio irekiak partekatutako gailutan. |
| **Ikasleak** | Profil pertsonala, matrikulazioa ikastaroetan (`/erregistratu.php`), norbere matrikula-historia. | Gelako ordenagailuetan saioa irekita uztea, pasahitz berrerabilia, aktibazio-esteka faltsuak sakatzea. |
| **Garatzaileak eta mantentze-taldea** | Kode-basea, datu-basea, `.env` fitxategia, hedapena eta segurtasun-adabakiak. | `.env` sekretuak kode-biltegira igotzea, konfigurazio-akatsa produkzioan (`APP_DEBUG=true`), menpekotasun zaharkituak. |

### 2.4. Identifikatutako Mehatxu Nagusiak

Plataformaren egitura eta erabilera-ohiturei erreparatuta, ondorengo mehatxuak dira garrantzitsuenak:

- **Phishing-a eta identitate-ordezkapenа:** Ikastetxearen izenean bidalitako aktibazio-mezu faltsuak erabiltzaile-kredentzialak eskuratzeko. Ikasleek aktibazio-emailak jasotzen dituztenez, eraso-bide hau bereziki eraginkorra da.
- **Pasahitz ahulak eta sekretu estatikoak:** Sistemaren hasierako konfigurazio-unean `Admin123` bezalako pasahitz arruntak erabiltzea, inoiz aldatzen ez direnak.
- **Saioak ireki uzteа gailu partekatuetan:** Ikasgeletan edo administrazio-guneetan saioa zabalik uztea bertara sartu daitekeen edozeinen eskuetan uztea da ikasle-datuak.
- **Konfigurazio-akatsa hedatzean:** `APP_DEBUG=true` edo `APP_ENV=local` aldagaiak produkzio-ingurunera iristea, barne-informazioa agerian utz dezakeena.
- **Datu pertsonalen zirkulazio kontrolgabea:** Ikasleen zerrendak edo emailak baimenik gabeko kanaletara (txat-taldeak, posta pertsonala) eramateko tentazioa.

### 2.5. Babes Teknikoaren eta Giza Faktorearen Arteko Oreka

Plataformak dagoeneko hainbat babes-geruza ditu ezarrita, kode-azterketan egiaztatuak:

- **Sarbide-kontrola:** `AdminOnly` middleware-ak `admin` rola egiaztatzen du administrazio-bisterarako sarbide bakoitzean, ez soilik saioa hastean.
- **Indar gordineko erasoen aurkako babesa:** `RateLimiter` bidez, 5 saiakera oker eta gero sarrera blokeatzen da automatikoki 60 segundoz (`AdministrazioaController`).
- **Injekzio-erasoen babesa:** Eloquent ORM-ek SQL injekzioak saihesten ditu, eta `e()` funtzioa ikuspegietan XSS-en aurka erabiltzen da.
- **CSRF babesa:** Token berezia formulario guztietan, kanpotik eraso bidezko eskaera faltsuak ekiditeko.
- **Kontu-aktibazioa:** Ikasleek ezin dute konturik sortu libreki; administratzaileak aurretik onartu behar ditu.

**Ondorioa:** Babes tekniko hauek guztiak alferrikakoak bihurtzen dira administratzaile batek kredentzialak mezu faltsu bati ematen badizkie, edo garatzaile batek `DB_PASSWORD=Admin123` kode-biltegira igotzen badu. **Kontzientziazio Plana ez da osagarri hautazkoa — segurtasun-katearen ezinbesteko esteka da.**

---

## 3. Lan-ildoak

Jarraian sei lan-ildo aurkezten dira, bakoitza hiru ikuspegitik landuta:
- **Kontzientziazioa:** Komunitatea sentsibilizatzeko jarduerak.
- **Teknikoa:** Arlo hori hobetzeko neurri tekniko espezifikoak.
- **Prozedurala:** Arauak, protokoloak eta eginbeharrak.

Lan-ildo hauek 1.3 ataleko helburuekin eta 2.4 ataleko mehatxuekin zuzenean lotuta daude.

---

### 3.1. Lan-ildoa: Phishing-a eta Gizarte-Ingeniaritza

**Xede-taldeak:** Administratzaileak, ikasleak.

#### Kontzientziazioa

- **Tailerra ikasturte hasieran** (60 min): Phishing-aren mekanismoa eta ondorioak azaltzea adibide errealekin. Ikastetxearen aktibazio-emaila imita dezakeen mezu faltsu baten azterketa bisuala egitea taldean: zer seinalek salatzen dute eranskin edo esteka bat?
- **Simulazio kontrolatuak hiruhilero:** Administrazio-taldeari phishing mezu simulatu bat bidali, ondoren tasa neurtu (nork sakatu duen, nork jakinarazi duen) eta emaitzak taldean komentatzeа zigorrik gabe.
- **Poster eta txartel ikusgarriak:** Administrazio-eremuan eta ikasgeletan jartzea: *«Ikastetxeak ez dizu inoiz pasahitzik eskatuko emailez»* mezuarekin.

#### Teknikoa

- Posta-domeinuan **SPF, DKIM eta DMARC** konfiguratzea: Ikastetxearen izenean bidalitako mezu faltsuak zailtzeko.
- Plataformako emailetan (aktibazio-mezuak) mezu argi bat gehitzea: *«Esteka hau ikastetxearen domeinu ofizialetik dator. Ez sartu zure pasahitza galdetu diezaizun inori»*.
- Administrazio-panelean **alerta-banner bat** jartzea phishingaren aurkako oinarrizko gomendioekin.

#### Prozedurala

- **Arau nagusia:** Mezu susmagarria jaso, ez sakatu, ez erantzun — **segurtasun-arduradunari birbidali** (helbide bakar eta ofiziala).
- Administratzaileek datu-eskaera edo sarbide-eskaera guzti-guztiak **bigarren kanal batetik egiaztatu** (telefonoa edo aurrez aurrekoa) emailez iristen badira ere.
- Simulazioen emaitzak bildu eta taldeen arabera segmentatu: maila baxuenean diren kolektiboak prestakuntza berezia jaso.

---

### 3.2. Lan-ildoa: Pasahitzak eta Kontu-Segurtasuna

**Xede-taldeak:** Administratzaileak, ikasleak, garatzaileak.

#### Kontzientziazioa

- **Gida praktikoa** pasahitz-politikari buruz: gutxienez 12 karaktere, zerbitzu bakoitzeko desberdina, pasahitz-esaldiak erabiltzea (adib. `Kaixo!Eibar2026#`) eta zergatik huts egiten duten ohiko ordezketak (`a→@`, `e→3`).
- **Pasahitz-kudeatzaileen aurkezpena**: Bitwarden edo KeePassXC erakustea taldean, saio bat erabiltzea instalazioa eta erabilera ikasiz.
- **Argi utzi kodearen arrisku bat:** `Admin123` bezalako pasahitzak ez dira soilik ahulak — *sistema barruan idatzita uzten badira (Seeder-etan edo konfigurazio-fitxategietan), aurkitzea oso erraza da.*

#### Teknikoa

- Plataforman erregistratzerakoan pasahitzaren gutxieneko luzera **12 karakterera** handitzea (oraingoz 8 dira `IkastaroController`-en).
- **Administrazio-kontuentzat bigarren faktore autentifikazioa (2FA/TOTP)** derrigorrezko bihurtzea `/administrazioa.php`-ra sartzeko.
- `AdminSeeder.php`-n pasahitz estatikoa (`Admin123`) **ingurune-aldagaira eramatea** (`ADMIN_PASSWORD` `.env` fitxategian), inoiz kode-biltegira ez igotzeko.
- Blokeo-gertaerak (rate limiting aktibatzea) erregistratzea eta alerta bidali sistemak automatikoki.

#### Prozedurala

- **Kontu partekatuak erabat debekatzea**: Pertsona bakoitzak bere kredentzialak ditu. Norbaitek taldea uzten badu, sarbideak berehala baliogabetzen dira.
- Pasahitza konpromititu dela susmatzen bada: **24 orduko epean** aldatu eta segurtasun-arduradunari jakinarazi.
- Administratzaileen kontuen urteko berrikuspena: kontu aktiboak, azken sarbide-data eta rol-egokitasuna.

---

### 3.3. Lan-ildoa: Saioen Kudeaketa eta Gailu Partekatuak

**Xede-taldeak:** Ikasleak, administratzaileak.

#### Kontzientziazioa

- **Komunikazio ikusgarria ikasgeletan:** Pantailaren aurrean ohar iraunkorrak: *«Amaitu duzunean, itxi saioa. Ezker goiko izkinan daukazu»*, Ikastetxeako plataformako irten-botoiaren argazkiarekin.
- **Eztabaida gidatua ikaslekin:** «Zer gerta daiteke zure saioa zabalik uzten baduzu?» galdera erabiliz, ondorio praktikoak taldean aztertzea: norbaitek zure izenpean matrikula egin dezake, edo zure datuak ikusi.
- **Lan-ekipoen erabilera-arauak** — administrazio-langileentzat: pantaila blokeatzea mahaigaintik alde egitean (`Win+L`), nabigatzaileko saio gordeak ez erabiltzea.

#### Teknikoa

- Saioaren iraungitze automatikoa inaktibitatean: **20 minutu administratzaileentzat**, **45 minutu ikasleeentzat** (`SESSION_LIFETIME` aldagaia `.env` fitxategian).
- `SESSION_ENCRYPT=true` ezartzea: Saio-datuak datu-basean zifratuta gordetzea.
- `SESSION_SECURE_COOKIE=true` ezartzea produkzioan: Cookie-ak HTTPS bidez soilik bidaltzeko.
- Administrazio-bistan **«Itxi nire beste saio guztiak»** aukera gehitzea, gailua galdu edo konpromititu denean.

#### Prozedurala

- Ikasgelako irakasleek **azken saioaren ondoren** egiaztatu behar dute ordenagailu guztiak itxita daudela: ez saioa soilik, nabigatzaile-leihoa ere bai.
- Norbaitek besteren saioa irekita topatzen badu: **itxi, ez erabili, eta irakasleari edo administratzaileari jakinarazi berehalakoan**.
- Administrazio-langileen gailu pertsonaletan plataformara sartzen badira: ez erabili Wi-Fi publiko bat VPN gabe.

---

### 3.4. Lan-ildoa: Datu Pertsonalen Tratamendua eta Pribatutasuna

**Xede-taldeak:** Administratzaileak.

#### Kontzientziazioa

- **Prestakuntza-saio bat DBEO/LOPDGDD-ri buruz** (30-45 min): Zer den datu pertsonala, minimizazio-printzipioa eta ikasleek dituzten eskubideak (atzipena, zuzenketa, ezabaketa, ahanztura-eskubidea).
- **Kasu praktiko eztabaidagarriak:** «Zein da arazo honen ondorioa?»: ikasle-zerrenda WhatsApp talde batean partekatzea, pantaila-argazkia hartu eta bidaltzea, USB batean kopia egitea etxera eramateko.
- Administrazio-sarbidea jaso aurretik **konfidentzialtasun-konpromisoa sinatzea**, argi utziz plataforman ikusitakoa ez dela baimenik gabeko kanaletara irteten.

#### Teknikoa

- **Rol eta baimenen printzipio minimoa**: Administratzaile bakoitzak bere lanean behar dituen baimenak soilik izatea — datu guztiak ez dira denontzat.
- Plataforman ikasleen datu sentikorrak (emailak, izenak) **ez erakustea erabiltzaile publikoei** — dagoeneko administrazio-middlewarek babesten du, baina ikuspegietan ere egiaztatu behar da.
- Datuak esportatu edo deskargatu direnean **erregistroa uztea**: nork, noiz eta zer deskargatu duen.

#### Prozedurala

- **Arau nagusia:** Ikasle-datuak baimendutako kanal instituzionalak soilik erabiliz partekatu — plataformaren barnean edo posta korporatiboaren bidez, inoiz tresna pertsonaletan.
- Ikasle batek bere datuen kontsulta, zuzenketa edo ezabatze-eskaera egiten badu, **hilabeteko epean** erantzun behar da (DBEO 12. art.).
- Datu-urraketa bat detektatzen bada (ikasle-datu bat agerian geratu bada), **72 orduko epean** AEPDri jakinarazi (DBEO 33. art.) eta, arriskua altua bada, eragindakoei ere bai.

---

### 3.5. Lan-ildoa: Gorabeheren Jakinarazpena eta Erantzuna

**Xede-taldeak:** Komunitate osoa.

#### Kontzientziazioa

- **«3 urrats» txartela** ikasgeletan eta administrazio-gunean: *(1) Gelditu eta pantaila-argazkia hartu. (2) Ez ezabatu ezer. (3) Jakinarazi segurtasun-arduradunari*.
- **Kultura ez-zigortzailea abiapuntua:** Akats bat azkar jakinarazteak ez du zigorrik ekarriko — alderantziz, eskertuko da. Hori argi eta garbi esatea komunikazio ofizialetan.
- Urtean **simulakro bat administrazio-taldearekin**: adibidez, *«Garatzaileak `.env` fitxategia GitHub-era igo du oharkabean»* eszenatokia, 9. ataleko erantzun-protokoloa praktikan jarriz.

#### Teknikoa

- Laravel-en **erregistro (logs) zentralizatuak** eta alertak konfiguratzea: saioa hasteko saiakera anitz, ordutegi ezohikoak, administrazio-panelera sartzeko saiakera huts.
- **Jakinarazpenerako kanal bakarra** ezartzea: posta-helbide edo formulario ofizial bat, arduradunak jarraipena egin dezan (egoera, arduraduna, konponketa-data).
- `.env` sekretuak, `APP_KEY` eta `DB_PASSWORD` aldizka **biratzea** (gutxienez urtean behin, eta berehala susmo kasuetan).
- **Segurtasun-kopiak** egunero automatikoki egitea eta hilero berreskuratze-proba bat egitea, funtzionatzen duela egiaztatzeko.

#### Prozedurala

- **Erantzun-protokoloa gorabehera baten aurrean:**
  1. **Detektatu** — Ordua, zer ikusi den eta non idatzi.
  2. **Eutsi** — Hedapena mugatu: plataforma itzali (`php artisan down`), konpromitutako pasahitzak aldatu.
  3. **Ikertu** — Logak aztertu, kausa identifikatu, eragina neurtu.
  4. **Konpondu** — Arazoa zuzendu eta hura detektatuko duen testa gehitu.
  5. **Berreskuratu** — Plataforma berrabiarazi, azken kopia ona leheneratu behar izanez gero.
  6. **Ikasi** — Txostena 5 egunean: zer gertatu zen, zergatik, zer aldatzen den.
- **Larritasun-mailak eta erantzun-epeak:**
  - *Larria* (kredentzial-lapurreta, datu-urraketa): **1 ordu**
  - *Ertaina* (plataforma erorita, konfigurazio-akatsa): **4 ordu**
  - *Baxua* (erabiltzaile-akatsa, log susmagarria): **24 ordu**

---

### 3.6. Lan-ildoa: Garapen Segurua eta Ahultasunen Kudeaketa

**Xede-taldeak:** Garapen- eta mantentze-taldea, administratzaileak.

#### Kontzientziazioa

- **OWASP Top 10 (2021) saio praktikoa garatzaileentzat**: Injekzioak, autentifikazio-akatsak, konfigurazio okerrak — Ikastetxearen plataformako adibide errealak erabiliz (adib. `APP_DEBUG=true` produkzioan zertan den arriskutsua, edo `Admin123` Seeder-ean agertzearen ondorioak).
- **Kode-berrikuspenetan segurtasun-kontrol-zerrenda erabiltzea**: Inprimaki bat sortzea pull request bakoitzeko `✓ `.env berri bat gehitu al duzu? ✓ APP_DEBUG=false? ✓ composer audit garbia?`.
- Segurtasun-aurkikuntzak taldean **partekatu eta komentatu** zigorrik gabe, ikasteko aukera gisa.

#### Teknikoa

- **`composer audit`** eta **`npm audit`** integratzea hedapen-prozesuaren parte bezala, automatikoki menpekotasunen ahultasunak detektatzeko.
- `APP_DEBUG=false` eta `APP_ENV=production` produkzioko `.env` fitxategian **beharrezkoa** da, inoiz garapen-konfigurazioa produkziora irits ez dadin.
- **`AdminSeeder`-en pasahitz estatikoa** (`Admin123`) ingurune-aldagaira eramatea: `ADMIN_PASSWORD` `.env` fitxategian, inoiz kode-biltegira igo gabe.
- Kode-biltegi publikoan `.env` fitxategia **inoiz ez agertzea** egiaztatzea: `.gitignore`-an dago (✅ dagoeneko ezarrita), baina `git log` berrikusi `.env` inoiz igo ote den.
- **Test automatikoak** mantentzea: 6 test-fitxategi daude `tests/Feature/`-n — bertsio garrantzitsu bakoitzaren aurretik exekutatu (`php artisan test`) eta %100ean berdean eduki.

#### Prozedurala

- **Aldaketa-kudeaketa**: Produkziora hedatu aurretik kode-berrikuspena (beste pertsona batek) eta testak berdean.
- Ahultasun kritiko bat aurkitzen bada (`composer audit` bidez edo kanpotik jakinarazita): **48 orduko epean** konpondu eta adabakia aplikatu.
- **Urteko segurtasun-auditoria** edo penetrazio-proba bat: kanpoko talde batek sistematikoki aztertzen du plataforma eta emaitzen arabera ekintza-plana eguneratzen da.
- Garatzaile berri bat taldean sartzen denean: `.env` fitxategiaren eta sekretu-politiken inguruko azalpena eman, konpromiso-dokumentua sinatu.

---

## 4. Jarraipena eta Ebaluazioa

### 4.1. Adierazle Nagusiak

| Adierazlea | Helburua | Nola neurtzen den |
|---|---|---|
| Phishing-simulazioetan sakatze-tasa | <%10 | Simulakro bakoitzaren ondoren |
| 2FA aktibo administratzaile-kontuetan | %100 | Hileko berrikuspena |
| Pasahitz-politika betetzen duten kontuak | %100 | Hiruhileko berrikuspena |
| Jakinarazitako gorabeherak | Igotzen ari bada, ona da (kultura) | Urteko konparaketa |
| `composer audit` ahultasun kritikoak | 0 | Hedapen bakoitzean |
| Test automatikoak berdean | %100 | `php artisan test` hedapen aurretik |
| Segurtasun-kopia egiaztatu den egunak | %100 | Aste bakoitzeko |

### 4.2. Berrikuspena eta Eguneraketa

Plan hau **urtean behin** berrikusten da, edo lehenago:

- Segurtasun-gorabehera garrantzitsu bat gertatu ondoren.
- Plataforman aldaketa tekniko garrantzitsua egin ondoren.
- Arau-esparru berriak argitaratu ondoren.

---

## 5. Erreferentziak

1. **DBEO (EB 2016/679)** — Datuak Babesteko Erregelamendu Orokorra: [eur-lex.europa.eu](https://eur-lex.europa.eu)
2. **LOPDGDD (3/2018 LO)** — Datu Pertsonalak Babesteko eta Eskubide Digitalak Bermatzeko Lege Organikoa
3. **ENS (RD 311/2022)** — Segurtasun Eskema Nazionala: [ccn-cert.cni.es](https://www.ccn-cert.cni.es)
4. **OWASP Top 10 (2021):** [owasp.org/Top10](https://owasp.org/Top10/)
5. **INCIBE, «Protege tu empresa»:** [incibe.es/empresas](https://www.incibe.es/empresas)
6. **Cyberzaintza — Zibersegurtasunaren Euskal Agentzia:** [cyberzaintza.eus](https://cyberzaintza.eus)
7. **AEPD — Agencia Española de Protección de Datos:** [aepd.es](https://www.aepd.es)
8. **Laravel Segurtasun-dokumentazioa:** [laravel.com/docs/security](https://laravel.com/docs/security)

---

*Dokumentu hau 2026ko urriaren 1ean sortua da.*
*Hurrengo berrikuspena: 2027ko urriaren 1a — edo lehenago gorabehera garrantzitsu bat gertatuz gero.*
