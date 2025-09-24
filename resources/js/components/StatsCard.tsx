import { Card, CardContent } from '@/components/ui';
import { cn } from '@/lib/utils';
import { ReactNode } from 'react';

interface StatsCardProps {
    title: string;
    value: string;
    icon: ReactNode;
    iconColorClass?: string;
    className?: string;
}

export function StatsCard({ title, value, icon, iconColorClass = 'text-primary', className }: StatsCardProps) {
    return (
        <Card className={className}>
            <CardContent className="p-6">
                <div className="flex items-center">
                    <div className="flex-1">
                        <p className="text-[color:var(--color-muted)] text-sm font-medium">{title}</p>
                        <p className="text-[color:var(--color-text)] text-2xl font-bold">{value}</p>
                    </div>
                    <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-[color:var(--color-primary)]/10">
                        <div className={cn('h-6 w-6', iconColorClass)}>{icon}</div>
                    </div>
                </div>
            </CardContent>
        </Card>
    );
}