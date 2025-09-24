import { Badge, Card, CardContent, CardHeader, CardTitle } from '@/components/ui';
import { Link } from '@inertiajs/react';

interface Activity {
    id: string;
    title: string;
    description: string;
    badge: {
        text: string;
        variant: 'default' | 'secondary' | 'destructive' | 'outline';
    };
}

interface ActivityCardProps {
    activities?: Activity[];
    viewAllHref?: string;
}

export function ActivityCard({ activities = [], viewAllHref = '/activities' }: ActivityCardProps) {
    const defaultActivities: Activity[] = [
        {
            id: '1',
            title: 'Novo usuário registrado',
            description: 'João Silva • há 2 horas',
            badge: { text: 'Novo', variant: 'default' },
        },
        {
            id: '2',
            title: 'Pedido processado',
            description: '#1234 • há 1 dia',
            badge: { text: 'Sucesso', variant: 'secondary' },
        },
        {
            id: '3',
            title: 'Sistema atualizado',
            description: 'v2.1.0 • há 3 dias',
            badge: { text: 'Info', variant: 'outline' },
        },
    ];

    const displayActivities = activities.length > 0 ? activities : defaultActivities;

    return (
        <Card>
            <CardHeader>
                <div className="flex items-center justify-between">
                    <CardTitle>Últimas Atividades</CardTitle>
                    <Link href={viewAllHref} className="text-[color:var(--color-primary)] text-sm hover:underline">
                        Ver todas
                    </Link>
                </div>
            </CardHeader>
            <CardContent>
                <div className="space-y-3">
                    {displayActivities.map((activity, index) => (
                        <div
                            key={activity.id}
                            className={`flex items-center justify-between ${
                                index < displayActivities.length - 1 ? 'border-border border-b pb-2' : ''
                            }`}
                        >
                            <div>
                                <p className="text-[color:var(--color-text)] text-sm font-medium">{activity.title}</p>
                                <p className="text-[color:var(--color-muted)] text-xs">{activity.description}</p>
                            </div>
                            <Badge variant={activity.badge.variant}>{activity.badge.text}</Badge>
                        </div>
                    ))}
                </div>
            </CardContent>
        </Card>
    );
}