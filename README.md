# CoolEventListener
The library for creation cool events listeners with attributes.
This is a syntax sugar.

## Using
Event listener:
```php
<?php

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\EventPriority;
use qpi\listener\EventHandler;

class SampleListener implements Listener {
    
    #[EventHandler]
    private function onJoin(PlayerJoinEvent $event): void {
        $event->getPlayer()->sendMessage("Hello dude :P");
    }
    
    #[EventHandler(priority: EventPriority::HIGH)]
    private function onChat1(PlayerChatEvent $event): void {
        $event->getPlayer()->sendMessage("A event with high priority");
    }
    
    #[EventHandler(priority: EventPriority::LOW)]
    private function onChat2(PlayerChatEvent $event): void {
        $event->getPlayer()->sendMessage("A event with low priority");
    }
}
```
Plugin:
```php
<?php

use pocketmine\plugin\PluginBase;
use qpi\listener\CoolEventListener;

class SamplePlugin extends PluginBase {
    
    protected function onEnable() : void{
        CoolEventListener::registerEvents(new SampleListener());
    }
}
```