<?php

namespace Company\Test_Plugin\Frontend;

class Display {

  /**
	 * Full path and filename of plugin.
	 *
	 * @var string $plugin Full path and filename of plugin.
	 */
  private $plugin;
  
  /**
   * __construct
   *
   * @param  mixed $plugin
   * @return void
   */
  public function __construct($plugin) {
    $this->plugin = $plugin;
  }
  
  /**
   * Init
   *
   * @return void
   */
  public function init() {
    // Register shortcodes here
    add_shortcode('payment_tracker', array($this, 'render_payment_tracker_shortcode'));
  }
  
  /**
   * Render payment tracker shortcode
   *
   * @return string
   */
  public function render_payment_tracker_shortcode() {
    $payment_tracker = new Payment_Tracker($this->plugin);
    return $payment_tracker->render_payment_tracker();
  }
  
}