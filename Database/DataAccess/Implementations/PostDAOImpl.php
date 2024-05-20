<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\DataTimeStamp;
use Models\Post;

class PostDAOImpl implements PostDAO
{
    public function create(string $text, ?string $file_path,string $file_name,string $mime_type,string $size,?string $shared_url,?int $reply_to_id): bool
    {
        //if ($user->getId() !== null) throw new \Exception('Cannot create a user with an existing ID. id: ' . $user->getId());

        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "INSERT INTO posts (reply_to_id, message, image, video,scheduled_at,status,user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $result = $mysqli->prepareAndExecute(
            $query,
            'isssssi',
            [
                $reply_to_id,
                $text,
                $file_path,
                null,
                null,
                "published",
                $_SESSION['user_id']
            ]
        );

        if (!$result) return false;

        //$user->setId($mysqli->insert_id);

        return true;
    }

    private function getRawById(int $id): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts WHERE user_id = ?";

        $result = $mysqli->prepareAndFetchAll($query, 'i', [$id]) ?? null;

        if ($result === null) return null;

        return $result;
    }

    public function getRawByPostId(int $id): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts WHERE post_id = ?";

        $result = $mysqli->prepareAndFetchAll($query, 'i', [$id])[0] ?? null;

        if ($result === null) return null;

        return $result;
    }

    // private function getRawByEmail(string $email): ?array{
    //     $mysqli = DatabaseManager::getMysqliConnection();

    //     $query = "SELECT * FROM users WHERE email = ?";

    //     $result = $mysqli->prepareAndFetchAll($query, 's', [$email])[0] ?? null;

    //     if ($result === null) return null;
    //     return $result;
    // }

    private function getRawOrderedByLikesDesc(): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT posts.*,
                    COUNT(posts.post_id) AS like_count,
                    users.username,
                    users.id
                FROM posts
                LEFT JOIN users
                ON posts.user_id= users.id
                LEFT JOIN likes
                ON posts.post_id= likes.post_id
                GROUP BY 
                posts.post_id,users.username,users.id
                ORDER BY
                like_count DESC
                LIMIT 20;";

        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC) ?? null;

        if ($result === null) return null;
        return $result;
    }
    public function getAllRaw(): ?array{
        $mysqli = DatabaseManager::getMysqliConnection();

        $query = "SELECT * FROM posts";

        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC) ?? null;

        if ($result === null) return null;
        return $result;
    }
    // public function update(Post $user, string $password, ?string $emailVerifiedAt): bool
    // {
    //     if ($user->getId() === null) throw new \Exception('The specified user has no ID.');
       
    //     $mysqli = DatabaseManager::getMysqliConnection();

    //     $query = 
    //     <<<SQL
    //         INSERT INTO users (id, username, email, password, email_verified_at, company)
    //         VALUES (?, ?, ?, ?, ?, ?)
    //         ON DUPLICATE KEY UPDATE id = ?,
    //         username = VALUES(username), 
    //         email = VALUES(email),
    //         password = VALUES(password),
    //         email_verified_at = VALUES(email_verified_at),
    //         company = VALUES(company);
    //     SQL;

    //     $result = $mysqli->prepareAndExecute(
    //         $query,
    //         'isssssi',
    //         [
    //             $user->getId(),
    //             $user->getUsername(),
    //             $user->getEmail(),
    //             $password,
    //             $emailVerifiedAt,
    //             $user->getCompany(),
    //             $user->getId()
    //         ]
    //     );
       
    //     if (!$result) return false;

    //     $user->setEmail_verified_at($emailVerifiedAt);
    //     error_log("get_Email_At : ".$user->getEmail_verified_at());

    //     return true;
    // }

    // private function rawDataToUser(array $rawData): Post{
    //     return new Post(
    //         replyToId: $rawData['replyToId'],
    //         message: $rawData['message'],
    //         image: $rawData['image'],
    //         video: $rawData['video'] ?? null,
    //         scheduledAt: $rawData['scheduledAt'] ?? null,
    //         status: new DataTimeStamp($rawData['created_at'], $rawData['updated_at'])
    //     );
    // }
    private function rawDataToPost(array $rawData): Post{
        return new Post(
            postId: $rawData['post_id'],
            replyToId: $rawData['replyToId'],
            message: $rawData['message'],
            image: $rawData['image'],
            video: $rawData['video'] ?? null,
            scheduledAt: $rawData['scheduledAt'] ?? null,
            timeStamp: new DataTimeStamp($rawData['created_at'], $rawData['updated_at']),
            status: $rawData['status'] ?? null,
            userId: $rawData['user_id'] ?? null,
        );
    }

    public function getById(int $id): ?array
    {
        $postsRaw = $this->getRawById($id);
        if($postsRaw === null) return null;
        $posts=[];
        foreach($postsRaw as $postRaw){ 
            array_push($posts,$this->rawDataToPost($postRaw));
        }

        return $posts;
    }

    // public function getByEmail(string $email): ?Post
    // {
    //     $userRaw = $this->getRawByEmail($email);
    //     if($userRaw === null) return null;

    //     return $this->rawDataToUser($userRaw);
    // }

    public function getPostsOrderedByLikesDesc(): ?array
    {
        $postsRaw = $this->getRawOrderedByLikesDesc();
        if($postsRaw === null) return null;

        // $posts=[];
        // foreach($postsRaw as $postRaw){ 
        //     array_push($posts,$this->rawDataToPost($postRaw));
        // }

        return $postsRaw;
    }

    // public function getHashedPasswordById(int $id): ?string
    // {
    //     return $this->getRawById($id)['password']??null;
    // }

    public function getByPostId(int $id): ?array
    {
        $postsRaw = $this->getRawByPostId($id);
        if($postsRaw === null) return null;

        return $postsRaw;
    }

    public function getAllPosts(): ?array
    {
        $postsRaws = $this->getAllRaw();
        if($postsRaws === null) return null;

        return $postsRaws;
    }
}