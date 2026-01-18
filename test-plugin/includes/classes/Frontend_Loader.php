<?php

namespace Company\Test_Plugin;

use Company\Test_Plugin\Frontend\Enqueue;
use Company\Test_Plugin\Frontend\Display;

class Frontend_Loader {

  /**
	 * Full path and filename of plugin.
	 *
	 * @var string $version Full path and filename of plugin.
	 */
  private $plugin;
  
  /**
   * __construct
   *
   * @return void
   */
  public function __construct($plugin) {
    $this->plugin         = $plugin;
  }
  
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    $this->load_enqueue();
    $this->load_display();
  }
  
  /**
   * Load UI
   *
   * @return void
   */
  public function load_enqueue() {
    $enqueue = new Enqueue($this->plugin);
    $enqueue->init();
  }
  
  /**
   * Load Display
   *
   * @return void
   */
  public function load_display() {
    $display = new Display($this->plugin);
    $display->init();
  }

}