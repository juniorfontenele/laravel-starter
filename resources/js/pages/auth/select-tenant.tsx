import { ThemeToggle } from '@/components/ThemeToggle';
import { Button } from '@/components/ui/button';
import { store } from '@/routes/select-tenant';
import { User } from '@/types';
import { Form, Head, usePage } from '@inertiajs/react';

interface Tenant {
    id: number | string;
    name: string;
}

interface SelectTenantProps {
    tenants: Tenant[];
}

export default function SelectTenant({ tenants }: SelectTenantProps) {
    const { errors, user } = usePage<{ user: User }>().props;

    return (
        <>
            <Head title="Selecionar Tenant" />
            <div className="bg-page flex h-dvh min-h-dvh items-center justify-center p-4">
                <div className="w-full max-w-sm">
                    <div className="bg-surface rounded-radius p-8 shadow-lg">
                        {/* Título */}
                        <h1 className="text-text mb-8 text-center text-2xl font-semibold">Selecione o Tenant</h1>

                        <Form method="post" action={store()} className="space-y-6">
                            <div>
                                <label htmlFor="tenant_id" className="text-text mb-2 block text-sm font-medium">
                                    Tenant
                                </label>
                                <select id="tenant_id" name="tenant_id" required className="input" defaultValue={user.last_tenant_id ?? ''}>
                                    <option value="" disabled>
                                        Selecione um tenant
                                    </option>
                                    {tenants.map((tenant) => (
                                        <option key={tenant.id} value={tenant.id}>
                                            {tenant.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            {errors.tenant_id && <div className="text-error mt-1 text-sm">{errors.tenant_id}</div>}
                            <Button type="submit" className="w-full">
                                Entrar
                            </Button>
                        </Form>
                    </div>
                </div>
            </div>
            {/* Theme Toggle - Fixed Position */}
            <div className="fixed top-4 right-4 z-50">
                <ThemeToggle />
            </div>
        </>
    );
}
