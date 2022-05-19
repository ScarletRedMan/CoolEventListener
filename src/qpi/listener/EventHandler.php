<?php

namespace qpi\listener;

use Attribute;
use pocketmine\event\EventPriority;

#[Attribute(Attribute::TARGET_METHOD)]
class EventHandler {

    public int $priority;
    public bool $ignoreCancelled;

    public function __construct(int $priority = EventPriority::NORMAL, bool $ignoreCancelled = false) {
        if (!in_array($priority, EventPriority::ALL)) {
            throw new \LogicException("Invalid event priority");
        }

        $this->priority = $priority;
        $this->ignoreCancelled = $ignoreCancelled;
    }
}