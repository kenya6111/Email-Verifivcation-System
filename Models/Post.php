<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model {
    use GenericModel;
    //
    public function __construct(
        private ?int $postId,
        private ?int $replyToId,
        private string $message,
        private ?string $image = null,
        private ?string $video = null,
        private ?DataTimeStamp $scheduledAt = null,
        private ?DataTimeStamp $timeStamp = null,
        private ?string $status = null,
        private ?int $userId = null,
    ) {}

    public function getReplyToId(): ?int {
        return $this->replyToId;
    }

    public function setReplyToId(int $replyToId): void {
        $this->replyToId = $replyToId;
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function setMessage(string $message): void {
        $this->message = $message;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }

    public function getVideo(): ?string {
        return $this->video;
    }

    public function setVideo(?string $video): void {
        $this->video = $video;
    }

    public function getScheduledAt(): ?DataTimeStamp
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(DataTimeStamp $scheduledAt): void
    {
        $this->scheduledAt = $scheduledAt;
    }
    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
}