# ECF_garage
ECF en symfony 6 pour formation développeur web  promo  VITTI
cloner le projet symfony 

executer le fichier initTable.SQL qui se trouve dans  GarageWeb/migrations
      >> pour initialiser les tables
      
dans le fichier .Env vous devrez initialise 3 varible selon votre Basse de donné
      >> GARAGE_DATABASE_URL="mysql:host=localhost;dbname=bddName" 
      >> GARAGE_DATABASE_USER="root"
      >> GARAGE_DATABASE_PASSWORD="1234"

dans la console sur le repertoir ECF_garage lancer la commande
      >> bin/console FillGarageBDD 
      >> etre patient 2 minute

lancer le serveur de symfony 
      >> bin/console server:start -d

le site devrait etre accécible depuis votre navigateur 

enjoy !!!
