<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240613055441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create sheet tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE checkouts_sheet (
                id SERIAL PRIMARY KEY,
                book_id UUID NOT NULL,
                status VARCHAR(20) NOT NULL,
                checkout_event_id UUID UNIQUE,
                checked_out_by_patron_id UUID,
                checked_out_at TIMESTAMP,
                returned_at TIMESTAMP,
                checked_out_at_branch UUID,
                checkout_till TIMESTAMP
             );
        ');

        $this->addSql('
            CREATE TABLE holds_sheet (
                id SERIAL PRIMARY KEY,
                book_id UUID NOT NULL,
                status VARCHAR(20) NOT NULL,
                hold_event_id UUID UNIQUE,
                hold_at_branch UUID,
                hold_by_patron_id UUID,
                hold_at TIMESTAMP,
                hold_till TIMESTAMP,
                expired_at TIMESTAMP,
                canceled_at TIMESTAMP,
                checked_out_at TIMESTAMP
             );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE checkouts_sheet');
        $this->addSql('DROP TABLE holds_sheet');
    }
}
