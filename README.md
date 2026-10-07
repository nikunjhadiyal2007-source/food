# LDCE FoodHub

## Run on the phone with AWebServer

1. Extract the ZIP contents into AWebServer's **Document Root**. Keep `index.php` directly in that folder, not inside an extra nested folder.
2. In AWebServer, start both **Apache** and **MariaDB/SQL** and wait for both to show **Running**.
3. Open the website at the address AWebServer shows, for example `http://192.168.0.168/` (include its port if shown).
4. On the first open, the app automatically creates the `restaurant` database and its tables/menu data. You do not need to import SQL manually. If you prefer phpMyAdmin, the included `IMPORT_DATABASE.sql` is available as a manual alternative on a fresh database.

### Admin login

- Username: `admin`
- Password: `Admin@123`

The demo admin is created automatically on a fresh local install. Keep AWebServer private to your own device or trusted Wi-Fi while using this demo account.

If the site still shows a database error, check AWebServer's **MariaDB/SQL** panel first: its status must say **Running**. The local defaults are host `127.0.0.1`, port `3306`, user `root`, and password `root`; if you changed the MariaDB password or port, update `DB_PASSWORD` or `DB_PORT` in `config/db.php`.

## Public hosting

For a public host, use PHP 8.1+, MySQL/MariaDB, and a dedicated database user. Import `database/restaurant.sql`, configure `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD`, and create the first admin from a registered account in the database. Do not use the local demo admin credentials on a public site.
