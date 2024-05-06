<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class CreatePostTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE posts (
            post_id INT AUTO_INCREMENT PRIMARY KEY,
            reply_to_id INT,
            message TEXT,
            image VARCHAR(255),
            video VARCHAR(255),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            scheduled_at DATETIME,
            status ENUM('draft', 'scheduled', 'published'),
            FOREIGN KEY (reply_to_id) REFERENCES posts(post_id) ON DELETE CASCADE
        );
        "];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}