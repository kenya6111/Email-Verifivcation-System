<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class CreateFollowsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE follows (
            follower_id BIGINT NOT NULL,
            followed_id BIGINT NOT NULL,
            followed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (follower_id, followed_id),
            FOREIGN KEY (follower_id) REFERENCES users(id),
            FOREIGN KEY (followed_id) REFERENCES users(id)
        );"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}