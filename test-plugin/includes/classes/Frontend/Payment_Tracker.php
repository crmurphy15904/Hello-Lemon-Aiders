<?php

namespace Company\Test_Plugin\Frontend;

class Payment_Tracker {

  /**
   * Full path and filename of plugin.
   *
   * @var string $plugin Full path and filename of plugin.
   */
  private $plugin;
  
  /**
   * Test data for payment tracking
   *
   * @var array $payment_data
   */
  private $payment_data;
  
  /**
   * __construct
   *
   * @param  mixed $plugin
   * @return void
   */
  public function __construct($plugin) {
    $this->plugin = $plugin;
    $this->init_test_data();
  }
  
  /**
   * Initialize test data
   *
   * NOTE: This uses hard-coded test data for first iteration development.
   * In future iterations, this should be replaced with database queries
   * or configurable data sources.
   *
   * @return void
   */
  private function init_test_data() {
    // Hard-coded test data for development purposes (non-persistent across sessions)
    $this->payment_data = array(
      array(
        'user' => 'User 1',
        'total_cost' => 5000,
        'paid' => 1000,
      ),
      array(
        'user' => 'User 2',
        'total_cost' => 5000,
        'paid' => 2500,
      ),
      array(
        'user' => 'User 3',
        'total_cost' => 5000,
        'paid' => 0,
      ),
      array(
        'user' => 'User 4',
        'total_cost' => 5000,
        'paid' => 0,
      ),
    );
  }
  
  /**
   * Render payment tracker table
   *
   * @return string
   */
  public function render_payment_tracker() {
    ob_start();
    ?>
    <div class="payment-tracker-wrapper">
      <table class="payment-tracker-table">
        <thead>
          <tr>
            <th><?php esc_html_e('User', 'test-plugin'); ?></th>
            <th><?php esc_html_e('Total Trip Cost', 'test-plugin'); ?></th>
            <th><?php esc_html_e('Paid', 'test-plugin'); ?></th>
            <th><?php esc_html_e('Remaining Balance', 'test-plugin'); ?></th>
            <th><?php esc_html_e('Actions', 'test-plugin'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->payment_data as $index => $user_payment) : 
            $remaining = $user_payment['total_cost'] - $user_payment['paid'];
          ?>
          <tr data-user-index="<?php echo esc_attr($index); ?>">
            <td class="user-name"><?php echo esc_html($user_payment['user']); ?></td>
            <td class="total-cost" data-total="<?php echo esc_attr($user_payment['total_cost']); ?>">
              $<?php echo number_format($user_payment['total_cost'], 2); ?>
            </td>
            <td class="paid-amount" data-paid="<?php echo esc_attr($user_payment['paid']); ?>">
              $<?php echo number_format($user_payment['paid'], 2); ?>
            </td>
            <td class="remaining-balance" data-remaining="<?php echo esc_attr($remaining); ?>">
              $<?php echo number_format($remaining, 2); ?>
            </td>
            <td class="actions">
              <button class="edit-payment-btn" data-user-index="<?php echo esc_attr($index); ?>">
                <?php esc_html_e('Edit', 'test-plugin'); ?>
              </button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <!-- Edit Modal -->
      <div id="payment-edit-modal" class="payment-modal" style="display: none;">
        <div class="payment-modal-content">
          <span class="payment-modal-close">&times;</span>
          <h3><?php esc_html_e('Edit Payment', 'test-plugin'); ?></h3>
          <form id="payment-edit-form">
            <input type="hidden" id="edit-user-index" value="">
            <div class="form-group">
              <label for="edit-user-name"><?php esc_html_e('User:', 'test-plugin'); ?></label>
              <input type="text" id="edit-user-name" readonly>
            </div>
            <div class="form-group">
              <label for="edit-paid-amount"><?php esc_html_e('Paid Amount:', 'test-plugin'); ?></label>
              <input type="number" id="edit-paid-amount" step="0.01" min="0" required>
            </div>
            <div class="form-actions">
              <button type="submit" class="save-payment-btn"><?php esc_html_e('Save', 'test-plugin'); ?></button>
              <button type="button" class="cancel-payment-btn"><?php esc_html_e('Cancel', 'test-plugin'); ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }
  
}
