namespace App\Entity;

interface TimestampableInterface
{
public function setCreatedAt(\DateTimeImmutable $createdAt): void;
public function setUpdatedAt(\DateTimeImmutable $updatedAt): void;
}