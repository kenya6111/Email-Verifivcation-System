<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class CreateNotificationsTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE notifications (
            notice_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT NOT NULL,
            notification_type VARCHAR(50) NOT NULL,
            source_id INT NOT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );
        "];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}
