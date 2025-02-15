<?php

declare(strict_types=1);

namespace Darren2005\MyWelcomeApp;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use Darren2005\MyWelcomeApp\commands\HelloCommand;
use Darren2005\MyWelcomeApp\commands\SetHomeCommand;
use Darren2005\MyWelcomeApp\commands\HomeCommand;
use Darren2005\MyWelcomeApp\events\EventListener;

class Main extends PluginBase {

    private static ?Main $instance = null; 
    private Config $configData;
    private Config $playerData;
    private Config $homes;

    public function onEnable(): void {
        self::$instance = $this;

        // Ensure data folder exists
        @mkdir($this->getDataFolder());

        // Save default configs
        $this->saveDefaultConfig();
        $this->configData = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->playerData = new Config($this->getDataFolder() . "PlayerData.yml", Config::YAML);
        $this->homes = new Config($this->getDataFolder() . "homes.yml", Config::YAML);

        // Register commands
        $this->registerCommands();

        // Register event listeners
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();

        if ($this->configData->get("enable-hello-command", true)) {
            if (class_exists(HelloCommand::class)) {
                $commandMap->register("MyWelcomeApp", new HelloCommand($this));
            }
        }

        if (class_exists(SetHomeCommand::class)) {
            $commandMap->register("MyWelcomeApp", new SetHomeCommand($this));
        }

        if (class_exists(HomeCommand::class)) {
            $commandMap->register("MyWelcomeApp", new HomeCommand($this));
        }
    }

    public function onDisable(): void {
        $this->homes->save();
        $this->playerData->save();
    }

    public function getConfigData(): Config {
        return $this->configData;
    }

    public function getPlayerData(): Config {
        return $this->playerData;
    }

    public function getHomes(): Config {
        return $this->homes;
    }

    public static function getInstance(): ?Main {
        return self::$instance;
    }
}
