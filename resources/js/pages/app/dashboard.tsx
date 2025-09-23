import { DashboardLayout } from '@/components/DashboardLayout';
import { Tenant, User } from '@/types';
import { Head, usePage } from '@inertiajs/react';

export default function Dashboard() {
    const { tenant, user } = usePage<{ tenant: Tenant; user: User }>().props;

    if (!user) {
        return null;
    }

    return (
        <>
            <Head title="Dashboard" />
            <DashboardLayout tenant={tenant} user={user} />
        </>
    );
}
