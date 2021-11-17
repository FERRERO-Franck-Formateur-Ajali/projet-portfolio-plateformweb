<div align="center">
<h1>PROJET PORTFOLIO PLATEFORMWEB</h1>
<img src="/public/images/symfony.svg" alt="symfony">
<h3>:boom: SYMFONY 5.3.10 avec Easyadmin3 :boom:</h3>
</div>
       
### Cloner le projet  
Cloner le projet:    
```
$ git clone https://github.com/FERRERO-Franck-Formateur-Ajali/projet-portfolio-plateformweb.git
```
     
### Installer les dépendances/vendor    
```
$ composer install  
```
    
### Fichier environnement  
Copier et coller le fichier __.env__ à la racine du projet  
Renommer la copie en __.env.local__  
  
### Configurer le fichier .env.local avec vos identifiants SQL  
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"    
db_user pour login phpmyadmin       
db_password pour password phpmyadmin      
db_name pour le nom de la base de donnée    
```
       
### Créer la database   
```
$ php bin/console doctrine:database:create   
```
    
### Ajouter les entités a la database    
```
$ php bin/console make:migration  
$ php bin/console doctrine:migrations:migrate  
```
    
### Lancer le server 
```
$ symfony server:start  
```

### Dans un nouveau terminal 
Crée un controller test avec une vue test ou vous pouvez faire vos tests code.     
```
$ symfony console make:controller TestController     
```

### Ligne de commandes les plus utilisées lors du projet    
```
# crée un nouveau controller et sa vue associée      
$ symfony console make:controller   
           
# crée un nouveau formulaire associé a une entité ou pas          
$ symfony console make:form          
      
# crée une nouvelle entité            
$ symfony console make:entity          
      
# crée les migrations des entités                  
$ symfony console make:migration        
           
# met à jour la base de donnée avec les migrations                            
$ symfony console doctrine:migrations:migrate              
```

### Liens utiles      
- Symfony.exe: https://symfony.com/download    
- Documentation symfony: https://symfony.com/doc/current/index.html         
- Twig: https://twig.symfony.com/doc/3.x/      
- EasyAdmin3: https://symfony.com/bundles/EasyAdminBundle/current/index.html   
