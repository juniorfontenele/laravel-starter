import { ThemeToggle } from '@/components/ThemeToggle';
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
    Button,
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui';
import { logout, selectTenant } from '@/routes';
import { Tenant, User } from '@/types';
import { Link, router } from '@inertiajs/react';
import { AiOutlineUser } from 'react-icons/ai';
import { BiBarChartAlt2 } from 'react-icons/bi';
import { MdDashboard, MdKeyboardArrowDown, MdLogout, MdPerson, MdSettings, MdSwapHoriz } from 'react-icons/md';

interface DashboardHeaderProps {
    tenant: Tenant;
    user: User;
}

export function DashboardHeader({ tenant, user }: DashboardHeaderProps) {
    const handleLogout = () => {
        router.visit(logout.url());
    };

    return (
        <header className="bg-surface border-border border-b shadow-sm">
            <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between">
                    {/* Logo e nome do tenant */}
                    <div className="flex items-center space-x-4">
                        <img src={tenant.logo} alt={tenant.name} className="h-8 w-auto" />
                        <div>
                            <h1 className="text-[color:var(--color-text)] text-lg font-semibold">{tenant.title}</h1>
                        </div>
                    </div>

                    {/* Menu de navegação */}
                    <nav className="hidden items-center space-x-8 md:flex">
                        <Link
                            href="/dashboard"
                            className="text-[color:var(--color-text)] hover:text-[color:var(--color-primary)] flex items-center gap-2 font-medium transition-colors"
                        >
                            <MdDashboard />
                            Dashboard
                        </Link>

                        <Link href="/users" className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 font-medium transition-colors">
                            <AiOutlineUser />
                            Usuários
                        </Link>

                        <Link
                            href="/analytics"
                            className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 font-medium transition-colors"
                        >
                            <BiBarChartAlt2 />
                            Analytics
                        </Link>

                        <Link
                            href="/settings"
                            className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 font-medium transition-colors"
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
                                        className="text-[color:var(--color-text)] hover:text-[color:var(--color-primary)] flex h-auto items-center space-x-2 p-2 transition-colors"
                                    >
                                        <Avatar className="h-8 w-8">
                                            <AvatarImage src={user.avatar} alt={user.name} />
                                            <AvatarFallback>{user.name.charAt(0).toUpperCase()}</AvatarFallback>
                                        </Avatar>
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
                                    <DropdownMenuItem className="text-[color:var(--color-danger)] focus:text-[color:var(--color-danger)] cursor-pointer" onClick={handleLogout}>
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
                        className="text-[color:var(--color-text)] hover:text-[color:var(--color-primary)] flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                    >
                        <MdDashboard />
                        Dashboard
                    </Link>
                    <Link
                        href="/users"
                        className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                    >
                        <AiOutlineUser />
                        Usuários
                    </Link>
                    <Link
                        href="/analytics"
                        className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                    >
                        <BiBarChartAlt2 />
                        Analytics
                    </Link>
                    <Link
                        href="/settings"
                        className="text-[color:var(--color-muted)] hover:text-[color:var(--color-primary)] flex items-center gap-2 px-3 py-2 font-medium transition-colors"
                    >
                        <MdSettings />
                        Configurações
                    </Link>
                </div>
            </div>
        </header>
    );
}