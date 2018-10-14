Rescue Test

 **Instructions**
 
    git clone https://github.com/miguelgallegos/rescue.git
    
    cd rescue

    composer install

In MySQL, create a database called 'pkm'. The application is assuming that there is a DB in localhost:3306, with **root** and no password.

Proceed to with DB tables creation and initialization:

    bin/console doctrine:migrations:migrate --no-interaction

    bin/console app:import-pokemons https://gist.githubusercontent.com/andygroff/274283a38f2786796df57e11738d6bba/raw/f8eb9332ac08a4ee75767bcd76904f001cb6ec37/pokemon.json

Front-end is being handled through Webpack Encore:

    yarn install
For Mac OS thru **brew**

    brew install yarn
Then continue with jquery installation and compiling:

    yarn add jquery

    yarn encore dev

Finally, run the app as:

    bin/console server:run

And open the following URL in a browser: 

    http://127.0.0.1:8001/pokemon
    //or any given port





