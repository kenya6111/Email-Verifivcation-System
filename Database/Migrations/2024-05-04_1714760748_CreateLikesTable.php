<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class CreateLikesTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE likes (
            like_id INT AUTO_INCREMENT PRIMARY KEY,
            post_id INT NOT NULL,
            user_id BIGINT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
        "];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}