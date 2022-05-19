<?php

namespace qpi\listener;

use pocketmine\event\Event;
use ReflectionClass;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class CoolEventListener extends PluginBase {

    private static CoolEventListener $instance;

    protected function onLoad(): void {
        self::$instance = $this;
    }

    public static function registerEvents(Listener $listener): void {
        $ref = new ReflectionClass($listener::class);
        $pluginManager = self::$instance->getServer()->getPluginManager();

        foreach ($ref->getMethods() as $method) {
            $eventHandler = null;
            foreach ($method->getAttributes(EventHandler::class) as $attribute) {
                $eventHandler = $attribute->newInstance();
                break;
            }
            if ($eventHandler === null) continue;

            $eventClass = null;
            foreach ($method->getParameters() as $parameter) {
                $class = $parameter->getType()->getName();
                echo $class . PHP_EOL;
                if (!is_subclass_of($class, Event::class)) {
                    throw new \LogicException("Method must have only one parameter with subclass of Event");
                }

                $eventClass = $class;
                break;
            }
            if ($eventClass === null) throw new \LogicException("Method must have only one parameter with subclass of Event");

            $pluginManager->registerEvent($eventClass, function ($event) use ($listener, $method) {
                if (!$method->isPublic()) $method->setAccessible(true);
                $method->invokeArgs($listener, [$event]);
            }, $eventHandler->priority, self::$instance, $eventHandler->ignoreCancelled);
        }
    }
}