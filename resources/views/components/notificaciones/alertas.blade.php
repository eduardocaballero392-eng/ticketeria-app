<style>
    :root {
        --bezier-smooth: cubic-bezier(0.4, 0, 0.2, 1);

        --info-bg: #E3F2FD; --info-border: #1976D2; --info-text: #1565C0;
        --success-bg: #E8F5E9; --success-border: #388E3C; --success-text: #2E7D32;
        --warning-bg: #FFF3E0; --warning-border: #F57C00; --warning-text: #EF6C00;
        --danger-bg: #FFEBEE; --danger-border: #D32F2F; --danger-text: #C62828;

        --saas-z-index: 9999;
        --saas-overlay-bg: rgba(15, 23, 42, 0.4);
        --saas-card-bg: #ffffff;
        --saas-card-border: #e2e8f0;
        --saas-text-title: #0f172a;
        --saas-text-desc: #475569;
        --saas-success-icon-bg: #dcfce7;
        --saas-success-icon: #16a34a;
        --saas-danger-icon-bg: #fee2e2;
        --saas-danger-icon: #dc2626;
        --saas-btn-primary: #0f172a;
        --saas-btn-primary-hover: #334155;
        --saas-btn-danger: #dc2626;
        --saas-btn-danger-hover: #b91c1c;
        --saas-btn-cancel-bg: #ffffff;
        --saas-btn-cancel-border: #cbd5e1;
        --saas-btn-cancel-text: #334155;
        --saas-btn-cancel-hover: #f8fafc;
    }

    /* ══ TOASTS ══ */
    #toast-container {
        position: fixed;
        top: 24px;
        right: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        z-index: 9999;
        pointer-events: none;
    }

    .toast {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        width: 360px;
        box-sizing: border-box;
        padding: 16px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        pointer-events: auto;
        transform: translateX(120%);
        opacity: 0;
        transition: transform .4s var(--bezier-smooth), opacity .4s var(--bezier-smooth);
    }
    .toast.show { transform: translateX(0); opacity: 1; }
    .toast.hide { opacity: 0; transform: translateX(20px); }

    .toast-info    { background: var(--info-bg);    border-left: 4px solid var(--info-border);    color: var(--info-text); }
    .toast-success { background: var(--success-bg); border-left: 4px solid var(--success-border); color: var(--success-text); }
    .toast-warning { background: var(--warning-bg); border-left: 4px solid var(--warning-border); color: var(--warning-text); }
    .toast-danger  { background: var(--danger-bg);  border-left: 4px solid var(--danger-border);  color: var(--danger-text); }

    .toast-icon { width: 24px; height: 24px; flex-shrink: 0; }
    .toast-content { flex: 1; }
    .toast-title { margin: 0; font-size: 14px; font-weight: 600; }
    .toast-message { margin-top: 4px; font-size: 13px; line-height: 1.4; }
    .toast-close { background: transparent; border: none; color: inherit; cursor: pointer; opacity: .6; }
    .toast-progress {
        position: absolute; bottom: 0; left: 0;
        height: 3px; width: 100%;
        background: currentColor; opacity: .3;
        transform-origin: left;
        animation: shrink linear forwards;
    }
    @keyframes shrink { to { transform: scaleX(0); } }

    @media (max-width: 600px) {
        #toast-container { top: 16px; left: 16px; right: 16px; }
        .toast { width: 100%; }
    }

    /* ══ MODAL CONFIRMACIÓN ══ */
    .modal-system-overlay {
        position: fixed;
        inset: 0;
        background-color: var(--saas-overlay-bg);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: var(--saas-z-index);
        padding: 24px;
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }
    .modal-system-overlay.is-active { opacity: 1; visibility: visible; }

    .modal-system-card {
        background: var(--saas-card-bg);
        width: 100%;
        max-width: 420px;
        border-radius: 12px;
        border: 1px solid var(--saas-card-border);
        padding: 32px 24px;
        box-shadow: 0 20px 25px -5px rgba(0,0,0,.1), 0 8px 10px -6px rgba(0,0,0,.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        opacity: 0;
        transform: translateY(15px) scale(.98);
        transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), opacity .25s ease;
    }
    .modal-system-overlay.is-active .modal-system-card { opacity: 1; transform: translateY(0) scale(1); }

    .modal-icon-wrapper {
        width: 56px; height: 56px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
    }
    .modal-icon-wrapper svg { width: 28px; height: 28px; }
    .modal-title { font-size: 20px; font-weight: 600; color: var(--saas-text-title); margin-bottom: 10px; }
    .modal-desc  { font-size: 15px; line-height: 1.6; color: var(--saas-text-desc); margin-bottom: 32px; }

    .modal-actions { width: 100%; display: flex; flex-direction: column; gap: 10px; }

    .modal-btn { height: 44px; border-radius: 8px; border: none; cursor: pointer; font-size: 15px; font-weight: 500; transition: .2s; }
    .modal-btn:active { transform: translateY(1px); }
    .modal-btn-primary { background: var(--saas-btn-primary); color: white; }
    .modal-btn-primary:hover { background: var(--saas-btn-primary-hover); }
    .modal-btn-danger  { background: var(--saas-btn-danger); color: white; }
    .modal-btn-danger:hover { background: var(--saas-btn-danger-hover); }
    .modal-btn-cancel  { background: var(--saas-btn-cancel-bg); border: 1px solid var(--saas-btn-cancel-border); color: var(--saas-btn-cancel-text); }
    .modal-btn-cancel:hover { background: var(--saas-btn-cancel-hover); }

    @media (min-width: 640px) {
        .modal-actions { flex-direction: row-reverse; }
        .modal-btn { min-width: 140px; width: auto; padding: 0 20px; }
    }

    body.modal-open { overflow: hidden; }
</style>

<script>
/* ══════════════════════════════════════
   TOAST — para errores, warnings, info
   Uso: showNotification('danger', 'Título', 'Mensaje')
══════════════════════════════════════ */
class EnterpriseToastSystem {
    constructor() {
        this.activeNotifications = new Set();
        this.setupContainer();
    }

    setupContainer() {
        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        document.body.appendChild(this.container);
    }

    getIcon(type) {
        const icons = {
            info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                   </svg>`,
            success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                        <path d="M9 12l2 2 4-4"></path>
                      </svg>`,
            warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                      </svg>`,
            danger:  `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                      </svg>`
        };
        return icons[type] || icons.info;
    }

    show(type, title, message, duration = 5000) {
        const hash = `${type}|${title}|${message}`;
        if (this.activeNotifications.has(hash)) return;
        this.activeNotifications.add(hash);

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${this.getIcon(type)}</div>
            <div class="toast-content">
                <div class="toast-title">${title}</div>
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">✕</button>
            <div class="toast-progress" style="animation-duration:${duration}ms;"></div>
        `;
        this.container.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('show'));

        const removeToast = () => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => { toast.remove(); this.activeNotifications.delete(hash); }, 400);
        };

        const timer = setTimeout(removeToast, duration);
        toast.querySelector('.toast-close').addEventListener('click', () => { clearTimeout(timer); removeToast(); });
    }
}

const toastSystem = new EnterpriseToastSystem();

window.showNotification = function(type, title, message, duration = 5000) {
    toastSystem.show(type, title, message, duration);
};


/* ══════════════════════════════════════
   MODAL — para confirmaciones y éxitos
   Uso: ModalSystem.show('success', { title, text, confirmText, onConfirm })
        ModalSystem.show('confirm', { title, text, confirmText, cancelText, onConfirm, onCancel })
══════════════════════════════════════ */
class ModalSystemCore {
    constructor() {
        this.modalNode = null;
        this.previousActiveElement = null;
        this.options = {};
        this.handleKeydown = this.handleKeydown.bind(this);
        this.handleOutsideClick = this.handleOutsideClick.bind(this);
    }

    getIcons() {
        return {
            success: {
                bg: 'var(--saas-success-icon-bg)',
                color: 'var(--saas-success-icon)',
                svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6L9 17l-5-5"></path>
                      </svg>`
            },
            confirm: {
                bg: 'var(--saas-danger-icon-bg)',
                color: 'var(--saas-danger-icon)',
                svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                      </svg>`
            },
             question: {
            bg: 'var(--saas-success-icon-bg)',
            color: 'var(--saas-success-icon)',
            svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                  </svg>`
            },
            warning: {
                bg: 'var(--warning-bg)',
                color: 'var(--warning-border)',
                svg: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>`
            },
        };
    }

    show(type = 'success', config = {}) {
        const defaults = {
            title: '',
            text: '',
            confirmText: 'Aceptar',
            cancelText: 'Cancelar',
            closeOnOutsideClick: false,
            onConfirm: () => {},
            onCancel: () => {},
            onClose: () => {}
        };

        this.options = { ...defaults, ...config };
        this.previousActiveElement = document.activeElement;
        this.buildDOM(type);
        this.attachEvents();

        document.body.classList.add('modal-open');

        requestAnimationFrame(() => {
            this.modalNode.classList.add('is-active');
            this.setFocus();
        });
    }

    buildDOM(type) {
        if (this.modalNode) this.modalNode.remove();
        const iconData = this.getIcons()[type];

        const buttonsHTML = type === 'success'
            ? `<button type="button" class="modal-btn modal-btn-primary" data-action="confirm">${this.options.confirmText}</button>`
            : `<button type="button" class="modal-btn modal-btn-danger"  data-action="confirm">${this.options.confirmText}</button>
               <button type="button" class="modal-btn modal-btn-cancel"  data-action="cancel">${this.options.cancelText}</button>`;

        document.body.insertAdjacentHTML('beforeend', `
            <div class="modal-system-overlay">
                <div class="modal-system-card" role="dialog" aria-modal="true">
                    <div class="modal-icon-wrapper" style="background:${iconData.bg};color:${iconData.color};">
                        ${iconData.svg}
                    </div>
                    <h2 class="modal-title">${this.options.title}</h2>
                    <p class="modal-desc">${this.options.text}</p>
                    <div class="modal-actions">${buttonsHTML}</div>
                </div>
            </div>
        `);
        this.modalNode = document.body.lastElementChild;
    }

    attachEvents() {
        this.modalNode.querySelectorAll('[data-action]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const action = e.target.dataset.action;
                this.close();
                setTimeout(() => {
                    if (action === 'confirm') this.options.onConfirm();
                    if (action === 'cancel')  this.options.onCancel();
                }, 10);
            });
        });
        if (this.options.closeOnOutsideClick) {
            this.modalNode.addEventListener('mousedown', this.handleOutsideClick);
        }
        document.addEventListener('keydown', this.handleKeydown);
    }

    handleOutsideClick(e) {
        if (e.target === this.modalNode) { this.options.onCancel(); this.close(); }
    }

    handleKeydown(e) {
        if (e.key === 'Escape') { this.options.onCancel(); this.close(); }
    }

    setFocus() {
        const btn = this.modalNode.querySelector('[data-action="confirm"]');
        if (btn) btn.focus();
    }

    close() {
        if (!this.modalNode) return;
        const nodeToClose = this.modalNode;
        this.modalNode = null;
        nodeToClose.classList.remove('is-active');
        setTimeout(() => {
            document.body.classList.remove('modal-open');
            nodeToClose.remove();
            if (this.previousActiveElement) this.previousActiveElement.focus();
        }, 250);
        document.removeEventListener('keydown', this.handleKeydown);
        this.options.onClose();
    }
}

const ModalSystem = new ModalSystemCore();
</script>