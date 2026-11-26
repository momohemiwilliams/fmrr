<style>
/* Universal Submit Button Spinner Styling */
.submit-btn-spinning {
    position: relative !important;
    pointer-events: none !important;
    cursor: not-allowed !important;
    opacity: 0.85 !important;
}

.submit-btn-spinner {
    display: inline-block !important;
    width: 0.95em !important;
    height: 0.95em !important;
    border: 2px solid currentColor !important;
    border-right-color: transparent !important;
    border-radius: 50% !important;
    vertical-align: -0.15em !important;
    margin-right: 0.45em !important;
    animation: submitSpinnerRotate 0.65s linear infinite !important;
    box-sizing: border-box !important;
    flex-shrink: 0 !important;
}

@keyframes submitSpinnerRotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
(function() {
    if (window.__SUBMIT_SPINNER_HANDLER_INITIALIZED__) return;
    window.__SUBMIT_SPINNER_HANDLER_INITIALIZED__ = true;

    var activeSubmitBtn = null;

    /**
     * Apply spinner and disable button safely
     */
    function applySubmitSpinner(button) {
        if (!button) return;
        if (button.dataset && button.dataset.isSubmitting === "true") return;

        // Prevent disabling if explicitly flagged to skip
        if (button.classList.contains('no-spinner') || (button.dataset && button.dataset.noSpinner)) {
            return;
        }

        button.dataset.isSubmitting = "true";
        button.dataset.wasAutoDisabled = "true";
        button.classList.add('submit-btn-spinning');
        button.setAttribute('aria-busy', 'true');

        // Preserve button dimensions so layout doesn't jump
        if (button.offsetWidth > 0 && !button.style.minWidth) {
            button.style.minWidth = button.offsetWidth + 'px';
        }

        // 1. Reveal existing FontAwesome or Bootstrap spinner if present inside button
        var existingSpinner = button.querySelector('.fa-spinner, .spinner-border, .spinner-grow');
        if (existingSpinner) {
            existingSpinner.style.removeProperty('display');
            existingSpinner.style.display = 'inline-block';
            existingSpinner.classList.remove('d-none');
        } else {
            // 2. Otherwise insert pure CSS spinner
            if (!button.querySelector('.submit-btn-spinner')) {
                var spinner = document.createElement('span');
                spinner.className = 'submit-btn-spinner';
                spinner.setAttribute('aria-hidden', 'true');
                button.insertBefore(spinner, button.firstChild);
            }
        }

        // If button has a .btn-text span, ensure it remains visible alongside spinner
        var btnText = button.querySelector('.btn-text');
        if (btnText && btnText.innerHTML.trim() === '') {
            btnText.innerHTML = 'Processing...';
        }

        // Disable asynchronously so standard form submission data is not dropped
        setTimeout(function() {
            button.disabled = true;
        }, 10);
    }

    /**
     * Reset button state (for AJAX completion, form invalidation, or page restore)
     */
    function resetButton(button) {
        if (!button) return;
        button.disabled = false;
        button.classList.remove('submit-btn-spinning');
        button.removeAttribute('aria-busy');
        if (button.dataset) {
            delete button.dataset.isSubmitting;
            delete button.dataset.wasAutoDisabled;
        }
        var autoSpinner = button.querySelector('.submit-btn-spinner');
        if (autoSpinner) {
            autoSpinner.remove();
        }
        var existingSpinner = button.querySelector('.fa-spinner');
        if (existingSpinner) {
            existingSpinner.style.display = 'none';
        }
    }

    // Expose global loading helper for backward compatibility with existing blade views
    window.loading = function(buttonId) {
        if (buttonId) {
            var el = typeof buttonId === 'string' ? document.getElementById(buttonId) : buttonId;
            if (el) {
                applySubmitSpinner(el);
                return;
            }
        }
        var active = activeSubmitBtn || document.querySelector('button[type="submit"]:focus, .auth-submit-btn:focus');
        if (active) {
            applySubmitSpinner(active);
        }
    };

    window.resetSubmitButton = resetButton;

    // Track clicked submit button across the document
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('button[type="submit"], input[type="submit"], button:not([type]), .btn-submit, .auth-submit-btn');
        if (btn) {
            activeSubmitBtn = btn;

            var form = btn.form || btn.closest('form');
            if (form) {
                // Check HTML5 validity
                if (form.checkValidity && !form.checkValidity()) {
                    return; // Let browser show native validation tooltip
                }
            }

            // Apply spinner on next tick if submission proceeds
            setTimeout(function() {
                if (e.defaultPrevented) return;
                applySubmitSpinner(btn);
            }, 10);
        }
    }, true);

    // Form submit listener (handles Enter key submits and programmatic submits)
    document.addEventListener('submit', function(e) {
        var form = e.target;
        if (!form || form.nodeName !== 'FORM') return;

        // Check HTML5 validity
        if (form.checkValidity && !form.checkValidity()) {
            return;
        }

        var btn = activeSubmitBtn;
        if (!btn || (btn.form && btn.form !== form)) {
            btn = form.querySelector('button[type="submit"], input[type="submit"], button:not([type]), .btn-submit, .auth-submit-btn, .btn-primary, .btn-success, .btn-danger');
        }

        if (btn) {
            setTimeout(function() {
                if (e.defaultPrevented) return;
                applySubmitSpinner(btn);
            }, 0);
        }
    }, false);

    // Intercept native form.submit() calls
    var originalSubmit = HTMLFormElement.prototype.submit;
    HTMLFormElement.prototype.submit = function() {
        var form = this;
        var btn = form.querySelector('button[type="submit"], input[type="submit"], button:not([type]), .btn-submit, .auth-submit-btn, .btn-primary, .btn-success, .btn-danger');
        if (btn) {
            applySubmitSpinner(btn);
        }
        return originalSubmit.apply(form, arguments);
    };

    // Re-enable buttons if restored from browser bfcache (Back/Forward)
    window.addEventListener('pageshow', function() {
        document.querySelectorAll('.submit-btn-spinning, button[data-is-submitting]').forEach(function(b) {
            resetButton(b);
        });
    });

    // Reset buttons on AJAX complete (if jQuery is present)
    if (window.jQuery) {
        window.jQuery(document).ajaxComplete(function() {
            document.querySelectorAll('.submit-btn-spinning, button[data-is-submitting]').forEach(function(b) {
                resetButton(b);
            });
        });
    }
})();
</script>

