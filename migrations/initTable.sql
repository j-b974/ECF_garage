CREATE TABLE IF NOT EXISTS identifiant (
    id       INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(255) NOT NULL,
    prenom       VARCHAR(255),
    adress_email VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB ;

CREATE TABLE IF NOT EXISTS avis (
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    identifiant_id INT(255) UNSIGNED,
    commentaire TEXT(600) NOT NULL,
    note TINYINT UNSIGNED DEFAULT 1 ,
    status enum('modifier','verifier','nouveau') NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT  fk_avis
        FOREIGN KEY (identifiant_id)
        REFERENCES identifiant (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact(
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    identifiant_id INT(255) UNSIGNED,
    numero_telephone INT(30) UNSIGNED NOT NULL,
    etat enum('nouveau','lu','traitement') NOT NULL,
    message TEXT(600) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT  fk_contact
    FOREIGN KEY (identifiant_id)
    REFERENCES identifiant (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user(
    identifiant_id INT(255) UNSIGNED,
    role enum('Employ','Administrateur') NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (identifiant_id),
    CONSTRAINT  fk_user
    FOREIGN KEY (identifiant_id)
    REFERENCES identifiant (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS voiture_occassion (
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    prix INT(255) UNSIGNED NOT NULL ,
    annee_fabrication date NOT NULL,
    kilometrage INT(255) UNSIGNED NOT NULL,
    PRIMARY KEY (id)
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS option_voiture (
    voiture_occassion_id INT(255) UNSIGNED NOT NULL,
    gps BOOLEAN ,
    radar_recule BOOLEAN,
    climatisation BOOLEAN,
    PRIMARY KEY (voiture_occassion_id),
    CONSTRAINT  fk_option
    FOREIGN KEY (voiture_occassion_id)
    REFERENCES voiture_occassion (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS caracteristique_voiture (
    voiture_occassion_id INT(255) UNSIGNED NOT NULL,
    carburant ENUM('essence','diesel','éléctrique'),
    nombre_porte TINYINT UNSIGNED ,
    boite_vitesse ENUM('manuel','semi-auto','automatique'),
    PRIMARY KEY (voiture_occassion_id),
    CONSTRAINT  fk_caracteristique
    FOREIGN KEY (voiture_occassion_id)
    REFERENCES voiture_occassion (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS titre_service(
    titre varchar(125) PRIMARY KEY
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS service_garage(
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    titre varchar(125) NOT NULL ,
    nom_service VARCHAR(255) NOT NULL ,
    label_Prix VARCHAR(125) NOT NULL ,
    PRIMARY KEY (id),
    CONSTRAINT  fk_titre
    FOREIGN KEY (titre)
    REFERENCES titre_service (titre)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS image_voiture(
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    voiture_occassion_id INT UNSIGNED NOT NULL ,
    path_image VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT  fk_image_voiture
        FOREIGN KEY (voiture_occassion_id)
            REFERENCES voiture_occassion (id)
            ON DELETE CASCADE
            ON UPDATE RESTRICT
)ENGINE=InnoDB;
