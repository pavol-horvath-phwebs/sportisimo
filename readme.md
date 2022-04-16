# Vypracovanie projektu - Sportisimo

## Návrh DB tabuľky pre značky

### brands

- id (integer, primárny kľúč, autoincrement)
- name (string, NOT NULL)
- create_at (datetime, default NOW())
- update_at (datetime, defalut NOW())

### SQL pre vytvorenie tabuľky

~~~mysql
CREATE TABLE `brands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `create_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;
~~~

### SQL pre naplnenie počiatočnými dátami

~~~mysql
INSERT INTO brands (name) VALUE
  ('Abus'),
  ('Acer'),
  ('Adidas'),
  ('Alpina'),
  ('Atomic'),
  ('Bauer'),
  ('Bergns'),
  ('Blizzard'),
  ('Boma'),
  ('Calvin Klein'),
  ('Castelli'),
  ('CITY BOSS'),
  ('dIESEL'),
  ('Fabric'),
  ('Fischer'),
  ('Gabel'),
  ('Galaxy'),
  ('Gladiator'),
  ('Hotronic'),
  ('Joma'),
  ('Mango'),
  ('Mikasa'),
  ('Nordica'),
  ('Puma'),
  ('Reebok'),
  ('Resuch'),
  ('Scott'),
  ('Warrior');
~~~

## Autentifikácia

Na prihlásenie je k dispozícii iba 1 používateľ nastavený v configu.

V prípade potrieb reálnej aplikácie by bol vytvorený Autentifikátor napojený na databázu.

### Prihlasovacie údaje

- Login: **admin**
- Password: **admin**

## Štýlovanie pomocu SASS

- Zdrojový súbor: **resources/app.scss**
- Spôsob konvertovania SASS súboru na CSS je extension Laravel MIX
- Pravidlá konvertovania sú definované v súbore **webpack.mix.js**
- Príkazy pre spustenie konvertovania sú v súbore **package.json**