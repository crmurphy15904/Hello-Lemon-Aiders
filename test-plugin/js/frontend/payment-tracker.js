(function($) {
  'use strict';

  /**
   * Payment Tracker functionality
   */
  class PaymentTracker {
    constructor() {
      this.modal = $('#payment-edit-modal');
      this.form = $('#payment-edit-form');
      this.sessionKey = 'payment_tracker_data';
      this.init();
    }

    init() {
      this.loadSessionData();
      this.bindEvents();
    }

    bindEvents() {
      // Edit button click
      $('.edit-payment-btn').on('click', (e) => {
        const userIndex = $(e.currentTarget).data('user-index');
        this.openEditModal(userIndex);
      });

      // Close modal
      $('.payment-modal-close, .cancel-payment-btn').on('click', () => {
        this.closeModal();
      });

      // Close modal on outside click
      $(window).on('click', (e) => {
        if ($(e.target).is('#payment-edit-modal')) {
          this.closeModal();
        }
      });

      // Form submit
      this.form.on('submit', (e) => {
        e.preventDefault();
        this.savePayment();
      });
    }

    openEditModal(userIndex) {
      const row = $(`tr[data-user-index="${userIndex}"]`);
      const userName = row.find('.user-name').text();
      const paidAmount = row.find('.paid-amount').data('paid');

      $('#edit-user-index').val(userIndex);
      $('#edit-user-name').val(userName);
      $('#edit-paid-amount').val(paidAmount);

      this.modal.fadeIn(300);
    }

    closeModal() {
      this.modal.fadeOut(300);
      this.form[0].reset();
    }

    savePayment() {
      const userIndex = $('#edit-user-index').val();
      const newPaidAmount = parseFloat($('#edit-paid-amount').val());

      if (isNaN(newPaidAmount) || newPaidAmount < 0) {
        alert('Please enter a valid payment amount.');
        return;
      }

      const row = $(`tr[data-user-index="${userIndex}"]`);
      const totalCost = parseFloat(row.find('.total-cost').data('total'));

      // Update paid amount
      row.find('.paid-amount')
        .data('paid', newPaidAmount)
        .text('$' + this.formatMoney(newPaidAmount));

      // Recalculate and update remaining balance
      const remainingBalance = totalCost - newPaidAmount;
      row.find('.remaining-balance')
        .data('remaining', remainingBalance)
        .text('$' + this.formatMoney(remainingBalance));

      // Save to session storage
      this.saveToSession(userIndex, newPaidAmount);

      this.closeModal();
    }

    formatMoney(amount) {
      return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    saveToSession(userIndex, paidAmount) {
      let sessionData = this.getSessionData();
      sessionData[userIndex] = paidAmount;
      sessionStorage.setItem(this.sessionKey, JSON.stringify(sessionData));
    }

    getSessionData() {
      const data = sessionStorage.getItem(this.sessionKey);
      return data ? JSON.parse(data) : {};
    }

    loadSessionData() {
      const sessionData = this.getSessionData();
      
      Object.keys(sessionData).forEach(userIndex => {
        const row = $(`tr[data-user-index="${userIndex}"]`);
        if (row.length) {
          const paidAmount = sessionData[userIndex];
          const totalCost = parseFloat(row.find('.total-cost').data('total'));

          // Update paid amount
          row.find('.paid-amount')
            .data('paid', paidAmount)
            .text('$' + this.formatMoney(paidAmount));

          // Recalculate and update remaining balance
          const remainingBalance = totalCost - paidAmount;
          row.find('.remaining-balance')
            .data('remaining', remainingBalance)
            .text('$' + this.formatMoney(remainingBalance));
        }
      });
    }
  }

  // Initialize on document ready
  $(document).ready(function() {
    if ($('.payment-tracker-wrapper').length) {
      new PaymentTracker();
    }
  });

})(jQuery);
