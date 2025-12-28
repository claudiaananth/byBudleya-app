import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { login, register } from '@/routes';
import { BreadcrumbItem, type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome({
    canRegister = true,
}: {
    canRegister?: boolean;
}) {
    const { auth } = usePage<SharedData>().props;
    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Menu',
            href: '/menu',
        }
    ];
    
    return (
            <AppHeaderLayout breadcrumbs={breadcrumbs}>
                    <Head title="By Budleya" />
                    welcome
          </AppHeaderLayout>
    );
}
