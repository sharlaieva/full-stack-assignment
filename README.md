# Jak spustit projekt

## Prerekvizity

Je potřeba mít na počítači nainstalovaný Docker, lze postupovat např. 
podle návodu: https://www.itnetwork.cz/site/docker/docker-teorie-a-instalace a nainstalovat 
si aplikaci Docker Desktop (https://docs.docker.com/desktop/setup/install/windows-install/).

Následně už lze otevřít příkazovou řádku a v adresáři se staženým repozitářem a spouštět jednotlivé příkazy.

## Spuštění serveru

```bash
docker compose build
docker compose up -d
```

API URL (Včetně DOC): http://localhost:8888
Contact app URL: http://localhost:3000


# Testy
Testy je možno doplnit pro techonolige, které řešitel zná. Případně jako bonus. Nejsou nutností řešení.
## Spuštění unit testů

```bash
docker compose exec php composer run test-unit
```

PHPUnit testy se nacházejí v adresáři `tests/unit`, kde lze doplňovat další testy, viz např. `FirstTest`.

## Spuštění codeception testů

1. Příprava
```bash
docker compose exec php composer run build-codecept
```

Zkopírovat soubor `tests/api/_envs/dev.yml.dist` do `tests/api/_envs/dev.yml`.

```bash
cp tests/api/_envs/dev.yml.dist tests/api/_envs/dev.yml
```

2. Spuštění

Před spuštěním testů musí být spuštěný server, poté:
```bash
docker compose exec php composer run test-api
```

Codeception testy se nacházejí v adresáři `tests/api`, kde lze doplňovat další testy, viz např. `GetIndexPageCest`.

## Spuštění react testů

```bash
docker compose exec reactApp npm run test
```

React testy lze doplňovat přímo do adresáře se zdrojovými kódy `contact-app/src`, kde lze doplňovat další testy, viz např. `App.test.tsx`.

## Spuštění cypress testů

Cypress lze spustit samostatně pomocí:

```bash
docker compose run cypress npx cypress run
```

nebo si nainstalovat Windows X Server: https://sourceforge.net/projects/vcxsrv/, spustit Xlaunch s 
"Disable access control" a následně spustit:

```bash
docker-compose up cypress -d
```

a otevře se Cypress GUI.

Cypress testy se nacházejí v adresáři `cypress/cypress/e2e`, kde lze doplňovat další testy, viz např. `spec.cy.ts`.
