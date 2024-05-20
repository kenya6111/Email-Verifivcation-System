<?php

namespace Database\DataAccess\Interfaces;

use Models\User;

interface UserDAO
{
    public function create(User $user, string $password): bool;
    public function getById(int $id): ?User;
    public function getByEmail(string $email): ?User;
    public function update(User $user, string $password, ?string $email_confirmed_at): bool;
    public function getHashedPasswordById(int $id): ?string;
    public function insertFollowRecord(int $id, int $loginUser): bool;
    public function deleteFollowRecord(int $id, int $loginUser): bool;
    public function getFollowListById(int $id): ?array;
    public function getFollowerListById(int $id): ?array;
    public function getFollowNumById(int $id): ?int;
    public function getFollowerNumById(int $id): ?int;
    public function insertLike(int $post_id,int $user_id): ?bool;
    public function insertLikeRaw(int $post_id,int $user_id): ?bool;
    public function deleteLike(int $post_id,int $user_id): ?bool;
    public function deleteLikeRaw(int $post_id,int $user_id): ?bool;
}