# Informazioaren Teknologien Inguruneetan Zibersegurtasuneko Espezializazio-Ikastaroa

**Iraupena:** 18 egun
**Antolaketa:** 4 pertsonako taldeak

**Modulu-blokeak:** Zibersegurtasun-gorabeherak, Sareak eta sistemak gotortzea, Ekoizpen seguruan jartzea, Auzitegi-analisi informatikoa, Hacking etikoa eta Zibersegurtasunaren arloko araudia.

---

## 1. Erronka — Oinarriak finkatzen

### Azalpen laburra

Oinarriak finkatzeko erronka izango da. Talde bakoitzak enpresa baten ardura hartu eta honen zibersegurtasunaren gorabeherak, sare eta sistemen gotortzea, software ekoizpen segurua, auzitegi-analisi informatikoa, hacking etiko bidezko lanketa eta araudiari dagozkion zereginak hartu beharko ditu beregain.

### Erronka

Web orria ariketa klasean egindakoa erabili behar da: **CRUD oso bat** (ikasleak sortu, zerrendatu, aldatu eta ezabatu).

Orri hori eskolako web orriaren administratzailearentzat utziko da, eta aurretik eskolako beste `index` bat sortu beharko da:

1. Egindako orriari izena aldatu: **`administrazioa.php`**
2. **`index.php`** berria sortu, honekin:
   - Ikastetxean ematen diren kurtso guztien zerrenda bat
   - Goian, login-a egiteko edo erregistratzeko menu bat
3. Erregistratzen uzteko, aurretik administratzaileak ikaslea taulan sartuta eduki behar du.
4. Login-a eginda, kurtso bakoitzaren alboan matrikulatzeko botoi bat agertuko da.
5. Login-a egiten duena administratzailea bada, zuzenean `administrazioa.php` orrira eraman behar zaio.
6. Datu-basean beste bi taula sortu: **`Usuarios`** eta **`Cursos`**.

> Klaseak nahi badira erabili: `Model` karpeta bat sortu eta hiru klase (taula bakoitzarentzat bat), datu-basera egiten diren atzipen guztien metodoekin.

**Hacking etikoa:** enpresa bat hackeatzeko jarraitu beharreko pausoak eta pauso bakoitzean erabili daitezkeen tresnak definitu. Pentesting-eko dokumentazio-egitura ere sortu.

**Auzitegi-analisia:** oinarrizko analisi bat abiarazi (identifikatu eta babestu, zaintza-katea bermatuta), aurrerago egingo diren analisietarako.

**Sareak/sistemak:** talde bakoitzak bere azpisarea eta zerbitzariak konfiguratu behar ditu, gutxienez lau esparrurekin:

- Web gunea kokatuko den DMZ
- Erabiltzaileen sarea
- Zerbitzarien sarea
- Sistemen sarea

**Prebentzioa:** gertakarien aurrean nola jokatu jasoko duen oinarrizko prebentzio-plana eta kontzientziazio-kanpaina bat zehaztu.

---

## 2. Helburuak / Ikasketa-emaitzak (OKD)

### Oinarrizko funtsak

- **IE1** — Ordenagailuak eta periferikoak sare kableatu/hari gabekoetan integratu eta ebaluatu
  - Sare-estandarrak identifikatu
  - IP helbideratze logikoa erabili
  - Sare-egokigailuak konfiguratu hainbat SEtan
- **IE2** — Informazioa segurtasunez tratatu eta ahuleziak identifikatu
  - Segurtasun fisiko vs logiko
  - Ingeniaritza soziala
  - Biometria
  - Kriptografia
  - Komunikazio-protokolo seguruak
- **IE3** — Sistema eragileen funtzio aurreratuak administratu
  - Segurtasun-politika zentralizatuak
  - Abioko prozesuak/fitxategiak
  - Konfigurazio-fitxategiak
  - Prozesuak eta logak aztertu
- **IE4** — Programa errazak egin datu-baseetan sartuta
  - Aldagaiak, egitura baldintzatzaile/errepikakorrak
  - Datu-egiturak, funtzioak, moduluak/paketeak
  - Errore-kudeaketa
  - CRUD oinarrizkoa

### Sareak eta sistemak gotortzea

- **IE1** — Bideratzailearen oinarrizko funtzioak: konfigurazio-sarbidea, bide estatikoak, konfigurazio-fitxategiak, trafiko-iragazkiak, ACLak, NAT, port forwarding
- **IE2** — VLANak konfiguratu: sare lokal birtualak, lotura nagusiak, switch/router multilayer, administrazio zentralizatua

### Ekoizpen seguruan jartzea

- **IE1** — POO oinarriak: objektuak, propietateak/metodoak, metodo estatikoak, eraikitzaileak, liburutegiak
- **IE2** — Klase anitzeko programak: klaseen sintaxia, herentzia, klase heredatuak, interfazeak
- **IE3** — POO ezaugarri aurreratuak: superklase/azpiklase, hierarkiak diseinatu/probatu

### Auzitegi-analisi informatikoa

- **IE1** — Metodologiak aplikatu (babeste, eskuratze, analisi, dokumentatze fasean): gailuak identifikatu, ebidentziak eskuratu, zaintza-katea, denbora-lerroa, ondorio-txostena (teknikoa/exekutiboa)

### Hacking etikoa

- **IE1** — Monitorizazio-tresnak zehaztu: intrusio-testaren irismena, ahulezia/eraso-motak, merkatuko tresnak erakunde motaren arabera

### Zibersegurtasunaren arloko araudia

- **IE1** — Betetze-puntuak eta erantzukizunak identifikatu: araudi-oinarriak, gobernu ona, politikak/prozedurak, arduradunaren eginkizunak, hirugarrenekiko harremanak
- **IE2** — Legeria/jurisprudentzia aplikatu: ISO 19600, ISO 31000, dokumentazioa

### Zibersegurtasuneko gertakariak

- **IE1** — Prebentzio- eta kontzientziazio-planak: printzipio orokorrak, lanpostuaren babes-araua, kontzientziazio-plana eta materiala, ikuskaritza

---

## 3. Zeharkakoak eta Garapena

### Zeharkakoak

| Konpetentzia | Pisua | Nork |
|---|---|---|
| Autonomia | 25% | Irakasleak bakarrik |
| Inplikazioa | 25% | Irakasleak eta ikasleak |
| Ahozko komunikazioa (aurkezpena) | 20% | Irakasleak bakarrik |
| Taldeko lana | 30% | Irakasleak eta ikasleak |

### Garapena

| Konpetentzia | Pisua |
|---|---|
| Planifikazioa | 20% |
| Dokumentazioa | 40% |
| Kontrol puntuak (jarraipena) | 40% |

---

## 4. Taldeak

Erronka garatzeko, eguneroko lanerako ezarri diren taldeetan egingo da lan (4 pertsonako taldeak).

---

## 5. Ebaluazioa

| Ehunekoa | 50% | | 50% | | |
|---|---|---|---|---|---|
| **%** | 15% | 35% | 10% | 15% | 25% |
| **Kontzeptua** | Erronkako garapen nota (gehigarriak, aurkezpena) | Ikasgaiko nota teknikoa | Autoebaluazioa | Koebaluazioa | Irakasle guztiek |
| **Nork ebaluatzen du** | Irakasle guztiek | Ikasgai bakoitzeko irakasleak | Ikasle bakoitzak bere burua | Erronkako taldekideek | Irakasle guztiek |
| **Errubrika** | OROKORRAK | TEKNIKOA | ZEHARKAKOAK | ZEHARKAKOAK | ZEHARKAKOAK |

---

## 6. Denboralizazioa

| Astelehena | Asteartea | Asteazkena | Osteguna | Ostirala |
|---|---|---|---|---|
| | | | 10 — KLASEAK - Aurkezpen orokorra | 11 — KLASEAK |
| 14 — KLASEAK | 15 — KLASEAK | 16 — KLASEAK | 17 — KLASEAK | 18 — KLASEAK |
| 21 — KLASEAK | 22 — **AZTERKETA** (Oinarriak + Gorabeherak) | 23 — Erronka 1: proposamenaren aurkezpena | 24 — Erronka 1 | 25 — Erronka 1 |
| 28 — Erronka 1 | 29 — Erronka 1 | 30 — Erronka 1 | 1 — Erronka 1 | 2 — Erronka 1 |
| 5 — Erronka 1: **aurkezpena** | | | | |

---

## Lizentzia

Lan hau **UNIEIBAR-ERMUA**k sortu du eta **Creative Commons CC-BY** lizentziarekin banatzen da.