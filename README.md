Stories\_free
=============

**API REST Symfony**, entre autre, permettant la récupération d'histoires.  
Pour initialiser le projet il est nécessaire d'executer quelques **commandes** dans un premier temps :

*   composer i _(Pour installer les dépendances)_
*   php bin/console doctrine:database:create _(Création de la base de donnée)_
*   php bin/console doctrine:migrations:migrate _(ou d:m:m afin de migrer la structure de la base de données dans celle que l'on vient de créer)_
*   php bin/console doctrine:fixtures:load (ou d:f:l afin d'executer les fixtures mises en place par l'application, pour avoir du contennu visuel)

  
Penser à créer un fichier **'.env.local'** pour surcharger les variables d'environnement, et pour sécuriser les données sensibles (ce fichier n'étant pas versionné).  
Pour lancer l'app il suffit de se mettre à la racine du projet et d'executer cette commande (ex :) **'php -S 127.0.0.1:8000 -t public'** ou bien de créer un virtualhost via WAMP par exemple.
