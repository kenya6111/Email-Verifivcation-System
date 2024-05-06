<?php

namespace Database\DataAccess\Interfaces;

use Models\Post;

interface PostDAO
{
    public function create(string $text, string $file_path,string $file_name,string $mime_type,string $size,string $shared_url): bool;
    public function getPostsOrderedByLikesDesc(): ?array;
    public function getById(int $id): ?array;
    // public function getByEmail(string $email): ?Post;
    // public function update(Post $user, string $password, ?string $email_confirmed_at): bool;
    // public function getHashedPasswordById(int $id): ?string;
}