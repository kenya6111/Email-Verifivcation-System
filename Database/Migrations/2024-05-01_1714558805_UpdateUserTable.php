<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class UpdateUserTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["ALTER TABLE users ADD COLUMN age Int
                                   ADD COLUMN address VARCHAR(255)
                                   ADD COLUMN hobby VARCHAR(255)
                                   ADD COLUMN self_introduction TEXT
                                   ADD COLUMN profile_image VARCHAR(255)"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [ "ALTER TABLE users DROP COLUMN email_verified_at"];
    }
}