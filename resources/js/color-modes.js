/*!
* Color mode toggler for CoreUI
*/
const THEME = 'apiforge-theme';

const getStoredTheme = () => localStorage.getItem(THEME);
const setStoredTheme = theme => localStorage.setItem(THEME, theme);

const getPreferredTheme = () => {
    const storedTheme = getStoredTheme();
    if (storedTheme) {
        return storedTheme;
    }
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const setTheme = theme => {
    if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.setAttribute('data-coreui-theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-coreui-theme', theme);
    }
    document.documentElement.dispatchEvent(new Event('ColorSchemeChange'));
};

setTheme(getPreferredTheme());

const showActiveTheme = theme => {
    const btnToActive = document.querySelector(`[data-coreui-theme-value="${theme}"]`);
    if (!btnToActive) return;
    for (const element of document.querySelectorAll('[data-coreui-theme-value]')) {
        element.classList.remove('active');
    }
    btnToActive.classList.add('active');
};

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme();
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
        setTheme(getPreferredTheme());
    }
});

window.addEventListener('DOMContentLoaded', () => {
    showActiveTheme(getPreferredTheme());
    for (const toggle of document.querySelectorAll('[data-coreui-theme-value]')) {
        toggle.addEventListener('click', () => {
            const theme = toggle.getAttribute('data-coreui-theme-value');
            setStoredTheme(theme);
            setTheme(theme);
            showActiveTheme(theme);
        });
    }
});