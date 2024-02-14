# Projet web - Site de vente de CD

## Présentation
Suite aux divers cours de travaux pratiques en PHP, nous ([@ToxykAuBleu](https://github.com/ToxykAuBleu) et [@Alakamar](https://github.com/Alakamar)) avons comme objectif de réaliser un site web de vente de CD. Voici le sujet de cet exercice :
```
1. Proposer un site qui affiche l’ensemble des CD (vignette de la pochette, titre, auteur/groupe). Lors de la sélection d’un titre on verra la pochette en taille réelle ainsi que l’ensemble des informations relatives au CD.

2. Proposer la fonctionnalité de sélection et de mise en panier. On simulera le paiement en vérifiant la saisie des 16 chiffres et vérifiant que le dernier est identique au premier, et que la date de validité est supérieure à la date du jour + 3 mois.  
*Remarque : afin de minimiser les temps de transferts, les vignettes seront de réelles vignettes (images générées en format réduit) et non pas les images redimensionnées avec WIDTH/HEIGHT d’IMG SRC.*

3. Proposer un accès sécurisé avec un back-office permettant l’ajout/suppression de CDs.

NB : Les CD pourront au choix être enregistrés sur une BD ou dans un fichier XML.
```

## Fonctionnalités supplémentaires
- Utilisation de [Bootstrap 5.3](https://getbootstrap.com/) pour le style des pages ainsi que des icônes.
- Possibilité de rechecher des CD de différentes manières : titre, genre, album.
- Application de la méthode AJAX sur la majorité du site (recherche de CD, gestion du panier).

## Installation
### Avant toute chose:
Afin d'installer le site web sur votre machine, vous devez vous assurer que vous avez :
- un serveur MySQL (version >= 5.7)
- Php (version >= 7.4)
- un serveur web (Apache2 ou NGINX) déjà un minimum configuré
- (Optionnel) git: Utile uniquement pour mettre à jour et pour cloner le dépot

### Processus d'installation:
> [!WARNING]  
> Nous prenons comme exemple un serveur Apache2 avec une configuration par défaut en ce qui concerne les hôtes virtules (répertoire par défaut normalement: `/var/www`).
1. Clôner le dépot, à la racine de votre site web, soit depuis une invite de commande (`git clone https://github.com/ToxykAuBleu/VenteCD`), soit en téléchargant le dossier ZIP.
2. Extraire l'archive (si c'est le dossier ZIP), puis déplacer vous dans le nouveau dossier avec `cd VenteCD/`
3. Créer un fichier de configuration `config.ini` en respectant le patron présent dans ce dépot (fichier `config.template.ini`)
4. Sur le serveur MySQL, créer une nouvelle base de données et un nouvel utilisateur puis exécuter la requête suivante sur cette nouvelle bdd:
```sql
DROP TABLE IF EXISTS CD;
CREATE TABLE CD (
    ID int(11) PRIMARY KEY,
    Titre varchar(50) NOT NULL,
    Auteur varchar(50) NOT NULL,
    Genre varchar(50) NOT NULL,
    Prix decimal(5,2) NOT NULL
);
```
5. Accéder au site en utilisant l'adresse du serveur web.
