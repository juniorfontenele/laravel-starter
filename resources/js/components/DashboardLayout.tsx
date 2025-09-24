import { ActivityCard } from '@/components/ActivityCard';
import { DashboardHeader } from '@/components/DashboardHeader';
import { QuickActions } from '@/components/QuickActions';
import { StatisticsCard } from '@/components/StatisticsCard';
import { StatsCard } from '@/components/StatsCard';
import { Tenant, User } from '@/types';
import { AiOutlineUser } from 'react-icons/ai';
import { BiBarChartAlt2, BiTrendingUp } from 'react-icons/bi';
import { MdCheckCircle } from 'react-icons/md';

interface DashboardLayoutProps {
    tenant: Tenant;
    user: User;
}

export function DashboardLayout({ tenant, user }: DashboardLayoutProps) {
    return (
        <div className="min-h-screen bg-[color:var(--color-background)]">
            <DashboardHeader tenant={tenant} user={user} />

            <main className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                {/* Boas-vindas */}
                <div className="mb-8">
                    <h2 className="text-[color:var(--color-text)] text-2xl font-bold">Bem-vindo, {user.name}!</h2>
                    <p className="text-[color:var(--color-muted)] mt-2">Visão geral da sua aplicação Laravel.</p>
                </div>

                {/* Cards de resumo */}
                <div className="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <StatsCard
                        title="Total de Usuários"
                        value="1,234"
                        icon={<AiOutlineUser />}
                        iconColorClass="text-primary"
                    />
                    <StatsCard
                        title="Vendas do Mês"
                        value="R$ 45,2k"
                        icon={<BiTrendingUp />}
                        iconColorClass="text-success"
                    />
                    <StatsCard
                        title="Pedidos Hoje"
                        value="23"
                        icon={<BiBarChartAlt2 />}
                        iconColorClass="text-info"
                    />
                    <StatsCard
                        title="Taxa de Conversão"
                        value="3.2%"
                        icon={<MdCheckCircle />}
                        iconColorClass="text-warning"
                    />
                </div>

                {/* Seções principais */}
                <div className="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <ActivityCard />
                    <StatisticsCard />
                </div>

                {/* Ações rápidas */}
                <QuickActions className="mt-8" />
            </main>
        </div>
    );
}