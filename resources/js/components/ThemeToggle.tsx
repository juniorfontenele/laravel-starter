import { useEffect, useState } from 'react';
import { MdDarkMode, MdLightMode } from 'react-icons/md';
import { applyTheme, getInitialTheme, type Theme } from '../providers/theme';

export function ThemeToggle() {
    const [theme, setTheme] = useState<Theme>(getInitialTheme());

    useEffect(() => applyTheme(theme), [theme]);

    const toggleTheme = () => {
        setTheme(theme === 'dark' ? 'light' : 'dark');
    };

    return (
        <button
            className={`theme-toggle ${theme === 'dark' ? 'active' : ''}`}
            onClick={toggleTheme}
            aria-label={`Alterar para tema ${theme === 'dark' ? 'claro' : 'escuro'}`}
            role="switch"
            aria-checked={theme === 'dark'}
        >
            <div className="theme-toggle-handle">{theme === 'dark' ? <MdDarkMode /> : <MdLightMode />}</div>
        </button>
    );
}
