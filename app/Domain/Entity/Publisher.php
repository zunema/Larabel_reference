<?php
// 5.5.3.2. PublisherのEntityクラス

namespace App\Domain\Entity;

class Publisher
{
  protected $id;
  protected $name;
  protected $address;

  public function __construct(?int $id, string $name, string $address)
  {
    $this->id = $id;
    $this->name = $name;
    $this->address = $address;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getAddress(): string
  {
    return $this->address;
  }
}