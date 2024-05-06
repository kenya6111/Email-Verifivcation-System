<?php
    
namespace Database\Migrations;
    
use Database\SchemaMigration;
    
class CreateMessageTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーションロジックをここに追加してください
        return ["CREATE TABLE messages (
            message_id INT AUTO_INCREMENT PRIMARY KEY,
            send_user_id BIGINT NOT NULL,
            receive_user_id BIGINT NOT NULL,
            message TEXT,
            image VARCHAR(255),
            video VARCHAR(255),
            sended_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (send_user_id) REFERENCES users(id),
            FOREIGN KEY (receive_user_id) REFERENCES users(id)
        );"];
    }

    public function down(): array
    {
        // ロールバックロジックを追加してください
        return [];
    }
}