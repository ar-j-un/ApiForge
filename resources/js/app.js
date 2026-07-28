import * as coreui from '@coreui/coreui';
window.coreui = coreui;

import './color-modes.js';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize all popovers
    document.querySelectorAll('[data-coreui-toggle="popover"]').forEach(el => {
        new coreui.Popover(el);
    });
});