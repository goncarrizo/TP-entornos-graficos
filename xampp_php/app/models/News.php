<?php

class News
{
    public static function all(): array
    {
        $stmt = Database::connection()->query('SELECT * FROM news ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function allActive(): array
    {
        $sql = 'SELECT * FROM news WHERE (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW()) ORDER BY created_at DESC';
        $stmt = Database::connection()->query($sql);
        return $stmt->fetchAll();
    }

    public static function countAll(): int
    {
        $stmt = Database::connection()->query('SELECT COUNT(*) AS c FROM news');
        $row = $stmt->fetch();
        return (int) $row['c'];
    }

    public static function countActive(): int
    {
        $sql = "SELECT COUNT(*) AS c FROM news WHERE (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW())";
        $stmt = Database::connection()->query($sql);
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

    public static function paginatedActive(int $limit, int $offset): array
    {
        $sql = 'SELECT * FROM news WHERE (start_date IS NULL OR start_date <= NOW()) AND (end_date IS NULL OR end_date >= NOW()) ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
        $stmt = Database::connection()->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create(string $title, string $content, ?string $startDate = null, ?string $endDate = null): bool
    {
        $sql = 'INSERT INTO news (title, content, start_date, end_date) VALUES (:title, :content, :start_date, :end_date)';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute([
            'title' => $title,
            'content' => $content,
            'start_date' => $startDate ?: null,
            'end_date' => $endDate ?: null,
        ]);
    }

    public static function update(int $id, string $title, string $content, ?string $startDate = null, ?string $endDate = null): bool
    {
        $sql = 'UPDATE news SET title = :title, content = :content, start_date = :start_date, end_date = :end_date WHERE id = :id';
        $stmt = Database::connection()->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'start_date' => $startDate ?: null,
            'end_date' => $endDate ?: null,
        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::connection()->prepare('DELETE FROM news WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
