<?php

/**
 * @file
 * Contains \Drupal\rules\Core\RulesUiManager.
 */

namespace Drupal\rules\Core;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Plugin manager for Rules Ui instances.
 *
 * Rules UIs are primarily defined in *.rules_ui.yml files. Usually, there is
 * no need to specify a 'class' as there is a suiting default handler class in
 * place. However, if done see the class must implement
 * \Drupal\rules\Core\RulesUiHandlerInterface.
 *
 * @see \Drupal\rules\Core\RulesUiHandlerInterface
 */
class RulesUiManager extends DefaultPluginManager implements RulesUiManagerInterface {

  /**
   * Provides some default values for the definition of all Rules event plugins.
   *
   * @var array
   */
  protected $defaults = [
    'class' => RulesUiDefaultHandler::class,
  ];

  /**
   * {@inheritdoc}
   */
  public function __construct(ModuleHandlerInterface $module_handler) {
    $this->alterInfo('rules_ui');
    $this->discovery = new ContainerDerivativeDiscoveryDecorator(new YamlDiscovery('rules_ui', $module_handler->getModuleDirectories()));
    $this->factory = new ContainerFactory($this, RulesUiDefaultHandler::class);
    $this->moduleHandler = $module_handler;
  }

}
