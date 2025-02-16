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
use Darren2005\MyWelcomeApp\events\EventListener;  // Import EventListener class

class Main extends PluginBase {

    private static ?Main $instance = null; 
    private Config $configData;
    private Config $playerData;
    private Config $homes;

    public function onEnable(): void {
        self::$instance = $this;

        // Ensure data folder exists
        @mkdir($this->getDataFolder());

        // Load or create configs
        $this->saveDefaultConfig();
        $this->configData = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        // Load player data file
        $playerDataFile = $this->getDataFolder() . "PlayerData.yml";
        if (!file_exists($playerDataFile)) {
            touch($playerDataFile); // Create empty file if missing
        }
        $this->playerData = new Config($playerDataFile, Config::YAML);

        // Load homes data file
        $homesFile = $this->getDataFolder() . "homes.yml";
        if (!file_exists($homesFile)) {
            touch($homesFile);
        }
        $this->homes = new Config($homesFile, Config::YAML);

        // Register commands
        $this->registerCommands();

        // Register event listeners
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);  // Ensure this works properly
    }

    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();

        if ($this->configData->get("enable-hello-command", true) && class_exists(HelloCommand::class)) {
            $commandMap->register("MyWelcomeApp", new HelloCommand($this));
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

    public static function getInstance(): Main {
        if (self::$instance === null) {
            throw new \RuntimeException("Main plugin instance is not initialized!");
        }
        return self::$instance;
    }
}
