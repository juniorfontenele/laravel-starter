import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui';
import { Link } from '@inertiajs/react';
import { ReactNode } from 'react';

interface Statistic {
    id: string;
    icon: ReactNode;
    iconColorClass: string;
    title: string;
    description: string;
}

interface StatisticsCardProps {
    statistics?: Statistic[];
    viewAllHref?: string;
}

export function StatisticsCard({ statistics = [], viewAllHref = '/analytics' }: StatisticsCardProps) {
    const defaultStatistics: Statistic[] = [
        {
            id: '1',
            icon: <svg className="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9a1 1 0 112 0v4a1 1 0 11-2 0V9z"/></svg>,
            iconColorClass: 'text-primary',
            title: '+15 novos usuários hoje',
            description: 'Crescimento de 12% em relação à semana passada',
        },
        {
            id: '2',
            icon: <svg className="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/></svg>,
            iconColorClass: 'text-success',
            title: '98% de uptime este mês',
            description: 'Melhor performance do trimestre',
        },
        {
            id: '3',
            icon: <svg className="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>,
            iconColorClass: 'text-info',
            title: 'Analytics ativado',
            description: 'Coletando dados desde ontem',
        },
    ];

    const displayStatistics = statistics.length > 0 ? statistics : defaultStatistics;

    return (
        <Card>
            <CardHeader>
                <div className="flex items-center justify-between">
                    <CardTitle>Estatísticas</CardTitle>
                    <Link href={viewAllHref} className="text-[color:var(--color-primary)] text-sm hover:underline">
                        Ver relatório
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <div className="space-y-3">
                    {displayStatistics.map((statistic) => (
                        <div key={statistic.id} className="flex items-start space-x-3">
                            <div className="flex h-6 w-6 items-center justify-center rounded-full bg-[color:var(--color-primary)]/10">
                                <div className={statistic.iconColorClass}>{statistic.icon}</div>
                            </div>
                            <div className="flex-1">
                                <p className="text-[color:var(--color-text)] text-sm font-medium">{statistic.title}</p>
                                <p className="text-[color:var(--color-muted)] text-xs">{statistic.description}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </CardContent>
        </Card>
    );
}