<?php

namespace App\Trait;


trait UuidTrait
{
    protected ?string $newId = null;

    public function getNewId(): ?string
    {
        $tmp = explode('/', $this->newId);
        return array_pop($tmp);
    }

    public function setNewId(?string $newId): static
    {
        $this->newId = $newId;

        return $this;
    }
}
