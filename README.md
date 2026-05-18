# Portfolio

Een persoonlijke portfolio website gebouwd met PHP, MySQL, HTML en SCSS/CSS. De website toont een introductie, skills en projecten. Via een afgeschermde adminpagina kunnen skills en projecten worden toegevoegd, aangepast en verwijderd.

## Inhoud

- Publieke portfolio pagina met navigatie naar home, skills en projecten
- Dynamische skills en projecten uit een MySQL database
- Admin login met PHP sessies
- CRUD beheer voor skills en projecten
- Basis beveiliging met prepared statements, `password_verify()` en HTML escaping
- Responsive styling via SCSS/CSS

## Tech stack

- PHP
- MySQL
- PDO
- HTML
- SCSS/CSS

## Projectstructuur

```text
Portfolio/
|-- .github/
|-- img/
|   |-- BvdT.png
|   |-- Ouderavond.png
|   |-- Selfie.jpeg
|   |-- avatar.png
|   |-- dev-picto.png
|   |-- portfolio-web-logo.png
|   `-- Webshop.png
|-- scss/
|   |-- _variables.scss
|   |-- main.scss
|   `-- main.css
|-- admin.php
|-- config.php
|-- database.sql
|-- functions.php
|-- index.php
|-- login.php
|-- logout.php
`-- README.md
```

## Belangrijkste bestanden

| Bestand | Beschrijving |
| --- | --- |
| `index.php` | Publieke portfolio pagina. Haalt skills en projecten op uit de database. |
| `admin.php` | Adminomgeving voor het beheren van skills en projecten. |
| `login.php` | Loginformulier voor de admin. |
| `logout.php` | Logt de admin uit en vernietigt de sessie. |
| `functions.php` | Databaseverbinding, helperfuncties, logincontrole en redirects. |
| `config.php` | Databaseconfiguratie. |
| `database.sql` | SQL-script voor het aanmaken en vullen van de database. |
| `scss/main.scss` | Bronbestand voor de styling. |
| `scss/main.css` | Gecompileerde CSS die door de pagina's wordt ingeladen. |

## Installatie

### 1. Repository plaatsen

Plaats de repository in de webroot van je lokale server. Bijvoorbeeld met Laragon:

```text
C:\laragon\www\Portfolio
```

Open daarna de website via:

```text
http://localhost/Portfolio/
```

### 2. Database importeren

Maak de database aan door `database.sql` te importeren in MySQL. Dit kan bijvoorbeeld via phpMyAdmin:

1. Open phpMyAdmin.
2. Kies de optie importeren.
3. Selecteer `database.sql`.
4. Voer de import uit.

Het script maakt standaard een database met de naam `portfolio` aan en vult deze met voorbeelddata voor skills, projecten en een adminaccount.

### 3. Databaseconfiguratie instellen

Pas `config.php` aan zodat de gegevens overeenkomen met jouw MySQL omgeving:

```php
define("SERVERNAME", "localhost");
define("DATABASE", "portfolio");
define("USERNAME", "root");
define("PASSWORD", "");
```

Gebruik voor productie geen echte wachtwoorden direct in de repository. Zet gevoelige gegevens bij voorkeur buiten versiebeheer.

### 4. Website openen

Open de publieke portfolio:

```text
http://localhost/Portfolio/index.php
```

Open de admin login:

```text
http://localhost/Portfolio/login.php
```

## Adminomgeving

Na het inloggen kom je op `admin.php`. Daar kun je:

- skills toevoegen
- skills aanpassen
- skills verwijderen
- projecten toevoegen
- projecten aanpassen
- projecten verwijderen

Projecten bestaan uit:

- titel
- projectlink
- afbeeldingspad
- alt-tekst
- volgorde

Skills bestaan uit:

- titel
- beschrijving
- volgorde

De volgorde wordt bepaald door `sort_order`. Items met een lager getal worden eerder getoond.

## Admin wachtwoord wijzigen

De admin gebruiker wordt aangemaakt via `database.sql`. Het wachtwoord staat opgeslagen als hash. Wil je een nieuw wachtwoord instellen, genereer dan een nieuwe hash met PHP:

```php
<?php
echo password_hash('nieuw-wachtwoord', PASSWORD_DEFAULT);
```

Werk daarna de database bij:

```sql
UPDATE admins
SET password_hash = 'PLAK_HIER_DE_NIEUWE_HASH'
WHERE username = 'admin';
```

## Styling aanpassen

De styling staat in de map `scss/`.

- Pas variabelen aan in `scss/_variables.scss`.
- Pas algemene styling aan in `scss/main.scss`.
- Zorg dat wijzigingen worden gecompileerd naar `scss/main.css`, want dat bestand wordt ingeladen door de PHP pagina's.

Als Sass geinstalleerd is, kun je bijvoorbeeld compileren met:

```bash
sass scss/main.scss scss/main.css
```

Of automatisch laten meekijken:

```bash
sass --watch scss/main.scss scss/main.css
```

## Database tabellen

### `admins`

Bevat de adminaccounts voor de beheeromgeving.

| Kolom | Type | Beschrijving |
| --- | --- | --- |
| `id` | INT | Unieke id |
| `username` | VARCHAR | Gebruikersnaam |
| `password_hash` | VARCHAR | Gehashte wachtwoordwaarde |
| `created_at` | TIMESTAMP | Aanmaakdatum |

### `skills`

Bevat de skills die op de portfolio worden getoond.

| Kolom | Type | Beschrijving |
| --- | --- | --- |
| `id` | INT | Unieke id |
| `title` | VARCHAR | Titel van de skill |
| `description` | TEXT | Beschrijving van de skill |
| `sort_order` | INT | Volgorde op de pagina |

### `projects`

Bevat de projecten die op de portfolio worden getoond.

| Kolom | Type | Beschrijving |
| --- | --- | --- |
| `id` | INT | Unieke id |
| `title` | VARCHAR | Titel van het project |
| `project_url` | VARCHAR | Link naar het project |
| `image_path` | VARCHAR | Pad naar de afbeelding |
| `image_alt` | VARCHAR | Alt-tekst voor toegankelijkheid |
| `sort_order` | INT | Volgorde op de pagina |

## Beveiliging

In deze repository zijn al een paar belangrijke beveiligingsmaatregelen aanwezig:

- Databasequeries gebruiken PDO prepared statements bij login en mutaties.
- Wachtwoorden worden gecontroleerd met `password_verify()`.
- Output wordt geescaped met de helperfunctie `e()`.
- Adminpagina's worden beschermd met `requireAdmin()`.
- Uitloggen vernietigt de actieve sessie.

Aanbevolen verbeteringen voor productie:

- Zet databasegegevens niet direct in `config.php` binnen versiebeheer.
- Gebruik HTTPS.
- Voeg CSRF-bescherming toe aan adminformulieren.
- Gebruik sterke adminwachtwoorden.
- Beperk foutmeldingen richting bezoekers.

## Ontwikkelen

Handige aandachtspunten tijdens het ontwikkelen:

- Voeg nieuwe afbeeldingen toe aan `img/`.
- Gebruik relatieve afbeeldingspaden zoals `img/Ouderavond.png`.
- Controleer na databasewijzigingen of `database.sql` nog actueel is.
- Test zowel de publieke pagina als de adminflow.
- Controleer formulieren op verplichte velden en correcte links.

## Mogelijke verbeteringen

- Contactformulier toevoegen
- Projectdetailpagina's maken
- Uploadfunctie voor projectafbeeldingen toevoegen
- Adminrollen uitbreiden
- CSRF-tokens toevoegen
- Validatie centraliseren in helperfuncties
- Deploymentconfiguratie toevoegen

## Auteur

Dion Breur

## Licentie

Er is nog geen licentie toegevoegd aan deze repository. Voeg een `LICENSE` bestand toe als je wilt vastleggen hoe anderen de code mogen gebruiken.
