<?php

namespace Schruptor\Sinusrhythm;

use Spatie\Dashboard\Models\Tile;

class StatusStore
{
    private Tile $tile;

    public static function make(): static
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName('sinusrhythm');
    }

    public function setStatus(array $status): self
    {
        $this->tile->putData('status', $status);

        return $this;
    }

    public function getStatus(): array
    {
        return $this->tile->getData('status') ?? [];
    }
}
