<?php

namespace Furnace;

use Furnace\Commands\FurnaceCommand;

use pocketmine\plugin\PluginBase;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\entity\Entity;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;

use pocketmine\tile\Tile;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase { 
	
	/** @var array */
	public $plugin;

  public function onLoad(){
    $this->getLogger()->info("Loading Plugin");
  }

  public function onDisable(){
    $this->getLogger()->info("Plugin Disabled");
  }
  
  public function onEnable(): void{
  	       $this->getLogger()->info("Plugin Enabled");
 
  	} 

}
