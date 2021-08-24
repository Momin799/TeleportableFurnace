
<?php

namespace Furnace\Commands;

use Furnace\Main;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\Plugin;

use pocketmine\block\Block;
use function array_key_exists;
use pocketmine\inventory\FurnaceGrid;
use pocketmine\network\mcpe\protocol\ContainerOpenPacket;
use pocketmine\network\mcpe\protocol\types\WindowTypes;

class FurnaceCommand extends PluginCommand{
	
	/** @var Main */
	public $plugin;

	public function __construct($name, Main $plugin) {
        parent::__construct($name, $plugin);
        $this->setDescription("Open a furnace");
        $this->setUsage("/furnace");
        $this->setPermission("furnace.command");
        $this->plugin = $plugin;
    }
    
    public function sendFurnace(Player $player)
    {
        $block1 = Block::get(Block::FURNACE);
        $block1->x = (int)floor($player->x);
        $block1->y = (int)floor($player->y) - 2;
        $block1->z = (int)floor($player->z);
        $block1->level = $player->getLevel();
        $block1->level->sendBlocks([$player], [$block1]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
		if (!$sender->hasPermission("furnace.command")) {
			$sender->sendMessage(TextFormat::RED . "You do not have permission to use this command");
			return false;
		}
		if ($sender instanceof ConsoleCommandSender) {
			$sender->sendMessage(TextFormat::RED . "This command can be only used in-game.");
			return false;
		}
		$this->sendFurnace($sender);
        $sender->setFurnaceGrid(new FurnaceGrid($sender, FurnaceGrid::SIZE_BIG));
        if(!array_key_exists($windowId = Player::HARDCODED_FURNACE_GRID_WINDOW_ID, $sender->openHardcodedWindows))
        {
        $pk = new ContainerOpenPacket();
        $pk->windowId = $windowId;
        $pk->type = WindowTypes::FURNACE;
        $pk->x = $sender->getFloorX();
        $pk->y = $sender->getFloorY() - 2;
        $pk->z = $sender->getFloorZ();
        $sender->sendDataPacket($pk);
        $sender->openHardcodedWindows[$windowId] = true;
	    return true;
		}
	}
}
