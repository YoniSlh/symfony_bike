<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018143128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEBC577D1');
        $this->addSql('DROP INDEX UNIQ_D34A04ADEBC577D1 ON product');
        $this->addSql('ALTER TABLE product DROP type, CHANGE type_nom_id type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADC54C8C93 ON product (type_id)');
        $this->addSql('ALTER TABLE type CHANGE type_nom type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE type CHANGE type type_nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADC54C8C93');
        $this->addSql('DROP INDEX UNIQ_D34A04ADC54C8C93 ON product');
        $this->addSql('ALTER TABLE product ADD type INT NOT NULL, CHANGE type_id type_nom_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEBC577D1 FOREIGN KEY (type_nom_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADEBC577D1 ON product (type_nom_id)');
    }
}
