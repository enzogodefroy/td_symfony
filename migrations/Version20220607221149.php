<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220607221149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE associatedproduct');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY basket_ibfk_1');
        $this->addSql('ALTER TABLE basket CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE basketdetail DROP FOREIGN KEY basketdetail_ibfk_1');
        $this->addSql('ALTER TABLE basketdetail DROP FOREIGN KEY basketdetail_ibfk_2');
        $this->addSql('ALTER TABLE basketdetail DROP quantity');
        $this->addSql('ALTER TABLE basketdetail ADD CONSTRAINT FK_F246D8354157F8E1 FOREIGN KEY (idBasket) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE basketdetail ADD CONSTRAINT FK_F246D835C3F36F5F FOREIGN KEY (idProduct) REFERENCES product (id)');
        $this->addSql('ALTER TABLE basketdetail RENAME INDEX idproduct TO IDX_F246D835C3F36F5F');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY order_ibfk_1');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY order_ibfk_3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY order_ibfk_2');
        $this->addSql('ALTER TABLE `order` CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398684778AC FOREIGN KEY (idTimeslot) REFERENCES timeslot (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E3C5FFA FOREIGN KEY (idEmployee) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY orderdetail_ibfk_1');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY orderdetail_ibfk_2');
        $this->addSql('ALTER TABLE orderdetail DROP quantity, DROP prepared');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT FK_27A0E7F2E2EDD085 FOREIGN KEY (idOrder) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT FK_27A0E7F2C3F36F5F FOREIGN KEY (idProduct) REFERENCES product (id)');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idproduct TO IDX_27A0E7F2C3F36F5F');
        $this->addSql('ALTER TABLE product CHANGE idSection idSection INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY pack_ibfk_1');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY pack_ibfk_2');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23C3F36F5F FOREIGN KEY (idProduct) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23E42300BD FOREIGN KEY (idPack) REFERENCES product (id)');
        $this->addSql('ALTER TABLE pack RENAME INDEX idproduct TO IDX_97DE5E23E42300BD');
        $this->addSql('ALTER TABLE timeslot CHANGE full full TINYINT(1) NOT NULL, CHANGE expired expired TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE associatedproduct (idProduct INT NOT NULL, idAssoProduct INT NOT NULL, INDEX productsasso_ibfk_1 (idAssoProduct), INDEX IDX_6223DC7BC3F36F5F (idProduct), PRIMARY KEY(idProduct, idAssoProduct)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE associatedproduct ADD CONSTRAINT associatedproduct_ibfk_1 FOREIGN KEY (idAssoProduct) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE associatedproduct ADD CONSTRAINT associatedproduct_ibfk_2 FOREIGN KEY (idProduct) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BFE6E88D7');
        $this->addSql('ALTER TABLE basket CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT basket_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basketdetail DROP FOREIGN KEY FK_F246D8354157F8E1');
        $this->addSql('ALTER TABLE basketdetail DROP FOREIGN KEY FK_F246D835C3F36F5F');
        $this->addSql('ALTER TABLE basketdetail ADD quantity INT NOT NULL');
        $this->addSql('ALTER TABLE basketdetail ADD CONSTRAINT basketdetail_ibfk_1 FOREIGN KEY (idBasket) REFERENCES basket (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basketdetail ADD CONSTRAINT basketdetail_ibfk_2 FOREIGN KEY (idProduct) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basketdetail RENAME INDEX idx_f246d835c3f36f5f TO idProduct');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398FE6E88D7');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398684778AC');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E3C5FFA');
        $this->addSql('ALTER TABLE `order` CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT order_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT order_ibfk_3 FOREIGN KEY (idTimeslot) REFERENCES timeslot (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT order_ibfk_2 FOREIGN KEY (idEmployee) REFERENCES employee (id) ON UPDATE CASCADE ON DELETE SET NULL');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY FK_27A0E7F2E2EDD085');
        $this->addSql('ALTER TABLE orderdetail DROP FOREIGN KEY FK_27A0E7F2C3F36F5F');
        $this->addSql('ALTER TABLE orderdetail ADD quantity NUMERIC(6, 2) NOT NULL, ADD prepared TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT orderdetail_ibfk_1 FOREIGN KEY (idOrder) REFERENCES `order` (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetail ADD CONSTRAINT orderdetail_ibfk_2 FOREIGN KEY (idProduct) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idx_27a0e7f2c3f36f5f TO idProduct');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23C3F36F5F');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23E42300BD');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT pack_ibfk_1 FOREIGN KEY (idProduct) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT pack_ibfk_2 FOREIGN KEY (idPack) REFERENCES product (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack RENAME INDEX idx_97de5e23e42300bd TO idProduct');
        $this->addSql('ALTER TABLE product CHANGE idSection idSection INT NOT NULL');
        $this->addSql('ALTER TABLE timeslot CHANGE full full TINYINT(1) DEFAULT 0 NOT NULL, CHANGE expired expired TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
