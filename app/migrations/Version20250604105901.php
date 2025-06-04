<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604105901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add test data for demo';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO company (name) VALUES ('Telecom Paris')");

        $this->addSql("INSERT INTO product_brand (name) VALUES ('Apple'), ('Samsung'), ('Huawei')");

        $this->addSql("INSERT INTO product_color (name) VALUES 
            ('Gris sideral'), ('Blanc'), ('Noir'), ('Or'), ('Argent')");

        $this->addSql("INSERT INTO product (brand_id, name, description, price) VALUES 
            (1, 'iPhone 12 Pro', 'L\'iPhone 12 Pro est un smartphone haut de gamme avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G.', 899),
            (1, 'iPhone 12 Pro Max', 'L\'iPhone 12 Pro Max est un smartphone haut de gamme d\'Apple, avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G. Il est la version maximisée de l\'iPhone 12 Pro.', 1099),
            (1, 'iPhone 12', 'L\'iPhone 12 est un smartphone haut de gamme d\'Apple, avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G. Il est également disponible en version Mini.', 799),
            (1, 'iPhone 12 Mini', 'L\'iPhone 12 Mini est un smartphone haut de gamme d\'Apple, avec un petit écran, un appareil photo professionnel, une puce rapide et une connexion 5G. Il est la version compacte de l\'iPhone 12.', 699),
            (2, 'Galaxy S21', 'Le Galaxy S21 est un smartphone haut de gamme de Samsung, avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G.', 849),
            (2, 'Galaxy S21 Ultra', 'Le Galaxy S21 Ultra est un smartphone haut de gamme de Samsung, avec un écran encore plus grand, un appareil photo professionnel avancé, une puce rapide et une connexion 5G.', 1199),
            (2, 'Galaxy S21+', 'Le Galaxy S21+ est un smartphone haut de gamme de Samsung, avec un écran plus grand que le S21 mais moins grand que le S21 Ultra, un appareil photo professionnel, une puce rapide et une connexion 5G.', 999),
            (3, 'HuaWei P40 Pro', 'Le HuaWei P40 Pro est un smartphone haut de gamme de Huawei, avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G.', 899),
            (3, 'HuaWei P40', 'Le HuaWei P40 est un smartphone haut de gamme de Huawei, avec un grand écran, un appareil photo professionnel, une puce rapide et une connexion 5G.', 699),
            (3, 'HuaWei P40 Lite', 'Le HuaWei P40 Lite est un smartphone haut de gamme de Huawei, avec un grand écran, un appareil photo professionnel de qualité décente, une puce rapide et une connexion 5G. Il est moins cher que les autres modèles de la série P40.', 399)");

        $this->addSql("INSERT INTO product_detail (product_id, screen_size, storage_capacity, operating_system, network) VALUES 
            (1, '6.1 pouces', '128 Go', 'iOS 14', '5G'),
            (2, '6.7 pouces', '128 Go', 'iOS 14', '5G'),
            (3, '6.1 pouces', '128 Go', 'iOS 14', '5G'),
            (4, '5.4 pouces', '128 Go', 'iOS 14', '5G'),
            (5, '6.2 pouces', '128 Go', 'Android 11', '5G'),
            (6, '6.8 pouces', '128 Go', 'Android 11', '5G'),
            (7, '6.5 pouces', '128 Go', 'Android 11', '5G'),
            (8, '6.5 pouces', '128 Go', 'Android 11', '5G'),
            (9, '6.5 pouces', '128 Go', 'Android 11', '5G'),
            (10, '6.76 pouces', '128 Go', 'Android 11', '5G')");

        $this->addSql("INSERT INTO product_stock (product_id, color_id, quantity) VALUES 
            (1, 1, 12), (1, 2, 8), (1, 3, 15), (1, 4, 3), (1, 5, 7),
            (2, 1, 5), (2, 2, 11), (2, 3, 9), (2, 4, 14), (2, 5, 2),
            (3, 1, 10), (3, 2, 6), (3, 3, 13), (3, 4, 1), (3, 5, 8),
            (4, 1, 4), (4, 2, 12), (4, 3, 7), (4, 4, 15), (4, 5, 9),
            (5, 1, 11), (5, 2, 3), (5, 3, 14), (5, 4, 6), (5, 5, 10),
            (6, 1, 8), (6, 2, 13), (6, 3, 2), (6, 4, 11), (6, 5, 5),
            (7, 1, 15), (7, 2, 7), (7, 3, 12), (7, 4, 4), (7, 5, 9),
            (8, 1, 6), (8, 2, 14), (8, 3, 1), (8, 4, 10), (8, 5, 13),
            (9, 1, 9), (9, 2, 5), (9, 3, 11), (9, 4, 8), (9, 5, 15),
            (10, 1, 3), (10, 2, 12), (10, 3, 6), (10, 4, 14), (10, 5, 4)");

        $hashedPassword = '$2y$13$QdtzJCt1Mce7LW6SoeaYE.Ec8P7kr8nyKTSxP9UHUcyQ3LcoC6sk2';

        $this->addSql("INSERT INTO customer (company_id, first_name, last_name, email, password, roles, phone_number) VALUES 
            (1, 'Julien', 'Martin', 'julien.martin@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0612345678'),
            (1, 'Marie', 'Dubois', 'marie.dubois@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0698765432'),
            (1, 'Pierre', 'Durand', 'pierre.durand@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0656789123'),
            (1, 'Sophie', 'Lefebvre', 'sophie.lefebvre@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0634567891'),
            (1, 'Nicolas', 'Roux', 'nicolas.roux@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0645678912'),
            (1, 'Amelie', 'Moreau', 'amelie.moreau@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0623456789'),
            (1, 'Thomas', 'Simon', 'thomas.simon@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0678912345'),
            (1, 'Camille', 'Laurent', 'camille.laurent@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0689123456'),
            (1, 'Antoine', 'Leroy', 'antoine.leroy@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0612347856'),
            (1, 'Emma', 'Garcia', 'emma.garcia@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0634785612'),
            (1, 'Lucas', 'David', 'lucas.david@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0645781236'),
            (1, 'Lea', 'Bertrand', 'lea.bertrand@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0656781234'),
            (1, 'Hugo', 'Petit', 'hugo.petit@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0667812345'),
            (1, 'Chloe', 'Robert', 'chloe.robert@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0678123456'),
            (1, 'Maxime', 'Richard', 'maxime.richard@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0689234567'),
            (1, 'Clara', 'Duval', 'clara.duval@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0612348567'),
            (1, 'Arthur', 'Lemoine', 'arthur.lemoine@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0634856712'),
            (1, 'Manon', 'Morel', 'manon.morel@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0645671238'),
            (1, 'Romain', 'Girard', 'romain.girard@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0656712384'),
            (1, 'Lola', 'Blanc', 'lola.blanc@email.fr', '$hashedPassword', '[\"ROLE_CUSTOMER\"]', '0667123845'),
            (1, 'Admin', 'Bilemo', 'admin@bilemo.fr', '$hashedPassword', '[\"ROLE_ADMIN\"]', '0689345672')");

        $this->addSql("INSERT INTO customer_address (customer_id, country, city, postal_code, address, address_details) VALUES 
            (1, 'France', 'Paris', 75001, '15 rue de Rivoli', 'Appartement 3B'),
            (2, 'France', 'Lyon', 69001, '23 avenue des Champs', NULL),
            (3, 'France', 'Marseille', 13001, '42 boulevard Saint-Jean', 'Etage 2'),
            (4, 'France', 'Toulouse', 31000, '8 place du Capitole', NULL),
            (5, 'France', 'Nice', 6000, '17 promenade des Anglais', 'Residence Azur'),
            (6, 'France', 'Nantes', 44000, '33 cours Cambronne', NULL),
            (7, 'France', 'Strasbourg', 67000, '21 rue de la Krutenau', 'Bat C'),
            (8, 'France', 'Montpellier', 34000, '14 place de la Comedie', NULL),
            (9, 'France', 'Bordeaux', 33000, '29 cours de l Intendance', 'Appt 12'),
            (10, 'France', 'Lille', 59000, '5 grand place', NULL),
            (11, 'France', 'Rennes', 35000, '18 place des Lices', 'Rez-de-chaussee'),
            (12, 'France', 'Reims', 51100, '7 place Drouet d Erlon', NULL),
            (13, 'France', 'Le Havre', 76600, '12 boulevard Clemenceau', 'Villa Marina'),
            (14, 'France', 'Saint-Etienne', 42000, '26 rue Gambetta', NULL),
            (15, 'France', 'Toulon', 83000, '9 avenue de la Republique', 'Residence Soleil'),
            (16, 'France', 'Grenoble', 38000, '31 cours Jean Jaures', NULL),
            (17, 'France', 'Dijon', 21000, '13 place Darcy', 'Appartement 7'),
            (18, 'France', 'Angers', 49000, '20 place du Ralliement', NULL),
            (19, 'France', 'Nimes', 30000, '6 boulevard Victor Hugo', 'Maison individuelle'),
            (20, 'France', 'Villeurbanne', 69100, '16 cours Emile Zola', NULL)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM customer_address');
        $this->addSql('DELETE FROM customer');
        $this->addSql('DELETE FROM product_stock');
        $this->addSql('DELETE FROM product_detail');
        $this->addSql('DELETE FROM product');
        $this->addSql('DELETE FROM product_color');
        $this->addSql('DELETE FROM product_brand');
        $this->addSql('DELETE FROM company');
    }
}
