sineo
=====

## Lancement

Pour faire tourner le projet :

```bash
git clone git@github.com:boninir/sineo.git
cd sineo
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```

Lancer ensuite un serveur php via :

```bash
php bin/console server:start
```

Il est maintenant possible d'accéder à l'application via le port 8000 :

```
http://127.0.0.1:8000
```
