# rescue
Instructions

git clone https://github.com/miguelgallegos/rescue.git

composer install

create schema pkm << add migration

bin/console doctrine:migrations:migrate --no-interaction

bin/console app:import-pokemons https://gist.githubusercontent.com/andygroff/274283a38f2786796df57e11738d6bba/raw/f8eb9332ac08a4ee75767bcd76904f001cb6ec37/pokemon.json

yarn install
brew install yarn
yarn add jquery
yarn encore dev

bin/console server:run

http://127.0.0.1:8001/pokemon
