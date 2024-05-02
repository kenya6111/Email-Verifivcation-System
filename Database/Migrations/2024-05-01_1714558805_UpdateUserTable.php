<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class UpdateUserTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["ALTER TABLE users ADD COLUMN email_verified_at DATE"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [ "ALTER TABLE users DROP COLUMN email_verified_at"];
    }
}