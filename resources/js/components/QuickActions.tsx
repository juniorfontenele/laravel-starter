import { Button } from '@/components/ui';
import { Link } from '@inertiajs/react';
import { ReactNode } from 'react';

interface QuickAction {
    id: string;
    title: string;
    description: string;
    href: string;
    icon: ReactNode;
    iconColorClass: string;
}

interface QuickActionsProps {
    actions?: QuickAction[];
    className?: string;
}

export function QuickActions({ actions = [], className }: QuickActionsProps) {
    const defaultActions: QuickAction[] = [
        {
            id: '1',
            title: 'Novo Usuário',
            description: 'Criar usuário',
            href: '/users/create',
            icon: <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/></svg>,
            iconColorClass: 'text-primary',
        },
        {
            id: '2',
            title: 'Usuários',
            description: 'Gerenciar usuários',
            href: '/users',
            icon: <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>,
            iconColorClass: 'text-info',
        },
        {
            id: '3',
            title: 'Analytics',
            description: 'Ver métricas',
            href: '/analytics',
            icon: <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>,
            iconColorClass: 'text-success',
        },
        {
            id: '4',
            title: 'Configurações',
            description: 'Ajustar sistema',
            href: '/settings',
            icon: <svg className="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fillRule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clipRule="evenodd"/></svg>,
            iconColorClass: 'text-warning',
        },
    ];

    const displayActions = actions.length > 0 ? actions : defaultActions;

    return (
        <div className={className}>
            <h3 className="text-[color:var(--color-text)] mb-4 text-lg font-semibold">Ações Rápidas</h3>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                {displayActions.map((action) => (
                    <Button key={action.id} variant="outline" asChild className="h-auto justify-start p-4">
                        <Link href={action.href} className="flex items-center space-x-3">
                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-[color:var(--color-primary)]/10">
                                <div className={action.iconColorClass}>{action.icon}</div>
                            </div>
                            <div>
                                <p className="text-[color:var(--color-text)] font-medium">{action.title}</p>
                                <p className="text-[color:var(--color-muted)] text-sm">{action.description}</p>
                            </div>
                        </Link>
                    </Button>
                ))}
            </div>
        </div>
    );
}