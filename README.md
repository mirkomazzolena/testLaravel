# Calcolatore del fattore KXPO

## Descrizione

Questa applicazione si occupa di calcolare il fattore KXPO partendo da alcuni parametri forniti nella homepage del progetto.

## Specifiche Tecniche

L'applicazione è basata su Laravel 11. Lo sviluppo è avvenuto su ambiente Docker.

I file di configurazione di Docker sono i seguenti:

```
docker-compose.yml
Dockerfile
docker/
```

Il progetto può comunque funzionare anche senza docker e dunque senza i file sopra citati.

### Modalità di avvio per Docker

In ambiente Docker l'applicazione può essere avviata con i seguenti comandi:

```
docker-compose build
docker-compose up -d
docker-compose execute app composer install
```

L'applicazione sarà poi raggiungibile all'url http://localhost:8085

### Modalità di avvio standard

Avvelendosi di un server locale Apache/Nginx + php + composer è possibile avviare l'applicazione con il seguente comando:

```
php artisan serve
composer install
```

L'applicazione sarà poi raggiungibile all'url http://localhost:8000
