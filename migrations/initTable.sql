
CREATE TABLE IF NOT EXISTS identifiant (
    id       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom        VARCHAR(255) NOT NULL,
    prenom       VARCHAR(255),
    adress_email VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (id)
) ENGINE=InnoDB ;


CREATE TABLE IF NOT EXISTS avis (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    identifiant_id INT UNSIGNED,
    commentaire TEXT(600) NOT NULL,
    note TINYINT UNSIGNED DEFAULT 1 ,
    PRIMARY KEY (id),
    CONSTRAINT  fk_avis
        FOREIGN KEY (identifiant_id)
        REFERENCES identifiant (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    identifiant_id INT UNSIGNED,
    numero_telephone INT UNSIGNED NOT NULL,
    message TEXT(600) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT  fk_contact
    FOREIGN KEY (identifiant_id)
    REFERENCES identifiant (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS user(
    identifiant_id INT UNSIGNED,
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
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prix INT UNSIGNED NOT NULL ,
    annee_fabrication date NOT NULL,
    kilometrage INT UNSIGNED NOT NULL,
    PRIMARY KEY (id)
    )ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS option_voiture (
    voiture_occassion_id INT UNSIGNED NOT NULL,
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
    voiture_occassion_id INT UNSIGNED NOT NULL,
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

CREATE TABLE IF NOT EXISTS service_garage(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    nom_service VARCHAR(255) NOT NULL UNIQUE
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS image_voiture(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    voiture_occassion_id INT UNSIGNED NOT NULL ,
    path_image VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT  fk_image_voiture
        FOREIGN KEY (voiture_occassion_id)
            REFERENCES voiture_occassion (id)
            ON DELETE CASCADE
            ON UPDATE RESTRICT
)ENGINE=InnoDB;
