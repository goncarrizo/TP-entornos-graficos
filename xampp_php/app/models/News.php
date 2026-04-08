<?php

class News
{
    public static function all(): array
    {
        $stmt = Database::connection()->query('SELECT * FROM news ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM news');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    public static function paginated(int $limit, int $offset): array
    {
        $sql = 'SELECT * FROM news ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
        $stmt = Database::connection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create(string $title, string $content): bool
    {
        $sql = 'INSERT INTO news (title, content) VALUES (:title, :content)';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(compact('title', 'content'));
    }

    public static function update(int $id, string $title, string $content): bool
    {
        $sql = 'UPDATE news SET title = :title, content = :content WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute(compact('id', 'title', 'content'));
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare('DELETE FROM news WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
