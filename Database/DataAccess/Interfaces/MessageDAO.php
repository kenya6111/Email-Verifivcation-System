<?php

namespace Database\DataAccess\Interfaces;

use Models\Message;

interface MessageDAO
{
    public function create(?int $userIdTo, int $userIdFrom,string $notificationType,int $sourceId): bool;
    // public function getPostsOrderedByLikesDesc(): ?array;
    public function getByUserId(int $id): ?array;
    public function getRawByUserId(int $id): ?array;
    // public function getByPostId(int $id): ?array;
    // public function getRawByPostId(int $id): ?array;
    // public function getAllPosts(): ?array;
    // public function getAllRaw(): ?array;
    // public function getByEmail(string $email): ?Post;
    // public function update(Post $user, string $password, ?string $email_confirmed_at): bool;
    // public function getHashedPasswordById(int $id): ?string;
    public function insert(int $sendUserId, int $recieveUserId, string $message ,string $iv): ?bool;
}