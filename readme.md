IT1901 - NTNUI Koier
=======

Dette er repo-et som holder styr på utviklingen av et
reservasjonssystem for NTNUI sine koier. For å lese
mer om selve koiene kan du besøke deres [nettsider](http://org.ntnu.no/koiene/).
Systemet er utviklet i forbindelse med emnet IT1901 (Prosjekt 1).

### Kom i gang
For å gjøre endringer i systemet (legge til ny funksjonalitet for eksempel) anbefales det at du benytter deg av <code>git</code>.

1. ##### Klon kodebasen
For å klone kodebasen skriver du følgende i en terminal.
````bash
git clone git@github.com:michaelmcmillan/IT1901.git
composer install --prefer-dist
````

2. ##### Importer databasestrukturen
Start din lokale MySQL-server og skriv følgende i en terminal for å migrere databasen.
````bash
cd it1901
mysql -u*bruker* -p *passord* < schema.sql
````

3. ##### Start webserveren
Webserveren vil lytte på port http://localhost:1337 etter at kommandoen under er utført.
````bash
./serve.sh
````
### Filstruktur
Under vises en trestruktur over filene.
````
├── assets (ressurser)
│   ├── css
│   ├── fonts
│   └── js
├── controllers (kontrollere)
├── models (redbean orm)
├── vendor (biblioteker)
│   ├── composer
│   └── slim
│       └── slim
└── views  (frontend)
````


### API
Systemet eksponerer et API over HTTP. Dette lar deg utvikle eksterne systemer som kan utføre handlinger uten å være knyttet til denne kodebasen. Under følger en oversikt over metodene du kan kalle på i API-et. Metodene krever at man er innlogget. Noen metoder krever at brukeren som er innlogget er markert som en administrator.

#### Brukermetoder
De følgende metodene krever brukerrettigheter.

##### GET /cabins
Returnerer et JSON-objekt med metadata om en koie.

##### POST /reserve/[int:cabinId]
Lag en reservasjon på en koie.

##### GET /reservations
Returnerer et array med reservasjons-objekter for en gitt bruker.

##### POST /reservations/[int:reservationId]/report
Legg ved en rapport for et opphold.

##### GET /cabins/[int:cabinId]/inventory
Returnerer et array med inventar-objekter for en koie.

#### Administratormetoder
De følgende metodene krever brukerrettigheter.

##### GET /cabins/[int:cabinId]/status
Returnerer en statusrapport for inventar for en gitt koie.

##### GET /cabins/[int:cabinId]/statistics
Returnerer statistikk 6 måneder tilbake i tid for en gitt koie.

### Produksjonsdatabase
Dersom du ønsker å gjøre endringer på selve produksjonsdatabasen kan du bruke en MySQL-klient til å logge deg inn med følgende bruker. Passordet kan oppgis ved forespørsel.
- Host: <code>mysql.stud.ntnu.no</code>
- Bruker: <code>it1901gr16_bruke</code>
- Database: <code>it1901gr16_koier</code>

### Utvikling
For at endringene du har gjort lokalt skal bli reflektert på
serveren som faktisk kjører programvaren må du *merge*
koden din inn i <code>production</code> branchen i dette repo-et. For å holde orden i kodebasen må følgende prosedyre følges:
1. <code>git branch -d *funksjonsnavn*
2. Gjør kodeendringer.
3. <code>git add . && git commit -m '*hva gjør endringen*'
4. <code>git push origin *funksjonsnavn*</code>
5. Få utviklingspartneren din til å kontrollere koden din via. et pull-request.
6. Koden *merges* inn i <code>production</code> branchen.
7. Systemet på org.ntnu.no oppdaterer seg automatisk.

### Utviklere
Hvis du har noen spørsmål kan du ta kontakt med utviklerne på prosjektet.
- Erlend Midttun
- Masoom Maham
- Mathias Bratvold Nervik
- Michael McMillan
