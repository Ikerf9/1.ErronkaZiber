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

## 6. Datuen antolaketa eta zaintza

Datu-baseak erabiltzaileen, rolen, ikastaroen eta matrikulen informazioa gordetzen du. Informazio hori lotuta dago, ikasle bakoitzaren matrikulak eta ikastaro bakoitzeko parte-hartzaileak ezagutzeko.

Sistemak helbide elektroniko errepikatuak eta ikastaro bereko matrikula bikoiztuak eragozten ditu. Plaza libreak matrikula aktiboen arabera kalkulatzen dira.

Matrikula desaktibatzean, haren informazioa mantentzen da, baina plaza libre geratzen da. Datuak ez galtzeko, arduradunak aldizkako babeskopiak egin behar ditu.

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
