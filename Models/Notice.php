<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Notice implements Model {
    use GenericModel;
    //
    public function __construct(
        private ?int $noticeId,
        private ?int $userId,
        private string $notificationType,
        private ?string $sourceId = null,
        private ?string $isRead = null,
        private ?DataTimeStamp $timeStamp = null
    ) {}

    // Getter and Setter for noticeId
    public function getNoticeId(): ?int {
        return $this->noticeId;
    }

    public function setNoticeId(?int $noticeId): void {
        $this->noticeId = $noticeId;
    }

    // Getter and Setter for userId
    public function getUserId(): ?int {
        return $this->userId;
    }

    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    // Getter and Setter for notificationType
    public function getNotificationType(): string {
        return $this->notificationType;
    }

    public function setNotificationType(string $notificationType): void {
        $this->notificationType = $notificationType;
    }

    // Getter and Setter for sourceId
    public function getSourceId(): ?string {
        return $this->sourceId;
    }

    public function setSourceId(?string $sourceId): void {
        $this->sourceId = $sourceId;
    }

    // Getter and Setter for isRead
    public function getIsRead(): ?string {
        return $this->isRead;
    }

    public function setIsRead(?string $isRead): void {
        $this->isRead = $isRead;
    }

    
}