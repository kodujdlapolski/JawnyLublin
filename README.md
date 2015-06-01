# Witamy w repozytorium kodu serwisu Jawny Lublin

Bazując na tym serwisie załóż portal Jawne Miasto w swoim mieście i podziel się z nami efektami!

Serwis http://JawnyLublin.pl został oryginalnie stworzony przez [Fundację Wolności](http://www.fundacjawolnosci.org/) studio [RedPapaya](http://redpapaya.pl/).
 
## Instalacja

1. Wypakuj pliki z tego repozytorium
2. W zrzucie bazy danych (database.mysql.dump) podmień adres `http://jawnylublin.pl` na docelowy adres portalu 
oraz mail jawnylublin@kodujdlapolski.pl na twój mail.
3. Stwórz bazę danych MySQL: `CREATE DATABASE jawny CHARACTER SET utf8 COLLATE utf8_general_ci;`
4. Stwórz użytownika MySQL i nadaj prawa: `CREATE USER jawny IDENTIFIED BY 'jawny';` `GRANT ALL ON jawny.* TO jawny@localhost;`
5. Stwórz plik `wp-config.php` na podstawie `wp-config.php.sample` i uzupełnij
6. Wejdź na `/wp-admin` i zresetuj hasło do konta, które podałeś w punkcie 2.
7. Uzupełnij dane w portalu!

