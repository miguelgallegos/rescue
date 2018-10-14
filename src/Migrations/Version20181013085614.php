<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181013085614 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_pokemon_type (pokemon_id INT NOT NULL, pokemon_type_id INT NOT NULL, INDEX IDX_F1F052B32FE71C3E (pokemon_id), INDEX IDX_F1F052B3A926F002 (pokemon_type_id), PRIMARY KEY(pokemon_id, pokemon_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon_pokemon_type ADD CONSTRAINT FK_F1F052B32FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_pokemon_type ADD CONSTRAINT FK_F1F052B3A926F002 FOREIGN KEY (pokemon_type_id) REFERENCES pokemon_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pokemon_pokemon_type DROP FOREIGN KEY FK_F1F052B32FE71C3E');
        $this->addSql('ALTER TABLE pokemon_pokemon_type DROP FOREIGN KEY FK_F1F052B3A926F002');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_pokemon_type');
        $this->addSql('DROP TABLE pokemon_type');
    }
}
