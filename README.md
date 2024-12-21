# Comment installer le projet

- ``git clone https://github.com/arizona-08/tp_symfony``
- ``docker compose build --no-cache``
- ``docker compose up -d``
- ``docker compose exec -it web_app composer install``
- ``docker compose exec -it web_app php bin/console doctrine:fixtures:load``
- ``docker compose exec -it web_app php bin/console tailwind:build --watch``

## les différents rôles:

- Role admin:
    email: admin@test.com
    mdp: coucou

- Role coach1:
    email: coach1@test.com
    mdp: coucou

- Role coach2:
    email: coach2@test.com
    mdp: coucou

- Role client1:
    email: client1@test.com
    mdp: coucou

- Role client2:
    email: client2@test.com
    mdp: coucou

- Role client3:
    email: client3@test.com
    mdp: coucou

- Role bannis:
    email: banned@test.com
    mdp: coucou