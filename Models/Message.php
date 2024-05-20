<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Notice implements Model {
    use GenericModel;
    //
    public function __construct(
        private ?int $messageId,
        private ?int $sendUserId,
        private ?int $recieveUserId,
        private string $message,
        private ?string $image = null,
        private ?string $video = null,
        private ?DataTimeStamp $timeStamp = null
    ) {}

    // Getter for messageId
    public function getMessageId(): ?int {
        return $this->messageId;
    }
    
    // Setter for messageId
    public function setMessageId(?int $messageId): void {
        $this->messageId = $messageId;
    }
    
    // Getter for sendUserId
    public function getSendUserId(): ?int {
        return $this->sendUserId;
    }
    
    // Setter for sendUserId
    public function setSendUserId(?int $sendUserId): void {
        $this->sendUserId = $sendUserId;
    }
    
    // Getter for recieveUserId
    public function getRecieveUserId(): ?int {
        return $this->recieveUserId;
    }
    
    // Setter for recieveUserId
    public function setRecieveUserId(?int $recieveUserId): void {
        $this->recieveUserId = $recieveUserId;
    }
    
    // Getter for message
    public function getMessage(): string {
        return $this->message;
    }
    
    // Setter for message
    public function setMessage(string $message): void {
        $this->message = $message;
    }
    
    // Getter for image
    public function getImage(): ?string {
        return $this->image;
    }
    
    // Setter for image
    public function setImage(?string $image): void {
        $this->image = $image;
    }
    
    // Getter for video
    public function getVideo(): ?string {
        return $this->video;
    }
    
    // Setter for video
    public function setVideo(?string $video): void {
        $this->video = $video;
    }
    
    // Getter for timeStamp
    public function getTimeStamp(): ?DataTimeStamp {
        return $this->timeStamp;
    }
    
    // Setter for timeStamp
    public function setTimeStamp(?DataTimeStamp $timeStamp): void {
        $this->timeStamp = $timeStamp;
    }
}