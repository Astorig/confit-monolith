<?php

declare(strict_types=1);

use Cog\Laravel\Clickhouse\Migration\AbstractClickhouseMigration;

return new class extends AbstractClickhouseMigration
{
    public function up(): void
    {
        $this->clickhouseClient->write(
            <<<SQL
                CREATE TABLE IF NOT EXISTS users (
            id UInt32,
            name String,
            email String,
            phone UInt64,
            date_of_creation Datetime,
            date_of_change Datetime,
            remember_token String,
            email_verified_at Datetime
            )
            ENGINE = MergeTree()
            ORDER BY id
            SQL
        );
    }
};
