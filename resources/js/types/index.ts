export interface Tenant {
    id: string;
    name: string;
    title: string;
    logo: string;
}

export interface User {
    id: number;
    name: string;
    email: string;
    last_tenant_id: number | null;
    has_multiple_tenants: boolean;
}
