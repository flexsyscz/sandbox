<?php
declare(strict_types=1);

namespace App\Bin;

use Flexsyscz\Universe\FileSystem\CsvStreamReader;
use Flexsyscz\Universe\FileSystem\CsvStreamWriter;
use Flexsyscz\Universe\Localization\TranslatedComponent;
use Nette\Loaders\RobotLoader;
use Nette\Neon\Exception;
use Nette\Neon\Neon;
use Nette\Utils\FileSystem;

require __DIR__ . '/../vendor/autoload.php';


/**
 * Class TranslationManager
 * @package App\Bin
 */
class TranslationManager
{
	public const VERSION = 'v0.1';

	public const DELIMITER = '.';

	/** @var RobotLoader */
	private $loader;

	/** @var string */
	private $dirName;

	/** @var string */
	private $suffix;

	/** @var string */
	private $projectDir;

	/** @var array<string> */
	private $items;

	/** @var array<string|array> */
	private $files;

	/** @var array<string|array> */
	private $changelog;


	/**
	 * TranslationManager constructor.
	 * @param array<string> $config
	 */
	public function __construct(array $config)
	{
		$this->loader = new RobotLoader();
		$this->loader->addDirectory($config['appDir'])
			->setTempDirectory($config['tempDir'])
			->register();

		$this->dirName = $config['dirName'];
		$this->suffix = $config['suffix'];
		$this->projectDir = isset($config['projectDir']) ? $config['projectDir'] : FileSystem::normalizePath($config['appDir'] . '/../');
	}


	/**
	 * @param string $file
	 */
	public function export(string $file): void
	{
		$export = [];

		foreach ($this->loader->getIndexedClasses() as $className => $path) {
			try {
				$reflection = new \ReflectionClass($className);
				if (in_array(TranslatedComponent::class, $reflection->getTraitNames(), true)) {
					$dir = sprintf('%s/%s', dirname($path), $this->dirName);
					foreach (scandir($dir) as $item) {
						if (preg_match("#\\{$this->suffix}$#", $item)) {
							$language = basename($item, $this->suffix);
							try {
								$filePath = sprintf('%s/%s', $dir, $item);
								$relativePath = $this->getRelativePath($filePath);
								$data = Neon::decode(file_get_contents($filePath));

								$this->items = [];
								$this->prepareItemsToExport($data);

								$a = sha1($dir);
								$b = sha1($relativePath);
								foreach ($this->items as $key => $value) {
									if(!isset($export[$a])) {
										$export[$a] = [];
									}

									if(!isset($export[$a][$key])) {
										$export[$a][$key] = [];
									}

									if(!isset($export[$a][$key][$b])) {
										$export[$a][$key][$b] = [];
									}

									$export[$a][$key][$b][$language] = $value;
								}

							} catch (Exception $e) {
								self::error($e->getMessage());
							}
						}
					}
				}
			} catch (\ReflectionException $e) {
				self::error($e->getMessage());
			}
		}

		if(!empty($export)) {
			$writer = new CsvStreamWriter();
			$writer->open($file);

			foreach ($export as $a => $dir) {
				foreach ($dir as $key => $items) {
					foreach ($items as $b => $item) {
						foreach ($item as $language => $text) {
							$writer->write([
								$a,
								$b,
								$language,
								$key,
								$text,
							]);
						}
					}
				}
			}

			$writer->close();
			self::success("Export has been successfully done.");

		} else {
			self::error('Export is empty.');
		}
	}


	/**
	 * @param array<string|array> $data
	 * @param string|null $node
	 */
	private function prepareItemsToExport(array $data, string $node = null): void
	{
		foreach ($data as $key => $value) {
			$_node = $node ? sprintf('%s%s%s', $node, self::DELIMITER, $key) : $key;
			if (is_array($value)) {
				$this->prepareItemsToExport($value, $_node);
			} else {
				$this->items[$_node] = $value;
			}
		}
	}


	/**
	 * @param string $file
	 * @param bool $onlyCheck
	 */
	public function import(string $file, bool $onlyCheck = false): void
	{
		$file = FileSystem::normalizePath($file);
		if(!file_exists($file)) {
			self::error("File '{$file}' not found.");
		}

		$this->changelog = [];
		if (!$this->check($file)) {
			self::error('Input data is not compatible with the current project structure.');
		}

		if(!$onlyCheck) {
			foreach ($this->files as $_file) {
				if ($_file['changed'] === true) {
					file_put_contents($_file['filePath'], Neon::encode($_file['data'], Neon::BLOCK));
				}
			}
		}

		if(!empty($this->changelog)) {
			echo "\n===== CHANGELOG =====\n\n";
			foreach ($this->changelog as $filePath => $item) {
				foreach ($item as $key => $diff) {
					foreach ($diff as $old => $new) {
						self::log("\033[1;33m[$key]\033[0m $old => $new", $this->getRelativePath($filePath));
					}
				}
			}
		}

		if($onlyCheck) {
			self::success("Import file has been checked with no errors. No changes were saved in the project structure!");
		} else {
			self::success("Import has been successfully done.");
		}
	}


	/**
	 * @param string $file
	 * @return bool
	 */
	public function check(string $file): bool
	{
		$check = true;
		$this->files = [];

		foreach ($this->loader->getIndexedClasses() as $className => $path) {
			try {
				$reflection = new \ReflectionClass($className);
				if (in_array(TranslatedComponent::class, $reflection->getTraitNames(), true)) {
					$dir = sprintf('%s/%s', dirname($path), $this->dirName);
					foreach (scandir($dir) as $item) {
						if (preg_match("#\\{$this->suffix}$#", $item)) {
							try {
								$language = basename($item, $this->suffix);
								$filePath = sprintf('%s/%s', $dir, $item);
								$relativePath = $this->getRelativePath($filePath);

								$this->files[sha1($relativePath)] = [
									'hash' => sha1($dir),
									'language' => $language,
									'filePath' => $filePath,
									'data' => Neon::decode(file_get_contents($filePath)),
									'changed' => false,
								];

							} catch (Exception $e) {
								self::error($e->getMessage());
							}
						}
					}
				}
			} catch (\ReflectionException $e) {
				self::error($e->getMessage());
			}
		}

		$reader = new CsvStreamReader();
		$reader->open($file);

		$i = 1;
		while($row = $reader->read()) {
			$log = implode(' | ', $row);

			if (count($row) !== 5) {
				$check = false;
				self::warning("Number of columns does not match the structure at row $i");
				self::log($log);
			}

			if(isset($this->files[$row[1]])) {
				$neon = &$this->files[$row[1]];
				if($neon['hash'] === $row[0]) {
					$path = explode(self::DELIMITER, $row[3]);
					$result = $this->storeNewValue($neon['filePath'], $neon['data'], $path, $row[4]);
					if($result === true) {
						$neon['changed'] = true;

					} else if($result === false) {
						$check = false;
					}
				} else {
					$check = false;
					self::warning("Mismatch error in the directory hash '{$row[0]}' at row $i");
					self::log($log);
				}
			} else {
				$check = false;
				self::warning("An unknown translation file '{$row[1]}' at row $i");
				self::log($log);
			}

			$i++;
		}

		$reader->close();
		return $check;
	}


	/**
	 * @param string $filePath
	 * @param array<string|array> $data
	 * @param array<string> $path
	 * @param string $value
	 * @return bool|null
	 */
	private function storeNewValue(string $filePath, array &$data, array $path, string $value): ?bool
	{
		if (empty($path)) {
			self::warning("Empty path of nodes.");
			return false;
		}

		$temp = &$data;
		foreach ($path as $node) {
			if(!isset($temp[$node])) {
				self::warning("Node {$node} not found.");
				return false;
			}

			$temp = &$temp[$node];
		}

		if($temp === $value) {
			return null;
		}

		if(!isset($this->changelog[$filePath])) {
			$this->changelog[$filePath] = [];
		}

		$this->changelog[$filePath][implode(self::DELIMITER, $path)] = [$temp => $value];
		$temp = $value;

		return true;
	}


	/**
	 * @param string $filePath
	 * @return string
	 */
	private function getRelativePath(string $filePath): string
	{
		return preg_replace('#^' . $this->projectDir . '#', '', $filePath);
	}


	public static function printHelp(): void
	{
		self::printBlockMessage("TranslationManager " . self::VERSION);

		echo "\n";
		echo "\033[0;32mUsage:\n\033[0m    php TranslationManager.php [options] [<file>]\n";
		echo "\n";
		echo "\033[0;32mOptions:\n";
		echo "\033[0m";
		echo "    -c | --check\t\tChecks the input CSV file intended for an import. Nothing will be saved into project files.\n";
		echo "    -e | --export\t\tExports all translations into CSV file.\n";
		echo "    -i | --import\t\tImports translations from CSV file into project.\n";
		echo "    -h | --help\t\t\tPrints this help.\n";
		echo "\n";
		exit(1);
	}


	/**
	 * @param string $message
	 * @param string $label
	 */
	public static function log(string $message, string $label = 'LOG'): void
	{
		echo "\033[1;36m[{$label}]\033[0m {$message}\n";
	}


	/**
	 * @param string $message
	 */
	public static function error(string $message): void
	{
		self::printBlockMessage("[ERROR] $message", "\033[41m", "\033[1;37m");
		exit(1);
	}


	/**
	 * @param string $message
	 */
	public static function warning(string $message): void
	{
		self::printBlockMessage("[WARNING] $message", "\033[43m");
	}


	/**
	 * @param string $message
	 */
	public static function success(string $message): void
	{
		self::printBlockMessage("[OK] $message");
	}


	/**
	 * @param string $message
	 * @param string $bkgColor
	 * @param string $textColor
	 */
	private static function printBlockMessage(string $message, string $bkgColor = "\033[42m", string $textColor = "\033[3;30m"): void
	{
		$message .= "  ";

		$line = 120;
		$length = mb_strlen($message);
		$max = $length < $line ? $line : $length + 4;

		echo "\n";
		echo $bkgColor;
		for($i = 0; $i <= $max; $i++) {
			echo " ";
		}
		echo "\033[0m\n";

		echo "$bkgColor  {$textColor}{$message}  ";
		if($max <= $line) {
			for ($i = 0; $i <= $max - $length - 4; $i++) {
				echo " ";
			}
		}
		echo "\033[0m\n";
		echo $bkgColor;
		for($i = 0; $i <= $max; $i++) {
			echo " ";
		}
		echo "\033[0m\n";
		echo "\n";
	}
}


try {
	if (!isset($argv[1]) || in_array($argv[1], ['-h', '--help'], true)) {
		TranslationManager::printHelp();
	}

	$config = [
		'appDir' => FileSystem::normalizePath(__DIR__ . '/../app'),
		'tempDir' => FileSystem::normalizePath(__DIR__ . '/../temp/bin'),
		'dirName' => 'translations',
		'suffix' => '.neon',
	];

	$manager = new TranslationManager($config);
	$file = isset($argv[2]) ? $argv[2] : 'export.csv';

	if(in_array($argv[1], ['-e', '--export', '-export'], true)) {
		$manager->export($file);

	} else if(in_array($argv[1], ['-i', '--import', '-import'], true)) {
		$manager->import($file);

	} else if(in_array($argv[1], ['-c', '--check', '-check'], true)) {
		$manager->import($file, true);

	} else {
		TranslationManager::printHelp();
	}
} catch (\TypeError $e) {
	TranslationManager::error($e->getMessage());
}

exit(0);
