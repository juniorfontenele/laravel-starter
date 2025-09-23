import { ThemeToggle } from '@/components/ThemeToggle';
import {
    Avatar,
    Badge,
    Button,
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui';
import { logout, selectTenant } from '@/routes';
import { Tenant, User } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { AiOutlinePlus, AiOutlineUser } from 'react-icons/ai';
import { BiBarChartAlt2, BiTrendingUp } from 'react-icons/bi';
import { MdCheckCircle, MdDashboard, MdKeyboardArrowDown, MdLogout, MdPerson, MdSettings, MdSwapHoriz } from 'react-icons/md';

export default function Dashboard() {
    const { tenant, user } = usePage<{ tenant: Tenant; user: User }>().props;

    const handleLogout = () => {
        router.visit(logout.url());
    };

    if (!user) {
        return null; // ou redirect para login
    }

    return (
        <>
            <Head title="Dashboard" />
            <div className="min-h-screen bg-[color:var(--color-background)]">
                {/* Header com menu superior horizontal */}
                <header className="bg-surface border-border border-b shadow-sm">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="flex h-16 items-center justify-between">
                            {/* Logo e nome do tenant */}
                            <div className="flex items-center space-x-4">
                                <img src={tenant.logo} alt={tenant.name} className="h-8 w-auto" />
                                <div>
                                    <h1 className="text-text text-lg font-semibold">{tenant.title}</h1>
                                </div>
                            </div>

                            {/* Menu de navegação */}
                            <nav className="hidden items-center space-x-8 md:flex">
                                <Link
                                    href="/dashboard"
                                    className="text-text hover:text-primary flex items-center gap-2 font-medium transition-colors"
                                >
                                    <MdDashboard />
                                    Dashboard
                                </Link>

                                <Link href="/users" className="text-muted hover:text-primary flex items-center gap-2 font-medium transition-colors">
                                    <AiOutlineUser />
                                    Usuários
                                </Link>

                                <Link
                                    href="/analytics"
                                    className="text-muted hover:text-primary flex items-center gap-2 font-medium transition-colors"
                                >
                                    <BiBarChartAlt2 />
                                    Analytics
                                </Link>

                                <Link
                                    href="/settings"
                                    className="text-muted hover:text-primary flex items-center gap-2 font-medium transition-colors"
                                >
                                    <MdSettings />
                                    Configurações
                                </Link>
                            </nav>

                            {/* Menu do usuário e controles */}
                            <div className="flex items-center space-x-4">
                                <ThemeToggle />

                                {/* Dropdown do usuário */}
                                <div className="relative">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger asChild>
                                            <Button
                                                variant="ghost"
                                                className="text-text hover:text-primary flex h-auto items-center space-x-2 p-2 transition-colors"
                                            >
                                                <Avatar fallback={user.name.charAt(0).toUpperCase()} className="h-8 w-8" />
                                                <span className="text-sm font-medium">{user.name}</span>
                                                <MdKeyboardArrowDown className="h-4 w-4" />
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end" className="w-56">
                                            <DropdownMenuItem asChild>
                                                <Link href="/profile" className="flex items-center gap-2">
                                                    <MdPerson className="h-4 w-4" />
                                                    Perfil
                                                </Link>
                                            </DropdownMenuItem>
                                            {user.has_multiple_tenants && (
                                                <DropdownMenuItem asChild>
                                                    <Link href={selectTenant.url()} className="flex items-center gap-2">
                                                        <MdSwapHoriz className="h-4 w-4" />
                                                        Alterar tenant
                                                    </Link>
                                                </DropdownMenuItem>
                                            )}
                                            <DropdownMenuSeparator />
                                            <DropdownMenuItem className="text-danger focus:text-danger cursor-pointer" onClick={handleLogout}>
                                                <MdLogout className="h-4 w-4" />
                                                Sair
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Menu mobile */}
                    <div className="border-border border-t md:hidden">
                        <div className="space-y-1 px-4 py-3">
                            <Link
                                href="/dashboard"
                                className="text-text hover:text-primary flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                            >
                                <MdDashboard />
                                Dashboard
                            </Link>
                            <Link
                                href="/users"
                                className="text-muted hover:text-primary flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                            >
                                <AiOutlineUser />
                                Usuários
                            </Link>
                            <Link
                                href="/analytics"
                                className="text-muted hover:text-primary flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                            >
                                <BiBarChartAlt2 />
                                Analytics
                            </Link>
                            <Link
                                href="/settings"
                                className="text-muted hover:text-primary flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                            >
                                <MdSettings />
                                Configurações
                            </Link>
                        </div>
                    </div>
                </header>

                {/* Conteúdo principal */}
                <main className="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Boas-vindas */}
                    <div className="mb-8">
                        <h2 className="text-text text-2xl font-bold">Bem-vindo, {user.name}!</h2>
                        <p className="text-muted mt-2">Visão geral da sua aplicação Laravel.</p>
                    </div>

                    {/* Cards de resumo */}
                    <div className="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <Card>
                            <CardContent className="p-6">
                                <div className="flex items-center">
                                    <div className="flex-1">
                                        <p className="text-muted text-sm font-medium">Total de Usuários</p>
                                        <p className="text-text text-2xl font-bold">1,234</p>
                                    </div>
                                    <div className="bg-primary/10 flex h-12 w-12 items-center justify-center rounded-lg">
                                        <AiOutlineUser className="text-primary h-6 w-6" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardContent className="p-6">
                                <div className="flex items-center">
                                    <div className="flex-1">
                                        <p className="text-muted text-sm font-medium">Vendas do Mês</p>
                                        <p className="text-text text-2xl font-bold">R$ 45,2k</p>
                                    </div>
                                    <div className="bg-success/10 flex h-12 w-12 items-center justify-center rounded-lg">
                                        <BiTrendingUp className="text-success h-6 w-6" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardContent className="p-6">
                                <div className="flex items-center">
                                    <div className="flex-1">
                                        <p className="text-muted text-sm font-medium">Pedidos Hoje</p>
                                        <p className="text-text text-2xl font-bold">23</p>
                                    </div>
                                    <div className="bg-info/10 flex h-12 w-12 items-center justify-center rounded-lg">
                                        <BiBarChartAlt2 className="text-info h-6 w-6" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardContent className="p-6">
                                <div className="flex items-center">
                                    <div className="flex-1">
                                        <p className="text-muted text-sm font-medium">Taxa de Conversão</p>
                                        <p className="text-text text-2xl font-bold">3.2%</p>
                                    </div>
                                    <div className="bg-warning/10 flex h-12 w-12 items-center justify-center rounded-lg">
                                        <MdCheckCircle className="text-warning h-6 w-6" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Seções principais */}
                    <div className="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        {/* Últimas Atividades */}
                        <Card>
                            <CardHeader>
                                <div className="flex items-center justify-between">
                                    <CardTitle>Últimas Atividades</CardTitle>
                                    <Link href="/activities" className="text-primary text-sm hover:underline">
                                        Ver todas
                                    </Link>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    <div className="border-border flex items-center justify-between border-b pb-2">
                                        <div>
                                            <p className="text-text text-sm font-medium">Novo usuário registrado</p>
                                            <p className="text-muted text-xs">João Silva • há 2 horas</p>
                                        </div>
                                        <Badge variant="default">Novo</Badge>
                                    </div>
                                    <div className="border-border flex items-center justify-between border-b pb-2">
                                        <div>
                                            <p className="text-text text-sm font-medium">Pedido processado</p>
                                            <p className="text-muted text-xs">#1234 • há 1 dia</p>
                                        </div>
                                        <Badge variant="success">Sucesso</Badge>
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <p className="text-text text-sm font-medium">Sistema atualizado</p>
                                            <p className="text-muted text-xs">v2.1.0 • há 3 dias</p>
                                        </div>
                                        <Badge variant="outline">Info</Badge>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Estatísticas */}
                        <Card>
                            <CardHeader>
                                <div className="flex items-center justify-between">
                                    <CardTitle>Estatísticas</CardTitle>
                                    <Link href="/analytics" className="text-primary text-sm hover:underline">
                                        Ver relatório
                                    </Link>
                                </div>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-3">
                                    <div className="flex items-start space-x-3">
                                        <div className="bg-primary/10 flex h-6 w-6 items-center justify-center rounded-full">
                                            <AiOutlineUser className="text-primary h-3 w-3" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="text-text text-sm font-medium">+15 novos usuários hoje</p>
                                            <p className="text-muted text-xs">Crescimento de 12% em relação à semana passada</p>
                                        </div>
                                    </div>
                                    <div className="flex items-start space-x-3">
                                        <div className="bg-success/10 flex h-6 w-6 items-center justify-center rounded-full">
                                            <MdCheckCircle className="text-success h-3 w-3" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="text-text text-sm font-medium">98% de uptime este mês</p>
                                            <p className="text-muted text-xs">Melhor performance do trimestre</p>
                                        </div>
                                    </div>
                                    <div className="flex items-start space-x-3">
                                        <div className="bg-info/10 flex h-6 w-6 items-center justify-center rounded-full">
                                            <BiBarChartAlt2 className="text-info h-3 w-3" />
                                        </div>
                                        <div className="flex-1">
                                            <p className="text-text text-sm font-medium">Analytics ativado</p>
                                            <p className="text-muted text-xs">Coletando dados desde ontem</p>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                    </div>

                    {/* Ações rápidas */}
                    <div className="mt-8">
                        <h3 className="text-text mb-4 text-lg font-semibold">Ações Rápidas</h3>
                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <Button variant="outline" asChild className="h-auto justify-start p-4">
                                <Link href="/users/create" className="flex items-center space-x-3">
                                    <div className="bg-primary/10 flex h-10 w-10 items-center justify-center rounded-lg">
                                        <AiOutlinePlus className="text-primary h-5 w-5" />
                                    </div>
                                    <div>
                                        <p className="text-text font-medium">Novo Usuário</p>
                                        <p className="text-muted text-sm">Criar usuário</p>
                                    </div>
                                </Link>
                            </Button>

                            <Button variant="outline" asChild className="h-auto justify-start p-4">
                                <Link href="/users" className="flex items-center space-x-3">
                                    <div className="bg-info/10 flex h-10 w-10 items-center justify-center rounded-lg">
                                        <AiOutlineUser className="text-info h-5 w-5" />
                                    </div>
                                    <div>
                                        <p className="text-text font-medium">Usuários</p>
                                        <p className="text-muted text-sm">Gerenciar usuários</p>
                                    </div>
                                </Link>
                            </Button>

                            <Button variant="outline" asChild className="h-auto justify-start p-4">
                                <Link href="/analytics" className="flex items-center space-x-3">
                                    <div className="bg-success/10 flex h-10 w-10 items-center justify-center rounded-lg">
                                        <BiBarChartAlt2 className="text-success h-5 w-5" />
                                    </div>
                                    <div>
                                        <p className="text-text font-medium">Analytics</p>
                                        <p className="text-muted text-sm">Ver métricas</p>
                                    </div>
                                </Link>
                            </Button>

                            <Button variant="outline" asChild className="h-auto justify-start p-4">
                                <Link href="/settings" className="flex items-center space-x-3">
                                    <div className="bg-warning/10 flex h-10 w-10 items-center justify-center rounded-lg">
                                        <MdSettings className="text-warning h-5 w-5" />
                                    </div>
                                    <div>
                                        <p className="text-text font-medium">Configurações</p>
                                        <p className="text-muted text-sm">Ajustar sistema</p>
                                    </div>
                                </Link>
                            </Button>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}
